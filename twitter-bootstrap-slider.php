<?php
/*
Plugin Name: Twitter Bootstrap Image Slider
Plugin URI: https://github.com/bassjobsen/twitter-bootstrap-slider
Description: Add a image slider to your pages based on Twitter's Bootstrap's Carousel component
Version: 1.1.3
Author: Bass Jobsen
Author URI: http://bassjobsen.weblogs.fm/
License: GPLv2
*/

/*  Copyright 2013 Bass Jobsen (email : bass@w3masters.nl)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if(!class_exists('Twitter_Bootstrap_Slider')) 
{ 
	
class Twitter_Bootstrap_Slider 
{ 

	private	$opts, $images	= false;
	private	$option_key	= 'flexslide-opts';
	private	$image_key	= 'flexslide-img';	
	
/*
* Construct the plugin object 
*/ 
public function __construct() 
{ 
	load_plugin_textdomain( 'twitterbootstrapslider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
 	// register actions 
	add_action('admin_init', array(&$this, 'admin_init')); 
	add_action('admin_menu', array(&$this, 'add_menu')); 
	
	
	
	add_filter( 'init', array( $this, 'init' ) );

	
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", array($this,'twitter_bootstrap_slider_settings_link')); 

} 
// END public 

/** 
 * Activate the plugin 
**/ 
public static function activate() 
{ 
	// Do nothing 
} 
// END public static function activate 

/** 
 * Deactivate the plugin 
 * 
**/ 
public static function deactivate() 

{ // Do nothing 
} 
// END public static function deactivate 

/** 
 * hook into WP's admin_init action hook 
 * */ 
 
public function admin_init() 
{ 
	// Set up the settings for this plugin 
	
	$this->init_settings(); 
	// Possibly do additional admin_init tasks 
} 
// END public static function activate - See more at: http://www.yaconiello.com/blog/how-to-write-wordpress-plugin/#sthash.mhyfhl3r.JacOJxrL.dpuf

/** * Initialize some custom settings */ 
public function init_settings() 
{ 
	// register the settings for this plugin 
	//register_setting('woocommerce-trustpilot-group', 'trustpilotemail'); 
	//register_setting('woocommerce-trustpilot-group', 'sendwhen'); 
} // END public function init_custom_settings()


function load_options() {
		$this->opts		= get_option($this->option_key);
		$this->images	= get_option($this->image_key);
		if (!$this->opts)	{	$this->load_default_options();	}
		if (!$this->images)	{	$this->load_default_images();	}
	}
	function reset_options() {
		delete_option($this->option_key);
		delete_option($this->image_key);
		unset($this->opts,$this->images);
		$this->load_options();
	}
	
	function save_options() {
		update_option($this->option_key,$this->opts);
		update_option($this->image_key, $this->images);
		//$this->reset_options();
	}
	
	function load_default_options() {
		$this->opts = array(
				'slider_interval'	=> 2000,
				'slider_pause'	=> true,
				'slider_automatically'	=> true,
				'slider_wrap'	=> true
				);
				
	}
	
	function load_default_images() {
		$this->images = array(
			array(
				'image'		=>  plugins_url( 'images/slide1.gif' , __FILE__ ),
				'caption'	=> '<h2>Lorem ipsum dolor sit amet</h2>
								<p>Maecenas tempor, ante id lacinia varius, est ante fringilla eros, ac porttitor mi purus porttitor augue. In venenatis auctor purus sit amet venenatis. Maecenas quis lacinia metus. Morbi lobortis vehicula lorem nec suscipit. Morbi euismod, mi quis sollicitudin rhoncus, lorem libero dapibus </p>',
				'link'		=> 'http://www.getbootstrap.com/'
			),
			array(
				'image'		=> plugins_url( 'images/slide2.gif' , __FILE__ ), 
				'caption'	=> '<h2>Cras volutpat viverra viverra</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse placerat urna sit amet rhoncus malesuada. Fusce eget semper mauris. Praesent vitae elit id dui condimentum sollicitudin. Vivamus a lectus at justo ornare aliquam sit amet ac nulla. Quisque dapibus nisl quis orci malesuada, a tristique tellus suscipit. Cras tempus venenatis erat posuere iaculis. Sed vitae lorem eget enim euismod porttitor eu eu nulla. Nulla facilisi. Integer tincidunt leo urna, at congue urna ultricies sit amet. Duis in molestie metus, ac vestibulum ante. Duis tincidunt tortor et gravida vulputate. </p>',
				'link'		=> ''
			),
			array(
				'image'		=> plugins_url( 'images/slide3.gif' , __FILE__ ),
				'caption'	=> '<h2>Cras molestie, nunc vel molestie ullamcorper</h2>
									  <p>Tellus nulla consequat arcu, et tincidunt velit enim laoreet dolor. Pellentesque dignissim tempor sapien. Morbi mollis tristique ligula vel accumsan. Fusce sed sapien est. Ut suscipit blandit diam, non pulvinar sapien tempor nec. Pellentesque rhoncus euismod tincidunt. Phasellus ac odio metus.</p>',
				'link'		=> ''
			)
		);
	}

/** * add a menu */ 
public function add_menu() 
{
	 
	 add_options_page('Twitter Bootstrap Slider', 'Twitter Bootstrap Slider', 'manage_options', 'twitter-bootstrap-slider', array(&$this, 'twitter_bootstrap_slider_settings_page'));
} // END public function add_menu() 

/** * Menu Callback */ 
public function twitter_bootstrap_slider_settings_page() 
{ 
	if(!current_user_can('manage_options')) 
	{ 
		wp_die(__('You do not have sufficient permissions to access this page.')); 
	
	} 
// Render the settings template 

//include(sprintf("%s/templates/settings.php", dirname(__FILE__))); 

$this->showform();


} 
// END public function plugin_settings_page() 

	
function showform()
{

		// Save form
		if (isset($_POST['SaveFlexSlider'])) {
			if (!wp_verify_nonce($_POST['_wpnonce'], $this->option_key)) { echo '<p class="alert">Invalid Security</p></div>'."\n"; return;	}
			$this->opts = array_merge($this->opts, array(
				'slider_interval'	=> isset($_POST['slider_interval'])?$_POST['slider_interval']:0,
				'slider_pause'	=> ((isset($_POST['slider_pause']) && $_POST['slider_pause']=='1') ? true : false),
				'slider_wrap'	=> ((isset($_POST['slider_wrap']) && ($_POST['slider_wrap']=='1')) ? true : false)
			));
			$this->images = array();
			foreach ($_POST['images_url'] as $key => $url) {
				if (empty($url))	continue;
				$this->images[] = array(
					'image'		=> $_POST['images_url'][$key],
					'caption'	=> $_POST['images_caption'][$key],
					'link'		=> $_POST['images_link'][$key]
				);
			}
			$this->save_options();
			echo '<div id="message" class="updated fade"><p><strong>Settings have been saved.</strong></p></div>';
		}

echo '<div class="wrap">'."\n";
?><h2>Twitter Bootstrap Slider <?php echo __('Settings','twitterbootstrapslider');?></h2><?php 
		
		
		// Show Forms
		?>
		<div class="metabox-holder">
		<form id="FeaturedBanners" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
		<?php wp_nonce_field($this->option_key); ?>
        <div class="postbox" id="flexslider_settings">
        	<h3>Options</h3>
            <div class="inside">
                <fieldset>
				<p><label for="slider_interval"><?php echo __('Interval','twitterbootstrapslider');?>:</label>
                	<select id="slider_interval" name="slider_interval" class="ms"><?php
					for ($i=0; $i<=20; $i++) {
						$ms = $i*500;
						echo '<option value="'.$ms.'" '.selected($ms,$this->opts['slider_interval']).'> '.number_format($ms/1000, 1).'</option>';
					}
					?></select> seconds</p>
			   <p><?php echo __('The amount of time to delay between automatically cycling an item. If 0, carousel will not automatically cycle.','twitterbootstrapslider');?></p>	
			    <p class="tick"><label><input type="checkbox" name="slider_wrap" value="1" <?php checked($this->opts['slider_wrap'], true);  ?>/>
                    <?php echo __('Whether the carousel should cycle continuously or have hard stops.','twitterbootstrapslider');?></label></p>	
		
			   <p class="tick"><label><input type="checkbox" name="slider_pause" value="1" <?php checked($this->opts['slider_pause'], true);  ?>/>
                    <?php echo __('Pause the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave?','twitterbootstrapslider');?></label></p>	

                <p class="submit"><input type="submit" name="SaveFlexSlider" value="Save All Changes" class="button-primary" /></p>
            </div>
        </div><!-- postbox -->
        
        
        <div class="postbox" id="flexslider_images">
        	<h3><?php echo __('Images','twitterbootstrapslider');?> <span><a href="" id="add_flexslider" class="button-primary">><?php echo __('Add new image','twitterbootstrapslider');?></a></span></h3>
            <div class="inside">
			<?php
			$this->count = 0;
			foreach ($this->images as $image) {
				$this->admin_image_row($image);
			} // foreach $images
			?>
                <p class="submit"><input type="submit" name="SaveFlexSlider" value="Save All Changes" class="button-primary" /></p>
            </div>
		</div>
        
        </form>
        </div><!-- metabox holder -->

<style><!--
.postbox { }
.postbox h3 { cursor:default; }
.postbox fieldset { margin:0.8em 0; }
.postbox p { margin:0.3em 0; clear:both; border-bottom:1px solid #FFF; padding-bottom:0.3em; }
.postbox p label { display:block; width:20%; float:left; padding-top:0.3em; }
.postbox p input { width:70%; }
.postbox p input.px { width:6em; }
.postbox p.tick label { width:auto; float:none; }
.postbox p.tick label input { margin:0 0.5em 0 18%; width:auto; }
.postbox p.submit input { width:auto; margin-left:20%; }

#flexslider_images #add_flexslider { float:right; }

#flexslider_images p label { width:auto; float:none; padding:0; }
#flexslider_images p label span { width:20%; float:left; padding-top:0.3em; }
#flexslider_images p label input { }
--></style>

<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$('#add_flexslider').click(function(e) {
		e.preventDefault();
		$('#flexslider_images fieldset:last').clone().insertBefore('#flexslider_images .inside p.submit');
		$('#flexslider_images fieldset:last input').val('');
	});
});
--></script>

        <?php
		echo '</div><!-- wrap -->'."\n";
}	


