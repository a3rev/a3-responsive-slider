<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */

namespace A3Rev\RSlider\FrameWork\Settings {

use A3Rev\RSlider\FrameWork;

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
Slider Mobile Template Title Settings

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

class Template_Mobile_Title extends FrameWork\Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'title-mobile';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'a3_rslider_template_mobile_title_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'a3_rslider_template_mobile_title_settings';
	
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
				'success_message'	=> __( 'Image Title Settings successfully saved.', 'a3-responsive-slider' ),
				'error_message'		=> __( 'Error: Image Title Settings can not save.', 'a3-responsive-slider' ),
				'reset_message'		=> __( 'Image Title Settings successfully reseted.', 'a3-responsive-slider' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
							
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
				
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
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
			'name'				=> 'title',
			'label'				=> __( 'Image Title', 'a3-responsive-slider' ),
			'callback_function'	=> 'a3_responsive_sider_template_mobile_title_settings_form',
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
				'name'		=> __( 'Image Title Settings', 'a3-responsive-slider' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Title', 'a3-responsive-slider' ),
				'id' 		=> 'enable_slider_title',
				'class'		=> 'enable_slider_title',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'a3-responsive-slider' ),
				'unchecked_label' 	=> __( 'OFF', 'a3-responsive-slider' ),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'slider_title_container'
           	),
			array(  
				'name' 		=> __( 'Title Margin', 'a3-responsive-slider' ),
				'id' 		=> 'title_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'title_margin_top',
	 										'name' 		=> __( 'Top', 'a3-responsive-slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'title_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'a3-responsive-slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'title_margin_left',
	 										'name' 		=> __( 'Left', 'a3-responsive-slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
											
									array( 
											'id' 		=> 'title_margin_right',
	 										'name' 		=> __( 'Right', 'a3-responsive-slider' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 10 ),
	 							)
			),
			array(  
				'name' 		=> __( 'Title Font', 'a3-responsive-slider' ),
				'id' 		=> 'title_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '16px', 'line_height' => '1.4em', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#6d6d6d' )
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	
	if ( $("input.enable_slider_title:checked").val() == '1') {
		$(".slider_title_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".slider_title_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.enable_slider_title', function( event, value, status ) {
		$(".slider_title_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".slider_title_container").slideDown();
		} else {
			$(".slider_title_container").slideUp();
		}
	});
	
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
 * a3_responsive_sider_template_mobile_title_settings_form()
 * Define the callback function to show subtab content
 */
function a3_responsive_sider_template_mobile_title_settings_form() {
	global $a3_responsive_sider_template_mobile_title_settings;
	$a3_responsive_sider_template_mobile_title_settings->settings_form();
}

}
