<?php
/**
 * This is the admin file for Testimonial Basics
 *
 * @package     Testimonial Basics WordPress Plugin
 * @copyright   Copyright (C) 2020 or later Kevin Archibald
 * @license     http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author      Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */

/*
 * ====================================================================================
 * Function Index
 * ------------------------------------------------------------------------------------
 *
 * katb_testimonial_basic_admin_style()--------------------------------------- ~   66
 * katb_testimonial_basics_create_menu()-------------------------------------- ~   93
 * katb_testimonial_basics_introduction()------------------------------------- ~  151
 * katb_testimonial_basics_options_page()------------------------------------- ~  400
 * katb_testimonial_basics_admin_init()--------------------------------------- ~  432
 * katb_get_page_tab_markup()------------------------------------------------- ~  524
 * katb_sections_callback()--------------------------------------------------- ~  569
 * katb_setting_callback()---------------------------------------------------- ~  594
 * katb_testimonial_basics_edit_page()---------------------------------------- ~  704
 * katb_edit_testimonials_contextual_help()----------------------------------- ~ 1243
 * katb_plugin_options_contextual_help()-------------------------------------- ~ 1294
 * katb_general_tab_help()---------------------------------------------------- ~ 1362
 * katb_input_tab_help()------------------------------------------------------ ~ 1426
 * katb_content_tab_help()---------------------------------------------------- ~ 1508
 * katb_widget_tab_help()----------------------------------------------------- ~ 1572
 * katb_faq_tab_help()-------------------------------------------------------- ~ 1633
 * katb_validate_options()---------------------------------------------------- ~ 1673
 * katb_show_msg()------------------------------------------------------------ ~ 1809
 * katb_admin_msgs()---------------------------------------------------------- ~ 1816
 * katb_intro_html()---------------------------------------------------------- ~ 1845
 * katb_get_settings_by_tab()------------------------------------------------- ~ 1882
 * katb_get_settings_page_tabs()---------------------------------------------- ~ 1923
 * katb_get_current_tab()----------------------------------------------------- ~ 2018
 * katb_backup_restore_page()------------------------------------------------- ~ 2041
 * katb_maybe_download()------------------------------------------------------ ~ 2092
 * katb_maybe_upload()-------------------------------------------------------- ~ 2110
 * katb_do_backup()----------------------------------------------------------- ~ 2154
 * katb_wrap_cdata()---------------------------------------------------------- ~ 2204
 * katb_import()-------------------------------------------------------------- ~ 2215
 * katb_parse()--------------------------------------------------------------- ~ 2328
 * katb_admin_notices()------------------------------------------------------- ~ 2365
 * katb_add_unapproved_count()------------------------------------------------ ~ 2387
 *
 * ============================================= End Function Index ===================
 */

/**
 * Admin Style
 *
 * This function loads the admin stylesheet and scripts for Testimonial
 * Basics admin pages. The styles and scripts are only loaded if a
 * Testimonial Basics admin page is loaded.
 * file:katb_testimonial_basics_admin.css is in /css and is usde to style the admin pages
 * file:katb_testimonial_basics_doc_ready.js is located in /js and contains scripts for
 * display in the admin pages, and to display set up the color wheel useage
 * wp-color-picker :  are jquery scripts for selectig colors
 *
 * @param string $hook is the page url.
 */
