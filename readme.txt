=== Plugin Name ===
Contributors: verysimple
Donate link: http://verysimple.com/products/hungryfeed/
Tags: inline,embed,rss,feed,reader,feed reader,page,simplepie,inline rss,rss feed,feed reader,rss reader,inline feed reader,embed feed,inline rss feed
Requires at least: 2.7
Tested up to: 3.2.0
Stable tag: trunk

HungryFEED embeds and displays RSS feeds inline on your pages, posts or sidebar using Shortcodes.

== Description ==

HungryFEED allows you to embed and display an RSS feed inline on your posts, pages or sidebar
by adding a Shortcode.  Usage is easy, just use the following shortcode:

[hungryfeed url="http://verysimple.com/feed/"]

= Features =

* Uses WordPress Shortcodes to embed RSS feeds on any page, post or sidebar widget
* Has a variety of parameters to filter and format the feed
* Relies on WordPress built-in SimplePie for processing RSS data
* Fixes characters in URLs that may get mangled when editing in Visual mode
* Caches feeds and allows configuration of the cache expiration
* Outputs clean, HTML for easy styling with a CSS configuration setting
* Allows you to customize the HTML using templates
* Allows filtering of items in the RSS feed based on keywords
* Allows feed pagination

== Installation ==

Automatic Installation:

1. Go to Admin - Plugins - Add New
2. Search for HungryFEED
3. Click the Install Button

Manual Installation:

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

= 1.4.7 =
* fixed bug with feeds that have no category

== Changelog ==

= 1.4.7 =
* fixed bug with feeds that have no category

= 1.4.6 =
* added a button to the post/page editor to provide a GUI for creating shortcodes
* added index tag to be used in templates
* category tag in template now displays comma-delimited list if there are multiple categories

= 1.4.5 =
* added filter_out parameter to exclude items with certain keywords

= 1.4.4 =
* added order parameter to allow reverse or random order

= 1.4.3 =
* description can now be truncated using truncate_description parameter

= 1.4.2 =
* description can now be truncated using truncate_description parameter

= 1.4.1 =
* multiple filter words can now be specified, separated by a pipe | char
* Added attr selector in order to get attributes of selected elements, such as an image src
* added additional properties to the feed: soure, enclosure, id, category
* updated settings page with documentation

= 1.4.0 =
* Added feature to templates for transforming the RSS description field using phpquery selectors
* Filter parameter is now case-insensitive

= 1.3.9 =
* Added option to enable shortcodes in widgets

= 1.3.8 =
* HOTFIX pagination re-enabled

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