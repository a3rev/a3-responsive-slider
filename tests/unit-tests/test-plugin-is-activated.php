<?php
/**
 * Class SampleTest
 *
 * @package Sample_Plugin
 */

/**
 * Sample test case.
 */
class a3Rev_Tests_Responsive_Slider extends WP_UnitTestCase {

	function test_constants_defined() {
		$this->assertTrue( defined( 'A3_RESPONSIVE_SLIDER_KEY' ) );
		$this->assertTrue( defined( 'A3_RESPONSIVE_SLIDER_PREFIX' ) );
		$this->assertTrue( defined( 'A3_RESPONSIVE_SLIDER_VERSION' ) );
	}
}
