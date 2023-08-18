/*
 * Doc ready script to render multiple reCaptchas.
 *
 * @package   Testimonial Basics WordPress Plugin
 * @copyright Copyright (C) 2020 or later Kevin Archibald
 * @license   http://www.gnu.org/licenses/quick-guide-gplv3.html  GNU Public License
 * @author    Kevin Archibald <www.kevinsspace.ca/contact/>
 * Testimonial Basics is distributed under the terms of the GNU GPL
 */
var reCaptchaWidgetID1;
var KatbCaptchaCallback = function() {
	if ( jQuery( '#widget_captcha_1' ).length > 0 ) {
		var widget_1_sitekey = jQuery( '#widget_captcha_1' ).data( "sitekey" );
		reCaptchaWidgetID1 = grecaptcha.render( 'widget_captcha_1', { 'sitekey' : widget_1_sitekey } );
		grecaptcha.reset(reCaptchaWidgetID1);
		//reCaptchaWidgetID1 = grecaptcha.render( document.getElementById( 'widget_captcha_1' ), { 'sitekey' : widget_1_sitekey } );
	}
	if ( jQuery( '#widget_captcha_2' ).length > 0 ) {
		var widget_2_sitekey = jQuery( '#widget_captcha_2' ).data( "sitekey" );
		reCaptchaWidgetID2 = grecaptcha.render( 'widget_captcha_2', { 'sitekey' : widget_2_sitekey } );
	}
	if ( jQuery( '#widget_captcha_3' ).length > 0 ) {
		var widget_3_sitekey = jQuery( '#widget_captcha_3' ).data( "sitekey" );
		reCaptchaWidgetID3 = grecaptcha.render( 'widget_captcha_3', { 'sitekey' : widget_3_sitekey } );
	}
	if ( jQuery( '#widget_captcha_4' ).length > 0 ) {
		var widget_4_sitekey = jQuery( '#widget_captcha_4' ).data( "sitekey" );
		reCaptchaWidgetID4 = grecaptcha.render( 'widget_captcha_4', { 'sitekey' : widget_4_sitekey } );
	}
	if ( jQuery( '#widget_captcha_5' ).length > 0 ) {
		var widget_5_sitekey = jQuery( '#widget_captcha_5' ).data( "sitekey" );
		reCaptchaWidgetID5 = grecaptcha.render( 'widget_captcha_5', { 'sitekey' : widget_5_sitekey } );
	}
	if ( jQuery( '#content_captcha_1' ).length > 0 ) {
		var content_1_sitekey = jQuery( '#content_captcha_1' ).data( "sitekey" );
		reCaptchaContentID1 = grecaptcha.render( 'content_captcha_1', { 'sitekey' : content_1_sitekey } );
	}
	if ( jQuery( '#content_captcha_2' ).length > 0 ) {
		var content_2_sitekey = jQuery( '#content_captcha_2' ).data( "sitekey" );
		reCaptchaContentID2 = grecaptcha.render( 'content_captcha_2', { 'sitekey' : content_2_sitekey } );
	}
	if ( jQuery( '#content_captcha_3' ).length > 0 ) {
		var content_3_sitekey = jQuery( '#content_captcha_3' ).data( "sitekey" );
		reCaptchaContentID3 = grecaptcha.render( 'content_captcha_3', { 'sitekey' : content_3_sitekey } );
	}
	if ( jQuery( '#content_captcha_4' ).length > 0 ) {
		var content_4_sitekey = jQuery( '#content_captcha_4' ).data( "sitekey" );
		reCaptchaContentID4 = grecaptcha.render( 'content_captcha_4', { 'sitekey' : content_4_sitekey } );
	}
	if ( jQuery( '#content_captcha_5' ).length > 0 ) {
		var content_5_sitekey = jQuery( '#content_captcha_5' ).data( "sitekey" );
		reCaptchaContentID5 = grecaptcha.render( 'content_captcha_5', { 'sitekey' : content_5_sitekey } );
	}
};
