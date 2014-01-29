=== Twitter Bootstrap Slider ===
Contributors: bassjobsen
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SNYGRL7YNVYQW
Tags: image slider, slide show, captions, responsive, twitter's bootstrap, carousel
Requires at least: 3.6
Tested up to: 3.9
Stable tag: 1.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a responsive image slider to your pages based on Twitter's Bootstrap's Carousel component.


== Description ==

Add a image slider to your pages based on Twitter's Bootstrap's Carousel component. [Bootstrap](http:/www.getbootstrap.com/) is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. This responsive image slider is build with [Bootstrap's Carousel component](http://getbootstrap.com/javascript/#carousel). Bootstrap's javascripts plugins are jQuery based.


* Via a WordPress hook: `do_action('insert_bootstrapslider');`
* Via a ShortCode: `[bootstrapslider]`


Theme integration
-----------------

To use this plugin in your themes copy the files to for example `{wordpress}/wp-contents/themes/{yourtheme}/vendor/` and add according to this the code below to your `functions.php`:

	if( !function_exists( 'wts' ) ):
	function wts()
	{
	wp_deregister_style ( 'woocommerce-twitterbootstrap');	
	wp_dequeue_style( 'woocommerce-twitterbootstrap');
	wp_register_style ( 'woocommerce-twitterbootstrap', get_stylesheet_directory_uri() . '/vendor/woocommerce-twitterbootstrap/css/woocommerce-twitterboostrap.css', 'woocommerce' );
	wp_enqueue_style( 'woocommerce-twitterbootstrap');
	}
	endif;	
	add_action( 'wp_enqueue_scripts', 'wts', 200 ); 


	remove_action('admin_menu',array($twitterbootstrapslider,'add_menu'));
	add_action('admin_menu','twitter_bootstrap_slider_add_menu');
	/** * add a menu */ 
	function twitter_bootstrap_slider_add_menu() 
	{
		 global $twitterbootstrapslider;
		 add_theme_page('Twitter Bootstrap Slider', 'Twitter Bootstrap Slider', 'manage_options', 'twitter-bootstrap-slider', array($twitterbootstrapslider, 'twitter_bootstrap_slider_settings_page'));
		 
		 
	} // END public function add_menu()


Contribute!
-----------
If you have suggestions for a new feature or improvement, feel free to contact us on [Twitter](http://twitter.com/JamedoWebsites). Alternatively, you can fork the plugin from [Github](https://github.com/bassjobsen/twitter-bootstrap-slider).

== Installation ==

1. You can download and install Twitter Bootstrap Slider using the built in WordPress plugin installer. If you download Twitter Bootstrap Slider manually, make sure it is uploaded to "/wp-content/plugins/twitter-bootstrap-slider/".

2. Activate Twitter Bootstrap Slider in the "Plugins" admin panel using the "Activate" link. 

== Frequently Asked Questions ==


== Screenshots ==

1. Twitter Bootstrap Slider

== Changelog ==

= 1.0 =
* First version

== Requirements ==

* [Wordpress](http://wordpress.org/download/) tested with >= 3.6
* A Bootstrap ready WordPress Theme, try [JBST](https://github.com/bassjobsen/jamedo-bootstrap-start-theme/)

== Support ==

We are always happy to help you. If you have any question regarding this code. [Send us a message](http://www.jamedowebsites.nl/contact/) or contact us on twitter [@JamedoWebsites](http://twitter.com/JamedoWebsites).