function init()
{

		$this->load_options();
		add_shortcode('bootstrapslider', array(&$this,'shortcode_show_bootstrapslider'));
		add_action('insert_bootstrapslider', array(&$this,'handle_hook_action'));
		wp_enqueue_script('bootstrapslider-script', plugin_dir_url( __FILE__ ) . 'js/bootstrapslider.js',array('jquery','bootstrap'));
		//see: http://pippinsplugins.com/use-wp_localize_script-it-is-awesome/
	    add_action( 'wp_enqueue_scripts', array(&$this,'tbs_localize_script'), 300 );   
		
		$this->count = 0;
		$this->elements = array();
}
function tbs_localize_script()
{
	    wp_localize_script('bootstrapslider-script', 'bootstrapslider_script_vars', array(
			'interval' => ($this->opts['slider_interval'])?$this->opts['slider_interval']:false,
			'pause' => ($this->opts['slider_pause'])?'hover':'none',
			'wrap' => ($this->opts['slider_wrap'])?true:false
		));
}


	/**
	 *	Call from a template via do_action()
	 */
	function handle_hook_action() {
		echo $this->shortcode_show_bootstrapslider();
	}

function shortcode_show_bootstrapslider()
{

	$i=0;
	$items=array();
	$indicators=array();
	foreach($this->images as $image)
	{
		$items[$i] = '';
		if(!empty($image['link']) && $image['link']!=='#') $items[$i] .= '<a href="'.$image['link'].'">';
		$items[$i] .= '<img src="'.$image['image'].'">';
		if(!empty($image['link']) && $image['link']!=='#') $items[$i] .= '</a>';
		if(!empty($image['caption']) ) $items[$i] .= '<div class="carousel-caption">'.stripslashes($image['caption']).'</div>';
		
		$indicators[$i] = ''; 
		$indicators[$i]  .= '<li '.(($i==0)?'class="active"':'').' data-slide-to="'.$i.'" data-target="#bootstrapslider"></li>';
		$i++;
	}	
?>		
	
	<?php	
		ob_start();
	?>
	<div class="clearfix"></div>
	<div data-ride="carousel" class="carousel slide" id="bootstrapslider">
		  <ol class="carousel-indicators">
          <?php
          foreach($indicators as $indicator)
          {
			  echo $indicator;
		  } 	  
          ?>
        </ol>
        <div class="carousel-inner">

		<?php	

		  $k=0;
		  foreach($items as $item)
          {
			  ?><div class="item<?php echo ($k==0?' active':''); ?>"><?php
			  echo $item;
			  ?></div><?php
			  $k++;
		  } 
		?>
		</div>	 
		<a data-slide="prev" href="#bootstrapslider" class="left carousel-control">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a data-slide="next" href="#bootstrapslider" class="right carousel-control">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
		
	</div>
	<?php
	
	
	
	ob_end_flush();
}		

