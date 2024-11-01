<?php
/*
Plugin Name: WP Talkshoe Archives
Plugin URI: http://www.nmpnetwork.com/wordpress-plugins/wp-tsarchives
Description: Displays the audio archive of a specified Talkshoe Show.
Author: Dr. Robert White
Author URI: http://www.nmpnetwork.com
Version: 1.1
*/
/*  Copyright 2010-2011  Dr. Robert White  (email : graitesites@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Define and Load RSS Feed
$options = (array) get_option('widget_wta');
$wtashowid = $options['wtashowid'];
$feedurl = "http://recordings.talkshoe.com/rss".$wtashowid.".xml";
define("WTA_FEED_URL", $feedurl);

// This gets called at the plugins_loaded action
function widget_wta_init() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_wta_control() {
		$options = $newoptions = get_option('widget_wta');
		if ( $_POST['wta-submit'] ) {
		    $newoptions['wtashowname'] = $_POST['wta-showname'];
			$newoptions['wtashowid'] = $_POST['wta-showid'];
			$newoptions['shownumberitems'] = $_POST['wta-show-numberitems'];
			$newoptions['showdate'] = isset($_POST['wta-show-date']);
			$newoptions['wtablubrry'] = $_POST['wta-blubrry'];
			
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_wta', $options);
		}
		$wtashowdate = $options['showdate'] ? 'checked="checked"' : '';
		
	?>
				<div style="text-align:right">
				<label for="wta-showname" style="line-height:35px;display:block;">Name of the Talkshoe Show: 
				<input type="text" name="wta-showname" value="<?php echo $options['wtashowname']; ?>" />
				</label>
				<label for="wta-showid" style="line-height:35px;display:block;">Call ID of the Talkshoe Show: 
				<input type="text" name="wta-showid" value="<?php echo $options['wtashowid']; ?>" />
				</label>
				<label for="wta-blubrry" style="line-height:35px;display:block;">Enter your Blubrry Tracking Code (optional): 
				<input type="text" name="wta-blubrry" value="<?php echo $options['wtablubrry']; ?>" />
				</label>
				<label for="wta-show-numberitems" style="line-height:35px;display:block;">Number of MP3 Links to show: 
						<select id="wta-show-numberitems" name="wta-show-numberitems">
								 <option value="5" <?php selected('5',$options['shownumberitems']); ?>>5</option>
								 <option value="10" <?php selected('10',$options['shownumberitems']); ?>>10</option>
								 <option value="15" <?php selected('15',$options['shownumberitems']); ?>>15</option>
								 <option value="20" <?php selected('20',$options['shownumberitems']); ?>>20</option>
						</select>
				</label>
				<label for="wta-show-date">Show Archived Show Date ? <input class="checkbox" type="checkbox" <?php echo $wtashowdate; ?> id="wta-show-date" name="wta-show-date" /></label><br/>
				<input type="hidden" name="wta-submit" id="wta-submit" value="1" />
				</div>
	<?php
	}

	// This prints the widget
	function widget_wpta() {
//		extract($args);
		$options = (array) get_option('widget_wta');
    $linktarget = ' target="_blank"'; 
    $wtashowname = $options['wtashowname'];	
	$wtablubrry = $options['wtablubrry'];
	$title = $wtashowname;

?>
    <?php echo $before_widget; ?>
    <?php echo $before_title . $title . $after_title; ?>
    <div id="wta-box" style="margin:0;padding:0;border:none;">
<?php
// Remove the remark // on line 96 if Simplepie is not already installed.
//            require_once('simplepie.inc');
            $feed = new SimplePie();
            $feed->set_feed_url(WTA_FEED_URL);
            $feed->enable_cache(false);
            $feed->init();
            $feed->handle_content_type();
          
?>
         
        <strong>Audio Archives</strong>
        <ul style="list-style-type:none">
<?php
        
		foreach ($feed->get_items(0, $options['shownumberitems']) as $item) {
        
                    $title = $item->get_title();
                    $link = $item->get_permalink();
                    $pubDate = $item->get_date('F jS o');
                    

		// Add BluBrry Tracking Code if available to MP3 Links
			
			if ($wtablubrry == ""){
			$link = $link;
			
			}else{
			$link = substr_replace($link, $wtablubrry, 0, 7);
			
			}
					
?>
        <li>
        <table border="0">
        <tr>
        <td style="vertical-align:middle"><img src="<?php echo $feed->get_image_url(); ?>" width="25" height="25"></td>
        <td>
        <a href="<?php echo $link; ?>"  title="<?php echo $title; ?>"<?php echo $linktarget; ?>><?php echo $title; ?></a>
<?php

                if ($options['showdate']) { 

?>
            <br /><small><?php echo $pubDate; ?></small>

<?php
            }
?>            
            </td>
            </tr>
            </table>
            </li>            
<?php

                
            }
?>
        <li><a href="http://www.talkshoe.com/tc/<?php echo $wtashowid = $options['wtashowid']; ?>"<?php echo $linktarget; ?>>More...</a></li>
        </ul></p>
        </div>
		<?php echo $after_widget; ?>
<?php

	}
//WordPress Hooks    
 add_shortcode('wpta', 'widget_wpta'); 
 
    
	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget('WP Talkshoe Archives', 'widget_wpta');
	register_widget_control('WP Talkshoe Archives', 'widget_wta_control', 300, 220);
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('plugins_loaded', 'widget_wta_init');

?>
