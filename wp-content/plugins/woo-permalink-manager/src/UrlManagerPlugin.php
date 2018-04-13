<?php namespace Premmerce\UrlManager;

use Premmerce\UrlManager\Admin\Admin;
use Premmerce\UrlManager\Frontend\Frontend;
use Premmerce\UrlManager\WordpressSDK\FileManager\FileManager;
use Premmerce\UrlManager\WordpressSDK\Notifications\AdminNotifier;

/**
 * Class UrlManagerPlugin
 *
 * @package Premmerce\UrlManager
 */
class UrlManagerPlugin{

	const WOOCOMMERCE_PRODUCT = 'product';

	const WOOCOMMERCE_CATEGORY = 'product_cat';

	const DOMAIN = 'premmerce-url-manager';

	const OPTION_URL = 'premmerce_url_manager_options';

	const OPTION_DISABLED = 'premmerce_url_manager_disabled';

	const OPTION_FLUSH = 'premmerce_url_manager_flush_rules';

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * @var AdminNotifier
	 */
	private $notifier;

	/**
	 * PluginManager constructor.
	 *
	 * @param $mainFile
	 */
	public function __construct($mainFile){
		$this->fileManager = new FileManager($mainFile);
		$this->notifier    = new AdminNotifier();

		add_action('init', [$this, 'loadTextDomain']);

		add_action('admin_init', [$this, 'checkRequirePlugins']);
	}

	/**
	 * Run plugin part
	 */
	public function run(){
		$valid = count($this->validateRequiredPlugins()) === 0;

		if(is_admin()){
			new Admin($this->fileManager);
		}

		if($valid){
			if(!is_admin()){
				new Frontend();
			}
			(new PermalinkListener())->registerFilters();
		}

	}

	/**
	 * Fired when the plugin is activated
	 */
	public function activate(){
		delete_option(self::OPTION_DISABLED);
		flush_rewrite_rules();
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate(){
		update_option(self::OPTION_DISABLED, true);
		flush_rewrite_rules();
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall(){
		delete_option(self::OPTION_URL);
		delete_option(self::OPTION_FLUSH);
		delete_option(self::OPTION_DISABLED);
		flush_rewrite_rules();
	}

	/**
	 * Load plugin translations
	 */
	public function loadTextDomain(){
		$name = $this->fileManager->getPluginName();
		load_plugin_textdomain(self::DOMAIN, false, $name . '/languages/');
	}

	/**
	 * Check required plugins and push notifications
	 */
	public function checkRequirePlugins(){
		$message = __('The %s plugin requires %s plugin to be active!', 'woo-seo-addon');

		$plugins = $this->validateRequiredPlugins();

		if(count($plugins)){
			foreach($plugins as $plugin){
				$error = sprintf($message, 'WooCommerce Permalink Manager', $plugin);
				$this->notifier->push($error, AdminNotifier::ERROR, false);
			}
		}

	}

	/**
	 * Validate required plugins
	 *
	 * @return array
	 */
	private function validateRequiredPlugins(){

		$plugins = [];

		if(!function_exists('is_plugin_active')){
			include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}

		/**
		 * Check if WooCommerce is active
		 **/
		if(!(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active_for_network('woocommerce/woocommerce.php'))){
			$plugins[] = '<a target="_blank" href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a>';
		}

		return $plugins;
	}
}
