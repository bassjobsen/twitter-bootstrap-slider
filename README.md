Twitter Bootstrap Slider
==============================================
Add a responsive image slider to your pages based on Twitter's Bootstrap's Carousel component. [Bootstrap](http:/www.getbootstrap.com/) is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. This responsive image slider is build with [Bootstrap's Carousel component](http://getbootstrap.com/javascript/#carousel). Bootstrap's javascripts plugins are jQuery based.

The slider can be inserted in two ways:

* Via a WordPress hook: `do_action('insert_bootstrapslider');`
* Via a ShortCode: `[bootstrapslider]`


Installation
------------

[Download the latest version as .zip file](https://github.com/bassjobsen/twitter-bootstrap-slider/archive/master.zip). Upload the .zip file to your Wordpress plugin directory (wp-content/plugin) and use the activate function in your dashboard.
( Plugins > installed plugins ). Add your images via Settings (settings menu).

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


Requirements
---------
* [Wordpress](http://wordpress.org/download/) tested with >= 3.6
* A Bootstrap ready WordPress Theme, try [JBST](https://github.com/bassjobsen/jamedo-bootstrap-start-theme/)

Support
-------

We are always happy to help you. If you have any question regarding this code. [Send us a message](http://www.jamedowebsites.nl/contact/) or contact us on twitter [@JamedoWebsites](http://twitter.com/JamedoWebsites).

Changelog
---------

1.1

* Theme integration

1.0

* First version
