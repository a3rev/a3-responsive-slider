<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita347453d0b2d79c8d0c452cc699345d4
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'A3Rev\\RSlider\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'A3Rev\\RSlider\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
            1 => __DIR__ . '/../..' . '/admin',
            2 => __DIR__ . '/../..' . '/includes',
            3 => __DIR__ . '/../..' . '/shortcodes',
            4 => __DIR__ . '/../..' . '/preview',
            5 => __DIR__ . '/../..' . '/widgets',
        ),
    );

    public static $classMap = array (
        'A3Rev\\RSlider\\Admin\\Slider_Edit' => __DIR__ . '/../..' . '/admin/classes/a3-rslider-edit.php',
        'A3Rev\\RSlider\\Custom_Post' => __DIR__ . '/../..' . '/classes/a3-rslider-custom-post.php',
        'A3Rev\\RSlider\\Data' => __DIR__ . '/../..' . '/classes/data/a3-rslider-data.php',
        'A3Rev\\RSlider\\Display' => __DIR__ . '/../..' . '/classes/a3-rslider-display.php',
        'A3Rev\\RSlider\\Duplicate' => __DIR__ . '/../..' . '/classes/a3-rslider-duplicate.php',
        'A3Rev\\RSlider\\Functions' => __DIR__ . '/../..' . '/classes/a3-rslider-functions.php',
        'A3Rev\\RSlider\\Hook_Filter' => __DIR__ . '/../..' . '/classes/a3-rslider-hook-filter.php',
        'A3Rev\\RSlider\\Mobile_Detect' => __DIR__ . '/../..' . '/includes/mobile_detect.php',
        'A3Rev\\RSlider\\Mobile_Display' => __DIR__ . '/../..' . '/classes/a3-rslider-mobile-display.php',
        'A3Rev\\RSlider\\Preview' => __DIR__ . '/../..' . '/preview/a3-rslider-preview.php',
        'A3Rev\\RSlider\\Shortcode' => __DIR__ . '/../..' . '/shortcodes/class-rslider-shortcodes.php',
        'A3Rev\\RSlider\\Widget' => __DIR__ . '/../..' . '/widgets/class-rslider-widgets.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita347453d0b2d79c8d0c452cc699345d4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita347453d0b2d79c8d0c452cc699345d4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita347453d0b2d79c8d0c452cc699345d4::$classMap;

        }, null, ClassLoader::class);
    }
}
