<?php
add_action('add_meta_boxes', 'add_slider_meta_box');

// Add Meta Box
function add_slider_meta_box()
{
    add_meta_box('slider_slides', 'Sliders', 'meta_box_function', 'sliders');
}

// Add slider callback
function meta_box_function($post)
{
    $slides = get_post_meta($post->ID, 'slides', true);
    if (!is_array($slides)) {
        $slides = [];
    }
    ?>
    <!-- Design Part Here -->
    <div id="slides-wrapper">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="slide-item" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <h4>Slide <?php echo $index + 1; ?></h4>

                <p>
                    <label>Description</label><br>
                    <textarea name="slides[<?php echo $index; ?>][desc]"
                        style="width:100%;"><?php echo esc_textarea($slide['desc'] ?? ''); ?></textarea>
                </p>

                <p>
                    <label>Logo URL</label><br>
                    <input type="text" name="slides[<?php echo $index; ?>][logo]"
                        value="<?php echo esc_attr($slide['logo'] ?? ''); ?>" style="width:100%;">
                </p>

                <p>
                    <label>Button Text</label><br>
                    <input type="text" name="slides[<?php echo $index; ?>][btn_text]"
                        value="<?php echo esc_attr($slide['btn_text'] ?? ''); ?>" style="width:100%;">
                </p>

                <p>
                    <label>Button URL</label><br>
                    <input type="text" name="slides[<?php echo $index; ?>][btn_url]"
                        value="<?php echo esc_url($slide['btn_url'] ?? ''); ?>" style="width:100%;">
                </p>

                <p>
                    <label>Background Image URL</label><br>
                    <input type="text" name="slides[<?php echo $index; ?>][bg]"
                        value="<?php echo esc_url($slide['bg'] ?? ''); ?>" style="width:100%;">
                </p>

                <button type="button" class="remove-slide button">Remove Slide</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-slide" class="button">+ Add Slide</button>

    <!-- Admin JS -->
    <script>
        jQuery(document).ready(function ($) {
            let index = $('#slides-wrapper .slide-item').length;

            $('#add-slide').on('click', function () {
                let html = `
    <div class="slide-item" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <h4>Slide ${index + 1}</h4>
        <p><label>Description</label><br><textarea name="slides[${index}][desc]" style="width:100%;"></textarea></p>
        <p><label>Logo URL</label><br><input type="text" name="slides[${index}][logo]" style="width:100%;"></p>
        <p><label>Button Text</label><br><input type="text" name="slides[${index}][btn_text]" style="width:100%;"></p>
        <p><label>Button URL</label><br><input type="text" name="slides[${index}][btn_url]" style="width:100%;"></p>
        <p><label>Background Image URL</label><br><input type="text" name="slides[${index}][bg]" style="width:100%;"></p>
        <button type="button" class="remove-slide button">Remove Slide</button>
    </div>
    `;
                $('#slides-wrapper').append(html);
                index++;
            });

            $(document).on('click', '.remove-slide', function () {
                $(this).closest('.slide-item').remove();
            });
        });
    </script>

    <?php
}

// Save meta fields
add_action('save_post', 'save_slider_meta');

function save_slider_meta($post_id)
{
    // Prevent autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // Check if slides exist and save
    if (isset($_POST['slides']) && is_array($_POST['slides'])) {
        $slides_clean = [];
        foreach ($_POST['slides'] as $slide) {
            $slides_clean[] = [
                'desc' => sanitize_textarea_field($slide['desc'] ?? ''),
                'logo' => sanitize_text_field($slide['logo'] ?? ''),
                'btn_text' => sanitize_text_field($slide['btn_text'] ?? ''),
                'btn_url' => esc_url_raw($slide['btn_url'] ?? ''),
                'bg' => esc_url_raw($slide['bg'] ?? '')
            ];
        }
        update_post_meta($post_id, 'slides', $slides_clean);
    }

    // Save selected template
    if (isset($_POST['slide_template'])) {
        update_post_meta($post_id, 'slide_template', sanitize_text_field($_POST['slide_template']));
    }
}



// Add Meta box for shortcode and template 
add_action('add_meta_boxes', 'add_slider_setting_metabox');

function add_slider_setting_metabox()
{
    add_meta_box('slider_settings', 'Settings', 'add_slider_shortcode', 'sliders', 'side', 'default');
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

add_shortcode('custom_slider', 'slider_shortcode');

function slider_shortcode($atts)
{
    $atts = shortcode_atts(['id' => ''], $atts);
    if (!$atts['id'])
        return '';

    $post_id = $atts['id'];
    $slides = get_post_meta($post_id, 'slides', true);
    // print_r($slides);
    $template = get_post_meta($post_id, 'slide_template', true);

    if (!is_array($slides) || empty($slides))
        return '';

    ob_start();

    if ($template === 'template-1') {
        // Include template-1.php
        include(plugin_dir_path(__FILE__) . '../public/templates/template-1.php');
    } elseif ($template === 'template-2') {
        // Include template-2.php
        include(plugin_dir_path(__FILE__) . '../public/templates/template-2.php');
    } else {
        // Default rendering, in case no template is selected
        echo '<div class="custom-slider">';
        foreach ($slides as $slide) {
            ?>
            <div class="slide"
                style="background-image:url('<?php echo esc_url($slide['bg']); ?>'); padding:20px; margin-bottom:10px;">
                <?php if ($slide['logo']): ?>
                    <img src="<?php echo esc_url($slide['logo']); ?>" alt="" style="max-width:100px;">
                <?php endif; ?>
                <p><?php echo esc_html($slide['desc']); ?></p>
                <?php if ($slide['btn_text'] && $slide['btn_url']): ?>
                    <a href="<?php echo esc_url($slide['btn_url']); ?>"
                        class="slide-btn"><?php echo esc_html($slide['btn_text']); ?></a>
                <?php endif; ?>
            </div>
            <?php

        }
        echo '</div>';
    }
    return ob_get_clean();
}



