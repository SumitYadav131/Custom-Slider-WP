<?php

add_action('add_meta_boxes', 'add_slider_meta_box');

// Add Meta Box
function add_slider_meta_box()
{
    add_meta_box('slider_settings', 'Sliders', 'meta_box_function', 'sliders');
}

function meta_box_function($post)
{
    $desc = get_post_meta($post->ID, 'slide_desc', true);
    $logo = get_post_meta($post->ID, 'slide_logo', true);
    $btn_text = get_post_meta($post->ID, 'slide_btn_text', true);
    $btn_url = get_post_meta($post->ID, 'slide_btn_url', true);
    $bg = get_post_meta($post->ID, 'slide_bg', true);
    // $template = get_post_meta($post->ID, 'slide_template', true);

    ?>
    <!-- Design Part Here -->
    <p>
        <label>Description</label><br>
        <textarea name="slide_desc" style="width:100%"><?php echo esc_textarea($desc); ?></textarea>
    </p>

    <p>
        <label>Logo URL</label><br>
        <input type="text" name="slide_logo" value="<?php echo esc_url($logo); ?>" style="width:100%">
    </p>

    <p>
        <label>Button Text</label><br>
        <input type="text" name="slide_btn_text" value="<?php echo esc_attr($btn_text); ?>" style="width:100%">
    </p>

    <p>
        <label>Button URL</label><br>
        <input type="text" name="slide_btn_url" value="<?php echo esc_url($btn_url); ?>" style="width:100%">
    </p>

    <p>
        <label>Background Image URL</label><br>
        <input type="text" name="slide_bg" value="<?php echo esc_url($bg); ?>" style="width:100%">
    </p>

    <!-- <p>
        <label>Template</label><br>
        <select name="slide_template">
            <option value="template-1" <?php selected($template, 'template-1'); ?>>Template 1</option>
            <option value="template-2" <?php selected($template, 'template-2'); ?>>Template 2</option>
        </select>
    </p> -->

    <!-- <p>
        <strong>Shortcode:</strong><br>
        <code>[custom_slider id="<?php echo $post->ID; ?>"]</code>
    </p> -->


    <?php
}

// Save meta fields
add_action('save_post', 'save_slider_meta');

// New metabox for shortcode and meplate choice options 
add_action('add_meta_boxes', 'add_slider_setting_metabox');

function add_slider_setting_metabox()
{
    add_meta_box('slider_shortcode', 'Settings', 'add_slider_shortcode', 'sliders');
}

function add_slider_shortcode($post)
{
    $template = get_post_meta($post->ID, 'slide_template', true);
    ?>
    <p>
        <label>Template</label><br>
        <select name="slide_template">
            <option value="template-1" <?php selected($template, 'template-1'); ?>>Template 1</option>
            <option value="template-2" <?php selected($template, 'template-2'); ?>>Template 2</option>
        </select>
    </p>

    <p>
        <strong>Shortcode:</strong><br>
        <code>[custom_slider id="<?php echo $post->ID; ?>"]</code>
    </p>

    <?php
}


function save_slider_meta($post_id)
{
    $fields = [
        'slide_template',
        'slide_bg',
        'slide_btn_url',
        'slide_btn_text',
        'slide_logo',
        'slide_desc'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

// Shortcode
add_shortcode('custom_slider', 'slider_shortcode');
function slider_shortcode($atts)
{
    $atts = shortcode_atts(['id' => ''], $atts);
    if (!$atts['id'])
        return '';

    $post_id = $atts['id'];
    $template = get_post_meta($post_id, 'slide_template', true);

    ob_start();
    include plugin_dir_path(dirname(__FILE__)) . "public/templates/{$template}.php";
    return ob_get_clean();
}


