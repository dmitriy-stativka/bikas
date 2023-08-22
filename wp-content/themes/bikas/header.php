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
    <meta name="viewport" content="width=device-width,initial-scale=1">
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
                    <div class="burger-btn">
                        <span>Меню</span>
                        <button class="burger">
                            <span class="burger__line"></span>
                        </button>
                    </div>
                    

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
                        <button class="header__category catalog-trigger">
                            <span>категорії</span>
                            <svg width='20' height='20'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#menu'></use>
                            </svg>
                        </button>  

                        <div class="header__buttons">
                          <button class="header__btn" data-btn-modal="dialog">
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

                        <ul class='accordion phone header__numbers' data-accordion>
                            <li class='accordion__item'>
                                <div class="accordion__header">
                                    <a href="tel:+38 (093) 334 52 61">+38 (093) 334 52 61 <span>(Viber)</span></a>
                                    <button class='accordion__btn' data-id='1'>
                                        <svg width='15' height='15'>
                                            <use href='<?php echo $build_folder?>img/sprite/sprite.svg#arrow-bottom'></use>
                                        </svg>
                                    </button>
                                </div>
                            
                            <div class='accordion__content' data-content='1'>
                                <ul class="phone__list">
                                    <li class="phone__item">
                                        <a href="tel:+38 (093) 334 52 61">+38 (093) 334 52 61 <span>(Viber)</span></a>
                                    </li>
                                    <li class="phone__item">
                                        <a href="tel:+38 (093) 334 52 61">+38 (093) 334 52 61 <span>(Viber)</span></a>
                                    </li>
                                </ul>
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </header>
        <?php load_template(get_template_directory() . '/components/mobile-menu.php', true); ?>                     
        <div id="main" class="wrapper">
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="catalog-menu">
                    <div class="catalog-menu__top">
                            <svg width='40' height='40'>
                                <use href='<?php echo $build_folder?>img/sprite/sprite.svg#menu'></use>
                            </svg>

                        <button class="catalog-menu__close burger catalog-trigger">
                            <span class="burger__line"></span>
                        </button>
                    </div>
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div>
            <?php endif; ?>
