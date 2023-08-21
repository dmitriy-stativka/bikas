<?php  $build_folder = get_template_directory_uri() . '/assets/build/';?>

<div class="mobile-menu">

    <div class="mobile-menu__search">
        <form role="search" method="get" class="woocommerce-product-search header__search"
            action="https://bikas.com.ua/">
            <input type="search" id="woocommerce-product-search-field" class="search-field"
                placeholder="Пошук товарів&hellip;" value="" name="s" title="Искать:"/>
            <!-- <base_convert type="submit" class="icon-fontello" value="&#xe802;" /> -->
            <button class="submit-btn" type="submit">
                <svg width='20' height='20'>
                    <use href='<?php echo $build_folder?>img/sprite/sprite.svg#search'></use>
                </svg>
            </button>
            <input type="hidden" name="post_type" value="product" />
        </form>
    </div>

    <nav class="mobile-menu__nav">
        <ul>
            <li><a href="#">Жіночи куртки</a></li>
            <li><a href="#">Чоловічи куртки</a></li>
            <li><a href="#">Акціі</a></li>
            <li><a href="#">усі новинки</a></li>
            <li><a href="#">бестселери</a></li>
        </ul>

        <?php dynamic_sidebar('sidebar-1'); ?>
    </nav>

    <div class="mobile-menu__bottom">
        <?php wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class' => 'nav-menu',
        ]); ?>

        <div class="footer__text">
            <svg width='14' height='16'>
                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#clock'></use>
            </svg>

            <div class="footer__links">
            <span><?php echo esc_html( get_field( 'first', 'options' ) ); ?></span>
            <span><?php echo esc_html( get_field( 'second', 'options' ) ); ?></span>
            </div>
        </div>

    </div>

</div>