<?php
/**
* WP Eventbrite Embedded Checkout - Admin Functions
*
* In this file, 
* you will find all functions related to the plugin settings in WP-Admin area.
*
* @author 	Hendra Setiawan
* @version 	1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'wpeec_admin_menu' );


function wpeec_admin_menu() {
	add_menu_page(__('Eventbrite Form','wpeec'), __('Eventbrite Form','wpeec'), 'manage_options', 'eventbrite-embedded-checkout', 'wpeec_toplevel_page', 'dashicons-cart', 79 );
}

function wpeec_register_settings() {
    register_setting('wpeec-settings-group', 'wpeec-event-id');
    register_setting('wpeec-settings-group', 'wpeec-event-form-mode');
}
add_action('admin_init', 'wpeec_register_settings');

function wpeec_toplevel_page() {
	// Permission check
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	// SSL check
	if( !is_ssl() ):
		wp_die( __( 'To use Eventbrite Embedded Checkout, your website has to follow the latest security standards and must serve pages over HTTPS encryption. <a href="https://www.eventbrite.com/support/articleredirect?anum=41024" target="_blank">Learn more</a>' ) );	
	endif;
?>
<div class="wpwrap">
	<div class="card">
	<h1 style="margin-top: 25px;"><?php _e('WP Eventbrite Embedded Checkout Settings','wpeec'); ?></h1>
	<hr />
		<div class="form-wrap">
			<form method="post" action="options.php">
				<?php settings_fields('wpeec-settings-group'); ?>
				<?php do_settings_sections('wpeec-settings-group'); ?>
				<div class="form-field wpeec-event-id-wrap">
					<h3>Set The Event ID</h3>
					<label for="wpeec-event-id">Event ID</label>
					<input type="text" style="width: 100%;" value="<?php echo get_option('wpeec-event-id'); ?>" name="wpeec-event-id">
					<p>How to find your event ID? Please check this <a href="https://www.eventbrite.com/support/articles/en_US/How_To/how-to-find-the-event-id?lg=en_US" target="_blank">documentation</a>.</p>
				</div>
				<div class="form-field wpeec-form-mode-wrap">
					<h3>Choose How Checkout Appears</h3>
					<input type="radio" <?php if (get_option('wpeec-event-form-mode') == 'modal'): ?>checked="checked"<?php endif; ?> value="modal" id="wpeec-event-form-mode-modal" name="wpeec-event-form-mode">
                    <label for="wpeec-event-form-mode-modal" style="display: inline-block;"><?php _e('A button that opens the checkout modal over your content', 'wpeec') ?></label>
                    <br />
                    <input type="radio" <?php if (get_option('wpeec-event-form-mode') == 'embed' || get_option('wpeec-event-form-mode') == ''): ?>checked="checked"<?php endif; ?> value="embed" id="wpeec-event-form-mode-embed" name="wpeec-event-form-mode">
                    <label for="wpeec-event-form-mode-embed" style="display: inline-block;"><?php _e('Embedded on the page with your content', 'wpeec') ?></label>
				</div>
				<hr />
				<h3>Shortcode</h3>
				<?php
				$eid = get_option('wpeec-event-id');
				if($eid){
					echo '<p>Copy and paste this shortcode directly into any post or page.</p>';
					echo '<textarea style="width: 100%;" readonly="readonly">[wp-eventbrite-checkout]</textarea>';
				} else {
					echo '<p style="color: red;">Problem detected! Please set your Event ID.</p>';
				}
				?>
				<?php submit_button('Save Settings'); ?>
			</form>
			<hr />
			<p>WP Eventbrite Embedded Checkout. Made with <span class="dashicons dashicons-heart"></span> by <a href="https://hellohendra.com" target="_blank">Hendra Setiawan</a></p>
		</div>
	</div>
</div>
<?php 
}
