<?php
/** 
 * ################################################################################
 * ADMIN/SETTINGS UI
 * ################################################################################
 */

// hook the plugin menu link into the admin menu
add_action('admin_menu', 'hungryfeed_create_menu');

/**
 * Create the menu link to the plugin settings page and hook into admin_init
 */
function hungryfeed_create_menu() 
{

	//create new top-level menu
	add_options_page('HungryFEED Plugin Settings', 'HungryFEED', 'administrator', __FILE__, 'hungryfeed_settings_page');

	//call register settings function
	add_action( 'admin_init', 'hungryfeed_register_settings' );
}

/**
 * Registers all of the plugin settings on admin_init
 */
function hungryfeed_register_settings() 
{
	//register our settings
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_cache_duration' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_css' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_enable_widget_shortcodes' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_enable_editor_button' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_1' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_2' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_3' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_error_template' );
}

/**
 * Render the settings page
 */
function hungryfeed_settings_page() 
{
?>
<style>
	#hungryfeed_header
	{
		border: solid 1px #c6c6c6;
		margin: 12px 2px 8px 2px;
		padding: 20px;
		background-color: #e1e1e1;
	}
	#hungryfeed_header h4
	{
		margin: 0px 0px 0px 0px;
	}
	#hungryfeed_header tr
	{
		vertical-align: top;
	}
	
	.hungryfeed_section_header
	{
		border: solid 1px #c6c6c6;
		margin: 12px 2px 8px 2px;
		padding: 20px;
		background-color: #e1e1e1;
	}
	
</style>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>HungryFEED Settings</h2>

<?php 
// if simplepie isn't installed, this will display a warning
hungryfeed_include_simplepie() 
?>

	<div id="hungryfeed_header">
	
		<h4>HungryFEED Hungry!  Me Want RSS Feeds!</h4>

		<table>
			<tr>
			<td>
				<p>Thank you for installing this plugin.  HungryFEED displays RSS feeds inline on your wordpress pages and posts.
				Check out the 
				<a href="http://verysimple.com/products/hungryfeed/">HungryFEED Site</a> for documentation and support.</p>
				
				<h4>Basic Usage Example</h4>
				
				<p style="font-family: courier">[hungryfeed url="http://verysimple.com/feed/"]</p>
				
				<p>See the documentation on the <a href="http://verysimple.com/products/hungryfeed/">HungryFEED Site</a>
				for a full list of parameters that you can use to filter, customize an transform the output.</p>
				
				<h4>How To Support HungryFEED Development and a Great Cause</h4>
				
				<p>HungryFEED is absolutely free to use and modify.  However if you would like
				to encourage it's continued development, please consider making a donation
				directly to <a href="http://www.smiletrain.org" target="_blank">SmileTrain</a>.  I 
				am not affiliated with SmileTrain, however it is my favorite charity.</p>
				
				<p>Your Pal, Jason.</p>
			</td>
			<td style="text-align: center; width: 200px;">
				<img alt="HungryFEED!" src="<?php echo plugins_url().'/hungryfeed/images/hungryfeed.png'; ?>" style="margin-bottom: 15px;"/>
			
			</td>
			</tr>
		</table>
	</div>

<form method="post" action="options.php">

    <?php settings_fields( 'hungryfeed-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Cache Duration (in seconds)</th>
        <td><input type="text" style="width:50px;" name="hungryfeed_cache_duration" value="<?php echo get_option('hungryfeed_cache_duration',HUNGRYFEED_DEFAULT_CACHE_DURATION); ?>" /> (Enter 0 to disable caching)</td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Allow Feeds in Widgets</th>
        <td>
        <select name="hungryfeed_enable_widget_shortcodes">
        <option value="0">Use current WordPress setting (<?php echo get_option('hungryfeed_enable_widget_shortcodes',HUNGRYFEED_DEFAULT_ENABLE_WIDGET_SHORTCODES) ? 'Unknown' : (has_filter( 'widget_text', 'do_shortcode') ? 'Enabled' : 'Disabled') ?>)</option>
        <option value="1"
        <?php 
        	if (get_option('hungryfeed_enable_widget_shortcodes',HUNGRYFEED_DEFAULT_ENABLE_WIDGET_SHORTCODES))
        	{
        		echo " selected=\"selected\"";
        	}
        ?>
        >Enabled</option>
        </select><br/>
        <em>Caution: This setting will enable shortcodes in widgets for all plugins, not just HungryFEED.</em>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row">HungryFEED MCE Editor Button</th>
        <td>
        <select name="hungryfeed_enable_editor_button">
        <option value="0">Disabled</option>
        <option value="1"
        <?php 
        	if (get_option('hungryfeed_enable_editor_button',HUNGRYFEED_DEFAULT_ENABLE_EDITOR_BUTTON))
        	{
        		echo " selected=\"selected\"";
        	}
        ?>
        >Enabled</option>
        </select><br/>
        <em>This will display a HungryFEED button in the Post/Page editor if enabled.</em>
        </td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Custom CSS Code</th>
        <td><textarea name="hungryfeed_css" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_css',HUNGRYFEED_DEFAULT_CSS); ?></textarea></td>
        </tr>
        
        </table>
        
        <div class="hungryfeed_section_header">
        <h4 style="margin-top: 0px;">Custom Templates</h4>
        
        <p>Custom Templates can be used by specifying, for example template="1" in the shortcode.  Placeholder values
        available within the template are: {{id}}, {{index}}, {{category}}, {{permalink}}, {{title}}, {{description}}, 
        {{author}}, {{post_date}}, {{source_title}}, {{source_permalink}}, {{latitude}}, {{longitude}}, {{enclosure}}</p>
        
        <p>CSS selectors can be used on the description field using a 
        phpquery syntax for example:
        {{select(html).div:first}} or {{select(text).a:eq(2)}} or {{select(attr:src).img:first}}</p>
        
        <p>Raw feed data can be retrieved using the "data" variable for example:
        {{data['child']['http://itunes.apple.com/rss']['price']['0']['data']}}.  (Add the parameter show_data="1" in
        your shortcode to view the raw feed data array)</p>
        </div>
        
        <table class="form-table">

        <tr valign="top">
        <th scope="row">Custom Template 1</th>
        <td><textarea name="hungryfeed_html_1" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_html_1',HUNGRYFEED_DEFAULT_HTML); ?></textarea></td>
        </tr>

       <tr valign="top">
        <th scope="row">Custom Template 2</th>
        <td><textarea name="hungryfeed_html_2" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_html_2',HUNGRYFEED_DEFAULT_HTML); ?></textarea></td>
        </tr>

       <tr valign="top">
        <th scope="row">Custom Template 3</th>
        <td><textarea name="hungryfeed_html_3" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_html_3',HUNGRYFEED_DEFAULT_HTML); ?></textarea></td>
        </tr>

        </table>
        
        <div class="hungryfeed_section_header">
        
        <p>If an error is encountered, HungryFEED will output it to the browser.  You can adjust the design of
        this output so that user do not see an error.  The tag {{error}} will be replaced by the error details.</p>
        </div>
        
        <table class="form-table">
        
       <tr valign="top">
        <th scope="row">Error Message Template</th>
        <td><textarea name="hungryfeed_error_template" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_error_template',HUNGRYFEED_DEFAULT_ERROR_TEMPLATE); ?></textarea></td>
        </tr>

        <tr valign="top">
        <th scope="row">Info</th>
        <td>
        	<div>HungryFEED Version <?php echo HUNGRYFEED_VERSION; ?></div>
        	<div>SimplePie Version <?php echo defined('SIMPLEPIE_VERSION') ? SIMPLEPIE_VERSION : 'NOT FOUND' ; ?></div>
        	<div>HungryFEED designed and developed by <a href="http://verysimple.com/">Jason Hinkle</a></div>
        	<div>Scary monster logo designed by <a href="http://www.blog.spoongraphics.co.uk/">Chris Spooner</a></div>
        </td>
        </tr>

    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>

<?php 

}

?>