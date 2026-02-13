<?php
$slides = get_post_meta($post_id, 'slides', true);

if (is_array($slides) && !empty($slides)):
    $title = get_the_title($post_id);
    $first = true;
?>

    <style>
        .hero-carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        /* slides */
        .hero-carousel .carousel-item {
            height: 100vh;
            position: relative;
        }

        .hero-carousel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* overlay */
        .hero-carousel .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.25));
            z-index: 1;
        }

        /* hero content */
        .hero-content {
            position: absolute;
            bottom: 140px;
            left: 80px;
            max-width: 560px;
            z-index: 2;
            color: #fff;
        }

        .hero-content .count {
            font-size: 14px;
            opacity: 0.7;
            margin-bottom: 14px;
        }

        .hero-content h1 {
            font-size: 44px;
            line-height: 1.15;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .hero-content p {
            font-size: 16px;
            line-height: 1.7;
            opacity: 0.85;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-book {
            background: #f7c600;
            color: #000;
            padding: 14px 30px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
        }

        /* arrows */
        .carousel-control-prev,
        .carousel-control-next {
            width: auto;
            top: auto;
            bottom: 140px;
            opacity: 1;
            z-index: 3;
        }

        .carousel-control-prev {
            right: 0px;
            transform: translateY(80px);
        }

        .carousel-control-next {
            left: 140px;
            transform: translateY(80px);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 38px;
            height: 38px;
            border: 1px solid #fff;
            border-radius: 50%;
            background-size: 14px;
        }

        /* footer */
        .hero-footer {
            position: absolute;
            bottom: 40px;
            left: 60px;
            right: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 2;
            color: #fff;
            font-size: 12px;
        }

        /* socials */
        .hero-socials {
            display: flex;
            gap: 16px;
            opacity: 0.85;
        }

        /* destinations */
        .hero-destinations {
            display: flex;
            gap: 40px;
        }

        .hero-destinations span {
            display: block;
            font-size: 20px;
            opacity: 0.6;
        }

        .hero-destinations strong {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
        }

        /* responsive */
        @media (max-width: 768px) {
            .hero-content {
                left: 30px;
                right: 30px;
                bottom: 100px;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .carousel-control-prev,
            .carousel-control-next,
            .hero-destinations {
                display: none;
            }
        }
    </style>

    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">

        <div class="carousel-inner">
            <?php foreach ($slides as $index => $slide):
                $desc = $slide['desc'] ?? '';
                $bg   = $slide['bg'] ?? '';
            ?>
                <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                    <img src="<?php echo esc_url($bg); ?>" alt="">
                    <div class="overlay"></div>

                    <div class="hero-content">
                        <div class="count">
                            <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            / <?php echo str_pad(count($slides), 2, '0', STR_PAD_LEFT); ?>
                        </div>

                        <h1><?php echo esc_html($title); ?></h1>

                        <p><?php echo esc_html($desc); ?></p>

                        <div class="hero-actions">
                            <a href="#" class="btn-book">BOOK A TRIP</a>
                        </div>
                    </div>
                </div>
            <?php
                $first = false;
            endforeach; ?>
        </div>

        <div class="arrow-wrapper">
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>


        <!-- footer -->
        <div class="hero-footer">
            <div class="hero-socials">
                <span>FB</span>
                <span>TW</span>
                <span>IG</span>
                <span>YT</span>
            </div>

            <div class="hero-destinations">
                <div>
                    <span>01</span>
                    <strong>Tanzania’s<br>Great Migration</strong>
                </div>
                <div>
                    <span>02</span>
                    <strong>Danube Christmas<br>Markets Cruise</strong>
                </div>
                <div>
                    <span>03</span>
                    <strong>A Circumnavigation<br>of Iceland</strong>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php endif; ?>