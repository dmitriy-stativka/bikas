<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development and
 * https://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://codex.wordpress.org/Plugin_API
 *
 * @package    WordPress
 * @subpackage Twenty_Twelve
 * @since      Twenty Twelve 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( !isset( $content_width ) )
	$content_width = 625;

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses  load_theme_textdomain() For translation/localization support.
 * @uses  add_editor_style() To add a Visual Editor stylesheet.
 * @uses  add_theme_support() To add support for post thumbnails, automatic feed links,
 *    custom background, and post formats.
 * @uses  register_nav_menu() To add support for navigation menus.
 * @uses  set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentytwelve
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}

add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @return string Font stylesheet or empty string if disabled.
 * @since Twenty Twelve 1.2
 *
 */
function twentytwelve_get_font_url() {
	$font_url = '';
	return $font_url;
}

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140711', true );


	// Loads our main stylesheet.
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'fontello', get_template_directory_uri() . '/css/fontello.css', array( 'twentytwelve-style' ), '20160810' );
	wp_enqueue_style( 'fontello-codes', get_template_directory_uri() . '/css/fontello-codes.css', array( 'twentytwelve-style' ), '20160810' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}

add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );


if ( !defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

// Connetct main assets
function connect__assets() {
	wp_enqueue_style( 'main_style', get_stylesheet_directory_uri() . '/assets/build/css/style.css', array(), _S_VERSION );
	wp_enqueue_script( 'main_script', get_template_directory_uri() . '/assets/build/js/main.js', array(), _S_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'connect__assets' );

// Add global options group
if ( function_exists( 'acf_add_options_sub_page' ) ) {
	acf_add_options_sub_page();
}

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 *
 * @return string Filtered CSS path.
 * @uses  twentytwelve_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 */
function twentytwelve_mce_css( $mce_css ) {
	$font_url = twentytwelve_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( !empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}

add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 *
 * @return string Filtered title.
 * @since Twenty Twelve 1.0
 *
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && !is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( !isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
			'name'          => __( 'Main Sidebar', 'twentytwelve' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
	) );

	register_sidebar( array(
			'name'          => __( 'Головна', 'twentytwelve' ),
			'id'            => 'index-page',
			'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
			'before_widget' => '<div class="index-text">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title">',
			'after_title'   => '</h3>',
	) );
	register_sidebar( array(
			'name'          => __( 'Categorry', 'twentytwelve' ),
			'id'            => 'mobile-category',
			'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
			'before_widget' => '<div class="mobile-category">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="title">',
			'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'twentytwelve_widgets_init' );


if ( !function_exists( 'twentytwelve_content_nav' ) ) :
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_content_nav( $html_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
            <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
            <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
        </nav><!-- .navigation -->
		<?php endif;
	}
endif;

if ( !function_exists( 'twentytwelve_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own twentytwelve_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
          <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
          <p><?php _e( 'Pingback:', 'twentytwelve' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
      <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
          <article id="comment-<?php comment_ID(); ?>" class="comment">
              <header class="comment-meta comment-author vcard">
								<?php
								echo get_avatar( $comment, 44 );
								printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
										get_comment_author_link(),
										// If current post author is also comment author, make it known visually.
										( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
								);
								printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										/* translators: 1: date, 2: time */
										sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
								);
								?>
              </header><!-- .comment-meta -->

						<?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
						<?php endif; ?>

              <section class="comment-content comment">
								<?php comment_text(); ?>
								<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
              </section><!-- .comment-content -->

              <div class="reply">
								<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
              </div><!-- .reply -->
          </article><!-- #comment-## -->
				<?php
				break;
		endswitch; // end comment_type check
	}
endif;

if ( !function_exists( 'twentytwelve_entry_meta' ) ) :
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own twentytwelve_entry_meta() to override in a child theme.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_entry_meta() {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
		);

		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
				get_the_author()
		);

		// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
		if ( $tag_list ) {
			$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		} elseif ( $categories_list ) {
			$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		} else {
			$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		}

		printf(
				$utility_text,
				$categories_list,
				$tag_list,
				$date,
				$author
		);
	}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @param array $classes Existing class values.
 *
 * @return array Filtered class values.
 * @since Twenty Twelve 1.0
 *
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();


	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
    elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( !is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}

add_filter( 'body_class', 'twentytwelve_body_class' );


/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 *
 * @since Twenty Twelve 1.0
 *
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'            => '.site-title > a',
				'container_inclusive' => false,
				'render_callback'     => 'twentytwelve_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'twentytwelve_customize_partial_blogdescription',
		) );
	}
}

