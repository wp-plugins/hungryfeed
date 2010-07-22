<?php
/*
Plugin Name: HungryFEED
Plugin URI: http://verysimple.com/products/hungryfeed/
Description: HungryFEED displays RSS feeds on a page or post using Shortcodes.	Respect!
Version: 1.1.0
Author: VerySimple
Author URI: http://verysimple.com/
License: GPL2
*/

define('HUNGRYFEED_VERSION','1.1.0');
define('HUNGRYFEED_DEFAULT_CACHE_DURATION',3600);
define('HUNGRYFEED_DEFAULT_CSS',"h3.hungryfeed_feed_title {}\np.hungryfeed_feed_description {}\ndiv.hungryfeed_items {}\ndiv.hungryfeed_item {margin-bottom: 10px;}\ndiv.hungryfeed_item_title {font-weight: bold;}\ndiv.hungryfeed_item_description {}\ndiv.hungryfeed_item_author {}\ndiv.hungryfeed_item_date {}");
define('HUNGRYFEED_DEFAULT_CACHE_LOCATION',ABSPATH . 'wp-content/cache');
define('HUNGRYFEED_DEFAULT_FEED_FIELDS','title,description');
define('HUNGRYFEED_DEFAULT_ITEM_FIELDS','title,description,author,date');

/**
 * import supporting libraries
 */
include_once(plugin_dir_path(__FILE__).'settings.php');
include_once(plugin_dir_path(__FILE__).'libs/utils.php');

add_shortcode('hungryfeed', 'hungryfeed_display_rss');
add_action('admin_menu', 'hungryfeed_create_menu');

/**
 * Displays the RSS feed on the page
 * @param unknown_type $params
 */
function hungryfeed_display_rss($params)
{
	// if simplepie isn't installed then we can't continue
	if (!hungryfeed_include_simplepie()) return "";
	
	// read in all the possible shortcode parameters
	$url = hungryfeed_val($params,'url','http://verysimple.com/feed/');
	$force_feed = hungryfeed_val($params,'force_feed','0');
	$xml_dump = hungryfeed_val($params,'xml_dump','0');
	$decode_url = hungryfeed_val($params,'decode_url','1');
	$max_items = hungryfeed_val($params,'max_items',0);
	
	$feed_fields = explode(",", hungryfeed_val($params,'feed_fields',HUNGRYFEED_DEFAULT_FEED_FIELDS));
	$item_fields = explode(",", hungryfeed_val($params,'item_fields',HUNGRYFEED_DEFAULT_ITEM_FIELDS));
	
	// fix weirdness in the url due to the wordpress visual editor
	if ($decode_url) $url = html_entity_decode($url);
	
	// buffer the output.
	ob_start();
	
	echo "<style>\n" .  get_option('hungryfeed_css',HUNGRYFEED_DEFAULT_CSS) . "\n</style>";

	// catch any errors that simplepie throws
	set_error_handler('hungryfeed_handle_rss_error');
	$feed = new SimplePie();
	
	$cache_duration = get_option('hungryfeed_cache_duration',HUNGRYFEED_DEFAULT_CACHE_DURATION);
	if ($cache_duration)
	{
		$feed->enable_cache(true);
		$feed->set_cache_duration($cache_duration);
		$feed->set_cache_location(HUNGRYFEED_DEFAULT_CACHE_LOCATION);
	}
	else
	{
		$feed->enable_cache(false);
	}
	
	$feed->set_feed_url($url);
	
	// HACK: SimplePie adds this weird shit into eBay feeds
	$feed->feed_url = str_replace("%23038;","",$feed->feed_url);
	
	if ($force_feed) $feed->force_feed(true);
	
	if (!$feed->init())
	{	
		hungryfeed_fatal("SimplePie reported: " . $feed->error,"HungryFEED can't get feed.  Don't be mad at HungryFEED.");
		
		if ($xml_dump)
		{
			// this will cause messed up output since simplepie outputs xml headers
			// but there seems to be no other way to get the raw xml back out for debuggin
			
			echo "\n\n\n<!-- BEGIN DEBUG OUTPUT FROM FEED at $feed->feed_url -->\n\n\n";
			
			$feed->xml_dump = true;
			$feed->init();
			
			echo "\n\n\n<!-- END DEBUG OUTPUT FROM FEED -->\n\n\n";
			
		}

		$buffer = ob_get_clean();
		return $buffer;
	}
	
	// restore the normal wordpress error handling
	restore_error_handler();
	
	if (in_array("title",$feed_fields)) echo '<h3 class="hungryfeed_feed_title">' . $feed->get_title() . "</h3>\n";
	if (in_array("description",$feed_fields)) echo '<p class="hungryfeed_feed_description">' . $feed->get_description() . "</p>\n";
	
	echo "<div class=\"hungryfeed_items\">\n";
	
	$counter = 0;
	foreach ($feed->get_items() as $item)
	{
		$counter++;
		if ($max_items > 0 && $counter > $max_items) break;
		
		echo "<div class=\"hungryfeed_item\">\n";
			if (in_array("title",$item_fields)) echo '<div class="hungryfeed_item_title"><a href="' . $item->get_permalink() . '">' . $item->get_title() . "</a></div>\n";
			if (in_array("description",$item_fields)) echo '<div class="hungryfeed_item_description">' . $item->get_description() . "</div>\n";
			if (in_array("author",$item_fields)) echo '<div class="hungryfeed_item_author">' . $item->get_author()->name . "</div>\n";
			if (in_array("date",$item_fields)) echo '<div class="hungryfeed_item_date">' . $item->get_date($date_format) .  "</div>\n";
		echo "</div>\n";
	}
	
	echo "</div>\n";
	
	// flush the buffer and return
	$buffer = ob_get_clean();
	return $buffer;
}


