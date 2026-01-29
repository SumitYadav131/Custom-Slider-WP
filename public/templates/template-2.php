<?php
$title = get_the_title($post_id);
$desc = get_post_meta($post_id, 'slide_desc', true);
$logo = get_post_meta($post_id, 'slide_logo', true);
$btn_text = get_post_meta($post_id, 'slide_btn_text', true);
$btn_url = get_post_meta($post_id, 'slide_btn_url', true);
$bg = get_post_meta($post_id, 'slide_bg', true);
?>

<section class="minimal-slide py-5 px-5" style="background: url('<?php echo esc_url($bg); ?>') center/cover no-repeat;">
    <div class="container text-white">
        <?php if ($logo): ?>
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($title); ?>" class="mb-3"
                style="max-height:80px;">
        <?php endif; ?>

        <?php if ($title): ?>
            <h1 class="fw-bold mb-3"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>

        <?php if ($desc): ?>
            <p class="lead mb-4"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>

        <?php if ($btn_text && $btn_url): ?>
            <a href="<?php echo esc_url($btn_url); ?>" class="btn btn-primary btn-lg"><?php echo esc_html($btn_text); ?></a>
        <?php endif; ?>
    </div>
</section>

<style>
    .minimal-slide {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        color: #fff;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
    }

    .minimal-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        /* dark overlay for readability */
        z-index: 0;
    }

    .minimal-slide .container {
        position: relative;
        z-index: 1;
    }
</style>