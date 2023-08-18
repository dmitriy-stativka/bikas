=== Testimonial Basics ===
Contributors: kevinhaig
Donate link: http://kevinsspace.ca/testimonial-basics-wordpress-plugin/
Tags: testimonials,ratings,reviews
Requires at least: 5.3
Tested up to: 5.6
Stable tag: 4.5.1
License: GPLv3
License URI: http://www.gnu.org/licenses/quick-guide-gplv3.html

Testimonial Basics is an awesome full featured plugin for managing testimonials on your site. No paid upgrades offered or required. There are extensive options to collect and display testimonials for your business.

== Description ==

Testimonial Basics is a full featured testimonial management plugin.

* backup and restore testimonials
* setup input forms in content or widget areas
* Author,Email,Testimonial are required input fields
* Testimonial Title,Location,Website are optional input fields
* two additional customizable input fields
* show testimonials in content or widget areas
* group testimonials for separate display
* use 5 star rating system
* use sliders and excerpts
* optionally use schema/google snippet markup
* black and white or color captcha built in, NOW INCLUDES reCaptcha
* customize text color and background color
* 4 layouts for content display, 6 for widget
* use one of nine web friendly fonts
* include gravatars
* easily edit and approve testimonials in the admin panel
* pagination available in 3, 5, or 10 testimonials per page
* help available in admin panels
* translations : French, Dutch, German, Spanish
* RTL compatible
* optional GDPR opt in button for submitting testimonials
* optional GDPR link on testimonials to allow users to request removal of a testimonial

== Upgrade Notice ==
* 4.5.1
* fix syntax error in katb_functions.php line 1016

== Installation ==

1. Upload Testimonial Basics to the plugin directory
   (wp-content/plugins/testimonial-basics) of your wordpress setup.
2. Ensure all sub directories are maintained.
3. Activate the theme through the Wordpress Admin panel under "Plugins".

== Frequently Asked Questions ==

= Is there documentation for the plugin?

Yes. Detailed documentation is available at http://kevinsspace.ca/testimonial-basics-user-documentation/

= Page load speeds are slow =

If your page load speed is slow it will likely be because you are using Gravatars and you are not using a cache plugin. It is recommended that you use a cache plugin for any site, whether or not you are using Gravatars for Testimonial Basics. I use WP Super Cache.

= My testimonial is not showing? =

Ensure it is approved.

= I just approved a testimonial and it is not showing? =

If you have a cache plugin installed such as WP Super Cache, the page you use to display your testimonials may be cached. Simply edit the page and update it or wait and the cached files will eventually be deleted and refreshed.

= When I input a color number in the cell the color won't change? =

Hit the enter key.

= Why can't users upload photos? =

Users are not allowed to upload photos because it is a security issue. Use of gravatars is highly recommended. Administrators have the ability to add images in the Edit Testimonials admin panel.

== Screenshots ==

1. Option Panel

2. Edit Panel

3. Content Display Layouts

4. Content Display Mosaic

5. Widget Display Layouts

6. Input forms

== Licensing ==
* Copyright (C) 2019 kevinhaig kevinsspace.ca
* Testimonial Basics is licensed and distributed under the terms of the GNU GPLv3
* License URI: [http://www.gnu.org/licenses/quick-guide-gplv3.html](http://www.gnu.org/licenses/quick-guide-gplv3.html)
* Testimonial Basics is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or(at your option) any later version.
* Testimonial Basics is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
* You should have received a copy of the GNU General Public License along with Testimonial Basics.  If not, see <http://www.gnu.org/licenses/>.

== Third Party Resources ==
* IcoMoon icons
  Author: Keyamoon http://keyamoon.com
  Copyright Keyamoon
  License : GPLv3
  http://www.gnu.org/licenses/gpl.html
  SVG used: bin.svg, star-full.svg, star-half.svg, eye-minus.svg, star-empty.svg
* Raleway Font
  Copyright (c) 2010, Matt McInerney (matt@pixelspread.com),
  Copyright (c) 2011, Pablo Impallari (www.impallari.com|impallari@gmail.com),
  Copyright (c) 2011, Rodrigo Fuenzalida (www.rfuenzalida.com|hello@rfuenzalida.com), with Reserved Font Name Raleway
  License: SIL OFL http://scripts.sil.org/OFL

== Changelog ==
* see changelog.txt for a full changelog

= 4.4.9 =
- updated translation files
- updated Copyright to 2019
- fixed some css errors
- changed the itemreviewed from Thing to Organization to elimate Strutured Data testing error

= 4.4.7 =
- fixed reCaptcha handle so reCaptcha would load
- added V2 to input reCaptcha labels for better understanding

= 4.4.6 =
- add 4.4.5 changelog to readme.txt
- fixed input form bug causing Illegal string offset Warnings
- fixed bug where excerpt pop ups were not working in the mosaic layout

= 4.4.5 =
- Updated spanish translation
- fixed bug in translation removal request email, that occured when the page was accessed directly
- fixed css on confirmation GDPR note in the widget
- added input textarea's for GDPR checkbox note and for removal page notes, to work around language translation delays
- modified css styling for admin options to float, allowing default text in the GDPR descriptions
- update translations (for what they are worth?)
- fixed bug in pagination when using $group !== 'all'