function katb_testimonial_basic_admin_style( $hook ) {
	// Only enqueue if the admin page is loaded.
	if ( 'testimonials_page_katb-settings' !== $hook
		&& 'toplevel_page_katb_testimonial_basics_admin' !== $hook
		&& 'testimonials_page_katb_testimonial_basics_admin_edit' !== $hook
		&& 'testimonials_page_katb-backup' !== $hook ) {
		return;
	}
	// Page is loaded so go ahead.
	global $katb_options;
	if ( is_rtl() && false === $katb_options['katb_remove_rtl_support'] ) {
		wp_enqueue_style( 'katb_admin_style', plugins_url() . '/testimonial-basics/css/katb_testimonial_basics_admin_rtl.css', array(), TESTIMONIAL_BASICS_VERSION, 'all' );
	} else {
		wp_enqueue_style( 'katb_admin_style', plugins_url() . '/testimonial-basics/css/katb_testimonial_basics_admin.css', array(), TESTIMONIAL_BASICS_VERSION, 'all' );
	}
	// Load the color picker.
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	// Load our custom javascript file.
	wp_enqueue_media();
	wp_enqueue_script( 'katb_options_js', plugins_url() . '/testimonial-basics/js/katb_testimonial_basics_doc_ready.js', array( 'jquery' ), TESTIMONIAL_BASICS_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'katb_testimonial_basic_admin_style' );

/**
 * Create Menu Pages.
 */
function katb_testimonial_basics_create_menu() {
	/**
	 * Add Menu Page
	 */
	add_menu_page(
		__( 'Testimonial Basics', 'testimonial-basics' ),
		__( 'Testimonials', 'testimonial-basics' ),
		'manage_options',
		'katb_testimonial_basics_admin',
		'katb_testimonial_basics_introduction'
	);
	/**
	 * Get user options for the level that will be allowed to edit testimonials.
	 */
	$katb_options = katb_get_options();
	if ( 'Editor' === $katb_options['katb_admin_access_level'] ) {
		$edit_testimonial_capability = 'moderate_comments';
	} else {
		$edit_testimonial_capability = 'manage_options';
	}
	global $katb_edit_testimonials_page, $katb_plugin_options_page, $katb_backrest_page;
	$katb_plugin_options_page = add_submenu_page(
		'katb_testimonial_basics_admin',
		__( 'Testimonial Basics Backup or Restore', 'testimonial-basics' ),
		__( 'Backup or Restore', 'testimonial-basics' ),
		'manage_options',
		'katb-backup',
		'katb_backup_restore_page'
	);
	add_action( 'load-' . $katb_backrest_page, 'katb_plugin_options_contextual_help' );
	$katb_plugin_options_page = add_submenu_page(
		'katb_testimonial_basics_admin',
		__( 'Testimonial Basics Options', 'testimonial-basics' ),
		__( 'Options', 'testimonial-basics' ),
		'manage_options',
		'katb-settings',
		'katb_testimonial_basics_options_page'
	);
	add_action( 'load-' . $katb_plugin_options_page, 'katb_plugin_options_contextual_help' );
	$katb_edit_testimonials_page = add_submenu_page(
		'katb_testimonial_basics_admin',
		__( 'Testimonial Basics Edit Testimonials', 'testimonial-basics' ),
		__( 'Edit Testimonials', 'testimonial-basics' ),
		$edit_testimonial_capability, // phpcs:ignore
		'katb_testimonial_basics_admin_edit',
		'katb_testimonial_basics_edit_page'
	);
	add_action( 'load-' . $katb_edit_testimonials_page, 'katb_edit_testimonials_contextual_help' );
}
add_action( 'admin_menu', 'katb_testimonial_basics_create_menu' );

/**
 * Introduction
 *
 * Called by add_menu_page. Sets up the Testimonial Basics Introduction Page.
 *
 * @uses katb_intro_html()
 */
function katb_testimonial_basics_introduction(){ ?>
	<h1>
		<?php esc_html_e( 'Testimonial Basics - Instructions', 'testimonial-basics' ); ?>
	</h1>
	<?php echo katb_intro_html();// phpcs:ignore ?>
	<h3>
		<?php esc_html_e( 'Introduction', 'testimonial-basics' ); ?>
	</h3>
	<p>
		<?php
		esc_html_e( 'Testimonial Basics facilitates easy management of customer testimonials.', 'testimonial-basics' );
		echo '<br/>';
		esc_html_e( 'The user can set up an input form in a page or in a widget, and display all or selected testimonials in a page or a widget.', 'testimonial-basics' );
		?>
	</p>
	<p>
		<?php
		esc_html_e( 'If you like the program show your appreciation, buy me a coffee, beer, or a bottle of wine (red please!).', 'testimonial-basics' );
		echo '<br/>';
		esc_html_e( 'Or just head to the website link above and put in a testimonial, or send me an e-mail, pats on the back are pretty nice too!', 'testimonial-basics' );
		?>
	</p>
	<p>
		<?php esc_html_e( 'I plan to do updates if required, so also contact me if you find any problems, or have suggestions for improvements.', 'testimonial-basics' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'I briefly discuss the use of the plugin below. For detailed documentation, visit the plugin site.', 'testimonial-basics' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'I hope you enjoy Testimonial Basics!', 'testimonial-basics' ); ?>
	</p>
	<h3>
		<?php esc_html_e( 'General Data Protection Regulation', 'testimonial-basics' ); ?>
	</h3>
	<p>
		<?php
		esc_html_e( 'The EU will implement General Data protection Regulation in late May, 2018. ', 'testimonial-basics' );
		esc_html_e( 'For Testimonial Basics this means that visitors must aknowledge that their testimonial submission will be saved data. ', 'testimonial-basics' );
		esc_html_e( 'It also means that visitors can request removal of their testimonial data at any time. ', 'testimonial-basics' );
		echo ' ';
		echo '<br/><br/>';
		esc_html_e( 'Create a new page titled `Request Testimonial Removal`, or some other title you wish to use and add the following shortcode:', 'testimonial-basics' );
		echo ' ';
		?>
		<br/><br/>
		<code>[katb_remove_testimonial]</code>
		<br/><br/>
		<?php
		esc_html_e( 'In the Testimonial->Options->General tab you can set up your site to facilitate GDPR compliance.', 'testimonial-basics' );
		echo ' ';
		?>
		<ol>
			<li><?php esc_html_e( 'Check the "Use General Data Protection checkbox.".', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'A "Approve saving of testimonial data" checkbox will be set up on your testimonial input forms that must be checked by visitors submitting a testimonial.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'In "Request testimonial remove page permalink", add the permalink to the page you just created.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'You can change the default introduction text for the page.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'If the user accesses the page directly, a testimonial will not be listed. Replace this default message if you want.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'A eye minus icon appears on all testimonials displayed. If the user clicks it they will be taken to your Testimonial Removal page.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'They can add their email, and a optional comment.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'An email is sent to the site admin, or an optionally set email, requesting the testimonial be removed.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'If the email is the same as the testimonial or they provide additional details in the comments, you can remove the testimonial.', 'testimonial-basics' ); ?></li>
		</ol>
	</p>
	<h3>
		<?php esc_html_e( 'Visitor Input Form', 'testimonial-basics' ); ?>
	</h3>
	<p>
		<?php
		esc_html_e( 'You can set up a visitor input form very easily.', 'testimonial-basics' );
		echo ' ';
		esc_html_e( 'Simply include in your page content:', 'testimonial-basics' );
		echo ' ';
		?>
		<br/>
		<code>[katb_input_testimonials group="All" form="1"]</code>
		<br/>
		<ol>
			<li><?php esc_html_e( 'IMPORTANT : Make sure you set up the page using the "Text" editor and not the "Visual" editor.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'group - This will be the group name for the testimonial, default is "All"', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'form - The first form is 1 by default', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'If you have more than one form in the content area number then 1,2,3, ...', 'testimonial-basics' ); ?></li>
		</ol>
	</p>
	<h3>
		<?php esc_html_e( 'Visitor Input Widget', 'testimonial-basics' ); ?>
	</h3>
	<p>
		<?php
		esc_html_e( 'You can also use a widget as a user input form.', 'testimonial-basics' );
		echo ' ';
		esc_html_e( 'Go to "Appearance" => "Widgets" and drag the widget to the widgetized area.', 'testimonial-basics' );
		?>
	</p>
	<h3>
		<?php esc_html_e( 'Displaying Testimonials', 'testimonial-basics' ); ?>
	</h3>
	<p>
		<?php esc_html_e( 'You can display testimonials in the content of a page using shortcodes or you can use widgets to display testimonials.', 'testimonial-basics' ); ?>
	</p>
	<h4>
		<?php esc_html_e( 'Using a Shortcode', 'testimonial-basics' ); ?>
	</h4>
	<p>
		<?php
		esc_html_e( 'To display testimonials create a new page and enter the following shortcode :', 'testimonial-basics' );
		echo ' ';
		?>
		<br/>
		<code>[katb_testimonial group="all" number="all" by="random"  id="" rotate="no" layout="0" schema="default"]</code>
	</p>
	<ol>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "group" : "all" - ';
			esc_html_e( 'ignores groups', 'testimonial-basics' );
			echo ', "group_name"- ';
			esc_html_e( 'display only this grouping', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "number" : "all" - ';
			esc_html_e( 'displays all testimonials, or put in the number of testimonials you want to display', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "by" : "random" - ';
			esc_html_e( 'display randomly', 'testimonial-basics' );
			echo ', "order" - '; // translate ok.
			esc_html_e( 'display by order number, lowest to highest', 'testimonial-basics' );
			echo ', "date"- '; // translate ok.
			esc_html_e( 'display most recent first', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "id" : "" - ';
			esc_html_e( 'leave blank for multiple testimonials', 'testimonial-basics' );
			echo ', "ID" - '; // translate ok.
			esc_html_e( 'put in testimonial ID', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "rotate" : "no" - ';
			esc_html_e( 'display all selected testimonials', 'testimonial-basics' );
			echo ', "yes" - '; // translate ok.
			esc_html_e( 'rotate each testimonial', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "layout" : 0 - ';
			esc_html_e( 'default to whatever is set up in the General Options Panel', 'testimonial-basics' );
				echo ', 1 - '; // translate ok.
			esc_html_e( 'no format top meta', 'testimonial-basics' );
				echo ', 2 - '; // translate ok.
			esc_html_e( 'no format bottom meta', 'testimonial-basics' );
				echo ', 3 - '; // translate ok.
			esc_html_e( 'no format side meta', 'testimonial-basics' );
				echo ', 4 - '; // translate ok.
			esc_html_e( 'format top meta', 'testimonial-basics' );
				echo ', 5 - '; // translate ok.
			esc_html_e( 'format bottom meta', 'testimonial-basics' );
				echo ', 6 - '; // translate ok.
			esc_html_e( 'format side meta', 'testimonial-basics' );
				echo ', 7 - '; // translate ok.
			esc_html_e( 'no format mosaic', 'testimonial-basics' );
				echo ', 8 - '; // translate ok.
			esc_html_e( 'format mosaic', 'testimonial-basics' );
			?>
		</li>
		<li>
			<?php
			esc_html_e( 'Options for', 'testimonial-basics' );
			echo ' "schema" : "default" - ';
			esc_html_e( 'whatever is set up in the General Options Panel', 'testimonial-basics' );
			echo ', "yes" - '; // translate ok.
			esc_html_e( 'override to yes', 'testimonial-basics' );
			echo ', "no" - '; // translate ok.
			esc_html_e( 'override to no', 'testimonial-basics' );
			?>
		</li>
	</ol>
	<p><strong><?php esc_html_e( 'Tips', 'testimonial-basics' ); ?></strong></p>
	<ul>
		<li><?php esc_html_e( '* Note that if id is not blank ( id="" ), the "group", "by" and "number" attributes are ignored.', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* You must have more then 2 testimonials to rotate them.', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Use pagination to display a lot of testimonials.', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Pagination can only be used when displaying number="all" and by="date" or by ="order"', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Do not select rotate="yes" more than 5 times in a page content area', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* IMPORTANT : Make sure you set up the page using the "Text" editor and not the "Visual" editor.', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Layout options allow you to override the default layouts and have multiple layouts on your site.', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Schema should only be used once on a page, this option allows you to control that.', 'testimonial-basics' ); ?></li>
	</ul>
	<h4><?php esc_html_e( 'Using a Widget', 'testimonial-basics' ); ?></h4>
	<p><?php esc_html_e( 'You can also use a widget to display a testimonial.', 'testimonial-basics' ); ?>
		<ol>
			<li><?php esc_html_e( 'Drag the widget to a widetized area and enter a title', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'There are 12 options out in widgets, try one and see what it looks like', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'Save the settings', 'testimonial-basics' ); ?></li>
		</ol>	
	<p><strong><?php esc_html_e( 'Tips', 'testimonial-basics' ); ?></strong></p>
	<ul>
		<li><?php esc_html_e( '* The fewer the testimonials the lower the load time', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Rotate a maximum of 10 testimonials', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* You can not use more than 5 rotating widgets on a page', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* If you are not rotating testimonials keep the number below 3', 'testimonial-basics' ); ?></li>
		<li><?php esc_html_e( '* Some layouts are better suited for your type of sidebar then others.', 'testimonial-basics' ); ?></li>
	</ul>
	<?php
}

/** ----------------- katb_testimonial_basics_options_page -------------------------
 * Called by add_submenu_page. Sets up the Testimonial basics Option Page
 *
 * @uses katb_get_current_tab()
 * @uses katb_get_page_tab_markup()
 *
 * ---------------------------------------------------------------------------------- */
function katb_testimonial_basics_options_page() {
	// Determine the current page tab.
	$currenttab = katb_get_current_tab();
	// Define the page section accordingly.
	$settings_section = 'katb_' . $currenttab . '_tab';
	?>
	<div class="wrap katb_options_<?php echo esc_attr( $currenttab ); ?>">
		<?php katb_get_page_tab_markup(); ?>
		<form class="katb_options" action="options.php" method="post">
			<?php
			// color picker div.
			if ( 'content_display' === $currenttab || 'widget_display' === $currenttab ) {
				echo '<div id="katb_picker"></div>';
			}
			// Implement settings field security, nonces, etc.
			settings_fields( 'katb_testimonial_basics_options' );
			// Output each settings section, and each settings field in each section.
			do_settings_sections( $settings_section );
			?>
			<?php submit_button( __( 'Save Options', 'testimonial-basics' ), 'primary', 'katb_testimonial_basics_options[submit-' . $currenttab . ']', false ); ?>
			<?php submit_button( __( 'Reset Options', 'testimonial-basics' ), 'secondary', 'katb_testimonial_basics_options[reset-' . $currenttab . ']', false ); ?>
		</form>
	</div>
	<?php
}

/**
 * This function registers and defines settings for the Testimonial Basics admin panel.
 *
 * @uses katb_get_settings_page_tabs() found in this file
 * @uses katb_get_option_parameters() found in /includes/katb_functions.php
 */
function katb_testimonial_basics_admin_init() {
	// Register and define settings.
	/**
	 * Register Plugin Settings.
	 *
	 * Register katb_testimonial_basics_options array to hold all Plugin options.
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/register_setting  Codex Reference: register_setting()
	 *
	 * @param   string      $option_group       Unique Settings API identifier; passed to settings_fields() call
	 * @param   string      $option_name        Name of the wp_options database table entry
	 * @param   callback    $sanitize_callback  Name of the callback function in which user input data are sanitized
	 */
	register_setting( 'katb_testimonial_basics_options', 'katb_testimonial_basics_options', 'katb_validate_options' );
	/**
	 * Globalize the variable that holds
	 * the Settings Page tab definitions
	 *
	 * @global  array   Settings Page Tab definitions
	 */
	global $katb_tabs;
	$katb_tabs = katb_get_settings_page_tabs();
	/**
	 * Call add_settings_section() for each Settings
	 *
	 * Loop through each Theme Settings page tab, and add
	 * a new section to the Theme Settings page for each
	 * section specified for each tab.
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/add_settings_section  Codex Reference: add_settings_section()
	 *
	 * @param   string      $sectionid  Unique Settings API identifier; passed to add_settings_field() call
	 * @param   string      $title      Title of the Settings page section
	 * @param   callback    $callback   Name of the callback function in which section text is output
	 * @param   string      $pageid     Name of the Settings page to which to add the section; passed to do_settings_sections()
	 */
	foreach ( $katb_tabs as $tab ) {
		$tabname     = $tab['name'];
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $section ) {
			$sectionname  = $section['name'];
			$sectiontitle = $section['title'];
			add_settings_section( 'katb_' . $sectionname . '_section', $sectiontitle, 'katb_sections_callback', 'katb_' . $tabname . '_tab' ); // translate ok.
		}
	}

	/**
	 * Option Parameters.
	 *
	 * Globalize the variable that holds all the Theme option parameters.
	 *
	 * @global  array   Theme options parameters
	 */
	global $katb_option_parameters;
	$katb_option_parameters = katb_get_option_parameters();

	/**
	 * Call add_settings_field() for each Setting Field
	 *
	 * Loop through each Theme option, and add a new
	 * setting field to the Theme Settings page for each
	 * setting.
	 *
	 * @link    http://codex.wordpress.org/Function_Reference/add_settings_field    Codex Reference: add_settings_field()
	 *
	 * @param   string      $settingid  Unique Settings API identifier; passed to the callback function
	 * @param   string      $title      Title of the setting field
	 * @param   callback    $callback   Name of the callback function in which setting field markup is output
	 * @param   string      $pageid     Name of the Settings page to which to add the setting field; passed from add_settings_section()
	 * @param   string      $sectionid  ID of the Settings page section to which to add the setting field; passed from add_settings_section()
	 * @param   array       $args       Array of arguments to pass to the callback function
	 */
	foreach ( $katb_option_parameters as $option ) {
		$optionname    = $option['name'];
		$optiontitle   = $option['title'];
		$optiontab     = $option['tab'];
		$optionsection = $option['section'];
		$optiontype    = $option['type'];
		add_settings_field( 'katb_setting_' . $optionname, esc_html( $optiontitle ), 'katb_setting_callback', 'katb_' . $optiontab . '_tab', 'katb_' . $optionsection . '_section', $option ); // translate ok.
	}
}
add_action( 'admin_init', 'katb_testimonial_basics_admin_init' );

/**
 * Define katb Options Page Tab Markup
 *
 * @uses    katb_get_current_tab()  defined in this file
 * @uses    katb_get_settings_page_tabs()   defined in this file
 * @uses    katb_intro_html() defined in this file
 *
 * @link    http://www.onedesigns.com/tutorials/separate-multiple-theme-options-pages-using-tabs Daniel Tara
 */
function katb_get_page_tab_markup() {
	global $katb_options;
	$page    = 'katb-settings';
	$current = katb_get_current_tab();
	$tabs    = katb_get_settings_page_tabs();
	$links   = array();
	foreach ( $tabs as $tab ) {
		$tabname  = $tab['name'];
		$tabtitle = $tab['title'];
		if ( $tabname === $current ) {
			$links[] = "<a class='nav-tab nav-tab-active' href='?page=$page&tab=$tabname'>$tabtitle</a>";
		} else {
			$links[] = "<a class='nav-tab' href='?page=$page&tab=$tabname'>$tabtitle</a>";
		}
	}
	if ( is_rtl() && true === $katb_options['katb_remove_rtl_support'] ) {
		echo '<h1 style="float: right;margin: 20px 0 0 0;">Testimonial Basics Options </h1>';
	} else {
		echo '<h1 style="float: left;margin: 20px 0 0 0;">Testimonial Basics Options </h1>';
	}
	echo '<div style="clear: both;"></div>';
	katb_intro_html();

	if ( is_rtl() && true === $katb_options['katb_remove_rtl_support'] ) {
		echo '<h4 style="clear:both;float:right; margin: 10px 0 0 0;" class="nav-tab-wrapper">';
	} else {
		echo '<h4 style="clear:both;float:left; margin: 10px 0 0 0;" class="nav-tab-wrapper">';
	}
	foreach ( $links as $link ) {
		echo $link;// phpcs:ignore
	}
	echo '</h4>';
	echo '<div style="clear:both;"></div>';
}

/**
 * Callback for add_settings_section()
 *
 * Generic callback to output the section text
 * for each Plugin settings section.
 *
 * @uses katb_get_settings_page_tabs() found in this file
 *
 * @param array $section_passed Array passed from add_settings_section().
 */
function katb_sections_callback( $section_passed ) {
	global $katb_tabs;
	$katb_tabs = katb_get_settings_page_tabs();
	foreach ( $katb_tabs as $tabname => $tab ) {
		$tabsections = $tab['sections'];
		foreach ( $tabsections as $sectionname => $section ) {
			if ( 'katb_' . $sectionname . '_section' === $section_passed['id'] ) {
				?>
				<p><?php echo wp_kses_post( $section['description'] ); ?></p>
				<?php
			}
		}
	}
}

/**
 * Callback function is used to set up the html for the options page
 *
 * @param array $option is the array with the option names for that particular option.
 *
 * @uses katb_get_options()
 * @uses katb_get_option_parameters()
 * <?php checked( $katb_options[ $optionname ] ); ?>
 * <?php checked( $katb_options[ $optionname ], true, true ); ?>
 */
function katb_setting_callback( $option ) {
	// Callback for get_settings_field().
	global $katb_options;
	$option_parameters = katb_get_option_parameters();
	$optionname        = $option['name'];
	$optiontitle       = $option['title'];
	$optiondescription = $option['description'];
	$fieldtype         = $option['type'];
	$fieldname         = 'katb_testimonial_basics_options[' . $optionname . ']';
	$katb_input_class  = $option['class'];
	// Output checkbox form field markup.
	if ( 'checkbox' === $fieldtype ) {
		?>
		<input class="katb_options <?php echo esc_attr( $katb_input_class ); ?>"
				type="checkbox"
				name="<?php echo esc_attr( $fieldname ); ?>" <?php checked( $katb_options[ $optionname ] ); ?> />
		<?php
	} elseif ( 'radio' === $fieldtype ) {
		// Output radio button form field markup.
		$valid_options = array();
		$valid_options = $option['valid_options'];
		foreach ( $valid_options as $valid_option ) {
			?>
			<input class="katb_options <?php echo esc_attr( $katb_input_class ); ?>"
					type="radio"
					name="<?php echo esc_attr( $fieldname ); ?>" <?php checked( $valid_option['name'] === $katb_options[ $optionname ] ); ?>
					value="<?php echo esc_attr( $valid_option['name'] ); ?>" />
			<span>
			<?php
			echo esc_html( $valid_option['title'] );
			if ( $valid_option['description'] ) {
				?>
				<span style="padding-left:5px;"><em><?php echo wp_kses_post( $valid_option['description'] ); ?></em></span>
				<?php
			}
			?>
			</span>
			<br />
			<?php
		}
	} elseif ( 'select' === $fieldtype ) {
		// Output select form field markup.
		$valid_options = array();
		$valid_options = $option['valid_options'];
		?>
		<select class="katb_options <?php echo esc_attr( $katb_input_class ); ?>" name="<?php echo esc_attr( $fieldname ); ?>">
		<?php
		foreach ( $valid_options as $valid_option ) {
			?>
			<option <?php selected( $valid_option === $katb_options[ $optionname ] ); ?> value="<?php echo esc_attr( $valid_option ); ?>"><?php echo esc_html( $valid_option ); ?></option>
			<?php
		}
		?>
		</select>
		<?php
	} elseif ( 'text' === $fieldtype ) {
		// Output text input form field markup.
		if ( 'html' === $katb_input_class ) {
			?>
			<input id="<?php echo esc_attr( $optionname ); ?>"
					class="katb_options <?php echo esc_attr( $katb_input_class ); ?>"
					type="text"
					name="<?php echo esc_attr( $fieldname ); ?>"
					value="<?php echo esc_html( wp_unslash( $katb_options[ $optionname ] ) ); ?>" />
			<?php
		} elseif ( 'ka_color' === $katb_input_class ) {
			?>
			<input id="<?php echo esc_attr( $optionname ); ?>"
					class="katb_options hexcolor"
					type="text"
					name="<?php echo esc_attr( $fieldname ); ?>"
					value="<?php echo esc_html( wp_unslash( $katb_options[ $optionname ] ) ); ?>" />
			<?php
		} else {
			?>
			<input id="<?php echo esc_attr( $optionname ); ?>"
					class="katb_options <?php echo esc_attr( $katb_input_class ); ?>"
					type="text" name="<?php echo esc_attr( $fieldname ); ?>"
					value="<?php echo esc_attr( wp_unslash( $katb_options[ $optionname ] ) ); ?>" />
			<?php
		}
	} elseif ( 'textarea' === $fieldtype ) {
		// Output textarea input form field markup.
		?>
		<textarea class="katb_options <?php echo esc_attr( $katb_input_class ); ?>"
					type='textarea'
					name="<?php echo esc_attr( $fieldname ); ?>"
					rows='5'
					cols='41'><?php echo esc_attr( wp_unslash( $katb_options[ $optionname ] ) ); ?>
		</textarea>
		<?php
	}
	?>
	<span class="description">
		<?php echo esc_attr( wp_unslash( $optiondescription ) ); ?>
	</span>
	<?php
}

/** ---------------- katb_testimonial_basics_edit_page -----------------------------
 * called from the add_submenu_page
 * This is the edit testimonials section that displays all the testimonials and
 * allows the user to add, edit,delete, and approve testimonials
 *
 * @uses katb_get_options() found in /includes/katb_functions.php
 * @uses katb_intro_html(); found in this file
 * @uses katb_offset_setup found in /includes/katb_functions.php
 * @uses katb_setup_pagination() found in /includes/katb_functions.php
 * @uses katb_display_pagination() found in /includes/katb_functions.php
 */
function katb_testimonial_basics_edit_page() {
	global $wpdb,$tablename;
	$tablename = $wpdb->prefix . 'testimonial_basics';
	// get user options.
	$katb_options      = katb_get_options();
	$use_ratings       = $katb_options['katb_use_ratings'];
	$katb_custom1_name = $katb_options['katb_custom_field_1_name'];
	$katb_custom2_name = $katb_options['katb_custom_field_2_name'];
	// setup pagination.
	$katb_items_per_page = 10;
	// submit testimonial.
	if ( isset( $_POST['submitted'] ) && check_admin_referer( 'katb_nonce_3', 'katb_admin_form_nonce' ) ) {// phpcs:ignore
		// Validate Input.
		$error = '';
		if ( isset( $_POST['tb_id'] ) && '' !== $_POST['tb_id'] ) {
			$katb_id = intval( wp_unslash( $_POST['tb_id'] ) );// phpcs:ignore
		} else {
			$katb_id = '';
		}
		// Order must be an integer.
		if ( isset( $_POST['tb_order'] ) && '' !== $_POST['tb_order'] ) {
			$katb_order = intval( wp_unslash( $_POST['tb_order'] ) );// phpcs:ignore
		} else {
			$katb_order = 0;
		}
		// Approved is either checked (1) or not checked (0).
		if ( ! isset( $_POST['tb_approved'] ) ) {// phpcs:ignore
			$katb_approved = 0;
		} else {
			$katb_approved = 1;
		}
		// group validation.
		if ( ! empty( $_POST['tb_group'] ) ) {
			$katb_group = sanitize_text_field( wp_unslash( $_POST['tb_group'] ) );// phpcs:ignore
		} else {
			$katb_group = '';
		}
		// author validation.
		if ( ! empty( $_POST['tb_author'] ) ) {
			$katb_author = sanitize_text_field( wp_unslash( $_POST['tb_author'] ) );// phpcs:ignore
		} else {
			$katb_author = '';
			$error      .= '*' . esc_html__( 'Author is required', 'testimonial-basics' ) . '*';
		}
		// website validation.
		if ( ! empty( $_POST['tb_website'] ) ) {// phpcs:ignore
			$katb_website = esc_url_raw( wp_unslash( $_POST['tb_website'] ) );// phpcs:ignore
			if ( 'http://' === $katb_website ) {
				$katb_website = '';
			}
		} else {
			$katb_website = '';
		}
		// location validation.
		if ( ! empty( $_POST['tb_location'] ) ) {
			$katb_location = sanitize_text_field( wp_unslash( $_POST['tb_location'] ) );// phpcs:ignore
		} else {
			$katb_location = '';
		}
		// custom1 validation.
		if ( ! empty( $_POST['tb_custom1'] ) ) {
			$katb_custom1 = sanitize_text_field( wp_unslash( $_POST['tb_custom1'] ) );// phpcs:ignore
		} else {
			$katb_custom1 = '';
		}
		// custom2 validation.
		if ( ! empty( $_POST['tb_custom2'] ) ) {
			$katb_custom2 = sanitize_text_field( wp_unslash( $_POST['tb_custom2'] ) );// phpcs:ignore
		} else {
			$katb_custom2 = '';
		}
		// email validation.
		if ( ! empty( $_POST['tb_email'] ) ) {
			$katb_email = sanitize_email( wp_unslash( $_POST['tb_email'] ) );// phpcs:ignore
		} else {
			$katb_email = '';
		}
		// Date Validation.
		if ( ! empty( $_POST['tb_date'] ) ) {
			$katb_date = sanitize_text_field( wp_unslash( $_POST['tb_date'] ) );// phpcs:ignore
		} else {
			$katb_date = '';
		}
		if ( '' !== $katb_date ) {
			$year  = intval( substr( $katb_date, 0, 4 ) );
			$month = intval( substr( $katb_date, 5, 2 ) );
			$day   = intval( substr( $katb_date, 8, 2 ) );
			if ( ! checkdate( $month, $day, $year ) ) {
				$error .= '*' . esc_html__( 'Date must be', 'testimonial-basics' ) . ' YYYY-MM-DD*';
			}
		}
		// time validation.
		if ( ! empty( $_POST['tb_time'] ) ) {
			$katb_time = sanitize_text_field( wp_unslash( $_POST['tb_time'] ) );// phpcs:ignore
		} else {
			$katb_time = '';
		}
		if ( '' !== $katb_time ) {
			$hour = intval( substr( $katb_time, 0, 2 ) );
			$min  = intval( substr( $katb_time, 3, 2 ) );
			$sec  = intval( substr( $katb_time, 6, 2 ) );
			if ( 0 > $hour || 23 < $hour || 0 > $min || 59 < $min || 0 > $sec || 59 < $sec || ':' !== substr( $katb_time, 2, 1 ) || ':' !== substr( $katb_time, 5, 1 ) ) {
				$error .= '*' . esc_html__( 'Time must be', 'testimonial-basics' ) . ' HH:MM:SS*';
			}
		}
		if ( '' === $katb_date && '' === $katb_time ) {
			$katb_datetime = current_time( 'mysql' );
		} elseif ( '' !== $katb_date && '' === $katb_time ) {
			$katb_datetime = $katb_date . ' 00:00:00';
		} elseif ( '' === $katb_date && '' !== $katb_time ) {
			$katb_datetime = current_time( 'mysql' );
		} else {
			$katb_datetime = $katb_date . ' ' . $katb_time;
		}
		$katb_date = substr( $katb_datetime, 0, 10 );
		$katb_time = substr( $katb_datetime, 11, 8 );
		// Rating Validation.
		if ( ! empty( $_POST['tb_rating'] ) ) {
			$katb_rating = sanitize_text_field( wp_unslash( $_POST['tb_rating'] ) );// phpcs:ignore
		} else {
			$katb_rating = '';
		}
		// photo validation.
		if ( ! empty( $_POST['tb_upload_image'] ) ) {// phpcs:ignore
			$katb_picture_url = esc_url_raw( wp_unslash( $_POST['tb_upload_image'] ) );// phpcs:ignore
			if ( 'http://' === $katb_picture_url ) {
				$katb_picture_url = '';
			}
		} else {
			$katb_picture_url = '';
		}
		// title sanitization.
		if ( ! empty( $_POST['tb_title'] ) ) {
			$katb_title = sanitize_text_field( wp_unslash( $_POST['tb_title'] ) );// phpcs:ignore
		} else {
			$katb_title = '';
		}
		// Sanitize testimonial - same html allowed as allowed in posts.
		// if emoji present convert to html entities.
		if ( ! empty( $_POST['tb_testimonial'] ) ) {
			$katb_fix_emoticons = wp_encode_emoji( wp_unslash( $_POST['tb_testimonial'] ) );// phpcs:ignore
			// add WordPress Smiley support.
			$katp_add_smilies = convert_smilies( $katb_fix_emoticons );
			// sanitize.
			$katb_testimonial = wp_kses_post( $katp_add_smilies );
		} else {
			$katb_testimonial = '';
		}
		if ( '' === $katb_testimonial ) {
			$error .= '*' . esc_html__( 'Testimonial is required', 'testimonial-basics' ) . '*';
		}
		// Validation complete.
		if ( '' === $error ) {
			// OK $error is empty so let's update the database.
			$values         = array(
				'tb_date'        => $katb_datetime,
				'tb_order'       => $katb_order,
				'tb_approved'    => $katb_approved,
				'tb_group'       => $katb_group,
				'tb_name'        => $katb_author,
				'tb_email'       => $katb_email,
				'tb_location'    => $katb_location,
				'tb_custom1'     => $katb_custom1,
				'tb_custom2'     => $katb_custom2,
				'tb_url'         => $katb_website,
				'tb_pic_url'     => $katb_picture_url,
				'tb_rating'      => $katb_rating,
				'tb_title'       => $katb_title,
				'tb_testimonial' => $katb_testimonial,
			);
			$formats_values = array( '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
			if ( '' === $katb_id || '0' === $katb_id ) {
				// get previous entry to prevent reload duplication.
				$prev_entry = $wpdb->get_row( "SELECT * FROM `$tablename` ORDER BY `tb_id` DESC", ARRAY_A );// phpcs:ignore
				if ( $prev_entry['tb_testimonial'] !== $katb_testimonial ) {
					$wpdb->insert( $tablename, $values, $formats_values );// phpcs:ignore
					$katb_id = $wpdb->insert_id;
					echo '<div id="message" class="updated">' . esc_html__( 'Testimonial added successfuly.', 'testimonial-basics' ) . '</div>';
				} else {
					$katb_id = $prev_entry['tb_id'];
				}
			} else {
				$where = array( 'tb_id' => $katb_id );
				$wpdb->update( $tablename, $values, $where, $formats_values );// phpcs:ignore
				echo '<div id="message" class="updated">' . esc_html__( 'Testimonial updated.', 'testimonial-basics' ) . '</div>';
			}
		} else {
			echo '<div id="message" class="error">' . esc_html__( 'Error,testimonial was not added', 'testimonial-basics' ) . ': ' . $error . '</div>';// phpcs:ignore
		}
	} else {
		$katb_id          = '';
		$katb_order       = 0;
		$katb_approved    = 0;
		$katb_group       = '';
		$katb_date        = '';
		$katb_time        = '';
		$katb_author      = '';
		$katb_email       = '';
		$katb_website     = '';
		$katb_location    = '';
		$katb_custom1     = '';
		$katb_custom2     = '';
		$katb_rating      = '';
		$katb_picture_url = '';
		$katb_title       = '';
		$katb_testimonial = '';
	}
	/* ---------- Reset button is clicked ---------------- */
	if ( isset( $_POST['reset'] ) && check_admin_referer( 'katb_nonce_3', 'katb_admin_form_nonce' ) ) {// phpcs:ignore
		$katb_id          = '';
		$katb_order       = 0;
		$katb_approved    = 0;
		$katb_group       = '';
		$katb_date        = '';
		$katb_time        = '';
		$katb_author      = '';
		$katb_email       = '';
		$katb_website     = '';
		$katb_location    = '';
		$katb_custom1     = '';
		$katb_custom2     = '';
		$katb_rating      = '';
		$katb_picture_url = '';
		$katb_title       = '';
		$katb_testimonial = '';
	}
	/* ---------------- Delete Button is clicked ------------- */
	if ( isset( $_POST['delete'] ) && check_admin_referer( 'katb_nonce_3', 'katb_admin_form_nonce' ) ) {// phpcs:ignore
		if ( ! empty( $_POST['tb_id'] ) ) {
			$katb_id = sanitize_text_field( wp_unslash( $_POST['tb_id'] ) );// phpcs:ignore
		} else {
			$katb_id = '';
		}
		if ( '' === $katb_id ) {
			echo '<div id="message" class="error">' . esc_html__( 'Error, no ID', 'testimonial-basics' ) . '</div>';
		} else {
			$wpdb->query( $wpdb->prepare( "DELETE FROM `$tablename` WHERE `tb_id`=%d", $katb_id ) );// phpcs:ignore
			$katb_id          = '';
			$katb_order       = '';
			$katb_approved    = '';
			$katb_group       = '';
			$katb_date        = '';
			$katb_time        = '';
			$katb_author      = '';
			$katb_email       = '';
			$katb_website     = '';
			$katb_location    = '';
			$katb_custom1     = '';
			$katb_custom2     = '';
			$katb_rating      = '';
			$katb_picture_url = '';
			$katb_title       = '';
			$katb_testimonial = '';
			echo '<div id="message" class="updated">' . esc_html__( 'Testimonial was deleted.', 'testimonial-basics' ) . '</div>';
		}
	}
	/* ----------- select an id to edit ----------------- */
	if ( isset( $_POST['edit'] ) && check_admin_referer( 'katb_nonce_4', 'katb_admin_form_nonce_2' ) ) {
		$katb_id          = sanitize_text_field( wp_unslash( $_POST['edit'] ) );// phpcs:ignore
		$edit_data        = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM `$tablename` WHERE `tb_id` = %d", $katb_id ), ARRAY_A );// phpcs:ignore
		$katb_order       = $edit_data['tb_order'];
		$katb_group       = $edit_data['tb_group'];
		$katb_author      = $edit_data['tb_name'];
		$katb_email       = $edit_data['tb_email'];
		$katb_website     = $edit_data['tb_url'];
		$katb_location    = $edit_data['tb_location'];
		$katb_custom1     = $edit_data['tb_custom1'];
		$katb_custom2     = $edit_data['tb_custom2'];
		$katb_title       = $edit_data['tb_title'];
		$katb_testimonial = $edit_data['tb_testimonial'];
		$katb_approved    = $edit_data['tb_approved'];
		$katb_date        = substr( $edit_data['tb_date'], 0, 10 );
		$katb_time        = substr( $edit_data['tb_date'], 11, 8 );
		$katb_rating      = $edit_data['tb_rating'];
		$katb_picture_url = $edit_data['tb_pic_url'];
	}
	/* ------- set up pagination ----------- */
	if ( isset( $_POST['ka_paginate_post'], $_POST['katb_paginate_form_nonce'] ) &&
		wp_verify_nonce( sanitize_key( $_POST['katb_paginate_form_nonce'] ), 'katb_paginate_nonce' ) ) {
		// Get total entries.
		$results            = $wpdb->get_results( "SELECT COUNT(1) FROM `$tablename`", ARRAY_A );// phpcs:ignore
		$total_entries      = $results[0]['COUNT(1)'];
		$ka_paginate_action = sanitize_text_field( wp_unslash( $_POST['ka_paginate_post'] ) );// phpcs:ignore
		katb_offset_setup( $katb_items_per_page, $ka_paginate_action, $total_entries );
	}
	?>
	<div class="wrap katb_admin_edit_wrap">
		<h2><?php esc_html_e( 'Testimonial Basics - Edit and Approve Testimonials', 'testimonial-basics' ); ?></h2>
		<?php katb_intro_html();// phpcs:ignore ?>
		<p><?php esc_html_e( 'Click the Help button for instructions or see the testimonial_basics_docs.html file included in the plugin docs folder.', 'testimonial-basics' ); ?></p>
		<h3><?php esc_html_e( 'Enter or update a testimonial (*Required)', 'testimonial-basics' ); ?></h3>
		<form class="katb_admin_form" method="POST" action="#">
			<?php wp_nonce_field( 'katb_nonce_3', 'katb_admin_form_nonce' ); ?>
			<span class="ka_edit_column_1">
				<label class="katb_edit_id_label"><?php esc_html_e( 'ID : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_id_input" type="text" size="5" maxlength="5" readonly="readonly" name="tb_id" value="<?php echo esc_attr( $katb_id ); ?>" />
				<label class="katb_edit_approved_label"><?php esc_html_e( 'Approved : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_approved_input" type="checkbox" name="tb_approved" value="1" <?php checked( $katb_approved, 1, true ); ?>/>
				<label class="katb_edit_date_label"><?php esc_html_e( 'Date (YYYY-MM-DD) : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_date_input" type="text" maxlength="12" size="30" name="tb_date" value="<?php echo esc_attr( $katb_date ); ?>" />
				<label class="katb_edit_time_label"><?php esc_html_e( 'Time (HH:MM:SS) : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_time_input" type="text" maxlength="10" size="30" name="tb_time" value="<?php echo esc_attr( $katb_time ); ?>" />
				<label class="katb_edit_group_label"><?php esc_html_e( 'Group : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_group_input" type="text" maxlength="100" size="24" name="tb_group" value="<?php echo esc_attr( wp_unslash( $katb_group ) ); ?>" />
				<label class="katb_edit_order_label"><?php esc_html_e( 'Order : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_order_input" type="text" size="5" maxlength="5" name="tb_order" value="<?php echo intval( $katb_order ); ?>" />
				<label class="katb_edit_custom1_label"><?php echo esc_html( $katb_custom1_name ) . ' : '; ?></label>
				<input class="katb_edit_custom1_input" type="text" maxlength="100" size="24" name="tb_custom1" value="<?php echo esc_attr( wp_unslash( $katb_custom1 ) ); ?>" />
				<label class="katb_edit_custom2_label"><?php echo esc_html( $katb_custom2_name ) . ' : '; ?></label>
				<input class="katb_edit_custom2_input" type="text" maxlength="100" size="24" name="tb_custom2" value="<?php echo esc_attr( wp_unslash( $katb_custom2 ) ); ?>" />
				<label class="katb_edit_rating_label"><?php esc_html_e( 'Review Rating : ', 'testimonial-basics' ); ?></label>
				<select class="katb_edit_rating_input" name="tb_rating">
					<option <?php selected( $katb_rating ); ?> value="<?php echo esc_attr( $katb_rating ); ?>"><?php echo esc_html( $katb_rating ); ?></option>
					<option value="0.0">0.0</option>
					<option value="0.5">0.5</option>
					<option value="1.0">1.0</option>
					<option value="1.5">1.5</option>
					<option value="2.0">2.0</option>
					<option value="2.5">2.5</option>
					<option value="3.0">3.0</option>
					<option value="3.5">3.5</option>
					<option value="4.0">4.0</option>
					<option value="4.5">4.5</option>
					<option value="5.0">5.0</option>
				</select>
			</span>
			<span class="ka_edit_column_2">
				<label class="katb_edit_pic_label"><?php esc_html_e( 'Gravatar/Photo : ', 'testimonial-basics' ); ?></label>
				<?php
				if ( '' === $katb_picture_url ) {
					?>
					<span class="katb_edit_avatar">
						<?php
						$size = 60;
						echo get_avatar( $katb_email, $size );
						?>
					</span>
					<?php
				} else {
					?>
					<span class="katb_edit_pic"><img src="<?php echo esc_url( $katb_picture_url ); ?>" title="<?php esc_attr_e( 'Uploaded Author Image', 'testimonial-basics' ); ?>" alt="<?php esc_attr_e( 'Uploaded Author Image', 'testimonial-basics' ); ?>" /></span>
					<?php
				}
				?>
				<input id="katb_upload_image" class="katb_picture_url" type="text" name="tb_upload_image" maxlength="100" value="<?php echo esc_url( $katb_picture_url ); ?>" />
				<br/><br/><br/>
				<input id="katb_upload_button" class="katb_upload_button" type="button" name="tb_photo_add" value="Upload Image" />
				<label class="katb_edit_author_label"><?php esc_html_e( 'Author * : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_author_input" type="text" maxlength="100" name="tb_author" value="<?php echo esc_attr( wp_unslash( $katb_author ) ); ?>" />
				<label class="katb_edit_email_label"><?php esc_html_e( 'Email : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_email_input" type="text" maxlength="100" name="tb_email" value="<?php echo esc_attr( $katb_email ); ?>" />
				<label class="katb_edit_url_label"><?php esc_html_e( 'Website : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_url_input" type="text" maxlength="100" name="tb_website" value="<?php echo esc_url( $katb_website ); ?>" />
				<label class="katb_edit_location_label"><?php esc_html_e( 'Location : ', 'testimonial-basics' ); ?></label>
				<input class="katb_edit_location_input" type="text" maxlength="100" name="tb_location" value="<?php echo esc_attr( wp_unslash( $katb_location ) ); ?>" />
			</span>
			<label class="katb_edit_title_label"><?php esc_html_e( 'Testimonial Title : ', 'testimonial-basics' ); ?></label>
			<input class="katb_edit_title_input" type="text" name="tb_title" value="<?php echo esc_attr( wp_unslash( $katb_title ) ); ?>" />
			<label class="katb_edit_testimonial_label"><?php esc_html_e( 'Testimonial * : ', 'testimonial-basics' ); ?></label>
			<textarea class="katb_edit_testimonial_input"  name="tb_testimonial" ><?php echo esc_html( wp_unslash( $katb_testimonial ) ); ?></textarea>
			<input type="submit" name="submitted" value="<?php esc_attr_e( 'Save Testimonial', 'testimonial-basics' ); ?>" class="katb-primary button-primary" />
			<input type="submit" name="reset" value="<?php esc_attr_e( 'Reset', 'testimonial-basics' ); ?>" class="katb-secondary button-secondary" />
			<input type="submit" name="delete" value="<?php esc_attr_e( 'Delete', 'testimonial-basics' ); ?>" class="katb-highlighted button-highlighted" />
		</form>
		<div class="katb_admin_display_testimonials">
		<h3 class="katb_admin_title"><?php esc_html_e( 'Testimonials', 'testimonial-basics' ); ?></h3>
			<div style="clear:both;"></div>
			<?php
			// Get total entries.
			$results       = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` ", ARRAY_A );// phpcs:ignore
			$total_entries = $results[0]['COUNT(1)'];
			// Pagination.
			$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
			$katb_admin_offset   = $katb_paginate_setup['offset'];
			if ( 0 > $katb_admin_offset ) {
				$katb_admin_offset = 0;
			}
			$katb_tdata   = $wpdb->get_results( " SELECT * FROM `$tablename` ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_admin_offset ", ARRAY_A );// phpcs:ignore
			$katb_tnumber = $wpdb->num_rows;
			// Bulk Delete.
			if ( isset( $_POST['bulk_delete'] ) && check_admin_referer( 'katb_nonce_4', 'katb_admin_form_nonce_2' ) ) {
				for ( $i = 0; $i < $katb_tnumber; $i++ ) {
					if ( isset( $_POST[ 'bulk_delete-' . $katb_tdata[ $i ]['tb_id'] ] ) && '1' === $_POST[ 'bulk_delete-' . $katb_tdata[ $i ]['tb_id'] ] ) {
						if ( '' === $katb_tdata[ $i ]['tb_id'] ) {
							echo '<div id="message" class="updated">' . esc_html__( 'Error, no ID', 'testimonial-basics' ) . '</div>';
						} else {
							$delete_id = $katb_tdata[ $i ]['tb_id'];
							$wpdb->query( " DELETE FROM `$tablename` WHERE `tb_id`=$delete_id " );// phpcs:ignore
						}
					}
				}
				// reset the testimonials for display.
				// Get total entries.
				$results       = $wpdb->get_results( " SELECT COUNT(1) FROM `$tablename` ", ARRAY_A );// phpcs:ignore
				$total_entries = $results[0]['COUNT(1)'];
				// Pagination.
				$katb_paginate_setup = katb_setup_pagination( $katb_items_per_page, $total_entries );
				$katb_admin_offset   = $katb_paginate_setup['offset'];
				if ( $katb_admin_offset < 0 ) {
					$katb_admin_offset = 0;
				}
				$katb_tdata   = $wpdb->get_results( " SELECT * FROM `$tablename` ORDER BY `tb_date` DESC LIMIT $katb_items_per_page OFFSET $katb_admin_offset ", ARRAY_A );// phpcs:ignore
				$katb_tnumber = $wpdb->num_rows;
			}
			katb_display_pagination( $katb_paginate_setup );
			?>
			<form class="katb_admin_display_form" method="POST" action="#">
				<?php wp_nonce_field( 'katb_nonce_4', 'katb_admin_form_nonce_2' ); ?>
				<input type="submit" name="bulk_delete" value="Bulk Delete" class="katb-highlighted button-highlighted" title="<?php esc_attr_e( 'WARNING - NO SECOND CHANCE - checked items will be deleted', 'testimonial-basics' ); ?>"/>
				<div class="katb_admin_display">
					<?php
					for ( $i = 0; $i < $katb_tnumber; $i++ ) {
						?>
						<div class="katb_admin_display_element_row">
							<div class="katb_admin_row_top">
								<div class="ka_table_id">
									<input type="submit" name="edit" value="<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>" class="katb button-secondary" />
									<input class="katb_bulk_delete_input" type="checkbox" name="bulk_delete-<?php echo esc_attr( $katb_tdata[ $i ]['tb_id'] ); ?>" value="1" />
									<span class="katb_bulk_delete_label">
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
											<path d="M2 5v10c0 0.55 0.45 1 1 1h9c0.55 0 1-0.45 1-1v-10h-11zM5 14h-1v-7h1v7zM7 14h-1v-7h1v7zM9 14h-1v-7h1v7zM11 14h-1v-7h1v7z"></path>
											<path d="M13.25 2h-3.25v-1.25c0-0.412-0.338-0.75-0.75-0.75h-3.5c-0.412 0-0.75 0.338-0.75 0.75v1.25h-3.25c-0.413 0-0.75 0.337-0.75 0.75v1.25h13v-1.25c0-0.413-0.338-0.75-0.75-0.75zM9 2h-3v-0.987h3v0.987z"></path>
										</svg>
									</span>
								</div>
								<div class="ka_table_admin_column">
									<span class="ka_table_date">
										<span class="katb_table_date_label"><strong><?php esc_html_e( 'Date :', 'testimonial-basics' ); ?></strong></span>
										<span class="katb_table_date_value"><?php echo esc_html( substr( $katb_tdata[ $i ]['tb_date'], 0, 10 ) ); ?></span>
									</span>
									<span class="ka_table_time">
										<span class="ka_table_time_label"><strong><?php esc_html_e( 'Time: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_time_value"><?php echo esc_html( substr( $katb_tdata[ $i ]['tb_date'], 11, 8 ) ); ?></span>
									</span>
									<span class="ka_table_approved">
										<span class="ka_table_approved_label"><strong><?php esc_html_e( 'Approved: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_approved_value">
											<?php
											if ( true === $katb_tdata[ $i ]['tb_approved'] || '1' === $katb_tdata[ $i ]['tb_approved'] ) :
												?>
												<span style="color: green;font-weight: bold;">Y</span>
												<?php
											else :
												?>
												<span style="color: red;font-weight: bold;">N</span>
												<?php
											endif;
											?>
										</span>
									</span>
									<span class="ka_table_group">
										<span class="ka_table_group_label"><strong><?php esc_html_e( 'Group: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_group_value"><?php echo esc_html( wp_unslash( $katb_tdata[ $i ]['tb_group'] ) ); ?></span>
									</span>
									<span class="ka_table_order">
										<span class="ka_table_order_label"><strong><?php esc_html_e( 'Order: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_order_value">
										<?php
										if ( 0 === $katb_tdata[ $i ]['tb_order'] ) {
											echo '';
										} else {
											echo intval( $katb_tdata[ $i ]['tb_order'] ); }
										?>
									</span>
									</span>
									<span class="ka_table_custom1">
										<span class="ka_table_custom1_label"><strong><?php echo esc_html( $katb_custom1_name ) . ': '; ?></strong></span>
										<span class="ka_table_custom1_value"><?php echo esc_html( wp_unslash( $katb_tdata[ $i ]['tb_custom1'] ) ); ?></span>
									</span>
									<span class="ka_table_custom2">
										<span class="ka_table_custom2_label"><strong><?php echo esc_html( $katb_custom2_name ) . ': '; ?></strong></span>
										<span class="ka_table_custom2_value"><?php echo esc_html( wp_unslash( $katb_tdata[ $i ]['tb_custom2'] ) ); ?></span>
									</span>
									<span class="ka_table_rating">
										<span class="ka_table_rating_label"><strong><?php esc_html_e( 'Rating: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_rating_value"><?php echo esc_html( $katb_tdata[ $i ]['tb_rating'] ); ?></span>
									</span>
								</div>
								<div class="ka_table_author_column">
									<span class="ka_table_name">
										<span class="ka_table_name_label"><strong><?php esc_html_e( 'Name: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_name_value"><?php echo esc_html( wp_unslash( $katb_tdata[ $i ]['tb_name'] ) ); ?></span>
									</span>
									<span class="ka_table_email">
										<span class="ka_table_email_label"><strong><?php esc_html_e( 'E-mail: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_email_value"><?php echo esc_html( $katb_tdata[ $i ]['tb_email'] ); ?></span>
									</span>
									<span class="ka_table_location">
										<span class="ka_table_location_label"><strong><?php esc_html_e( 'Location: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_location_value"><?php echo esc_html( wp_unslash( $katb_tdata[ $i ]['tb_location'] ) ); ?></span>
									</span>
									<span class="ka_table_website">
										<span class="ka_table_website_label"><strong><?php esc_html_e( 'Website: ', 'testimonial-basics' ); ?></strong></span>
										<span class="ka_table_website_value"><?php echo esc_url( $katb_tdata[ $i ]['tb_url'] ); ?></span>
									</span>	
									<?php
									if ( '' === $katb_tdata[ $i ]['tb_pic_url'] ) {
										?>
										<span class="ka_table_pic">
										<?php
										$size = 60;
										echo get_avatar( $katb_tdata[ $i ]['tb_email'], $size );
										?>
										</span>
										<?php
									} else {
										?>
										<span class="ka_table_pic">
											<img src="<?php echo esc_url( $katb_tdata[ $i ]['tb_pic_url'] ); ?>"
												title="<?php esc_attr_e( 'Uploaded Author Image', 'testimonial-basics' ); ?>"
												alt="<?php esc_attr_e( 'Uploaded Author Image', 'testimonial-basics' ); ?>" />
										</span>
										<?php
									}
									?>
								</div>
							</div>
							<?php if ( '' !== $katb_tdata[ $i ]['tb_title'] ) { ?>
								<div class="ka_table_title"><?php echo wp_kses_post( wp_unslash( $katb_tdata[ $i ]['tb_title'] ) ); ?></div>
							<?php } ?>
							<div class="ka_table_testimonial"><?php echo wp_kses_post( wpautop( wp_unslash( $katb_tdata[ $i ]['tb_testimonial'] ) ) ); ?></div>
						</div>
						<?php
					}
					?>
				</div>
			</form>
			<?php katb_display_pagination( $katb_paginate_setup ); ?>
		</div>
	</div>
	<?php
}

/**
 * Edit Contextual Help
 *
 * This function sets up the help file for the Edit Testimonials panel.
 */
function katb_edit_testimonials_contextual_help() {
	// Globalize settings page.
	global $katb_edit_testimonials_page;
	// Get the current screen object.
	$screen = get_current_screen();
	// Ensure current page is the edit testimonials page.
	if ( $screen->id !== $katb_edit_testimonials_page ) {
		return;
	}
	$contextual_help  = '';
	$contextual_help .= '<h2>Testimonial Basics - ' . __( 'Adding And Editing Testimonials', 'testimonial-basics' ) . '</h2>';
	$contextual_help .= '<ul>';
	$contextual_help .= '<li>' . __( 'To add a testimonial simply enter the data and click the Save Testimonial button', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'To edit a testimonial click the ID button for the testimonial you want to edit, make your changes and Save Testimonial', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'If the Approved checkbox is not selected, the testimonial will not be displayed.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'Enter a Order number, and you can optionally display lowest order number first.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'Enter a Group name and you can optionally display only the grouped testimonials.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'A Gravatar will be shown if the e-mail was set up for a gravatar, and the photo url input is empty.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'If you are using gravatars but do not want to display a particular author gravatar, delete the author email.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'If you want to upload a photo instead of using a gravatar, click the Upload Image button', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'If you want add or change a rating, select the Review Rating dropdon list.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'In the admin panel testimonials are displayed by most recent date first.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'Each testimonial is assigned an ID number which can not be changed.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'To bulk delete testimonials select them and click the Bulk Delete button.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '<li>' . __( 'Be careful when you bulk delete, there is no second chance.', 'testimonial-basics' ) . '</li>';
	$contextual_help .= '</ul>';
	$contextual_help .= '<h4>Testimonial Basics - ' . __( 'Detailed User Documentation', 'testimonial-basics' ) . '</h4>';
	$contextual_help .= '<ul><li>' . __( 'Detailed user documentation is available at the plugin site.', 'testimonial-basics' ) . '</li></ul>';
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_edit_testimonials',
			// Tab Title.
			'title'   => __( 'Edit Testimonials Help', 'testimonial-basics' ),
			// Tab content.
			'content' => $contextual_help,
		)
	);
}

/**
 * Options Contextual Help
 *
 * This function sets up the help tabs for the Options panel
 *
 * @uses katb_general_tab_help() found in this file
 * @uses katb_input_tab_help() found in this file
 * @uses katb_content_tab_help() found in this file
 * @uses katb_widget_tab_help() found in this file
 * @uses katb_faq_tab_help() found in this file
 */
function katb_plugin_options_contextual_help() {
	// Globalize settings page.
	global $katb_plugin_options_page;
	// Get the current screen object.
	$screen = get_current_screen();
	// Ensure current page is the edit testimonials page.
	if ( $screen->id !== $katb_plugin_options_page ) {
		return;
	}
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_plugin_options_general_help',
			// Tab Title.
			'title'   => __( 'General', 'testimonial-basics' ),
			// Tab content.
			'content' => katb_general_tab_help(),
		)
	);
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_plugin_options_input_help',
			// Tab Title.
			'title'   => __( 'Input Forms', 'testimonial-basics' ),
			// Tab content.
			'content' => katb_input_tab_help(),
		)
	);
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_plugin_options_content_help',
			// Tab Title.
			'title'   => __( 'Content Display', 'testimonial-basics' ),
			// Tab content.
			'content' => katb_content_tab_help(),
		)
	);
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_plugin_options_widget_help',
			// Tab Title.
			'title'   => __( 'Widget Display', 'testimonial-basics' ),
			// Tab content.
			'content' => katb_widget_tab_help(),
		)
	);
	$screen->add_help_tab(
		array(
			// HTML ID attribute.
			'id'      => 'katb_plugin_options_faq_help',
			// Tab Title.
			'title'   => __( 'FAQ', 'testimonial-basics' ),
			// Tab content.
			'content' => katb_faq_tab_help(),
		)
	);
}

/**
 * General Help string
 *
 * Called by katb_plugin_options_contextual_help
 *
 * @return string $html
 */
function katb_general_tab_help() {
	$html  = '';
	$html .= '<h2>' . __( 'General Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'User role to edit testimonials', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Administrator : only logged in administrators can edit testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'Editor : logged in Administrators or Editors can edit testimonials.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Testimonial notify email address', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'An email is sent to this address (or admin email if left blank) to notify that a testimonial has been submitted.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Custom Field 1 Name', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This is a custom field, give it a name such as Business Name', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Custom Field 2 Name', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This is a custom field, give it a name such as Phone No', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Remove RTL Support', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'RTL is now supported, but you can disable that support here.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use Ratings', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this and the user will have the option of submitting a rating using a five star rating system.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use CSS Rating System', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this option and a CSS system is used for the 5 star rating system instead of jQuery.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Star color for css stars', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Pick the color you want. Only for the CSS System.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Enable the testimonial rotator script', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Uncheck this box to disable the script, if you are not using rotating testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'This option may come in handy if you are troubleshooting jQuery problems.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Custom CSS', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'For those of you that want to modify css styles, this is a place to do it.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Excerpt More Label', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Change the label that for the link to the full testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'General Data Protection Regulation', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Use General Data Protection', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'An "Approve saving of testimonial data" check box will be shown at the top of testimonial input forms.', 'testimonial-basics' );
	$html .= ' ' . __( 'Visitors must check this box to submit a testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Request testimonial remove page permalink', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Add the permalink of the page that will be loaded, if visitors click the Remove Testimonial link on a testimonial that is displayed.', 'testimonial-basics' );
	$html .= ' ' . __( 'You need to create this page first, see the main setup page "Testimonials".', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Request for Testimonial Removal Introduction', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If you do not like the default text here, add your own. This text introduces the Request a Testimonial Removal page and instructs visitors what to do.', 'testimonial-basics' );
	$html .= '<p><strong>' . __( 'Request for Testimonial Removal No Testimonial Selected', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If the Request a Testimonial Removal page is accessed directly, you can provide users with an additional message on how to proceed.', 'testimonial-basics' );
	$html .= '<h2>' . __( 'Schema Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Use schema markup', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If you choose to use schema markup fill out the information below even if you choose not to display some items.', 'testimonial-basics' );
	$html .= ' ' . __( 'The reason is that the information is still included in meta tags to help Google.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Schema Company Name', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Your company name will appear at the top of the page if you choose to display it.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Schema Company Website Reference', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Your company website address will appear at the top of the page if you choose to display it.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Schema Display Company', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Display your company name and website at the top of the page.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Schema Display Aggregate', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If you choose to display a group of testimonials then that group is summarized.', 'testimonial-basics' );
	$html .= ' ' . __( 'Otherwise the summary is for all the testimonials on your site.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Schema Display Reviews', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can choose to only display the summary if you want.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use Group Name for Aggregate Name', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If you have grouped the testimonials you can use the Group name you have set up for a summary title.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Custom Aggregate Review Name', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can specify a custom name if you do not want to use the Group name.', 'testimonial-basics' );
	$html .= ' ' . __( 'If you want to use the Group name then leave this blank.', 'testimonial-basics' );
	$html .= ' ' . __( 'If you do not want to use a name at all then leave the checkbox unchecked and this section blank.', 'testimonial-basics' ) . '</p>';
	return $html;
}

/**
 * Input Form Help string
 *
 * Called by katb_plugin_options_contextual_help()
 *
 * @return string $html
 */
function katb_input_tab_help() {
	$html  = '';
	$html .= '<h2>' . __( 'General Input Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Auto approve Testimonials', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can check this box to have testimonials automatically approved.', 'testimonial-basics' );
	$html .= ' ' . __( 'CAUTION: Not recommended so use at your own risk.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use honyepot to reduce spam', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This may be all the spam protection you need, give it a try.', 'testimonial-basics' );
	$html .= '<p><strong>' . __( 'Use captcha on input forms', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can include a black and white captcha on the input forms.', 'testimonial-basics' );
	$html .= ' ' . __( 'If for any reason the Captcha is not working, disable it here.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use Google reCaptcha', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Sign up for Google reCaptcha at https://www.google.com/recaptcha/.', 'testimonial-basics' );
	$html .= ' ' . __( 'Get the Site Key and Secret Key and enter it in the next two input boxes.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use color captcha option', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this to use a color captcha option.', 'testimonial-basics' );
	$html .= ' ' . __( 'If the black and white captcha is not working, try this one.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use Color Captcha Option 2', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This is the third captcha option.', 'testimonial-basics' );
	$html .= ' ' . __( 'It is the least secure but should work if the other two methods do not..', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Exclude Title for Testimonial in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select and the Title for Testimonial input will not be used.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Require Title for Testimonial in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If Title for Testimonial is included and this checkbox is selected, the Title for Testimonial input box must be completed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Exclude Website in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select and the website input will not be used.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Require Website in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If Website is included and this checkbox is selected, the Website input box must be completed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Exclude Location in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select and the location input will not be used.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Require Location in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If Location is included and this checkbox is selected, the Location input box must be completed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Exclude Custom 1 in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select and the Custom 1 input will not be used.', 'testimonial-basics' );
	$html .= ' ' . __( 'Note that Custom 1 may be replaced by your Custom 1 label in the General Options tab.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Require Custom 1 in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If Custom 1 is included and this checkbox is selected, the Custom 1 input box must be completed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Exclude Custom 2 in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select and the Custom 2 input will not be used.', 'testimonial-basics' );
	$html .= ' ' . __( 'Note that Custom 2 may be replaced by your Custom 2 label in the General Options tab.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Require Custom 2 in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If Custom 2 is included and this checkbox is selected, the Custom 2 input box must be completed.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'Content and Widget Form Input Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Include email note', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Check this if you want to add a note.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Email note', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Add the note here if you do not want to use the default.', 'testimonial-basics' );
	$html .= ' ' . __( 'Keep the text you enter to a reasonable length or it may look funny.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use popup messages', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Check to have a popup javascript messages for errors or thank you, to be displayed after the testimonial was submitted.', 'testimonial-basics' );
	$html .= ' ' . __( 'In some WordPress sites the green colored thank you may not be displayed.', 'testimonial-basics' );
	$html .= ' ' . __( 'This method provides an alternative.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Base Font Size', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This option allows you to change the font size.', 'testimonial-basics' ) . ' ';
	$html .= __( 'It should work for most themes but CSS Specifity can cause problems.', 'testimonial-basics' ) . ' ';
	$html .= __( 'Do not worry about what an em is just try one and see what happens.', 'testimonial-basics' );
	'</p>';
	$html .= '<p><strong>' . __( 'Include title on input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this to display a title above the input form.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Title for Input Form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Put the title you want to use here.', 'testimonial-basics' );
	$html .= ' ' . __( 'Note that for widgets the title is entered when you place the widget.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Show html allowed strip in input form', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Optionally include an html allowed strip on input forms.', 'testimonial-basics' );
	$html .= ' ' . __( 'This strip shows the user what html tags will be allowed in the testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Show gravatar link', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Visitors can use this link to set up a gravatar that will be included in the testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Position Labels inside or above input boxes', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'defaults-above for content forms, inside for widget forms.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Labels', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can change any of the labels in the input forms.', 'testimonial-basics' );
	$html .= ' ' . __( 'This feature will come in handy for users that want to use a different language.', 'testimonial-basics' ) . '</p>';
	return $html;
}

/**
 * Content Display Help string
 *
 * Called by katb_plugin_options_contextual_help()
 *
 * @return string $html
 */
function katb_content_tab_help() {
	$html  = '';
	$html .= '<h2>' . __( 'Content Display General Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Layout Option', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'The Meta referred to is the rating, author, date, location, and website.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can place it at the top or bottom or on the side, or use a mosaic 2 column layout.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Font for Content Display', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can choose a font from the dropdown list.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Base Font Size', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This option allows you to change the font size.', 'testimonial-basics' ) . ' ';
	$html .= __( 'It should work for most themes but CSS Specifity can cause problems.', 'testimonial-basics' ) . ' ';
	$html .= __( 'Do not worry about what an em is just try one and see what happens.', 'testimonial-basics' );
	'</p>';
	$html .= '<p><strong>' . __( 'Pagination', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can use pagination when you display all testimonials or all testimonials in a Group.', 'testimonial-basics' );
	$html .= ' ' . __( 'In any other display there is really no reason to use pagination.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can choose to display 3, 5 or 10 per page.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Excerpts', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can use excerpts with the specified number of words to display your testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'When excerpts are selected, the testimonial is limited to the number of words, extended to end of sentence or break in sentence.', 'testimonial-basics' );
	$html .= ' ' . __( 'A visitor can then click a ...more link to display a pop-up of the entire testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Show title in testimonial', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Actual title used first, if unavailable, use group, if group unavailable use fallback.', 'testimonial-basics' );
	$html .= '<p><strong>' . __( 'Meta Display Options', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'The author is displayed as a minimum.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can then optionally display website, location, custom 1, custom 2, and date.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Gravatars', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this to display Gravatars.', 'testimonial-basics' );
	$html .= ' ' . __( 'Uploaded photos are displayed first.', 'testimonial-basics' );
	$html .= ' ' . __( 'If an uploaded photo does not exist, the plugin will display a gravatar, if one exists.', 'testimonial-basics' );
	$html .= ' ' . __( 'If gravatar does not exist, you can optionally display a substitute character.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can also select the gravatar size and if the gravatars should be round.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use italic font style', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Click this and italics will be used for the testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'Content Display Rotator Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Time between slides', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select the time in mili-seconds 1000 ms = 1 sec.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Rotator height in pixels', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Selects a minimum height for all testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'Use this option to prevent the screen from growing or shrinking to accomodate each testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'Tip: use excerpts and make sure the length keeps testimonials within the minimum height prescribed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Rotator transition effect', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select the transition effect for the slider.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'Content Display Custom Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Use formatted display', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'To use formatted display select this box.', 'testimonial-basics' );
	$html .= ' ' . __( 'If the Formatted Display box is checked a color style is applied to the testimonials, which can be customized.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Colors', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Enter any hexdec color number preceded by a # mark or use the color picker', 'testimonial-basics' );
	$html .= ' ' . __( 'Select the color input cell you want to change.', 'testimonial-basics' );
	$html .= ' ' . __( 'A color box appears with a saturation bar on the right.', 'testimonial-basics' );
	$html .= ' ' . __( 'Drag the dot on the color box to select the color.', 'testimonial-basics' );
	$html .= ' ' . __( 'Change the saturation with the sliding bar on the right.', 'testimonial-basics' );
	$html .= ' ' . __( 'Click the Current Color Button when you are done.', 'testimonial-basics' ) . '</p>';
	return $html;
}

/**
 * Widget Display Help string
 *
 * Called by katb_plugin_options_contextual_help().
 *
 * @return string $html
 */
function katb_widget_tab_help() {
	$html  = '';
	$html .= '<h2>' . __( 'Widget Display Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Layout Option', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'There are six layout options for the widget allowing flexibility for different themes. ', 'testimonial-basics' );
	$html .= ' ' . __( 'Try different ones, and ensure they work on all devices.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Font for Widget Display', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can choose a font from the dropdown list.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Base Font Size', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'This option allows you to change the font size.', 'testimonial-basics' ) . ' ';
	$html .= __( 'It should work for most themes but CSS Specifity can cause problems.', 'testimonial-basics' ) . ' ';
	$html .= __( 'Do not worry about what an em is just try one and see what happens.', 'testimonial-basics' );
	'</p>';
	$html .= '<p><strong>' . __( 'Excerpts', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'You can use excerpts with the specified number of words to display your testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'When excerpts are selected, the testimonial is limited to the number of words, extended to end of sentence or break in sentence.', 'testimonial-basics' );
	$html .= ' ' . __( 'A visitor can then click a ...more link to display a pop-up of the entire testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Show title in testimonial', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'If you wish to show the Group name or a Custom name for your testimonial, select this option.', 'testimonial-basics' );
	$html .= ' ' . __( 'Then make sure the Custom Individual Review Name is filled out or Group Individual Review Name is selected - in the General Tab.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Meta Display Options', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'The author is displayed as a minimum.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can then optionally display website, location, and date.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Gravatars', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select this to display Gravatars.', 'testimonial-basics' );
	$html .= ' ' . __( 'Uploaded photos are displayed first.', 'testimonial-basics' );
	$html .= ' ' . __( 'If an uploaded photo does not exist, the plugin will display a gravatar, if one exists.', 'testimonial-basics' );
	$html .= ' ' . __( 'If gravatar does not exist, you can optionally display a substitute character.', 'testimonial-basics' );
	$html .= ' ' . __( 'You can also select the gravatar size and if the gravatars should be round.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Use italic font style', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Click this and italics will be used for the testimonial.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'Widget Display Rotator Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Time between slides', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select the time in mili-seconds 1000 ms = 1 sec.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Rotator height in pixels', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Selects a minimum height for all testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'Use this option to prevent the screen from growing or shrinking to accomodate each testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'Tip: use excerpts and make sure the length keeps testimonials within the minimum height prescribed.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Rotator transition effect', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Select the transition effect for the slider.', 'testimonial-basics' ) . '</p>';
	$html .= '<h2>' . __( 'Widget Display Custom Options', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Use formatted display', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'To use formatted display select this box.', 'testimonial-basics' );
	$html .= ' ' . __( 'If the Formatted Display box is checked a color style is applied to the testimonials, which can be customized.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Colors', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Enter any hexdec color number preceded by a # mark or use the color picker', 'testimonial-basics' );
	$html .= ' ' . __( 'Select the color input cell you want to change.', 'testimonial-basics' );
	$html .= ' ' . __( 'A color box appears with a saturation bar on the right.', 'testimonial-basics' );
	$html .= ' ' . __( 'Drag the dot on the color box to select the color.', 'testimonial-basics' );
	$html .= ' ' . __( 'Change the saturation with the sliding bar on the right.', 'testimonial-basics' );
	$html .= ' ' . __( 'Click the Current Color Button when you are done.', 'testimonial-basics' ) . '</p>';
	return $html;
}

/**
 * Widget Display Help string
 *
 * Called by katb_plugin_options_contextual_help()
 *
 * @return string $html
 */
function katb_faq_tab_help() {
	$html  = '';
	$html .= '<h2>' . __( 'FAQ', 'testimonial-basics' ) . '</h2>';
	$html .= '<p><strong>' . __( 'Why is pagination not working?', 'testimonial-basics' ) . ' - </strong>';
	$html .= ' ' . __( 'Most likely it is because you have set them to display by="random".', 'testimonial-basics' );
	$html .= ' ' . __( 'Set them to display by="date" or by="order".', 'testimonial-basics' );
	$html .= ' ' . __( 'Pagination does not work for random selections.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'Why are users not allowed to upload photos?', 'testimonial-basics' ) . ' - </strong>';
	$html .= __( 'Users are not allowed to upload photos for security reasons.', 'testimonial-basics' );
	$html .= ' ' . __( 'Allowing anyone who is not logged in to upload files to your WordPress site is a very risky practice.', 'testimonial-basics' );
	$html .= ' ' . __( 'The Gravatar system is very simple to register and the safe way to get user photos in their testimonials.', 'testimonial-basics' );
	$html .= ' ' . __( 'The Admin or Editor can log in and upload photos from the Edit Testimonials Panel.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'My testimonial is not displaying.', 'testimonial-basics' ) . ' - </strong>';
	$html .= ' ' . __( 'Go in to the edit testimonials panel and make sure it is approved.', 'testimonial-basics' ) . '</p>';
	$html .= '<p><strong>' . __( 'The widget labels in the input boxes do not disappear when selected.', 'testimonial-basics' ) . ' - </strong>';
	$html .= ' ' . __( 'They must be deleted.', 'testimonial-basics' );
	$html .= ' ' . __( 'It is set up this way to keep the entry for editing in the event of a submission error.', 'testimonial-basics' ) . '</p>';
	return $html;
}

/**
 * Plugin register_setting() sanitize callback
 *
 * Validate and whitelist user-input data before updating Theme.
 * Options in the database. Only whitelisted options are passed
 * back to the database, and user-input data for all whitelisted
 * options are sanitized.
 *
 * @link    http://codex.wordpress.org/Data_Validation  Codex Reference: Data Validation
 *
 * @param   array $input  Raw user-input data submitted via the Theme Settings page.
 *
 * @uses katb_get_options(); found in /includes/katb_functions.php
 * @uses katb_get_settings_by_tab() found in this file
 * @uses katb_get_option_parameters() found in this file
 * @uses katb_get_option_defaults() found in this file
 * @uses katb_get_settings_page_tabs() found in this file
 *
 * @return $valid_input Sanitized user-input data passed to the database
 */
function katb_validate_options( $input ) {
	// This is the "whitelist": current settings.
	$valid_input = katb_get_options();
	// Get the array of Theme settings, by Settings Page tab.
	$settingsbytab = katb_get_settings_by_tab();
	// Get the array of option parameters.
	$option_parameters = katb_get_option_parameters();
	// Get the array of option defaults.
	$option_defaults = katb_get_option_defaults();
	// Get list of tabs.
	$tabs = katb_get_settings_page_tabs();
	// array for possible errors.
	$katb_input_error = array();
	// Determine what type of submit was input.
	$submittype = 'submit';
	foreach ( $tabs as $tab ) {
		$resetname = 'reset-' . $tab['name'];
		if ( ! empty( $input[ $resetname ] ) ) {
			$submittype = 'reset';
		}
	}
	// Determine what tab was input.
	$submittab = 'general';
	foreach ( $tabs as $tab ) {
		$submitname = 'submit-' . $tab['name'];
		$resetname  = 'reset-' . $tab['name'];
		if ( ! empty( $input[ $submitname ] ) || ! empty( $input[ $resetname ] ) ) {
			$submittab = $tab['name'];
		}
	}
	// Get settings by tab.
	$tabsettings = $settingsbytab[ $submittab ];
	// Loop through each tab setting.
	foreach ( $tabsettings as $setting ) {
		// If no option is selected, set the default.
		$valid_input[ $setting ] = ( ! isset( $input[ $setting ] ) ? $option_defaults[ $setting ] : $input[ $setting ] );
		// If submit, validate/sanitize $input.
		if ( 'submit' === $submittype ) {
			// Get the setting details from the defaults array.
			$optiondetails = $option_parameters[ $setting ];
			// Get the array of valid options, if applicable.
			$valid_options = ( isset( $optiondetails['valid_options'] ) ? $optiondetails['valid_options'] : false );
			// Validate checkbox fields.
			if ( 'checkbox' === $optiondetails['type'] ) {
				// Note settings API returns "on" for checkboxes.
				if ( isset( $input[ $setting ] ) ) {
					if ( true === $input[ $setting ] || 'on' === $input[ $setting ] ) {
						$valid_input[ $setting ] = true;
					} else {
						$valid_input[ $setting ] = false;
					}
				} else {
					$valid_input[ $setting ] = false;
				}
			} elseif ( 'radio' === $optiondetails['type'] ) {
				// Validate radio button fields.
				// Only update setting if input value is in the list of valid options.
				$valid_input[ $setting ] = ( array_key_exists( $input[ $setting ], $valid_options ) ? $input[ $setting ] : $valid_input[ $setting ] );
			} elseif ( 'select' === $optiondetails['type'] ) {
				// Validate select fields.
				// Only update setting if input value is in the list of valid options.
				$valid_input[ $setting ] = ( array_key_exists( $input[ $setting ], $valid_options ) ? $input[ $setting ] : $valid_input[ $setting ] );
			} elseif ( ( 'text' === $optiondetails['type'] || 'textarea' === $optiondetails['type'] ) ) {
				// Validate text input and textarea fields.
				// Validate no-HTML content.
				if ( 'nohtml' === $optiondetails['class'] ) {
					// Pass input data through the wp_filter_nohtml_kses filter.
					$valid_input[ $setting ] = wp_filter_nohtml_kses( $input[ $setting ] );
				} elseif ( 'html' === $optiondetails['class'] ) {
					// Validate HTML content.
					// Pass input data through the wp_filter_kses filter.
					$valid_input[ $setting ] = wp_filter_post_kses( $input[ $setting ] );
				} elseif ( 'url' === $optiondetails['class'] || 'img' === $optiondetails['class'] ) {
					// eliminate invalid and dangerous characters.
					$valid_input[ $setting ] = esc_url_raw( $valid_input[ $setting ] );
				} elseif ( 'email' === $optiondetails['class'] ) {
					if ( '' !== $valid_input[ $setting ] ) {
						$valid_input[ $setting ] = sanitize_email( $valid_input[ $setting ] );
						if ( '' === $valid_input[ $setting ] ) {
							add_settings_error(
								$setting, // setting title.
								'katb_email_error', // error ID.
								__( 'Please enter a valid e-mail - blank returned', 'testimonial-basics' ), // error message.
								'error' // type of message.
							);
						}
					}
					if ( '' !== $valid_input[ $setting ] && ! is_email( $valid_input[ $setting ] ) ) {
						$valid_input[ $setting ] = '';
						add_settings_error(
							$setting, // setting title.
							'katb_email_error', // error ID.
							__( 'Please enter a valid e-mail - blank returned', 'testimonial-basics' ), // error message.
							'error' // type of message.
						);
					}
				} elseif ( 'ka_color' === $optiondetails['class'] ) {
					$valid_input[ $setting ] = trim( $valid_input[ $setting ] ); // trim whitespace.
					if ( '' === $valid_input[ $setting ] ) {
						$valid_input[ $setting ] = $option_defaults[ $setting ];
					}
					if ( '#' !== substr( $valid_input[ $setting ], 0, 1 ) ) {
						$valid_input[ $setting ] = '#' . $valid_input[ $setting ];}
					if ( ! preg_match( '/^#[a-f0-9]{6}$/i', $valid_input[ $setting ] ) ) { // hex color is valid.
						$valid_input[ $setting ] = $option_defaults[ $setting ];
						add_settings_error(
							$setting, // setting title.
							'katb_hex_color_error', // error ID.
							__( 'Please enter a valid Hex Color Number-default returned.', 'testimonial-basics' ), // error message.
							'error' // type of message.
						);
					}
				} elseif ( 'css' === $optiondetails['class'] ) {
					$valid_input[ $setting ] = wp_filter_nohtml_kses( $valid_input[ $setting ] ); // css validation.
				} else {
					// Catch all.
					// Pass input data through the wp_filter_kses filter.
					$valid_input[ $setting ] = wp_filter_kses( $input[ $setting ] );
				}
			}
		} elseif ( 'reset' === $submittype ) {
			// Set $setting to the default value.
			$valid_input[ $setting ] = $option_defaults[ $setting ];
		}
	}
	return $valid_input;
}

/**
 * Helper function for creating admin messages.
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area
 *
 * @param string $message The message to echo.
 * @param string $msgclass The message class.
 */
function katb_show_msg( $message, $msgclass = 'info' ) {
	echo '<div id="message" class="' . esc_attr( $msgclass ) . '">' . wp_kses_post( $message ) . '</div>';
}

/**
 * Callback function for displaying admin messages.
 */
function katb_admin_msgs() {
	// check for our settings page - need this in conditional further down.
	if ( isset( $_GET['page'] ) ) {// phpcs:ignore
		$katb_settings_pg = strpos( $_GET['page'], 'katb-settings' );// phpcs:ignore
	} else {
		$katb_settings_pg = false;
	}
	// collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors.
	$set_errors = get_settings_errors();
	// display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned!.
	if ( current_user_can( 'manage_options' ) && false !== $katb_settings_pg && ! empty( $set_errors ) ) {
		// have our settings succesfully been updated?
		if ( 'settings_updated' === $set_errors[0]['code'] && isset( $_GET['settings-updated'] ) ) {// phpcs:ignore
			katb_show_msg( '<p>' . $set_errors[0]['message'] . '</p>', 'updated' );
			// have errors been found?
		} else {
			// there maybe more than one so run a foreach loop.
			foreach ( $set_errors as $set_error ) {
				// set the title attribute to match the error "setting title" - need this in js file.
				katb_show_msg( '<p class="setting-error-message" title="' . $set_error['setting'] . '">' . $set_error['message'] . '</p>', 'error' );
			}
		}
	}
}
add_action( 'admin_notices', 'katb_admin_msgs' );

/**
 * This function contains the html for the intro section to the admin pages.
 */
function katb_intro_html() {
	?>
	<div class="katb_paypal"><?php esc_html_e( 'Show your appreciation!', 'testimonial-basics' ); ?>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="PP4GPMXBUVPY4">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	<p>
		<?php
		global $katb_options;
		if ( is_rtl() && false === $katb_options['katb_remove_rtl_support'] ) {
			echo '<a href="//www.kevinsspace.ca/testimonial-basics-wordpress-plugin/" target="_blank" >www.kevinsspace.ca/testimonial-basics-wordpress-plugin/</a>' . esc_html__( ' : Plugin Site', 'testimonial-basics' );
			echo '&nbsp;&nbsp;&nbsp;<a href="//www.kevinsspace.ca" target="_blank" >www.kevinsspace.ca</a>' . esc_html__( ' : Author Site', 'testimonial-basics' );
		} else {
			echo esc_html__( 'Author Site : ', 'testimonial-basics' ) . '<a href="//www.kevinsspace.ca" target="_blank" >www.kevinsspace.ca</a>&nbsp;&nbsp;&nbsp;';
			echo esc_html__( 'Plugin Site : ', 'testimonial-basics' ) . '<a href="//www.kevinsspace.ca/testimonial-basics-wordpress-plugin/" target="_blank" >www.kevinsspace.ca/testimonial-basics-wordpress-plugin/</a>';
		}
		?>
	</p>
	<?php
}

/**
 * Separate settings by tab
 *
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses    katb_get_option_parameters()
 * @uses    katb_get_settings_page_tabs()
 *
 * @return  array   $settingsbytab  array of arrays of settings by tab
 */
function katb_get_settings_by_tab() {
	// Get the list of settings page tabs.
	$tabs = katb_get_settings_page_tabs();
	// Initialize an array to hold.
	// an indexed array of tabnames.
	$settingsbytab = array();
	// Loop through the array of tabs.
	foreach ( $tabs as $tab ) {
		$tabname = $tab['name'];
		// Add an indexed array key.
		// to the settings-by-tab.
		// array for each tab name.
		$settingsbytab[] = $tabname;
	}
	// Get the array of option parameters.
	$option_parameters = katb_get_option_parameters();
	// Loop through the option parameters.
	foreach ( $option_parameters as $option_parameter ) {
		$optiontab  = $option_parameter['tab'];
		$optionname = $option_parameter['name'];
		// Add an indexed array key to the.
		// settings-by-tab array for each.
		// setting associated with each tab.
		$settingsbytab[ $optiontab ][] = $optionname;
		$settingsbytab['all'][]        = $optionname;
	}
	// Return the settings-by-tab array.
	return $settingsbytab;
}

/**
 * Testimonial Basics Admin Settings Page Tabs
 *
 * Array that holds all of the tabs for the
 * Testimonial Basics Settings Page. Each tab
 * key holds an array that defines the
 * sections for each tab, including the
 * description text.
 *
 * @return  array   $tabs   array of arrays of tab parameters
 */
function katb_get_settings_page_tabs() {
	$tabs = array(
		'general'         => array(
			'name'     => 'general',
			'title'    => __( 'General', 'testimonial-basics' ),
			'sections' => array(
				'general' => array(
					'name'        => 'general',
					'title'       => __( 'General Options', 'testimonial-basics' ),
					'description' => '',
				),
				'gdpr'    => array(
					'name'        => 'gdpr',
					'title'       => __( 'General Data Protection Regulation', 'testimonial-basics' ),
					'description' => '<p>' .
										__( 'This section deals with GDPR ( in effect May 25, 2018 ).', 'testimonial-basics' ) . ' ' .
										__( 'If you choose to use this feature, users must agree to you saving testimonial data.', 'testimonial-basics' ) . ' ' .
										__( 'An additional option allows you to set up a page where the user can send a request to have a testimonial removed.', 'testimonial-basics' ) . '</p>',
				),
				'schema'  => array(
					'name'        => 'schema',
					'title'       => __( 'Schema Options', 'testimonial-basics' ),
					'description' => '<p>' .
										__( 'I use the term Schema a bit loosley.', 'testimonial-basics' ) . ' ' .
										__( 'It refers to', 'testimonial-basics' ) . ' <a href="http://schema.org" title="schema" target="_blank">schema.org</a> ' .
										__( 'which is a', 'testimonial-basics' ) . ' <br/><br/> "' .
										__( 'collaboration by Google, Microsoft and Yahoo to improve the web by creating a structured data markup schema supported by major search engines.', 'testimonial-basics' ) . ' ' .
										__( 'On-page markup helps search engines understand the information on web pages and provide richer results.', 'testimonial-basics' ) . ' ' .
										__( 'A shared markup vocabulary makes it easier for webmasters to decide on a markup schema and get maximum benefit for their efforts.', 'testimonial-basics' ) . '"</p><p>' .
										__( 'You can now choose to display testimonials in a structured data format, which should help search results for your site.', 'testimonial-basics' ) . '</p>',
				),
			),
		),
		'input'           => array(
			'name'     => 'input',
			'title'    => __( 'Input Forms', 'testimonial-basics' ),
			'sections' => array(
				'general'            => array(
					'name'        => 'general',
					'title'       => __( 'General Input Options', 'testimonial-basics' ),
					'description' => '',
				),
				'content_input_form' => array(
					'name'        => 'content_input_form',
					'title'       => __( 'Content Form Input Options', 'testimonial-basics' ),
					'description' => '',
				),
				'widget_input_form'  => array(
					'name'        => 'widget_input_form',
					'title'       => __( 'Widget Form Input Options', 'testimonial-basics' ),
					'description' => '',
				),
			),
		),
		'content_display' => array(
			'name'     => 'content_display',
			'title'    => __( 'Content Display', 'testimonial-basics' ),
			'sections' => array(
				'content_general'        => array(
					'name'        => 'content_general',
					'title'       => __( 'Content Display General Options', 'testimonial-basics' ),
					'description' => '<p>' . __( 'Content display refers to displaying your testimonials in the content area of your pages and posts.', 'testimonial-basics' ) . '</p>',
				),
				'content_rotator'        => array(
					'name'        => 'content_rotator',
					'title'       => __( 'Content Display Rotator Options', 'testimonial-basics' ),
					'description' => '<p>' . __( 'You can display up to 5 content rotators on one page.', 'testimonial-basics' ) . '</p>',
				),
				'content_custom_formats' => array(
					'name'        => 'content_custom_formats',
					'title'       => __( 'Content Display Custom Options', 'testimonial-basics' ),
					'description' => '',
				),
			),
		),
		'widget_display'  => array(
			'name'     => 'widget_display',
			'title'    => __( 'Widget Display', 'testimonial-basics' ),
			'sections' => array(
				'widget_general'        => array(
					'name'        => 'widget_general',
					'title'       => __( 'Widget Display General Options', 'testimonial-basics' ),
					'description' => '',
				),
				'widget_rotator'        => array(
					'name'        => 'widget_rotator',
					'title'       => __( 'Widget Display Rotator Options', 'testimonial-basics' ),
					'description' => '<p>' . __( 'You can display up to 5 widget rotators on one page.', 'testimonial-basics' ) . '</p>',
				),
				'widget_custom_formats' => array(
					'name'        => 'widget_custom_formats',
					'title'       => __( 'Widget Display Custom Options', 'testimonial-basics' ),
					'description' => '',
				),
			),
		),
	);
	return apply_filters( 'katb_get_settings_page_tabs', $tabs );
}

/**
 * Get current settings page tab.
 */
function katb_get_current_tab() {
	$page = 'katb-settings';
	if ( isset( $_GET['tab'] ) ) {// phpcs:ignore
		$current = sanitize_text_field( wp_unslash( $_GET['tab'] ) );// phpcs:ignore
	} else {
		$current = 'general';
	}
	return $current;
}

/*
 * =========================================================================================
 *               Testimonial Basics Backup/Restore
 * =========================================================================================
 */
/**
 * Backup/Restore page
 *
 * Modified from:
 *
 * @link http://code.tutsplus.com/tutorials/custom-database-tables-exporting-data--wp-28796
 * @link http://code.tutsplus.com/tutorials/custom-database-tables-importing-data--wp-28869
 */
function katb_backup_restore_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Testimonial Basics - Backup or Restore Your Testimonials', 'testimonial-basics' ); ?></h1>
		<?php echo katb_intro_html();// phpcs:ignore ?>
		<!-- Backup Testimonials -->
		<h3><?php esc_html_e( 'Backup Testimonials', 'testimonial-basics' ); ?></h3>
		<p><?php esc_html_e( 'You can back up all your testimonials to an xml file, and it will be downloaded to your computer.', 'testimonial-basics' ); ?></p>
		<form id="katb-backup-form" method="post" action="">
			<p>
				<label><?php esc_html_e( 'Click to backup testimonials', 'testimonial-basics' ); ?></label>
				<input type="hidden" name="action" value="katb-backup-action" />
			</p>
			<?php wp_nonce_field( 'katb-export-testimonials', 'katb_backup_nonce' ); ?>
			<?php submit_button( __( 'Backup Testimonials', 'testimonial-basics' ), 'button' ); ?>
		</form>
		<!-- Restore Testimonials -->
		<h3><?php esc_html_e( 'Restore Testimonials', 'testimonial-basics' ); ?></h3>
		<p><?php esc_html_e( 'You can restore your testimonials from a backup xml file.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Maximum file size is 2MB.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'If your backup file is too large it will have to be broken up into parts.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'For example to break up your file into 2 files, use a text editor such as Notepad or Notepad++.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Make two copies of the full backup file and append _part1 and _part2 to the file names.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Remove the bottom half of the testimonials from the first file.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Remove the top half of the testimonials from the second file.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Note that all testimonials are wrapped in &lt;testimonials&gt;&lt;/testimonials&gt; tags. Do not delete these tags.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'Each testimonial is wrapped in &lt;testimonial&gt;&lt;/testimonial&gt; tags.', 'testimonial-basics' ); ?>
			<?php esc_html_e( 'To remove a testimonial delete everything between the &lt;testimonial&gt;&lt;/testimonial&gt; tags, including the tags.', 'testimonial-basics' ); ?>
		</p>
		<form method="post" action="" enctype="multipart/form-data">
			<p>
				<label for="katb_import_testimonials"><?php esc_html_e( 'Select an xml file', 'testimonial-basics' ); ?></label>
				<input type="file" id="katb_import_testimonials" name="katb_import_file" />
			</p>
			<input type="hidden" name="action" value="katb-import-action" />
			<?php wp_nonce_field( 'katb-import-testimonials', 'katb_import_nonce' ); ?>
			<?php submit_button( __( 'Restore Testimonials', 'testimonial-basics' ), 'secondary' ); ?>
		</form>
		<br/>
		<h3><?php esc_html_e( 'Other Notes/Tips', 'testimonial-basics' ); ?></h3>
		<ol>
			<li><?php esc_html_e( 'If the URL changed, uploaded photos will have to be re-uploaded.', 'testimonial-basics' ); ?></li>
			<li><?php esc_html_e( 'Testimonials with the same ID will not be restored.', 'testimonial-basics' ); ?></li>
		</ol>
	</div>
	<?php
}

/**
 * Listens for buttom press then executes downloaad.
 */
function katb_maybe_download() {
	// Listen for download form submission.
	if ( empty( $_POST['action'] ) || 'katb-backup-action' !== $_POST['action'] ) {// phpcs:ignore
		return;
	}
	// Check permissions and nonces.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( '' );
	}
	check_admin_referer( 'katb-export-testimonials', 'katb_backup_nonce' );
	// Trigger download.
	katb_do_backup();
}
add_action( 'admin_init', 'katb_maybe_download' );

/**
 * Maybe Upload.
 */
function katb_maybe_upload() {
	// Listen for upload form submission.
	if ( empty( $_POST['action'] ) || 'katb-import-action' !== $_POST['action'] ) {// phpcs:ignore
		return;
	}
	// Check permissions and nonces.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'You are not authorized to restore testimonials' );
	}
	check_admin_referer( 'katb-import-testimonials', 'katb_import_nonce' );
	// Perform checks on file.
	// Sanity check.
	if ( empty( $_FILES['katb_import_file'] ) ) {// phpcs:ignore
		wp_die( 'No file found' );
	}
	$file = $_FILES['katb_import_file'];// phpcs:ignore
	// Is it of the expected type?
	if ( 'text/xml' !== $file['type'] ) {
		// translators: wrong file type.
		wp_die( sprintf( esc_html__( "There was an error importing the logs. File type detected: '%s'. 'text/xml' expected", 'testimonial-basics' ), esc_html( $file['type'] ) ) );
	}
	// Impose a limit on the size of the uploaded file. Max 2097152 bytes = 2MB.
	if ( $file['size'] > 2097152 ) {
		$size = size_format( $file['size'], 2 );
		// translators: file size is too large.
		wp_die( sprintf( esc_html__( 'File size too large (%s). Maximum 2MB', 'testimonial-basics' ), esc_html( $size ) ) );
	}
	if ( $file['error'] > 0 ) {
		// translators: An error was discovered.
		wp_die( sprintf( esc_html__( 'Error encountered: %d', 'testimonial-basics' ), wp_kses_post( $file['error'] ) ) );
	}
	// If we've made it this far then we can import the data.
	$imported = katb_import( $file['tmp_name'] );
	// Everything is complete, now redirect back to the page.
	if ( wp_safe_redirect( add_query_arg( 'imported', $imported ) ) ) {
		exit();
	}
}
add_action( 'admin_init', 'katb_maybe_upload' );

/**
 * Creates the backup and downloads it.
 *
 * @param array $args don't know why it is there :).
 */
function katb_do_backup( $args = array() ) {
	// Create a file name.
	$filename = 'testimonial_basics_' . date( 'Y-m-d' ) . '.xml';// phpcs:ignore
	// Print the logs.
	global $wpdb;
	$table        = $wpdb->prefix . 'testimonial_basics';
	$katb_tdata   = $wpdb->get_results( " SELECT * FROM `$table` ORDER BY `tb_date` DESC ", ARRAY_A );// phpcs:ignore
	$katb_tnumber = $wpdb->num_rows;
	if ( 0 === $katb_tnumber ) {
		return false;
	}
	// Print header.
	header( 'Content-Description: File Transfer' );
	header( 'Content-Disposition: attachment; filename=' . $filename );
	header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
	// Print comments.
	?>
	<!-- This is a export of the testimonial-basics table -->
	<!--  Import using the Import Button in the Testimonial Basics admin page -->
	<testimonials>
		<?php for ( $i = 0; $i < $katb_tnumber; $i++ ) { ?>
			<testimonial>
				<id><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_id'] ) );// phpcs:ignore ?></id>
				<date><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_date'] ) );// phpcs:ignore ?></date>
				<group><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_group'] ) );// phpcs:ignore ?></group>
				<order><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_order'] ) );// phpcs:ignore ?></order>
				<approved><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_approved'] ) );// phpcs:ignore ?></approved>
				<name><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_name'] ) );// phpcs:ignore ?></name>
				<location><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_location'] ) );// phpcs:ignore ?></location>
				<email><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_email'] ) );// phpcs:ignore ?></email>
				<pic_url><?php echo katb_wrap_cdata( esc_url( $katb_tdata[ $i ]['tb_pic_url'] ) );// phpcs:ignore ?></pic_url>
				<web_url><?php echo katb_wrap_cdata( esc_url( $katb_tdata[ $i ]['tb_url'] ) );// phpcs:ignore ?></web_url>
				<rating><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_rating'] ) );// phpcs:ignore ?></rating>
				<custom1><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_custom1'] ) );// phpcs:ignore ?></custom1>
				<custom2><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_custom2'] ) );// phpcs:ignore ?></custom2>
				<title><?php echo katb_wrap_cdata( sanitize_text_field( $katb_tdata[ $i ]['tb_title'] ) );// phpcs:ignore ?></title>
				<content><?php echo katb_wrap_cdata( wp_kses_post( $katb_tdata[ $i ]['tb_testimonial'] ) );// phpcs:ignore ?></content>
			</testimonial>
		<?php } ?>
	</testimonials>
	<?php
	exit();
}

/**
 * Wraps the passed string in a XML CDATA tag.
 *
 * @param string $string String to wrap in a XML CDATA tag.
 * @return string
 */
function katb_wrap_cdata( $string ) {
	if ( false === seems_utf8( $string ) ) {
		$string = utf8_encode( $string );
	}
	return '<![CDATA[' . str_replace( ']]>', ']]]]><![CDATA[>', $string ) . ']]>';
}
/**
 * Import file.
 *
 * @param file $file is the import file.
 */
function katb_import( $file ) {
	// Parse file.
	$testimonials = katb_parse( $file );
	// No logs found ? - then aborted.
	if ( ! $testimonials ) {
		return false;
	}
	// get the testimonials from the existing database.
	global $wpdb;
	$table        = $wpdb->prefix . 'testimonial_basics';
	$katb_tdata   = $wpdb->get_results( " SELECT `tb_id` FROM `$table` ", ARRAY_A );// phpcs:ignore
	$katb_tnumber = $wpdb->num_rows;
	// Initialises a variable storing the number of testimonials successfully imported.
	$imported = 0;
	// Go through each testimonial to restore.
	foreach ( $testimonials as $testimonial ) {
		// Check if the testimonial id already exists, don't restore if it does.
		$exists = false;
		if ( $katb_tnumber > 0 ) {
			for ( $i = 0; $i < $katb_tnumber; $i++ ) {
				if ( $katb_tdata[ $i ]['tb_id'] === $testimonial['id'] ) {
					$exists = true;
				}
			}
		}
		// If it exists, don't import it.
		if ( $exists ) {
			$count++;
			continue;
		}
		// Proceed with restore.
		// Start by validating Input.
		// Testimonial unique id.
		$restore_id = intval( $testimonial['id'] );
		// Date Validation.
		$restore_datetime = sanitize_text_field( $testimonial['date'] );
		// group validation.
		$restore_group = sanitize_text_field( $testimonial['group'] );

		// Order must be an integer.
		$restore_order = $testimonial['order'];
		if ( '' !== $restore_order ) {
			if ( false === is_numeric( $restore_order ) ) {
				$restore_order = '';
			}
		}
		// Approved is either checked (1) or not checked (0).
		$restore_approved = $testimonial['approved'];
		if ( true === $restore_approved || '1' === $restore_approved || 1 === $restore_approved ) {
			$restore_approved = true;
		} else {
			$restore_approved = false;
		}
		// Author validation.
		$restore_author = sanitize_text_field( $testimonial['name'] );
		// Location validation.
		$restore_location = sanitize_text_field( $testimonial['location'] );
		// Email validation.
		$restore_email = sanitize_email( $testimonial['email'] );
		// Photo validation.
		$restore_picture_url = $testimonial['pic_url'];
		if ( '' !== $restore_picture_url ) {
			$restore_picture_url = esc_url( $restore_picture_url );
		}
		if ( 'http://' === $restore_picture_url ) {
			$restore_picture_url = '';
		}
		// Website validation.
		$restore_website = $testimonial['web_url'];
		if ( '' !== $restore_website ) {
			$restore_website = esc_url( $restore_website );
		}
		if ( 'http://' === $restore_website ) {
			$restore_website = '';
		}
		// Rating Validation.
		$restore_rating = sanitize_text_field( $testimonial['rating'] );
		// Sanitize custom1.
		$restore_custom1 = sanitize_text_field( $testimonial['custom1'] );
		// Sanitize custom2.
		$restore_custom2 = sanitize_text_field( $testimonial['custom2'] );
		// Sanitize title.
		$restore_title = sanitize_text_field( $testimonial['title'] );
		// Sanitize testimonial - same html allowed as allowed in posts.
		$restore_testimonial = wp_kses_post( $testimonial['content'] );
		// Validation complete.
		$values         = array(
			'tb_id'          => $restore_id,
			'tb_date'        => $restore_datetime,
			'tb_order'       => $restore_order,
			'tb_approved'    => $restore_approved,
			'tb_group'       => $restore_group,
			'tb_name'        => $restore_author,
			'tb_email'       => $restore_email,
			'tb_location'    => $restore_location,
			'tb_url'         => $restore_website,
			'tb_pic_url'     => $restore_picture_url,
			'tb_rating'      => $restore_rating,
			'tb_custom1'     => $restore_custom1,
			'tb_custom2'     => $restore_custom2,
			'tb_title'       => $restore_title,
			'tb_testimonial' => $restore_testimonial,
		);
		$formats_values = array( '%d', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
		$wpdb->insert( $table, $values, $formats_values );// phpcs:ignore
		$imported++;
	}
	return $imported;
}

/**
 * Parse XML file
 *
 * @param file $file is a file.
 */
function katb_parse( $file ) {
	// Load the xml file.
	$xml = simplexml_load_file( $file, null, LIBXML_NOCDATA );
	// Halt if loading produces an error.
	if ( ! $xml ) {
		return false;
	}
	$testimonial_counter = 0;
	// Initial logs array.
	$testimonials = array();
	foreach ( $xml->xpath( '/testimonials/testimonial' ) as $testimonial_obj ) {
		$testimonial                          = $testimonial_obj->children();
		$testimonials[ $testimonial_counter ] = array(
			'id'       => (int) $testimonial->id,
			'date'     => (string) $testimonial->date,
			'group'    => (string) $testimonial->group,
			'order'    => (int) $testimonial->order,
			'approved' => (int) $testimonial->approved,
			'name'     => (string) $testimonial->name,
			'location' => (string) $testimonial->location,
			'email'    => (string) $testimonial->email,
			'pic_url'  => (string) $testimonial->pic_url,
			'web_url'  => (string) $testimonial->web_url,
			'rating'   => (string) $testimonial->rating,
			'custom1'  => (string) $testimonial->custom1,
			'custom2'  => (string) $testimonial->custom2,
			'title'    => (string) $testimonial->title,
			'content'  => (string) $testimonial->content,
		);
		$testimonial_counter ++;
	}
	return $testimonials;
}

/**
 * Admin notices.
 */
function katb_admin_notices() {
	// Was an import attempted and are we on the correct admin page?
	if ( ! isset( $_GET['imported'] ) || 'testimonials_page_katb-backup' !== get_current_screen()->id ) {// phpcs:ignore
		return;
	}
	$imported = intval( wp_unslash( $_GET['imported'] ) );// phpcs:ignore
	if ( true === $imported ) {
		printf( '<div class="updated"><p>%s</p></div>', esc_html__( '1 testimonial successfully imported', 'testimonial-basics' ) );
	} elseif ( intval( wp_unslash( $_GET['imported'] ) ) ) {// phpcs:ignore
		// translators: Number of testimonials imported.
		printf( '<div class="updated"><p>%s</p></div>', sprintf( esc_html__( '%d testimonials successfully imported', 'testimonial-basics' ), esc_html( $imported ) ) );
	} else {
		printf( '<div class="error"><p>%s</p></div>', esc_html__( ' No testimonials were imported - must be a problem somewhere :(', 'testimonial-basics' ) );
	}
}
add_action( 'admin_notices', 'katb_admin_notices' );

/**
 * Function to add unapproved testimonials count to admin menu.
 *
 * Reference: http://wordpress.org/support/topic/add-bubble-for-pending-count-in-admin-dashboard?replies=1.
 */
function katb_add_unapproved_count() {
	// Setup database table.
	global $wpdb , $tablename, $menu;
	$tablename = $wpdb->prefix . 'testimonial_basics';
	$results   = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(1) FROM `$tablename` WHERE `tb_approved` = %s",'0' ), ARRAY_A );// phpcs:ignore
	$total     = $results[0]['COUNT(1)'];
	if ( 0 !== $total ) {
		foreach ( $menu as $key => $value ) {
			if ( 'katb_testimonial_basics_admin' === $menu[ $key ][2] ) {
				$menu[ $key ][0] .= " <span class='update-plugins count-$total'><span class='plugin-count'>" . $total . '</span></span>';// phpcs:ignore
				return;
			}
		}
	}
}
add_action( 'admin_menu', 'katb_add_unapproved_count' );

