<?
		// Save form
		if (isset($_POST['SaveFlexSlider'])) {
			if (!wp_verify_nonce($_POST['_wpnonce'], $this->option_key)) { echo '<p class="alert">Invalid Security</p></div>'."\n"; return;	}
			$this->opts = array_merge($this->opts, array(
				'slider_interval'	=> isset($_POST['slider_interval'])?$_POST['slider_interval']:0,
				'slider_pause'	=> ((isset($_POST['slider_pause']) && $_POST['slider_pause']=='1') ? true : false),
				'slider_automatically'	=> (($_POST['slider_automatically']=='1') ? true : false),
				'slider_wrap'	=> (($_POST['slider_wrap']=='1') ? true : false)
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
?>

<?php
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
					for ($i=1; $i<=20; $i++) {
						$ms = $i*500;
						echo '<option value="'.$ms.'" '.selected($ms,$this->opts['slider_interval']).'> '.number_format($ms/1000, 1).'</option>';
					}
					?></select> seconds</p>
			   <p><?php echo __('The amount of time to delay between automatically cycling an item. If 0, carousel will not automatically cycle.','twitterbootstrapslider');?></p>	
			    <p class="tick"><label><input type="checkbox" name="slider_wrap" value="1" <?php checked($this->opts['slider_wrap'], true);  ?>/>
                    <?php echo __('Whether the carousel should cycle continuously or have hard stops.','twitterbootstrapslider');?></label></p>	
		
			   <p class="tick"><label><input type="checkbox" name="slider_pause" value="1" <?php checked($this->opts['slider_pause'], true);  ?>/>
                    <?php echo __('Pause the cycling of the carousel on mouseenter and resumes the cycling of the carousel on mouseleave?','twitterbootstrapslider');?></label></p>	
				<p class="tick"><label><input type="checkbox" name="slider_automatically" value="1" <?php checked($this->opts['slider_automatically'], true);  ?>/>
                    <?php echo __('Play slideshow automatically?','twitterbootstrapslider');?></label></p>
				</fieldset>
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
		//echo '<pre>'; print_r($this->opts); echo '</pre>';
		//echo '<pre>'; print_r($this->images); echo '</pre>';
