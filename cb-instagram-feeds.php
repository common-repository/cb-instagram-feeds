<?php
/*
Plugin Name: Instagram Feeds
Plugin URI: https://profiles.wordpress.org/cynob
Description: This plugin helps to display feeds Instagram feeds on your site.
Author: cynob
Contributors: cynob
Version: 1.0.0
Author URI: http://cynob.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define('CBIF_DIR', plugin_dir_path(__FILE__));
define('CBIF_URL', plugin_dir_url(__FILE__));
define('CBIF_PAGE_DIR', plugin_dir_path(__FILE__).'pages/');
define('CBIF_INCLUDE_URL', plugin_dir_url(__FILE__).'includes/');

//Include menu and assign page
function cbif_plugin_menu() {
    $icon = CBIF_URL. 'includes/icon.png';
	add_menu_page("Instagram Feeds", "Instagram Feeds", "administrator", "cb-instagram-feed-setting", "cbif_plugin_pages", $icon ,30);
	add_submenu_page("cb-instagram-feed-setting", "About Us", "About Us", "administrator", "cbif-about-us", "cbif_plugin_pages");
}
add_action("admin_menu", "cbif_plugin_menu");

function cbif_plugin_pages() {
   $pageitem = esc_url(CBIF_PAGE_DIR.$_GET["page"].'.php');
   include($pageitem);
}

//Include frontend css 
function cbif_js_css_add_init() {
    wp_register_style("inst_front_css", plugins_url('includes/cbif-front-style.css',__FILE__ )); 
	wp_enqueue_style('inst_front_css');
}
add_action( 'wp_enqueue_scripts', 'cbif_js_css_add_init' );

// Include admin css
function cbif_admin_css() {
  wp_register_style('inst_admin_css', plugins_url('includes/cbif-admin-style.css',__FILE__ ));
  wp_enqueue_style('inst_admin_css');
}
add_action( 'admin_init','cbif_admin_css' );

// Error message
function cbif_err_msg($code) {
	$cbif_err = esc_html('Invalid Access Token!');
	if($code == 400) {
		throw new Exception($cbif_err);
	}
	return true;
}

// Generate Shortcode - list view
add_shortcode( 'instagram-feeds-list', 'cbif_shortcode_function_list_view' );
function cbif_shortcode_function_list_view( $atts ) {
	$inst_user_id = get_option('cynob_instagram_user_id');
	$inst_access_token = get_option('cynob_instagram_access_token');
	$photo_count = get_option('cynob_instagram_photo_count');
	
	$inst_url="https://api.instagram.com/v1/users/{$inst_user_id}/media/recent/?";
	$inst_url.="access_token={$inst_access_token}&count={$photo_count}";
	
	$response = wp_remote_get( esc_url($inst_url) );
	$inst_response = json_decode($response['body'], true, 512, JSON_BIGINT_AS_STRING);
	$msgCode = $inst_response['meta']['code'];
	$flag=1;
	
	//trigger exception in a "try" block
	try {
		cbif_err_msg($msgCode);
		if(!empty($inst_response)){
	?>
	<div class="main-instagram-feeds-div">
		<h1><?php echo esc_html( 'Instagram Feeds' ); ?></h1>
		<ul id="list_instagram_feed" class="instagram-feed-list-view">
			<?php
				foreach ($inst_response['data'] as $single_feed) {
				$pic_text = $single_feed['caption']['text'];
				$pic_link = $single_feed['link'];
				$pic_src = str_replace("http://", "https://", $single_feed['images']['standard_resolution']['url']);
			?>
			<li  id="insta-pic-<?php echo $flag; ?><?php echo ($flag%4); ?>">
				<div class="instagram_single_box">
					<div class="inst-img_box">
						<a target="_blank" href="<?php echo esc_url( $pic_link ); ?>">
							<img title='<?php echo esc_html( $pic_text ); ?>' src='<?php echo esc_url( $pic_src ); ?>' />
						</a>
					</div>
					<div class="content"> 
						<div class="contant_box1"><?php echo esc_html( $pic_text ); ?></div>
					</div>
				</div>
			</li>
			<?php
				$flag++;
			}
			?>
		</ul>
		<div style="clear:both;"></div>
	</div>
<?php
	}
	else {
		$nofeed = esc_html('No Feed Found!');
		echo '<div class="nopost"><h3>'.$nofeed.'</h3></div>';
	}
}
	//catch exception
	catch(Exception $e) {
		echo '<div class="err-msg"><span class="msg-details">' .$e->getMessage(). '</span></div>';
	}
}

//Cynob Shortcode grid view
add_shortcode( 'instagram-feeds-grid', 'cbif_shortcode_function_grid_view' );
function cbif_shortcode_function_grid_view( $atts ) {
	$inst_user_id = get_option('cynob_instagram_user_id');
	$inst_access_token = get_option('cynob_instagram_access_token');
	$photo_count = get_option('cynob_instagram_photo_count');
	
	$inst_url="https://api.instagram.com/v1/users/{$inst_user_id}/media/recent/?";
	$inst_url.="access_token={$inst_access_token}&count={$photo_count}";
	
	$response = wp_remote_get( esc_url($inst_url) );
	$inst_response = json_decode($response['body'], true, 512, JSON_BIGINT_AS_STRING);
	$msgCode = $inst_response['meta']['code'];
	$flag=1;
	
	//trigger exception in a "try" block
	try {
		cbif_err_msg($msgCode);
		if(!empty($inst_response)){
		?>
		<div class="main-instagram-feeds-div">
			<h1><?php echo esc_html( 'Instagram Feeds' ); ?></h1>
			<ul id="grid_instagram_feed" class="instagram-feed-grid-view">
				<?php
					foreach ($inst_response['data'] as $single_feed) {
					$pic_text = $single_feed['caption']['text'];
					$pic_link = $single_feed['link'];
					$pic_src = str_replace("http://", "https://", $single_feed['images']['standard_resolution']['url']);
				?>
				<li  id="insta-pic-<?php echo $flag; ?><?php echo ($flag%4); ?>">
					<div class="instagram_single_box">
						<div class="inst-img_box">
							<a target="_blank" href="<?php echo esc_url( $pic_link ); ?>">
								<img title='<?php echo esc_html( $pic_text ); ?>' src='<?php echo esc_url( $pic_src ); ?>' />
							</a>
						</div>
						<div class="inst-content"> 
							<div class="inst-title"><?php echo esc_html( $pic_text ); ?></div>
						</div>
					</div>
				</li>
				<?php
					$flag++;
				}
				?>
			</ul>
		</div>
		<div style="clear:both;"></div>
		<?php
		}
		else {
			$nofeed = esc_html('No Feed Found!');
			echo '<div class="nopost"><h3>'.$nofeed.'</h3></div>';
		}
	}
	//catch exception
	catch(Exception $e) {
	  echo '<div class="err-msg"><span class="msg-details">' .$e->getMessage().'</span></div>';
	}
}