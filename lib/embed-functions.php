<?php
/**
* WP Eventbrite Embedded Checkout - Embed Functions
*
* In this file, 
* you will find all functions to embed the Eventbrite Checkout form to your WordPress site.
*
* @author 	Hendra Setiawan
* @version 	1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wpeec_shortcode_functions(){
	// Get the plugin option values
	$eventID = get_option('wpeec-event-id');
	$eventMode = get_option('wpeec-event-form-mode');

	if(empty($eventID)) {
		return 'Error! Please specify the event ID.';
    } else {	
		if( ( empty($eventMode) ) || ( $eventMode == 'embed' ) ) {
			return '<div id="eventbrite-widget-container-' . $eventID . '"></div>';
		} else {
			return '<button id="eventbrite-widget-modal-trigger-' . $eventID . '" type="button">Buy Tickets</button>';
		}
	}
}
add_shortcode('wp-eventbrite-checkout', 'wpeec_shortcode_functions');

function wpeec_external_js(){
	global $post;
	if(has_shortcode($post->post_content, 'wp-eventbrite-checkout')):
		wp_enqueue_script( 'wpeec_eb_widgets', 'https://www.eventbrite.com/static/widgets/eb_widgets.js', true );
	endif;	
}
add_action( 'wp_enqueue_scripts', 'wpeec_external_js' );

function wpeec_js_code(){
	global $post;
	// Get the plugin option values
	$eventID = get_option('wpeec-event-id');
	$eventMode = get_option('wpeec-event-form-mode');

	if( (has_shortcode($post->post_content, 'wp-eventbrite-checkout')) && ( $eventID ) ):

	if( ( empty($eventMode) ) || ( $eventMode == 'embed' ) ) {
	?>

		<script type="text/javascript">
		    var OrderCompleteLog = function() {
		        console.log('Order complete!');
		    };

		    window.EBWidgets.createWidget({
		        // Required
		        widgetType: 'checkout',
		        eventId: '<?php echo $eventID; ?>',
		        iframeContainerId: 'eventbrite-widget-container-<?php echo $eventID; ?>',

		        // Optional
		        iframeContainerHeight: 425,  // Widget height in pixels. Defaults to a minimum of 425px if not provided
		        onOrderComplete: OrderCompleteLog  // Method called when an order has successfully completed
		    });
		</script>

	<?php } else { ?>
		
		<script type="text/javascript">
		    var OrderCompleteLog = function() {
		        console.log('Order complete!');
		    };

		    window.EBWidgets.createWidget({
		        widgetType: 'checkout',
		        eventId: '<?php echo $eventID; ?>',
		        modal: true,
		        modalTriggerElementId: 'eventbrite-widget-modal-trigger-<?php echo $eventID; ?>',
		        onOrderComplete: OrderCompleteLog
		    });
		</script>

<?php
	} // end of IF event Mode
	endif; // end of IF has shortcode
}
add_action('wp_footer','wpeec_js_code', 100);
