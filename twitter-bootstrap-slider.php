<?php
/*
Plugin Name: Twitter Bootstrap Image Slider
Plugin URI: https://github.com/bassjobsen/twitter-bootstrap-slider
Description: Add a image slider to your pages based on Twitter's Bootstrap's Carousel component
Version: 1.0
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

include(sprintf("%s/templates/settings.php", dirname(__FILE__))); 

} 
// END public function plugin_settings_page() 

	



function init()
{

		$this->load_options();
		add_shortcode('bootstrapslider', array(&$this,'shortcode_show_bootstrapslider'));
		add_action('insert_bootstrapslider', array(&$this,'handle_hook_action'));
		wp_enqueue_script('bootstrapslider-script', plugin_dir_url( __FILE__ ) . 'js/bootstrapslider.js',array('jquery','bootstrap'));
		//see: http://pippinsplugins.com/use-wp_localize_script-it-is-awesome/
		wp_localize_script('bootstrapslider-script', 'bootstrapslider_script_vars', array(
			'interval' => ($this->opts['slider_automatically'])?$this->opts['slider_interval']:0,
			'pause' => ($this->opts['slider_pause'])?'hover':'none',
			'wrap' => ($this->opts['slider_wrap'])?'true':'false'
		)
		);
		$this->count = 0;
		$this->elements = array();
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
		if(!empty($image['caption']) ) $items[$i] .= '<div class="carousel-caption">'.$image['caption'].'</div>';
		
		$indicators[$i] = ''; 
		$indicators[$i]  .= '<li '.(($i==0)?'class="active"':'').' data-slide-to="'.$i.'" data-target="#bootstrapslider"></li>';
		$i++;
	}	
?>		
	
	<?php	
		ob_start();
	?>
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
		<?	
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
			<textarea rows="5" cols="100" type="text" class="url" name="images_caption[]" value="<?php echo $image['caption']; ?>" /><?php echo $image['caption']; ?></textarea></label></p>
		<p><label><span>Image Link URL</span>
			<input type="text" class="url" name="images_link[]" value="<?php echo $image['link']; ?>" /></label></p>

		</fieldset>
		<?php
}


} // END class 

}

if(class_exists('Twitter_Bootstrap_Slider')) 
{ // Installation and uninstallation hooks 
	register_activation_hook(__FILE__, array('Twitter_Bootstrap_Slider', 'activate')); 
	register_deactivation_hook(__FILE__, array('Twitter_Bootstrap_Slider', 'deactivate')); 
	
	$woocommercetrustpilot = new Twitter_Bootstrap_Slider();
	// Add a link to the settings page onto the plugin page 
	if(isset($woocommercetrustpilot))
	{
		
		 function twitter_bootstrap_slider_settings_link($links) 
		 { 
			 $settings_link = '<a href="options-general.php?page=twitter-bootstrap-slider">'.__('Settings','twitterbootstrapslider').'</a>';
			 array_unshift($links, $settings_link); 
			
			 return $links; 
		 } 	
		 $plugin = plugin_basename(__FILE__); 
		 	
		
		 add_filter("plugin_action_links_$plugin", 'twitter_bootstrap_slider_settings_link'); 
	}
	
}

