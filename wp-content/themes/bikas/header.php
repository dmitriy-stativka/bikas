<?php


$build_folder = get_template_directory_uri() . '/assets/build/'
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta name="facebook-domain-verification" content="28844q6h21lgntdm53l2e9gwpoot8s" />
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php wp_title('|', TRUE, 'right'); ?></title>
    <link rel="preconnect" href="https://bikas.com.ua/">
    <link rel="dns-prefetch" href="https://bikas.com.ua/">


    <link rel="preload" href="<?php echo $build_folder ?>fonts/Comforter-Regular.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/Roboto-Regular.woff2" as="font" crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/RobotoCondensed-Light.woff2" as="font"
        crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/RobotoCondensed-Regular.woff2" as="font"
        crossorigin="anonymous">
    <link rel="preload" href="<?php echo $build_folder ?>fonts/RobotoCondensed-Bold.woff2" as="font"
        crossorigin="anonymous">

    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
    <?php wp_head(); ?>
    <!--<script>document.addEventListener('touchstart', onTouchStart, {passive: true});</script>-->
    <!-- Meta Pixel Code -->
    <script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) {
            return;
        }
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments);
        };
        if (!f._fbq) {
            f._fbq = n;
        }
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s);
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '851257589188347');
    fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=851257589188347&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->
</head>

<body <?php body_class(); ?>>
    <div id="page" class="hfeed site">

        <header>
            <div class="header-top">
                <div class="container">
                    <div class="header-top__inner">
                        <nav id="header-menu">
                            <?php wp_nav_menu([
                              'theme_location' => 'primary',
                              'menu_class' => 'nav-menu',
                            ]); ?>
                        </nav>

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
            </div>
            <div class="container">
                <div class="header">
                    <a href="/" class="header__logo">
                        <?php $logo_icon = get_field('logo_icon', 'options');
                        if ( $logo_icon ) : ?>
                        <img src="<?php echo esc_url($logo_icon['url']); ?>"
                            alt="<?php echo esc_attr($logo_icon['alt']); ?>" />
                        <?php endif; ?>
                    </a>

                    <div class="header__center">
                      <nav class="header__nav">
                          <ul>
                            <li><a href="#">Жіночи куртки</a></li>
                            <li><a href="#">Чоловічи куртки</a></li>
                            <li><a href="#">Акціі</a></li>
                            <li><a href="#">усі новинки</a></li>
                            <li><a href="#">бестселери</a></li>
                          </ul>
                      </nav>

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


                    <div class="header__coll">
                        <button class="header__category">
                            категорії 
                            <svg width='20' height='20'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#menu'></use>
                            </svg>
                        </button>  

                        <div class="header__buttons">
                          <button class="header__btn" data-btn-modal="favorite">
                            <svg width='20' height='20'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#favorite'></use>
                            </svg>
                          </button>
                          <button class="header__btn" data-btn-modal="cart">

                            <span class="header__btn-icon" id="cart-total">
                              <?php echo WC()->cart->get_cart_contents_count(); ?>
                            </span>
                            <svg width='20' height='20'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#cart'></use>
                            </svg>
                          </button>
                        </div>

                        <div class="header__numbers">
                            +38 (093) 334 52 61 (Viber)
                        </div>
                    </div>
                </div>
            </div>


        </header>


        <!-- <div id="mobile-header">
            <div id="mobile-nav">
                <a href="#" id="mobile-menu-button" class="icon-menu"></a>
                <a href="#" id="mobile-category-button" class="icon-doc-text-inv"></a>
                <a href="#" id="mobile-search-button" class="icon-search"></a>
                <a href="#cart-dialog" id="mobile-shop-button"
                    class="icon-shop"><span><?php echo WC()->cart->get_cart_contents_count(); ?></span></a>
                <a href="#" id="mobile-phone-button" class="icon-phone"></a>
                <a href="#callback-dialog" id="mobile-callback-button" class="icon-volume-control-phone"></a>
                <div id="mobile-logo"><a href="#">Bikas</a></div>
            </div>
            <nav id="mobile-menu">
                <?php wp_nav_menu([
                'menu' => 'mobile-menu',
                'items_wrap' => '%3$s',
                'container' => FALSE,
              ]); ?>
            </nav>
            <div id="mobile-phone">
                <div class="icon-phone"><span class="phone-number">+38 (093) <span
                            class="phone-number-bold">334-52-61</span></span></div>
                <div class="icon-phone"><span class="phone-number">+38 (096) <span
                            class="phone-number-bold">251-64-52</span></span></div>
            </div>
            <div id="mobile-search">
                <form role="search" method="get" class="woocommerce-product-search" action="https://bikas.com.ua/">
                    <input type="search" id="woocommerce-product-search-field" class="search-field"
                        placeholder="Поиск товаров&hellip;" value="" name="s" title="Искать:"
                        style="width: calc(100% - 50px);" />
                    <input type="submit" class="icon-fontello" value="&#xe802;" />
                    <input type="hidden" name="post_type" value="product" />
                </form>
            </div>
        </div> -->
        <!-- <header id="site-header">
            <div id="header-top">
                <div class="header-inner">

                    <div class="icon-location header-inner-one"><span><a href="https://bikas.com.ua/kontakty/">Адреса
                                магазину</a></span>
                    </div>
                    <div class="icon-volume-control-phone header-inner-one"><span><a href="#callback-dialog">Зворотний
                                дзвінок</a></span>
                    </div>
                    <div class="icon-user header-inner-one"><span><a href="https://bikas.com.ua/my-account/">Вхід в
                                особистий кабінет</a></span>
                    </div>
                </div>
            </div>
            <div id="header-contact">
                <div class="header-inner">
                    <?php if (is_home()) { ?>
                    <div id="header-logo"></div>
                    <?php } else { ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                        title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                        <div id="header-logo"></div>
                    </a>
                    <?php } ?>
                    <div id="header-phone">
                        <div class="icon-phone"><span class="phone-number">+38 (093) <span
                                    class="phone-number-bold">334-52-61</span> (Viber)</span>
                        </div>
                        <div class="icon-phone"><span class="phone-number">+38 (096) <span
                                    class="phone-number-bold">251-64-52</span></span>
                        </div>

                        
                    </div>
                    <a href="#cart-dialog">
                        <div id="header-cart">
                            <div id="cart-total"><?php echo WC()->cart->get_cart_contents_count(); ?></div>
                        </div>
                    </a>
                </div>
            </div>

        </header> -->
        <div id="main" class="wrapper">
            <?php if (is_active_sidebar('sidebar-1')) : ?>
            <div id="secondary" class="widget-area catalog-menu" role="complementary">
                <?php dynamic_sidebar('sidebar-1'); ?>
            </div><!-- #secondary -->
            <?php endif; ?>


