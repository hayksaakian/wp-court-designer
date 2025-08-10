=== Court Designer ===
Contributors: hayksaakian
Tags: sports, court, designer, tennis, basketball, pickleball, customization, color picker
Requires at least: 5.8
Tested up to: 6.4
Stable tag: 1.3.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Interactive court designer for tennis, basketball, and pickleball courts with customizable colors for construction companies to showcase options to clients.

== Description ==

Court Designer is a free, open-source WordPress plugin that allows construction companies to embed an interactive court designer on their website. Clients can preview different color combinations for tennis, basketball, and pickleball courts in real-time.

**Perfect for:**
* Court construction companies
* Sports facility contractors
* Athletic surface installers
* Recreation center planners

**Key Features:**

* **Three Court Types** - Tennis, Basketball, and Pickleball courts
* **Real-time Color Preview** - Instant visual feedback as colors are selected
* **17 Professional Colors** - Industry-standard court colors including LEED-certified options
* **Company Branding** - Add your company logo to all court designs
* **Download Designs** - Clients can save court designs as PNG images
* **Responsive Design** - Works perfectly on desktop, tablet, and mobile devices
* **Multiple Integration Methods** - Use via shortcode or Gutenberg block
* **No External Dependencies** - All rendering done client-side for fast performance

**Available Colors Include:**
* Ice Blue, Light Blue, Blue
* Light Green, Forest Green, Dark Green  
* Tournament Purple, Black, Maroon
* Red, Brite Red, Orange, Yellow
* Sandstone, Beige, Dove Gray
* Brown (ColorPlus fusion blend)

**Customizable Court Areas:**

*Tennis Courts:*
* Court (inner play area)
* Border (outer area)

*Basketball Courts:*
* Court surface
* Border
* 3-Point Area
* Key (paint area)
* Top of Key
* Center Court Circle

*Pickleball Courts:*
* Court
* Border  
* Non-Volley Zone (kitchen)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/court-designer` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings → Court Designer screen to configure the plugin and add your company logo
4. Add the court designer to any page or post using the shortcode or block

== Usage ==

**Via Shortcode:**
`[court_designer type="tennis"]`
`[court_designer type="basketball"]`
`[court_designer type="pickleball"]`

**Via Gutenberg Block:**
1. In the block editor, search for "Court Designer"
2. Add the block to your page
3. Select the court type in the block settings

== Frequently Asked Questions ==

= Can I customize the available colors? =

Yes, advanced users can modify the colors by editing the `assets/data/colors.json` file in the plugin directory.

= Is this plugin free? =

Yes, this plugin is completely free and open source under the GPL v2 license.

= Can clients save their designs? =

Yes, users can download their court designs as PNG images using the Download Design button.

= Does this work on mobile devices? =

Yes, the court designer is fully responsive and works on all modern devices and browsers.

= Can I add my company logo? =

Yes! Go to Settings → Court Designer in your WordPress admin to upload your company logo. It will appear on all court designs.

= Does this plugin make external API calls? =

No, all rendering is done client-side. The plugin does not make any external API calls or send data to third-party services.

== Screenshots ==

1. Tennis court designer with color selection interface
2. Basketball court with multiple customizable areas
3. Pickleball court designer showing color options
4. Admin settings page for logo upload
5. Mobile responsive view
6. Downloaded court design example

== Changelog ==

= 1.3.1 =
* Fixed reset colors button not updating color indicators
* Fixed basketball and pickleball color indicators display
* Fixed color indicators when switching court types

= 1.3.0 =
* Security Enhancement: Removed URL input for logos - Media Library only
* Added automatic migration from URLs to attachment IDs
* Improved WordPress Media Library integration
* Added image type filtering in media uploader

= 1.2.1 =
* Enhanced URL validation for logo uploads
* Added error handling for JSON file loading
* Improved file inclusion with existence checks
* Fixed JavaScript initialization for dynamically loaded scripts

= 1.2.0 =
* Added color indicators on area selection tabs
* Added "Currently Selected: [Color Name]" display
* Improved user interface for better color selection clarity

= 1.1.0 =
* Moved logo upload from frontend to admin settings only
* Logo now persistent across all court designs
* Added WordPress Media Library integration

= 1.0.2 =
* Fixed Settings link URL in plugins list

= 1.0.1 =
* Added Settings link in WordPress plugins list

= 1.0.0 =
* Initial release
* Support for Tennis, Basketball, and Pickleball courts
* 17 standard court colors with LEED certification info
* Real-time color customization
* Download court designs as PNG
* Shortcode and Gutenberg block support

== Upgrade Notice ==

= 1.3.0 =
Important security update: Logo uploads now restricted to WordPress Media Library only. External URLs no longer supported for maximum security.

= 1.2.0 =
Enhanced UI with color indicators showing current selections for each court area.

= 1.1.0 =
Logo upload moved to admin settings for better security and persistent branding.

== License ==

This plugin is licensed under the GPL v2 or later.

== Credits ==

Developed by Hayk Saakian