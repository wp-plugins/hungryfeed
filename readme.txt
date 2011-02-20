=== Plugin Name ===
Contributors: verysimple
Donate link: http://verysimple.com/products/hungryfeed/
Tags: rss,feed,reader,feed reader,page,simplepie,inline rss,rss feed,feed reader,rss reader,inline feed reader, inline rss feed
Requires at least: 2.7
Tested up to: 3.0.3
Stable tag: trunk

HungryFEED displays an RSS feed inline on a page or post using Wordpress Shortcodes.

== Description ==

HungryFEED allows you to display an RSS feed inline on your page by simply adding 
a Wordpress Shortcode within the page.  Usage is easy, just type the 
following anywhere in your page:

[hungryfeed url="http://verysimple.com/feed/"]

= Features =

* Uses WordPress Shortcodes for simple inclusion of feeds on any page or post
* Has a variety of parameters to control the output formatting
* Relies on WordPress built-in SimplePie for reading RSS
* Fixes characters in URLs that may get mangled when editing in Visual mode
* Caches feeds and allows configuration of the cache expiration
* Outputs clean, HTML for easy styling with a CSS configuration setting
* Allows you to custom the HTML template used to display feeds
* Allows filtering of items in the RSS feed
* Allows feed pagination

== Installation ==

1. Download hungryfeed.zip (or use the WordPress "Add New Plugin" feature)
2. Extract the ZIP and upload the 'hungryfeed' folder to the '/wp-content/plugins/' directory
3. To support caching, ensure the directory 'wp-content/cache' exists and is writable.
4. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Enter a Shortcode on your page or post
2. The RSS feed is pulled, cached and displayed inline
3. HungryFEED hungry for RSS feeds!

== Frequently Asked Questions ==

= What is HungryFEED? =

HungryFEED is a plugin that includes an RSS feed within the content of a page or post

= Where do I go for support? =

Documentation and support is available on the plugin homepage at http://verysimple.com/products/hungryfeed/

== Upgrade Notice ==

= 1.3.8 =
* HOTFIX pagination re-enabled

== Changelog ==

= 1.3.7 =
* HOTFIX disabled pagination feature while investing problem with permalinks

= 1.3.6 =
* Added page_size parameter for pagination (beta) and link_target for target in feed links

= 1.3.6 =
* Added page_size parameter for pagination (beta) and link_target for target in feed links

= 1.3.5 =
* Added filter parameter to include only items containing specified text

= 1.3.4 =
* Added feature for stripping ellipsis from rss description using parameter strip_ellipsis

= 1.3.3 =
* Added feature for stripping html from rss description using parameter allowed_tags

= 1.3.2 =
* Bug fix for unexpected T_OBJECT_OPERATOR

= 1.3.1 =
* Removed donation button and replaced it with a link to SmileTrain.  Happy Holidays!

= 1.3.0 =
* Added custom template settings that can be used to fully customize the output of the feed

= 1.2.1 =
* Fix to directory structure to make plugin work with wordpress installer

= 1.2.0 =
* Added parameter item_link_title to enable/disable the post title link
* Added parameter date_format to format the post date

= 1.1.0 =
* Improved feed reading when special characters get mangled by visual editor
* Improved error reporting when feeds cannot be read
* Awesome hungry monster logo added

= 1.0.0 =
*  Initial Release