<?php
/**
 * Testimonial Basucs WordPress Plugin
 *
 * A complete comprehensive management of testimonials.
 *
 * @package   Testimonial Basics
 * @link      https://kevinsspace.ca/testimonial-basics-user-documentation/testimonial-basics-wordpress-plugin/
 * @author    Kevin Archibald <kevin@kevinsspace.ca>
 * @copyright 2020 or later Kevin Archibald
 * @license   GPL v3
 *
 * Plugin Name: Testimonial Basics
 * Plugin URI: https://kevinsspace.ca/testimonial-basics-user-documentation/testimonial-basics-wordpress-plugin/
 * Description: This plugin provides complete comprehensive management of customer testimonials. The user can set up an input form in a page or in a widget, and display all or selected testimonials in a page or a widget. The plug in is very easy to use and modify.
 * Version: 4.5.1
 * Author: Kevin Archibald
 * Author URI: http://kevinsspace.ca
 * License: GPLv3
 * Text Domain: testimonial-basics
 */

/**
 * License: GNU General Public License V3
 * License URI: http://www.gnu.org/copyleft/gpl.html
 * Testimonial Basics is a plugin for WordPress
 * Copyright (C) 2020 or later Kevin Archibald
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Globalize $katb_options.
global $katb_options;

// constants.
define( 'TESTIMONIAL_BASICS_VERSION', '4.5.0' );

/**
 * Allows shortcodes to be displayed in sidebar text widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );

global $katb_db_new_version;
$katb_db_new_version = '1.5';
// Check for database table and create if not there.
if ( 'null' !== get_option( 'katb_database_version' ) ) {
	$katb_tb_installed_version = get_option( 'katb_database_version' );
} else {
	$katb_tb_installed_version = 0;
}

/**
 * Plugin Activation
 *
 * When the plugin is activated this function is executed
 * It initially checks for a minimum version of WordPress and won't load if
 * the WordPress Version is below that.
 *
 * Checks for database table and creates one if not there
 * table name : database prefix + testimonial_basics.
 */
function katb_testimomial_basics_activate() {
	// Check version compatibilities.
	if ( version_compare( get_bloginfo( 'version' ), '4.8', '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin.
		die( esc_html__( 'Please Upgrade your WordPress to use this plugin.', 'testimonial-basics' ) );
	}
	// Global variables.
	global $wpdb, $katb_db_new_version, $katb_tb_installed_version;
	$katb_tb_installed_version = get_option( 'katb_database_version' );
	$tablename                 = $wpdb->prefix . 'testimonial_basics';
	$tableprefix               = strtolower( $wpdb->prefix );
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$tablename'" ) !== $tablename && $wpdb->get_var( "SHOW TABLES LIKE '$tablename'" ) !== $tableprefix . 'testimonial_basics' ) { // phpcs:ignore
		// Add charset & collate like wp core.
		$charset_collate = $wpdb->get_charset_collate();
		// Create new table.
		$sql = "CREATE TABLE $tablename (
				tb_id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				tb_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				tb_group char(100) NOT NULL,
				tb_order int(4) UNSIGNED NOT NULL,
				tb_approved int(1) UNSIGNED NOT NULL,
				tb_name char(100) NOT NULL,
				tb_location char(100) NOT NULL,
				tb_email char(100) NOT NULL,
				tb_pic_url char(150) NOT NULL,
				tb_url char(150) NOT NULL,
				tb_rating char(5) NOT NULL,
				tb_title char(100) NOT NULL,
				tb_custom1 char(100) NOT NULL,
				tb_custom2 char(100) NOT NULL,
				tb_testimonial text NOT NULL,
				PRIMARY KEY (tb_id)
			)$charset_collate;"; // xss ok.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( 'katb_database_version', $katb_db_new_version );
	} elseif ( $katb_tb_installed_version !== $katb_db_new_version ) {
		// Ensure all tables are upgraded to 1.5.
		$sql = "CREATE TABLE $tablename (
				tb_id int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				tb_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				tb_group char(100) NOT NULL,
				tb_order int(4) UNSIGNED NOT NULL,
				tb_approved int(1) UNSIGNED NOT NULL,
				tb_name char(100) NOT NULL,
				tb_location char(100) NOT NULL,
				tb_email char(100) NOT NULL,
				tb_pic_url char(150) NOT NULL,
				tb_url char(150) NOT NULL,
				tb_rating char(5) NOT NULL,
				tb_title char(100) NOT NULL,
				tb_custom1 char(100) NOT NULL,
				tb_custom2 char(100) NOT NULL,
				tb_testimonial text NOT NULL
			);";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
		update_option( 'katb_database_version', $katb_db_new_version );
	}
}
register_activation_hook( __FILE__, 'katb_testimomial_basics_activate' );

