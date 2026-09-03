=== Image Ticker & Logo Slider – Continuous Auto-Scroll Carousel with Lightbox ===
Contributors:nik00726
Donate link:http://www.i13websolution.com/donate-wordpress_image_thumbnail.php
Tags: logo slider,image ticker,carousel,slider,lightbox
Requires at least: 5.0
Tested up to: 7.1
Version: 2.0
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An auto-scrolling image ticker & logo slider for WordPress with a responsive lightbox — dependency-free Modern engine (no jQuery), plus a native Gutenberg block.

== Description ==

**Image Ticker & Logo Slider** displays a continuously auto-scrolling row of images — client logos, a photo strip, a "featured in" bar — with an optional responsive lightbox, and no page reload or complicated setup required.

Choose between two engines: a brand-new **dependency-free "Modern" engine with no jQuery required**, or the original engine for maximum theme compatibility. Add your slider with a simple shortcode, or drop it in visually with the built-in **Gutenberg block** — no shortcode needed.

[youtube https://www.youtube.com/watch?v=IIltD_9L1Gs]


**Live Demo  [Image Ticker & Logo Slider](http://blog.i13websolution.com/wp-continuous-slider-with-lightbox-pro/)**

**Want unlimited sliders, bulk image upload, crop/border/shadow styling, and native Divi & Elementor support?** Find **Logo Slider & Image Ticker Pro** at [i13websolution.com](https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/)

**Please rate this plugin if you find it useful — it genuinely helps other people find it.**

= Features =

1. A continuously auto-scrolling image ticker, with an optional responsive lightbox.
2. **Modern engine**: a dependency-free, no-jQuery ticker and lightbox — lighter, faster, and touch/keyboard accessible. Or use the original engine if you prefer.
3. Native **Gutenberg block** — insert the slider visually, no shortcode required (the shortcode still works too, everywhere else).
4. Add, edit, and reorder images from a simple admin screen.
5. Image title doubles as the alt tag, for SEO, and as the lightbox caption.
6. Preview your slider before publishing.
7. Adjustable image height, width, and scroll speed.
8. Set how many images are visible at once.
9. Turn the lightbox on or off.
10. Optional link per image, added to the lightbox caption.
11. WordPress role/capability support.

= Why upgrade to Pro? =

The free version gives you one slider, shared everywhere you use it. **Logo Slider & Image Ticker Pro** unlocks:

* **Unlimited, independent sliders** — a different logo strip in the footer, a photo ticker on the homepage, a client bar on a landing page, each with its own images and settings.
* **Bulk image upload** — add a batch of images at once instead of one at a time.
* **Crop / No-crop** display mode, plus **border color, border radius, and box shadow** styling — per slider.
* **Random image order.**
* **Lightbox caption position** (over the image or below it) and padding — per slider.
* A **full-featured Gutenberg block** — pick or create a slider and manage its images right from the block's own settings panel.
* Native **Divi module** and **Elementor widget** — no shortcode needed in either builder.
* Add a WordPress featured image to a slider directly from the post/page editor.
* No advertisements, priority support.

**[→ See Logo Slider & Image Ticker Pro](https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/)**

[Get Support](http://www.i13websolution.com/contacts)

== Installation ==

1. Upload the `continuous-image-carousel-with-lightbox` folder to `wp-content/plugins`.
2. Activate the plugin from Dashboard → Plugins.
3. Go to the **Continuous Slider plus Lightbox** menu to add your images and choose your settings.

### Usage ###

There are two ways to add your slider — use whichever fits how you build pages:

1. **Gutenberg block** — search for "Image Ticker & Logo Slider" (or "Continuous Image Carousel") in the block inserter and add it directly. No shortcode needed.
2. **Shortcode** — add `[print_continuous_slider_plus_lightbox]` to any post or page, or in a theme template: `echo do_shortcode('[print_continuous_slider_plus_lightbox]');`

Manage images and every setting — including which engine to use — from the **Continuous Slider plus Lightbox** admin menu.

== Screenshots ==

1. Slider Settings
2. Manage Images
3. Preview Slider
4. Slider on website frontend
5. Slider lightbox
6. Responsive continuous carousel slider
7. Pro Version slider
8. Pro version manage sliders.
9. Pro version manage images.
10. Free version block
11. Pro Version Block
12. New lightbox

== License ==

This plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial site. If you find it useful, a donation is always appreciated.

== Changelog ==

= 2.0 =

* Added a new "Modern" engine for both the slider and the lightbox — dependency-free, no jQuery required. Existing sliders keep using the original engine automatically after updating; Modern is opt-in in the slider settings.
* Added a native Gutenberg block, so the slider can be inserted without the shortcode.
* Fixed: image caption not rendering on the Modern engine.
* Fixed: extra gap under images on the Modern engine.
* Fixed: caption exceeding the image's rounded border on the Modern engine.
* Fixed: possible fatal error on very old WordPress versions if block registration ran without the required core function present.
* Added cache-busting based on file modification time for engine assets, so updates are never served stale by the browser or a page cache.
* Added a menu icon.
* Renamed the plugin to better reflect what it does (Image Ticker & Logo Slider). No functionality changed because of the rename, and your existing shortcodes/settings are unaffected.
* Tested with WordPress 7.1

= 1.0.20 =

* Security fixes -- php.error.echo.reporting.multipart.form.copy

= 1.0.19 =

* Added webp image support
* Tested with WordPress 6.8

= 1.0.18 =

* Fixed E_Error – Too few arguments to function

= 1.0.17 =

* Make shortcode compatible with block editor
* Tested with WordPress 6.3

= 1.0.16 =

* Fixed vulnerability
* Tested with WordPress 6.2

= 1.0.15 =

* Fixed page not refresh after adding mass images to slider
* Tested with WordPress 6.1

= 1.0.14 =

* Fixed html broken some themes
* Tested with WordPress 5.9
* Added mass image add function

= 1.0.13 =

* Fixed image flicker in chrome

= 1.0.12 =

* Fixed slider and lightbox not working with jQuery 3.x

= 1.0.11 =

* Fixed lazy loading
* Tested with WordPress 5.5

= 1.0.10 =

* Removed jQuery.NoConflict
* Fixed animation of other elements after slider that cause not showing or invalid places.

= 1.0.9 =

* Improve slider loading by hidden untile slider loaded.

= 1.0.8 =

* Fixed undefined error problem while installation
* Tested with WordPress 5.3

= 1.0.7 =

* Some how wordpress adding noopener noreferrer into link, and that cause problem in lightbox. So fix that.

= 1.0.6 =

* Added caption option to slider
* Tested with WordPress 5.2
* Improve code so that slider can work even, if jquery included in footer.

= 1.0.5 =
* Tested with WordPress 5.1
* Added WordPress capabilities feature

= 1.0.4 =

* Improve admin UI
* Plugin is now translatable
* Tested with WordPress 5.0

= 1.0.3 =

* fixes for shortcode not working in new wordpress 4.8 widgets

= 1.0.2 =

* fixes for multiple fancybox version.

= 1.0.1 =

* I notice that some host wan't allow url in copy function php so now it is fixed.

* Tested upto wordpress 4.6

= 1.0 =

* Stable 1.0 first release

== Upgrade notice ==

= 2.0 =
* New: dependency-free "Modern" engine option and a native Gutenberg block. Fully backward compatible — your existing slider keeps its exact current appearance and behavior after updating.

= 1.0.9 =

* Please clear browser cache as well as WordPress cache.

= 1.0.7 =

* Please clear browser cache as well as WordPress cache.

= 1.0.2 =

* fixes for multiple fancybox version.

= 1.0.1 =

* Pro version please do not Upgrade here insted contact @ https://www.i13websolution.com/contacts

= 1.0 =

* Stable 1.0 first release

== Frequently asked questions ==

= What's the difference between the Modern and Legacy engine? =

Modern is a small, dependency-free ticker and lightbox with no jQuery required — faster, and works even if a theme or another plugin has jQuery conflicts. Legacy is the original engine. Your slider keeps running on Legacy automatically after you update; Modern is opt-in in the slider settings.

= Will updating this plugin change how my slider looks? =

No. Your slider is pinned to its current engine automatically. Nothing changes unless you deliberately switch it to Modern.

= Can I use more than one slider? =

The free version supports one slider, shared everywhere you add it (shortcode or block). [Pro](https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/) supports unlimited independent sliders, each with its own images and settings.

= Does this work with Elementor or Divi? =

The free version works anywhere you can place a shortcode or a Gutenberg block, including inside most builders' shortcode/HTML widgets. For a dedicated native Divi module and Elementor widget, see [Pro](https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/).

= How do I add many images at once? =

The free version adds images one at a time. [Pro](https://www.i13websolution.com/product/wordpress-continuous-image-carousel-with-lightbox-pro/) adds bulk image upload from the Media Library.

= Is this compatible with multisite? =

Yes.

For more info, see the Installation and Usage notes above.
