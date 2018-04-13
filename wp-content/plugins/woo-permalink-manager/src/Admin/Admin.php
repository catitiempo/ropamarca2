<?php namespace Premmerce\UrlManager\Admin;

use Premmerce\UrlManager\WordpressSDK\FileManager\FileManager;
use Premmerce\UrlManager\UrlManagerPlugin;

/**
 * Class Admin
 *
 * @package Premmerce\UrlManager
 */
class Admin{

	/**
	 * @var string
	 */
	private $settingsPage;
	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * Admin constructor.
	 *
	 * @param FileManager $fileManager
	 */
	public function __construct(FileManager $fileManager){
		$this->fileManager  = $fileManager;
		$this->settingsPage = UrlManagerPlugin::DOMAIN . '-admin';
		$this->registerActions();
	}

	private function registerActions(){
		$flushActions = [
			'created_product_cat',
			'edited_product_cat',
			'delete_product_cat',
			'update_option_' . UrlManagerPlugin::OPTION_URL,
		];

		foreach($flushActions as $action){
			add_action($action, [$this, 'triggerFlush']);
		}

		add_action('admin_menu', [$this, 'addMenuPage']);
		add_action('admin_menu', [$this, 'addFullPack'], 100);

		add_action('admin_init', [$this, 'registerSettings']);

		add_action('init', [$this, 'flush'], 999);
	}


	/**
	 * Add submenu to premmerce menu page
	 */
	public function addMenuPage(){
		global $admin_page_hooks;

		$premmerceMenuExists = isset($admin_page_hooks['premmerce']);


		if(!$premmerceMenuExists){
			$svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="20" height="16" style="fill:#82878c" viewBox="0 0 20 16"><g id="Rectangle_7"> <path d="M17.8,4l-0.5,1C15.8,7.3,14.4,8,14,8c0,0,0,0,0,0H8h0V4.3C8,4.1,8.1,4,8.3,4H17.8 M4,0H1C0.4,0,0,0.4,0,1c0,0.6,0.4,1,1,1 h1.7C2.9,2,3,2.1,3,2.3V12c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1V1C5,0.4,4.6,0,4,0L4,0z M18,2H7.3C6.6,2,6,2.6,6,3.3V12 c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1v-1.7C8,10.1,8.1,10,8.3,10H14c1.1,0,3.2-1.1,5-4l0.7-1.4C20,4,20,3.2,19.5,2.6 C19.1,2.2,18.6,2,18,2L18,2z M14,11h-4c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1h4c0.6,0,1-0.4,1-1C15,11.4,14.6,11,14,11L14,11z M14,14 c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1c0.6,0,1-0.4,1-1C15,14.4,14.6,14,14,14L14,14z M4,14c-0.6,0-1,0.4-1,1c0,0.6,0.4,1,1,1 c0.6,0,1-0.4,1-1C5,14.4,4.6,14,4,14L4,14z"/></g></svg>';
			$svg = 'data:image/svg+xml;base64,' . base64_encode($svg);

			add_menu_page(
				'Premmerce',
				'Premmerce',
				'manage_options',
				'premmerce',
				'',
				$svg
			);
		}


		add_submenu_page(
			'premmerce',
			__('Permalink Manager', 'premmerce-url-manager'),
			__('Permalink Manager', 'premmerce-url-manager'),
			'manage_options',
			$this->settingsPage,
			[$this, 'options']
		);

		if(!$premmerceMenuExists){
			global $submenu;
			unset($submenu['premmerce'][0]);
		}
	}

	public function addFullPack(){
		global $submenu;

		if(!function_exists('get_plugins')){
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();

		$premmerceInstalled = array_key_exists('premmerce-premium/premmerce.php', $plugins)
		                      || array_key_exists('premmerce/premmerce.php', $plugins);

		if(!$premmerceInstalled){
			$submenu['premmerce'][999] = [
				'Get premmerce full pack',
				'manage_options',
				admin_url('plugin-install.php?tab=plugin-information&plugin=premmerce'),
			];
		}
	}

	/**
	 * Options page
	 */
	public function options(){

		$current = isset($_GET['tab'])? $_GET['tab'] : 'settings';

		$tabs['settings'] = __('Settings', 'premmerce-url-manager');

		if(function_exists('premmerce_wpm_fs')){
			$tabs['contact'] = __('Contact Us', 'premmerce-url-manager');
			if(premmerce_wpm_fs()->is_registered()){
				$tabs['account'] = __('Account', 'premmerce-url-manager');
			}
		}

		if($current === 'settings'){
			$this->triggerFlush();
		}

		$this->fileManager->includeTemplate(
			'admin/main.php',
			[
				'tabs'    => $tabs,
				'current' => $current,
				'options' => get_option(UrlManagerPlugin::OPTION_URL),
			]
		);
	}


	/**
	 * Register settings group
	 */
	public function registerSettings(){
		register_setting(
			UrlManagerPlugin::DOMAIN . '-group',
			UrlManagerPlugin::OPTION_URL
		);
	}


	/**
	 * Set flush trigger
	 */
	public function triggerFlush(){
		update_option(UrlManagerPlugin::OPTION_FLUSH, true);
	}

	/**
	 * Flush rewrite rules
	 */
	public function flush(){
		$option = UrlManagerPlugin::OPTION_FLUSH;
		if(get_option($option)){
			add_action('shutdown', 'flush_rewrite_rules');
			delete_option($option);
		}
	}
}