/**
 * Check database version and update.
 */
function katb_update_db_check() {
	global $katb_db_new_version, $katb_tb_installed_version;
	if ( $katb_tb_installed_version !== $katb_db_new_version ) {
		katb_testimomial_basics_activate();
	}
}
add_action( 'plugins_loaded', 'katb_update_db_check' );

/**
 * Plugin Deactivation
 *
 * When the plugin is deactivated this function is executed.
 * Nothing is required to be done with this plugin but I left the function here
 * as a reminder.
 */
function katb_testimomial_basics_deactivate() {
	// Do these things when deactvated.
}
register_deactivation_hook( __FILE__, 'katb_testimomial_basics_deactivate' );

/**
 * Plugin Setup
 *
 * When the plugin is loaded this function is executed.
 * Loads these files on setup.
 * Activates the translation on setup.
 * ---------------------------------------------------------------------- */
function katb_testimonial_basics_plugin_setup() {
	require_once dirname( __FILE__ ) . '/includes/katb-options.php';
	require_once dirname( __FILE__ ) . '/includes/katb-shortcodes.php';
	require_once dirname( __FILE__ ) . '/widgets/class-katb-input-testimonial-widget.php';
	require_once dirname( __FILE__ ) . '/widgets/class-katb-display-testimonial-widget.php';
	require_once dirname( __FILE__ ) . '/includes/katb-functions.php';
	// Enable translation.
	load_plugin_textdomain( 'testimonial-basics', false, 'testimonial-basics/languages/' );
	// Load plugin options.
	global $katb_options;
	$katb_options = katb_get_options();
}
add_action( 'plugins_loaded', 'katb_testimonial_basics_plugin_setup' );

/**
 * Load Admin Functions
 *
 * The admin functions are loaded if in admin mode.
 */
if ( is_admin() ) {
	// Load admin functions.
	require_once dirname( __FILE__ ) . '/includes/katb-testimonial-basics-admin.php';
}

/**
 * Enqueue Styles
 *
 * When the plugin is activated this function is executed.
 * Loads these files on setup.
 * Activates the translation on setup.
 * ----------------------------------------------------------------------- */
function katb_add_styles() {
	global $katb_options;
	if ( is_rtl() && true === $katb_options['katb_remove_rtl_support'] ) {
		wp_enqueue_style( 'katb_user_styles', plugin_dir_url( __FILE__ ) . 'css/katb_user_styles_rtl.css', array(), TESTIMONIAL_BASICS_VERSION );
	} else {
		wp_enqueue_style( 'katb_user_styles', plugin_dir_url( __FILE__ ) . 'css/katb_user_styles.css', array(), TESTIMONIAL_BASICS_VERSION );
	}
	$katb_css = katb_custom_css();
	wp_add_inline_style( 'katb_user_styles', $katb_css );
}
add_action( 'wp_enqueue_scripts', 'katb_add_styles' );

/**
 * Enqueue Scripts
 *
 * Loads the excerpt, rotator, and ratings script if required
 *
 * @uses katb_get_options() from katb_functions.php
 */
function katb_load_scripts() {
	global $katb_options;
	if ( true === $katb_options['katb_widget_use_excerpts'] || true === $katb_options['katb_use_excerpts'] ) {
		wp_enqueue_script( 'katb_excerpt_js', plugins_url() . '/testimonial-basics/js/katb_excerpt_doc_ready.js', array( 'jquery' ), TESTIMONIAL_BASICS_VERSION, true );
	}
	if ( true === $katb_options['katb_enable_rotator'] ) {
		wp_enqueue_script( 'katb_rotator_js', plugins_url() . '/testimonial-basics/js/katb_rotator_doc_ready.js', array( 'jquery' ), TESTIMONIAL_BASICS_VERSION, true );
		wp_enqueue_script( 'jquery-effects-slide' );
	}
	if ( true === $katb_options['katb_use_recaptcha'] ) {
		// CaptchaCallback is in the doc ready so it is loaded first.
		wp_enqueue_script( 'katb-recaptcha-doc-ready', plugins_url() . '/testimonial-basics/js/katb_recaptcha.js', array( 'jquery' ), TESTIMONIAL_BASICS_VERSION, true );
		wp_enqueue_script( 'katb-google-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=KatbCaptchaCallback&render=explicit', array( 'katb-recaptcha-doc-ready' ), TESTIMONIAL_BASICS_VERSION, true );
	}
	wp_enqueue_script( 'katb_mosaic_js', plugins_url() . '/testimonial-basics/js/katb_mosaic_doc_ready.js', array( 'jquery' ), TESTIMONIAL_BASICS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'katb_load_scripts' );
