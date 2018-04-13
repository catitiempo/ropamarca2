<?php namespace Premmerce\UrlManager;

/**
 * Class PermalinkListener
 *
 * The class is responsible for filtering of
 * product and category links invoked by 'post_type_link' and 'term_link'
 *
 * @package Premmerce\UrlManager
 */
class PermalinkListener{

	/**
	 * @var array
	 */
	private $categories;

	/**
	 * Add post_type_link, term_link, rewrite_rules_array filters
	 */
	public function registerFilters(){
		add_filter('post_type_link', [$this, 'replaceProductLink'], 1, 2);
		add_filter('term_link', [$this, 'replaceCategoryLink'], 1, 3);
		add_filter('rewrite_rules_array', [$this, 'addRewriteRules'], 99);
	}

	/**
	 * Replace category permalink according to settings
	 *
	 * @param string $link
	 * @param object $term
	 * @param string $taxonomy
	 *
	 * @return string
	 */
	public function replaceCategoryLink($link, $term, $taxonomy){
		if($taxonomy !== UrlManagerPlugin::WOOCOMMERCE_CATEGORY){
			return $link;
		}

		if(!get_option('permalink_structure')){
			return $link;
		}

		$permalinkStructure = wc_get_permalink_structure();

		$category_base = trailingslashit($permalinkStructure['category_rewrite_slug']);

		$urlOptions = get_option(UrlManagerPlugin::OPTION_URL);

		$removeCategoryBase = isset($urlOptions['remove_category_base']);
		$removeParentSlugs  = isset($urlOptions['remove_category_parent_slugs']);

		if($removeCategoryBase){
			$link          = str_replace($category_base, '', $link);
			$category_base = '';
		}

		if($removeParentSlugs){
			$link = home_url(trailingslashit($category_base . $term->slug));
		}


		return $link;
	}


	/**
	 * Replace product permalink according to settings
	 *
	 *
	 * @param string $permalink
	 * @param object $post
	 *
	 * @return string
	 */
	public function replaceProductLink($permalink, $post){
		if($post->post_type !== UrlManagerPlugin::WOOCOMMERCE_PRODUCT){
			return $permalink;
		}


		if(!get_option('permalink_structure')){
			return $permalink;
		}


		$urlOptions = get_option(UrlManagerPlugin::OPTION_URL);

		$permalinkStructure = wc_get_permalink_structure();

		$product_base = $permalinkStructure['product_rewrite_slug'];

		$removeProductBase = isset($urlOptions['remove_product_base']);

		$product_base = explode('/', '/' . ltrim($product_base, '/'));


		$remove = array_filter($product_base, function($el) use ($removeProductBase){
			if($el === '%product_cat%'){
				return false;
			}
			if(mb_strlen($el) > 0){
				return $removeProductBase;
			}

			return true;
		});

		$remove = implode('/', $remove);

		$link = str_replace($remove . '/', '/', $permalink);

		$link = $this->setPrimaryCategoryLink($post, $link, $permalinkStructure);

		return $link;
	}

	/**
	 * Replace %product_cat% variable with primary category link if seo plugin is enabled
	 *
	 * @param $post
	 * @param $link
	 * @param $permalinkStructure
	 *
	 * @return string
	 */
	protected function setPrimaryCategoryLink($post, $link, $permalinkStructure){
		if($this->checkSeoPlugin() && strpos($link, '%product_cat%') !== false){
			$category = new \WPSEO_Primary_Term(UrlManagerPlugin::WOOCOMMERCE_CATEGORY, $post->ID);

			$primaryTerm = $category->get_primary_term();

			$term = get_term($primaryTerm);

			if($term instanceof \WP_Error){
				return $link;
			}

			$termLink = get_term_link($term);

			$search   = [
				home_url(),
				trailingslashit($permalinkStructure['category_rewrite_slug']),
			];
			$termLink = trim(str_replace($search, '', $termLink), '/');

			$link = str_replace('%product_cat%', $termLink, $link);
		}

		return $link;
	}

