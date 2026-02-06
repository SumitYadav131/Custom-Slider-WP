<?php
$slides = get_post_meta($post_id, 'slides', true);
if (is_array($slides) && !empty($slides)):
    $title = get_the_title($post_id);
    $first = true;
    ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <style>
            img.d-block.w-100 {
                height: 70vh;
                object-fit: cover;
            }
        </style>
        <div class="carousel-inner">
            <?php foreach ($slides as $slide):
                $desc = $slide['desc'] ?? '';
                $bg = $slide['bg'] ?? '';
                ?>
                <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                    <img src="<?php echo esc_url($bg); ?>" class="d-block w-100" alt="">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?php echo esc_html($title); ?></h5>
                        <p><?php echo esc_html($desc); ?></p>
                    </div>
                </div>

                <?php
                $first = false;
            endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
<?php endif; ?>