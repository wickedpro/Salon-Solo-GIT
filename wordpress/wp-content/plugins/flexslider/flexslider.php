<?php
/*
Plugin Name:	FlexSlider
Plugin URI:		http://www.fergusweb.net/software/flexslider/
Description:	Insert a large banner rotator - based on <a href="http://flex.madebymufffin.com/">FlexSlider</a> and jQuery.
Version:		1.0.1
Author:			Anthony Ferguson
Author URI:		http://www.fergusweb.net
*/



class FlexSlider {
	public	$plugin_url, $plugin_dir	= false;
	private	$opts, $images	= false;
	private	$option_key	= 'flexslide-opts';
	private	$image_key	= 'flexslide-img';
	public	$hook		= 'insert_flex_slider';		// Use: do_action(hook); to insert the slider
	public	$shortcode	= 'flexslider';				// Can also insert via shortcode
	
	/**
	 *	Constructor
	 */
	function FlexSlider() { $this->__construct(); }
	function __construct() {
		// Prepare
		$this->plugin_url	= plugin_dir_url(__FILE__);
		$this->plugin_dir	= trailingslashit(dirname(__FILE__));
		$this->possible_animations = array( 'fade', 'slide', 'show' );
		// Groundwork
		$this->load_options();
		$this->register_for_enqueue();
		// Launch
		if (!is_admin()) {
			add_action('init', array(&$this,'public_init'));
		} else {
			add_action('init', array(&$this,'admin_init'));
		}
	}
	
	/**
	 *	Register scripts and styles to be enqueued
	 */
	function register_for_enqueue() {
		wp_register_script('jquery-flexslider', $this->plugin_url.'js/jquery.flexslider-min.js', array('jquery'), '1.5', true);
		wp_register_style('flexslider', $this->plugin_url.'js/flexslider.css');
	}
	
	/**
	 *	Option Helpers
	 */
	function load_options() {
		$this->opts		= get_option($this->option_key);
		$this->images	= get_option($this->image_key);
		if (!$this->opts)	{	$this->load_default_options();	}
		if (!$this->images)	{	$this->load_default_images();	}
	}
	function save_options() {
		update_option($this->option_key, $this->opts);
		update_option($this->image_key, $this->images);
	}
	function load_default_options() {
		$this->opts = array(
			'width'		=> 800,
			'height'	=> 504,
			'animation'	=> 'fade',	// fade, slide, show
			'slideshow'	=> true,	// Play slideshow automatically?
			'speed'		=> 3000,
			'duration'	=> 500,
		);
	}
	function load_default_images() {
		$this->images = array(
			array(
				'image'		=> $this->plugin_url.'images/inacup_samoa.jpg',
				'caption'	=> 'Captions and cupcakes. Winning combination.',
				'link'		=> '',
			),
			array(
				'image'		=> $this->plugin_url.'images/inacup_pumpkin.jpg',
				'caption'	=> 'This image is wrapped in a link!',
				'link'		=> 'http://flex.madebymufffin.com',
			),
			array(
				'image'		=> $this->plugin_url.'images/inacup_donut.jpg',
				'caption'	=> '',
				'link'		=> '',
			),
			array(
				'image'		=> $this->plugin_url.'images/inacup_vanilla.jpg',
				'caption'	=> '',
				'link'		=> '',
			),
		);
	}
	

	
	
	
	/**
	 *	Public Functions
	 */
	function public_init() {
		add_shortcode($this->shortcode, array(&$this,'shortcode_show_flexslider'));
		add_action($this->hook, array(&$this,'handle_hook_action'));
		wp_enqueue_script('jquery-flexslider');
		wp_enqueue_style('flexslider');
		$this->count = 0;
		$this->elements = array();
	}
	
	/**
	 *	Call from a template via do_action()
	 */
	function handle_hook_action() {
		echo $this->shortcode_show_flexslider();
	}
	
	/**
	 *	Shortcode Handler
	 */
	function shortcode_show_flexslider($atts=false) {
		if ($this->count > 0)	return;	// Flex Slider does not yet support more than one instance.  Hopefully fix later.
		$flex_id = 'flexslider_'.$this->count;
		ob_start();
		?>
		<div class="flexslider" id="<?php echo $flex_id; ?>"><ul class="slides">
		<?php
		foreach ($this->images as $slide) {
			$img = '<img src="'.$slide['image'].'" width="'.$this->opts['width'].'" height="'.$this->opts['height'].'" />';
			if (!empty($slide['link']))		$img = '<a href="'.$slide['link'].'">'.$img.'</a>';
			if (!empty($slide['caption']))	$img = $img.'<p class="flex-caption">'.$slide['caption'].'</p>';
			echo '<li>'.$img.'</li>'."\n";
		}
		?>
		</ul></div><!-- flexslider -->
        <?php
		add_action('wp_print_footer_scripts', array(&$this,'footer_script'));
		$this->count++;
		$this->elements[] = $flex_id;
		return ob_get_clean();
	}
	
	/**
	 *	We'll output the JS to call FlexSlider at the bottom of the page.
	 *	Ideally would be a separate .js file - but we need the variable control.
	 */
	function footer_script() {
		?>
<script type="text/javascript"><!--
jQuery(document).ready(function($){
<?php
foreach ($this->elements as $flex_id) {
?>
	$("#<?php echo $flex_id; ?>").flexslider({
		'animation':	'<?php echo $this->opts['animation']; ?>',
		'slideshow':	<?php echo ($this->opts['slideshow']) ? 'true' : 'false'; ?>,
		'slideshowSpeed':	<?php echo $this->opts['speed']; ?>,
		'animationDuration':<?php echo $this->opts['duration']; ?> 
	});
<?php
}
?>
});
--></script>
		<?php
	}
	
	
	
	
	/**
	 *	Admin Functions
	 */
	function admin_init() {
		add_action('admin_menu', array(&$this,'admin_menu'));
	}
	