add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 * @see   twentytwelve_customize_register()
 *
 * @since Twenty Twelve 2.0
 */
function twentytwelve_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 * @see   twentytwelve_customize_register()
 *
 * @since Twenty Twelve 2.0
 */
function twentytwelve_customize_partial_blogdescription() {
	bloginfo( 'description' );
}


// Кнопка купить в карточке товара
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
	return __( 'Зробити замовлення', 'woocommerce' );
}

/*
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );  // 2.1 +
function woo_custom_product_add_to_cart_text() {
    return __( 'Купити', 'woocommerce' );
}

//
add_filter('woocommerce_product_add_to_cart_text','my_woocommerce_variable_text_button',10,2);
function my_woocommerce_variable_text_button($text,$product){
	if($product->product_type == 'variable'){
		$text = 'Вибрати колір';
	}
 return $text;
}
*/

// Скрыть отображение количества товаров в категории. 
add_filter( 'woocommerce_subcategory_count_html', 'jk_hide_category_count' );
function jk_hide_category_count() {
}


/*
// Меняем вкладку "Дополнительная информация" на "Характеристики" на странице товара

add_filter ( 'woocommerce_product_additional_information_tab_title', 'custom_product_additional_information_tab_title' ) ;
function custom_product_additional_information_tab_title() {
return 'Характеристики'; // Change Me!
}
add_filter ( 'woocommerce_product_additional_information_heading', 'custom_product_additional_information_heading' ) ;
function custom_product_additional_information_heading() {
return 'Характеристики'; // Change Me!
}

*/


// Заменяем кнопку Добавить в корзину на подробнее 

// шаг 1 - Удаляем кнопку Добавить в корзину

function remove_loop_button() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

add_action( 'init', 'remove_loop_button' );


// шаг 2 -Добавляем кнопку Подробнее 

add_action( 'woocommerce_after_shop_loop_item', 'replace_add_to_cart' );
function replace_add_to_cart() {
	global $product;
	$link = $product->get_permalink();
	echo do_shortcode( '<a href="' . $link . '" class="button alt add-to-cart">У кошик</a>' );
}

//add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 24;' ), 20 );


/*

*/


/* remove dashicon */
function wpdocs_dequeue_dashicon() {
	if ( current_user_can( 'update_core' ) ) {
		return;
	}
	wp_deregister_style( 'dashicons' );
}

add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );
add_filter( 'script_loader_tag', 'add_async_attribute', 10, 2 );


/* Cниппет, который добавит асинхронную загрузку для скриптов, подключенных через */
function add_async_attribute( $tag, $handle ) {
	if ( !is_admin() ) {
		if ( 'jquery-core' == $handle ) {
			return $tag;
		}
		return str_replace( ' src', ' defer src', $tag );
	} else {
		return $tag;
	}
}

/*

function woo_catalog_orderby( $orderby ) {
   

   unset($orderby["price"]); // Сортировка по цене по возрастанию
    unset($orderby["price-desc"]); // Сортировка по цене по убыванию
    unset($orderby["popularity"]); // Сортировка по популярности
    unset($orderby["rating"]); // Сортировка по рейтингу
    unset($orderby["date"]);    // Сортировка по дате
    unset($orderby["title"]);	 // Сортировка по названию
	
    unset($orderby["menu_order"]); // Сортировка по умолчанию (можно определить порядок в админ панели)
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "woo_catalog_orderby", 20 );


add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
  $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if ( 'random_list' == $orderby_value ) {
		$args['orderby'] = 'date';
		$args['order'] = '';
		$args['meta_key'] = '';
	}
	return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
function custom_woocommerce_catalog_orderby( $sortby ) {
	$sortby['random_list'] = 'Новинки';
	return $sortby;
}

*/


add_filter( 'woocommerce_get_catalog_ordering_args', 'truemisha_sort_by_stock', 25 );

function truemisha_sort_by_stock( $args ) {

	$args['orderby'] = 'date';
	$args['order']   = 'DESC';

	return $args;

}


/*
 * Remove billing_email from WooCommerce addon
 */

add_filter( 'wppb_woo_billing_fields', 'wppbc_remove_billing_email' );
function wppbc_remove_billing_email( $fields ) {
	if ( is_array( $fields ) && isset( $fields['billing_email'] ) ) {
		unset( $fields['billing_email'] );
	}
	return $fields;
}

//add_theme_support( 'woocommerce' );