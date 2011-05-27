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
 * Truncates text to a certain number of characters.  If the text contains HTML, any tags will 
 * be properly closed so as not to mess up layout.
 * @param string $text
 * @param int $length
 * @param string $ending
 * @param bool $exact
 * @param bool $considerHtml
 */
function hungryfeed_truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
    if (is_array($ending)) {
        extract($ending);
    }
    if ($considerHtml) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen($ending);
        $openTags = array();
        $truncate = '';
        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }

    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($considerHtml) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }

    $truncate .= $ending;

    if ($considerHtml) {
        foreach ($openTags as $tag) {
            $truncate .= '</'.$tag.'>';
        }
    }

    return $truncate;
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
 * Create a pagination/filter URL, appending the specified querystring.  
 * will prepend a ? or & as needed depending on the current url
 * @param array $querystring example: array('var1'=>'val1','var2'=>'val2')
 * @bool preserve any existing querystring parameters
 * @return string
 */
function hungryfeed_create_url($pairs,$preserve_existing = true)
{
	$uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "";
	
	// need to strip out an previous value
	list($base,$original_qs) = explode("?",$uri,2);
	
	$new_qs = "";
	$delim = "?";
	
	$params = explode("&",$original_qs);
	
	if ($preserve_existing)
	{
		// add existing params that we need to preserve
		foreach ($params as $param)
		{
			list($key,$val) = explode("=",$param,2);
	
			if (!array_key_exists($key,$pairs))
			{
				$new_qs .= $delim . $param;
				$delim = "&";
			}
		}
	}

	// now add any new params necessary
	foreach ($pairs as $key=>$val)
	{
		$new_qs .= $delim . $key . "=" . $val;
		$delim = "&";
	}
	
	return $base . $new_qs;
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