function admin_image_row($image=false) 
{
		?>
		<fieldset>
		<hr>
		<p><label><span>Image Source</span>
			<input type="text" class="url" name="images_url[]" value="<?php echo $image['image']; ?>" /></label></p>
		<p><label><span>Image Caption</span>
			<textarea rows="5" cols="100" type="text" class="url" name="images_caption[]" /><?php echo stripslashes($image['caption']); ?></textarea></label></p>
		<p><label><span>Image Link URL</span>
			<input type="text" class="url" name="images_link[]" value="<?php echo $image['link']; ?>" /></label></p>

		</fieldset>
		<?php
}


		 function twitter_bootstrap_slider_settings_link($links) 
		 { 
			 $settings_link = '<a href="options-general.php?page=twitter-bootstrap-slider">'.__('Settings','twitterbootstrapslider').'</a>';
			 array_unshift($links, $settings_link); 
			
			 return $links; 
		 } 	


} // END class 

}

if(class_exists('Twitter_Bootstrap_Slider')) 
{ // Installation and uninstallation hooks 
	register_activation_hook(__FILE__, array('Twitter_Bootstrap_Slider', 'activate')); 
	register_deactivation_hook(__FILE__, array('Twitter_Bootstrap_Slider', 'deactivate')); 

	new Twitter_Bootstrap_Slider();
}
