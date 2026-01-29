<?php
/*
Plugin Name: Custom Slider
Author: Mydevit-solutions
Version: 1.0
*/

if (!defined('ABSPATH'))
    exit;

// Register cpt

add_action('init', function () {
    register_post_type('sliders', [
        'label' => 'Sliders',
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => ['title']
    ]);
});


require_once plugin_dir_path(__FILE__) . 'admin/slider-metabox.php';

add_shortcode('custom', 'render_custom_slider');