	/**
	 * Check that seo plugin is enabled and available to use
	 *
	 * @return bool
	 */
	protected function checkSeoPlugin(){
		if(!function_exists('is_plugin_active')){
			include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		$active = function_exists('is_plugin_active')
		          && defined('WPSEO_BASENAME')
		          && is_plugin_active(WPSEO_BASENAME)
		          && class_exists(\WPSEO_Primary_Term::class);

		return $active;
	}

	/**
	 * Add rewrite rules for wp
	 *
	 * @param $rules
	 *
	 * @return array
	 */
	public function addRewriteRules($rules){
		$premmerceOptions = get_option(UrlManagerPlugin::OPTION_URL);

		if(!$premmerceOptions || get_option(UrlManagerPlugin::OPTION_DISABLED)){
			return $rules;
		}

		global $wp_rewrite;

		wp_cache_flush();

		$removeCategoryBase        = isset($premmerceOptions['remove_category_base']);
		$removeCategoryParentSlugs = isset($premmerceOptions['remove_category_parent_slugs']);
		$removeProductBase         = isset($premmerceOptions['remove_product_base']);
		$permalinkStructure        = wc_get_permalink_structure();

		$useParentCategorySlug = strpos($permalinkStructure['product_rewrite_slug'], '%product_cat%') !== false;

		$categoryBase = $removeCategoryBase? '' : $permalinkStructure['category_rewrite_slug'];


		$categoryRules = [];
		$productRules  = [];

		$categories = $this->getCategories();


		foreach($categories as $category){
			$categorySlug = $category['slug'];


			if(!$removeCategoryParentSlugs){
				$categorySlug = $this->getCategoryFullPath($category);
			}

			$categoryRules[ $categoryBase . $categorySlug . '/?$' ]                                                   = 'index.php?product_cat=' . $category['slug'];
			$categoryRules[ $categoryBase . $categorySlug . '/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ]                = 'index.php?product_cat=' . $category['slug'] . '&feed=$matches[1]';
			$categoryRules[ $categoryBase . $categorySlug . '/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?$' ] = 'index.php?product_cat=' . $category['slug'] . '&paged=$matches[1]';

			if($removeProductBase && $useParentCategorySlug){
				$productRules[ $categorySlug . '/([^/]+)/?$' ]                                                        = 'index.php?product=$matches[1]';
				$productRules[ $categorySlug . '/([^/]+)/' . $wp_rewrite->comments_pagination_base . '-([0-9]{1,})/?$' ] = 'index.php?product=$matches[1]&cpage=$matches[2]';
			}
		}

		$rules = empty($rules)? [] : $rules;

		return $categoryRules + $productRules + $rules;
	}

	/**
	 * Returns categories array:
	 * ['category id' => ['slug' => 'category slug', 'parent' => 'parent category id']]
	 *
	 * @return array
	 */
	private function getCategories(){
		if(is_null($this->categories)){
			$categories = get_categories([
				'taxonomy'   => UrlManagerPlugin::WOOCOMMERCE_CATEGORY,
				'hide_empty' => false,
			]);

			$slugs = [];
			foreach($categories as $category){
				$slugs[ $category->term_id ] = [
					'parent' => $category->parent,
					'slug'   => $category->slug,
				];
			}

			$this->categories = $slugs;
		}

		return $this->categories;
	}

	/**
	 * Recursively builds category full path
	 *
	 * @param $category
	 *
	 * @return string
	 */
	public function getCategoryFullPath($category){
		$categories = $this->getCategories();

		$parent = $category['parent'];

		if($parent > 0 && array_key_exists($parent, $categories)){
			return $this->getCategoryFullPath($categories[ $parent ]) . '/' . $category['slug'];
		}

		return $category['slug'];
	}
}
