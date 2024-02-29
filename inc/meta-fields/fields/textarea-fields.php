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




function tatCmf_textarea_field( $args = array() ){
	
	$default = array(
		'type' 		=> 'textarea',
		'class' 	=> '',
		'id' 		=> '',
		'label' 	=> 'Field Label',
	);
	
	
	$args = wp_parse_args( $args, $default );
	
	$val = get_post_meta( get_the_ID(), $args['id'] , true );
	
	echo '<div class="field-row">';
	
		echo '<div class="field-col">';
			echo '<label>'.esc_html( $args['label'] ).'</label>';
		echo '</div>';
		
		echo '<div class="field-col">';
			echo '<textarea  name="'.esc_attr( $args['id'] ).'" rows="10" cols="50" id="'.esc_attr( $args['id'] ).'" class="tatCmf-'.esc_attr( $args['type'] ).'-field '.esc_attr( $args['class'] ).'" >'.wp_kses_post( $val ).'</textarea>';
		echo '</div>';
	
	echo '</div>';
}


?>