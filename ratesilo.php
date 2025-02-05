<?php 
/**
* Plugin Name: Ratesilo
* Plugin URI: https://ratesilo.com
* Description: This plugin allows you to add widgets to display your reviews from your Ratesilo business page.
* Version: 1.0.0
* Author: Shahul Hameed
* Author URI: http://hameid.net
*/

if ( ! defined( 'ABSPATH' ) ) exit;

class ratesilo_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'ratesilo_widget', 
			__('Ratesilo Widget', 'ratesilo'), 
			array( 'description' => __( 'Display your reviews from your Ratesilo business page', 'ratesilo' ), ) 
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$username = $instance['username'];
		$count = $instance['count'];
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		echo "<iframe src='https://ratesilo.com/api/widget/{$username}/inline/?count={$count}' style='border: 0px; width:100%' height='400' ></iframe>";
		//echo "<div data-ratesilo-widget-user='{$username}' data-ratesilo-widget-type='inline' data-count='{$count}'></div>";
		
		echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Ratesilo Widget', 'ratesilo' );
		}
		$username = isset($instance['username'])?$instance['username']:'';		
		$count = isset($instance['count'])?$instance['count']:0;		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
		return $instance;
	}
}

function ratesilo_load_widget() {
	register_widget( 'ratesilo_widget' );
}
add_action( 'widgets_init', 'ratesilo_load_widget' );

function ratesilo_load_scripts(){
    wp_register_script( 
        'ratesilo-script', 
        'https://ratesilo.com/widget-v2.js', 
        array( 'jquery' )
    );
    wp_enqueue_script( 'ratesilo-script' );
}
add_action('wp_enqueue_scripts', 'ratesilo_load_scripts');

function ratesilo_floating_widget_options() {
	include_once('content-options.php');
}

function ratesilo_plugin_options_menu_item() {
	add_menu_page("Ratesilo", "Ratesilo", "manage_options", "ratesilo-widget-options", "ratesilo_floating_widget_options", null, 99);
}
add_action("admin_menu", "ratesilo_plugin_options_menu_item");

function ratesilo_floating_widget_script_inject() {
	if(!get_option("ratesilo_floating_enable", 1)) {
		return;
	}
	$user = get_option("ratesilo_floating_user", "");
	$position = get_option("ratesilo_floating_position", "left");
	$height = get_option("ratesilo_floating_height", "400px");
	$width = get_option("ratesilo_floating_width", "300px");
	$count = get_option("ratesilo_floating_count", "0");
	$text = urlencode(get_option("ratesilo_floating_text", "Why People Like Us?"));
	$color = str_replace('#', '', get_option("ratesilo_floating_color", "#FFFFFF")); 
	$primary = str_replace('#', '', get_option("ratesilo_floating_background", "#1BA1E2"));
	echo "<iframe id='floatingwidget' src='https://ratesilo.com/api/widget/{$user}/floating/?count={$count}&primaryColor={$primary}&labelColor={$color}&label={$text}&height={$height}' width='{$width}' height='{$height}' style='border: 0px; position: fixed; bottom: 10px; {$position}: 10px; z-index: 10000;' ></iframe>";
}
add_action('wp_footer', 'ratesilo_floating_widget_script_inject');

function ratesilo_widget_shortcode_callback( $atts ) {
    $a = shortcode_atts( array(
        'username' => '',
        'count' => 0,
		'type' => 'inline',
		'columns' => '3',
		'width' => '300',
		'height' => '400',
    ), $atts );

	if(($a['type'] == 'grid') && ($a['width'] == 300)) {
		$a['width'] = '900';
	}
	
	return "<iframe src='https://ratesilo.com/api/widget/{$a['username']}/{$a['type']}/?count={$a['count']}&columns={$a['columns']}' style='border: 0px;' width='{$a['width']}' height='{$a['height']}' ></iframe>";
	//return "<div data-ratesilo-widget-user='{$a['username']}' data-ratesilo-widget-type='{$a['type']}' data-count='{$a['count']}' data-columns='{$a['columns']}'></div>";
}
add_shortcode( 'ratesilo', 'ratesilo_widget_shortcode_callback' );