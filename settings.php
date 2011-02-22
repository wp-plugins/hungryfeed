<?php
/** 
 * ################################################################################
 * ADMIN/SETTINGS UI
 * ################################################################################
 */

function hungryfeed_create_menu() {

	//create new top-level menu
	add_options_page('HungryFEED Plugin Settings', 'HungryFEED', 'administrator', __FILE__, 'hungryfeed_settings_page');

	//call register settings function
	add_action( 'admin_init', 'hungryfeed_register_settings' );
}

function hungryfeed_register_settings() {
	//register our settings
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_cache_duration' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_css' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_enable_widget_shortcodes' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_1' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_2' );
	register_setting( 'hungryfeed-settings-group', 'hungryfeed_html_3' );
}

function hungryfeed_settings_page() {
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
				
				<h4>Usage Example</h4>
				
				<p style="font-family: courier">[hungryfeed url="http://verysimple.com/feed/"]</p>
				
				<h4 style="color: navy;">Support HungryFEED Development and a Great Cause</h4>
				
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
        <th scope="row">CSS Code</th>
        <td><textarea name="hungryfeed_css" cols="25" rows="5" style="width: 400px; height: 160px;"><?php echo get_option('hungryfeed_css',HUNGRYFEED_DEFAULT_CSS); ?></textarea></td>
        </tr>

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