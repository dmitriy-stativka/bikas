<?php

$build_folder = get_template_directory_uri() . '/assets/build/';

/* Template Name: Home */
get_header(); ?>
    <!-- <div id="primary" class="site-content">
        <div id="content" role="main">
            <?php
            echo do_shortcode('[metaslider id=204]'); ?>
        </div>
    </div> -->
<?php get_sidebar(); ?>
    <div class="home-category">

        <?php load_template(get_template_directory() . '/components/banners.php', true); ?>

        <section class="home-category-section">
            <div class="container">
                <?php load_template(get_template_directory() . '/components/catalog-grid.php', true); ?>
            </div>
        </section>


        <section class="product-section">
            <div class="container">
                <div class="product-section__inner">
                    <div class="main-top">
                        <h2 class="main-top__title">
                            <b>Топ</b> продажів
                        </h2>
                    </div>

                    <div class='product-section__slider'>
                        <button class='swiper-button swiper-button-prev'>
                            <svg width='22' height='40'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-left'></use>
                            </svg>
                        </button>
                        <div class='swiper-container'>
                            <ul class='swiper-wrapper'>
                                <?php if (have_rows('homme', 9495)) {
                                while (have_rows('homme', 9495)) { 
                                    the_row();
                                    
                                    $id = get_sub_field('chooser', 9495);
                                    
                                    // Do something...
                                    
                                    $args = array(
                                        'posts_per_page' => 1,
                                        'post_type' => 'product',
                                        'post__in' => array($id),
                                    );

                                    $query = new WP_Query($args);

                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                        ?><li class="swiper-slide"><?php  wc_get_template_part('content', 'product'); ?></li> <?php
                                        }
                                    } else {
                                        // Постов не найдено
                                    }

                                    wp_reset_postdata();
                                }
                                } else {
                                    // Do something...
                                }
                                ?>
                            </ul>
                        </div>
                        <button class='swiper-button swiper-button-next'>
                            <svg width='22' height='40'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-right'></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <?php load_template(get_template_directory() . '/components/icons-section.php', true); ?>

        <section class="product-section">
            <div class="container">
                <div class="product-section__inner">
                    <div class="main-top">
                        <h2 class="main-top__title">
                            <b>Наша</b> продукція
                        </h2>
                    </div>

                    <div class='product-section__slider'>
                        <button class='swiper-button swiper-button-prev'>
                            <svg width='22' height='40'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-left'></use>
                            </svg>
                        </button>
                        <?php echo do_shortcode('[recent_products per_page="12"]'); ?>
                        <button class='swiper-button swiper-button-next'>
                            <svg width='22' height='40'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-right'></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
            
        <!-- <div class="home-contant">
            <?php the_content(9495); ?>
        </div> -->
        <div class="home-widget">
            <?php
            if (is_active_sidebar('index-page')) : ?>
                <?php
                dynamic_sidebar('index-page'); ?>
            <?php
            endif; ?>
        </div>
    </div>
<?php
get_footer(); ?>