<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\RSlider\FrameWork\Settings {

use A3Rev\RSlider\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
Slider Template 1 Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class Template_1_Global extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'a3-rslider-template-1';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'a3_rslider_template1_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'a3_rslider_template1_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init_form_fields' ), 1 );
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Skin Settings successfully saved.', 'a3-responsive-slider' ),
				'error_message'		=> __( 'Error: Skin Settings can not save.', 'a3-responsive-slider' ),
				'reset_message'		=> __( 'Skin Settings successfully reseted.', 'a3-responsive-slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
							
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
				
		$GLOBALS[$this->plugin_prefix.'admin_interface']->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
				
		$GLOBALS[$this->plugin_prefix.'admin_interface']->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
				
		$GLOBALS[$this->plugin_prefix.'admin_interface']->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'global-settings',
			'label'				=> __( 'Skin Settings', 'a3-responsive-slider' ),
			'callback_function'	=> 'a3_responsive_sider_template_1_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
				
		$output = '';
		$output .= $GLOBALS[$this->plugin_prefix.'admin_interface']->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
		
			array(
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Template Name', 'a3-responsive-slider' ),
				'id' 		=> 'a3_rslider_template_1',
				'type' 		=> 'text',
				'default'	=> __( 'Template 1', 'a3-responsive-slider' ),
				'free_version'		=> true,
				'separate_option'	=> true,
				'custom_attributes'	=> array( 'maxlength' => 17 )
			),

			array(
                'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields slider_touch_container',
           	),
			array(  
				'name' 		=> __( 'Mobile Skin', 'a3-responsive-slider' ),
				'desc'		=> __( 'Active custom mobile skin', 'a3-responsive-slider' ),
				'id' 		=> 'is_used_mobile_skin',
				'class'		=> 'is_used_mobile_skin',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 1,
				'unchecked_value'	=> 0,
				'checked_label'		=> __( 'ON', 'a3-responsive-slider' ),
				'unchecked_label' 	=> __( 'OFF', 'a3-responsive-slider' ),	
			),
			
        ));
	}

	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	

});
})(jQuery);
</script>
    <?php	
	}
	
}

}

// global code
namespace {

/** 
 * a3_responsive_sider_template_1_global_settings_form()
 * Define the callback function to show subtab content
 */
function a3_responsive_sider_template_1_global_settings_form() {
	global $a3_responsive_sider_template_1_global_settings;
	$a3_responsive_sider_template_1_global_settings->settings_form();
}

}
