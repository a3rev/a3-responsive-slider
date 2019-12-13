<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Slider Slider Card Skin Settings Page

TABLE OF CONTENTS

- var menu_slug
- var page_data

- __construct()
- page_init()
- page_data()
- add_admin_menu()
- tabs_include()
- admin_settings_page()

-----------------------------------------------------------------------------------*/

class A3_Responsive_Slider_Card_Skin_Page extends A3_Responsive_Slider_Admin_UI
{	
	/**
	 * @var string
	 */
	private $menu_slug = 'a3-rslider-card-skin';
	
	/**
	 * @var array
	 */
	private $page_data;
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->page_init();
		$this->tabs_include();
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_init() */
	/* Page Init */
	/*-----------------------------------------------------------------------------------*/
	public function page_init() {
		
		add_filter( $this->plugin_name . '_add_admin_menu', array( $this, 'add_admin_menu' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* page_data() */
	/* Get Page Data */
	/*-----------------------------------------------------------------------------------*/
	public function page_data() {
		
		
		
		$page_data = array(
			'type'				=> 'submenu',
			'parent_slug'		=> 'edit.php?post_type=a3_slider',
			'page_title'		=> \A3Rev\RSlider\Functions::get_slider_template( 'template-card' ),
			'menu_title'		=> \A3Rev\RSlider\Functions::get_slider_template( 'template-card' ),
			'capability'		=> 'manage_options',
			'menu_slug'			=> $this->menu_slug,
			'function'			=> 'a3_responsive_slider_card_skin_page_show',
			'admin_url'			=> 'edit.php?post_type=a3_slider',
			'callback_function' => '',
			'script_function' 	=> '',
			'view_doc'			=> '',
		);
		
		if ( $this->page_data ) return $this->page_data;
		return $this->page_data = $page_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_admin_menu() */
	/* Add This page to menu on left sidebar */
	/*-----------------------------------------------------------------------------------*/
	public function add_admin_menu( $admin_menu ) {
		
		if ( ! is_array( $admin_menu ) ) $admin_menu = array();
		$admin_menu[] = $this->page_data();
		
		return $admin_menu;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* tabs_include() */
	/* Include all tabs into this page
	/*-----------------------------------------------------------------------------------*/
	public function tabs_include() {
		
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/global-settings-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/dimensions-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/card-container-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/card-footer-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/control-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/pager-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/title-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/caption-tab.php' );
		include_once( $this->admin_plugin_dir() . '/tabs/card-skin/readmore-tab.php' );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* admin_settings_page() */
	/* Show Settings Page */
	/*-----------------------------------------------------------------------------------*/
	public function admin_settings_page() {
		global $a3_responsive_slider_admin_init;
		
		$a3_responsive_slider_admin_init->admin_settings_page( $this->page_data() );
	}
	
}

global $a3_responsive_slider_card_skin_page;
$a3_responsive_slider_card_skin_page = new A3_Responsive_Slider_Card_Skin_Page();

/** 
 * a3_responsive_slider_card_skin_page_show()
 * Define the callback function to show page content
 */
function a3_responsive_slider_card_skin_page_show() {
	global $a3_responsive_slider_card_skin_page;
	$a3_responsive_slider_card_skin_page->admin_settings_page();
}

?>