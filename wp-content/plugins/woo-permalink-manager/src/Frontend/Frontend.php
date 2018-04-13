<?php namespace Premmerce\UrlManager\Frontend;

use Premmerce\UrlManager\UrlManagerPlugin;

/**
 * Class Frontend
 *
 * @package Premmerce\UrlManager
 */
class Frontend{

	/**
	 * Frontend constructor.
	 */
	public function __construct(){
		add_action('request', [$this, 'replaceRequest']);
	}


	/**
	 * Replace request if product found
	 *
	 *
	 * @param array $request
	 *
	 * @return array
	 */
	public function replaceRequest($request){
		global $wp, $wpdb;
		$url = $wp->request;

		if(!empty($url)){
			$productRequest = [];

			$url = explode('/', $url);

			$slug = array_pop($url);

			if($slug === 'feed'){
				$productRequest['feed'] = $slug;
				$slug                   = array_pop($url);
			}

			$sql = "SELECT COUNT(ID) as count_id FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s AND post_status = %s";

			$query = $wpdb->prepare($sql, [$slug, UrlManagerPlugin::WOOCOMMERCE_PRODUCT, 'publish']);

			$num = intval($wpdb->get_var($query));

			if($num > 0){
				$productRequest['post_type'] = UrlManagerPlugin::WOOCOMMERCE_PRODUCT;

				$productRequest['product'] = $slug;

				$productRequest['name'] = $slug;

				return $productRequest;
			}
		}

		return $request;
	}
}
