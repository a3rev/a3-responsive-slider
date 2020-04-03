<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Sample_Plugin
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?";
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	if ( ! defined( 'A3_RESPONSIVE_SLIDER_TRAVIS' ) ) { 
		define( 'A3_RESPONSIVE_SLIDER_TRAVIS', true );
	}

	echo esc_html( 'Loading plugin' . PHP_EOL );
	require dirname( dirname( __FILE__ ) ) . '/a3_responsive_slider.php';
	update_option('a3rev_rslider_version', A3_RESPONSIVE_SLIDER_VERSION);
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

function _manual_install_data() {
	if ( ! defined( 'A3_RESPONSIVE_SLIDER_TRAVIS' ) ) { 
		define( 'A3_RESPONSIVE_SLIDER_TRAVIS', true );
	}

	echo esc_html( 'Installing My Plugin Data ...' . PHP_EOL );
	\A3Rev\RSlider\Data::install_database();
}
tests_add_filter( 'setup_theme', '_manual_install_data' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

