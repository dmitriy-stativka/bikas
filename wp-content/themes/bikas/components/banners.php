<section class="banner-section">
    <div class="container">
        <div class="banner-section__inner">
            <div class="swiper-container">
                <?php if (have_rows("Baners")): ?>
                    <ul class="swiper-wrapper">
                        <?php while (have_rows("Baners")):the_row(); ?>
                            <li class="swiper-slide">
                                <div class="banner">
                                    <?php if ($description = get_sub_field("description")): ?>
                                        <span class="banner__descr">
                                            <?php echo esc_html($description)?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ($title = get_sub_field("title")): ?>
                                        <h2 class="banner__title"><?php echo $title; ?></h2>
                                    <?php endif; ?>

                                    <?php if ($subtitle = get_sub_field("subtitle")): ?>
                                        <p class="banner__subtitle"><?php echo esc_html($subtitle)?></p>
                                    <?php endif; ?>

                                    <?php if ($link = get_sub_field("link")): ?>
                                        <a class="banner__link main-button" href="<?php echo esc_html($link)?>">дивитися</a>
                                    <?php endif; ?>

                                    <?php $img = get_sub_field("img");
                                    if ($img): ?>
                                        <div class="banner__image">
                                            <img src="<?php echo esc_url($img["url"])?>"
                                                 alt="<?php echo esc_attr($img["alt"])?>" />
                                        </div>
                                    <?php endif;?>
                                </div>
                            </li>

                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <span class="swiper-pagination banner-section__pagination"></span>
        </div>
    </div>
</section>