	function admin_menu() {
		$hooks[] = add_submenu_page('themes.php', 'Manage FlexSlider Settings', 'FlexSlider Settings', 'manage_options', $this->hook, array(&$this,'admin_page'));
	}
	
	/**
	 *	Admin Settings page
	 */
	function admin_page() {
		echo '<div class="wrap">'."\n";
		echo '<h2>FlexSlider Settings</h2>'."\n";
		
		// Save form
		if (isset($_POST['SaveFlexSlider'])) {
			if (!wp_verify_nonce($_POST['_wpnonce'], $this->option_key)) { echo '<p class="alert">Invalid Security</p></div>'."\n"; return;	}
			$this->opts = array_merge($this->opts, array(
				'width'		=> $_POST['flex_width'],
				'height'	=> $_POST['flex_height'],
				'animation'	=> $_POST['flex_animation'],
				'slideshow'	=> (($_POST['flex_automatically']=='1') ? true : false),
				'speed'		=> $_POST['flex_speed'],
				'duration'	=> $_POST['flex_duration'],
			));
			$this->images = array();
			foreach ($_POST['images_url'] as $key => $url) {
				if (empty($url))	continue;
				$this->images[] = array(
					'image'		=> $_POST['images_url'][$key],
					'caption'	=> $_POST['images_caption'][$key],
					'link'		=> $_POST['images_link'][$key],
				);
			}
			$this->save_options();
			echo '<div id="message" class="updated fade"><p><strong>Settings have been saved.</strong></p></div>';
		}
		
		// Show Forms
		?>
		<div class="metabox-holder">
		<form id="FeaturedBanners" method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
		<?php wp_nonce_field($this->option_key); ?>
        <div class="postbox" id="flexslider_settings">
        	<h3>Options</h3>
            <div class="inside">
            	<fieldset>
            	<p><label for="flex_width">Image width:</label>
                	<input type="text" class="px" id="flex_width" name="flex_width" value="<?php echo $this->opts['width']; ?>" /> px</p>
				<p><label for="flex_height">Image height:</label>
                	<input type="text" class="px" id="flex_height" name="flex_height" value="<?php echo $this->opts['height']; ?>" /> px</p>
				</fieldset>
                <fieldset>
            	<p><label for="flex_animation">Animation:</label>
                	<select id="flex_animation" name="flex_animation" class="txt"><?php
					foreach ($this->possible_animations as $possible) {
						echo '<option value="'.$possible.'" '.selected($possible,$this->opts['animation']).'> '.ucwords($possible).'</option>';
					}
					?></select></p>
				<p><label for="flex_speed">Slideshow Speed:</label>
                	<select id="flex_speed" name="flex_speed" class="ms"><?php
					for ($i=1; $i<=20; $i++) {
						$ms = $i*500;
						echo '<option value="'.$ms.'" '.selected($ms,$this->opts['speed']).'> '.number_format($ms/1000, 1).'</option>';
					}
					?></select> seconds</p>
				<p><label for="flex_duration">Animation Delay:</label>
                	<select id="flex_duration" name="flex_duration" class="ms"><?php
					for ($i=1; $i<=20; $i++) {
						$ms = $i*500;
						echo '<option value="'.$ms.'" '.selected($ms,$this->opts['delay']).'> '.number_format($ms/1000, 1).'</option>';
					}
					?></select> seconds</p>
				<p class="tick"><label><input type="checkbox" name="flex_automatically" value="1" <?php checked($this->opts['slideshow'], true);  ?>/>
                    Play slideshow automatically?</label></p>
				</fieldset>
                <p class="submit"><input type="submit" name="SaveFlexSlider" value="Save All Changes" class="button-primary" /></p>
            </div>
        </div><!-- postbox -->
        
        
        <div class="postbox" id="flexslider_images">
        	<h3><span id="add_flexslider">Add</span>Images</h3>
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

#flexslider_images #add_flexslider { float:right; background:url(<?php echo $this->plugin_url; ?>images/add.png); width:16px; height:16px; text-indent:-2999px; cursor:pointer; }

#flexslider_images p label { width:auto; float:none; padding:0; }
#flexslider_images p label span { width:20%; float:left; padding-top:0.3em; }
#flexslider_images p label input { }
--></style>

<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$('#add_flexslider').click(function(e) {
		$('#flexslider_images fieldset:last').clone().insertBefore('#flexslider_images .inside p.submit');
		$('#flexslider_images fieldset:last input').val('');
	});
});
--></script>

        <?php
		echo '</div><!-- wrap -->'."\n";
		//echo '<pre>'; print_r($this->opts); echo '</pre>';
		//echo '<pre>'; print_r($this->images); echo '</pre>';
	}
	
	
	function admin_image_row($image=false) {
		?>
		<fieldset>
		<p><label><span>Image Source</span>
			<input type="text" class="url" name="images_url[]" value="<?php echo $image['image']; ?>" /></label></p>
		<p><label><span>Image Caption</span>
			<input type="text" class="url" name="images_caption[]" value="<?php echo $image['caption']; ?>" /></label></p>
		<p><label><span>Link URL</span>
			<input type="text" class="url" name="images_link[]" value="<?php echo $image['link']; ?>" /></label></p>
		</fieldset>
		<?php
	}
		
}

// Launch Class
new FlexSlider();

?>