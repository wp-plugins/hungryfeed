<?php 
/** 
 * ################################################################################
 * UTILITIES
 * ################################################################################
 */

/**
 * Util function returns an array value, if not defined then returns default instead.
 * @param Array $array
 * @param string $key
 * @param variant $default
 */
function hungryfeed_val($arr,$key,$default='')
{
	return isset($arr[$key]) ? $arr[$key] : $default;
}

/**
 * output a fatal error and optionally die
 * 
 * @param string $message
 * @param string $title
 * @param bool $die
 */
function hungryfeed_fatal($message, $title = "", $die = false)
{
	echo ("<div style='margin:5px 0px 5px 0px;padding:10px;border: solid 1px red; background-color: #ff6666; color: black;'>"
		. ($title ? "<h4 style='font-weight: bold; margin: 3px 0px 8px 0px;'>" . $title . "</h4>" : "")
		. $message
		. "</div>");
		
	if ($die) die();
}

/**
 * Used in combination with set_error_handler before reading feeds so that any errors can be caught
 * and displayed in a friendly way without freaking out visitors.
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 */
function hungryfeed_handle_rss_error($errno, $errstr, $errfile, $errline) 
{
	// the simplepie plugin makes a lot of static calls illegally.  ignore 'em
	if ($errno == '2048') return true;
	
	hungryfeed_fatal("An error occured while processing the feed: " . $errstr);
	return true;
}

/**
 * include the simplepie class files and return true if successful.  if not
 * successful then an error message will be displayed and false will be returned.
 */
function hungryfeed_include_simplepie()
{
	if (!class_exists('SimplePie'))
	{
		if (file_exists(ABSPATH . WPINC . '/class-simplepie.php'))
		{
			include_once(ABSPATH . WPINC . '/class-simplepie.php');
		}
		else
		{
			hungryfeed_fatal("Please either upgrade to WordPress 3 or else install the "
				."<a href='http://wordpress.org/extend/plugins/simplepie-core'>SimplePie Core plugin</a> "
				."for WordPress.", "HungryFEED can't find SimplePie.  Don't be mad at HungryFEED.");
				
			return false;
		}
	}
	
	return true;
}

?>