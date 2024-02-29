<?php 
 /**
  * 
  * @package    iDonate - blood donor management system WordPress Plugin
  * @version    1.0
  * @author     ThemeAtelier
  * @Websites: https://themeatelier.net/
  *
  */
  
// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}

/**************************************
*Creating About Widget
***************************************/
 
class idonate_blood_request_widget extends WP_Widget {


function __construct() {

parent::__construct(
// Base ID of your widget
'idonate_blood_request_widget', 


// Widget name will appear in UI
esc_html__( 'Blood Request Widget [Idonate]', 'idonate' ), 

// Widget description
array( 'description' => esc_html__( 'Add blood request widget.', 'idonate' ), ) 
);

}

// This is where the action happens
public function widget( $args, $instance ) {
$title 			= apply_filters( 'widget_title', $instance['title'] );
$requestnumber 	= apply_filters( 'widget_requestnumber', $instance['requestnumber'] );

// before and after widget arguments are defined by themes
echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $title ) )
echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );

    
?>
	<div class="blood-request-widget">
		<?php 
		$postargs = array(
			'post_type' => 'blood_request',
			'posts_per_page' => esc_html( $requestnumber )
		);
		
		$loop =  new WP_Query( $postargs );
		
		if( $loop->have_posts() ){
			echo '<ul>';
			while( $loop->have_posts() ){
				$loop->the_post();
				
				$title = get_the_title();
				$bloodgroup  = get_post_meta( get_the_ID(), 'idonatepatient_bloodgroup', true );
				$date 		 = get_post_meta( get_the_ID(), 'idonatepatient_bloodneed', true );
				
				//
				if( $title ){
					$title = '<span class="display-block"><strong>'.esc_html( $title ).'</strong></span>';
				}else{
					$title = '';
				}
				//
				if( $bloodgroup ){
					$bloodgroup = '<span class="display-block">'.esc_html__( 'Blood Group: ', 'idonate' ).esc_html( $bloodgroup ).'</span>';
				}else{
					$bloodgroup = '';
				}
				//
				if( $date ){
					$date = '<span class="display-block">'.esc_html__( 'Date: ', 'idonate' ).esc_html( $date ).'</span>';
				}else{
					$date = '';
				}
				//
				echo '<li>
				<a href="'.esc_url( get_the_permalink() ).'" target="_blank">'.wp_kses_post( $title.$bloodgroup.$date ).'</a>
				</li>';
				
			}
			echo '</ul>';
			
		}
		
		
		?>
		
	</div>
<?php

echo wp_kses_post( $args['after_widget'] );
}
		
// Widget Backend 
public function form( $instance ) {
	
if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
}else {
	$title = esc_html__( 'Blood Request', 'idonate' );
}

//	Button URL
if ( isset( $instance[ 'requestnumber' ] ) ) {
	$requestnumber = $instance[ 'requestnumber' ];
}else {
	$requestnumber = '5';
}


// Widget admin form
?>
<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:' ,'idonate'); ?></label> 
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo esc_attr( $this->get_field_id( 'requestnumber' ) ); ?>"><?php esc_html_e( 'Show  Blood Request Number:' ,'idonate'); ?></label> 
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'requestnumber' ) ); ?>" name="<?php echo $this->get_field_name( 'requestnumber' ); ?>" type="text" value="<?php echo esc_attr( $requestnumber ); ?>" />
</p>

<?php 
}

	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
	
	
$instance = array();
$instance['title'] 	  = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['requestnumber']  = ( ! empty( $new_instance['requestnumber'] ) ) ? strip_tags( $new_instance['requestnumber'] ) : '';

return $instance;
}
} // Class  ends here


// Register and load the widget
function idonate_blood_requestload_widget() {
	register_widget( 'idonate_blood_request_widget' );
}
add_action( 'widgets_init', 'idonate_blood_requestload_widget' );
	

?>