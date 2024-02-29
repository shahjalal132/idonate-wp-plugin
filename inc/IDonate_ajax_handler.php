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
if( !class_exists( 'IDonate_ajax_handler' ) ){
	class IDonate_ajax_handler{
		
		function __construct(){
		
			add_action( 'wp_ajax_admin_donor_profile_view', array( $this, 'admin_donor_profile_view' ) );
			add_action( 'wp_ajax_country_to_states_ajax', array( $this, 'idonate_country_to_states_ajax' ) );
			add_action( 'wp_ajax_nopriv_country_to_states_ajax', array( $this, 'idonate_country_to_states_ajax' ) );
			
		}
		
		public function admin_donor_profile_view(){
			
			$meta_key_name = array(
				'full_name',
				'bloodgroup',
				'gender',
				'date_birth',
				'mobile',
				'landline',
				'country',
				'state',
				'city',
				'address',
				'availability',
				'profilepic',
			);
						
			$id = '';
			if( isset( $_REQUEST['id'] ) && absint( $_REQUEST['id'] )  ){
				$id = $_REQUEST['id'];
			}
			
			$data = array();
			if( $id ){
				
				$userData = get_userdata( $id );
								
				$data['id'] = $userData->id;
				$data['user_name'] = $userData->user_login;
				$data['email'] 	   = $userData->user_email;
				
				foreach( $meta_key_name as $key_name  ){
					
					if( 'idonate_donor_'.esc_html( $key_name ) == 'idonate_donor_country' ){
						$country = get_user_meta( esc_html( $id ), 'idonate_donor_'.esc_html( $key_name ), true );
						$data[$key_name] = idonate_country_name_by_code( $country );
						$data['contycode'] = $country;
						
					}elseif( 'idonate_donor_'.esc_html( $key_name ) == 'idonate_donor_state' ){
						
						$statecode  = get_user_meta( esc_html( $id ), 'idonate_donor_'.esc_html( $key_name ), true );
						$countrycode = get_user_meta( esc_html( $id ), 'idonate_donor_country', true );
						$data[$key_name] = idonate_states_name_by_code( $countrycode, $statecode );
						$data['statecode'] = $statecode;
						
						
					}elseif( 'idonate_donor_'.esc_html( $key_name ) == 'idonate_donor_profilepic' ){
						
						$attachmentID = get_user_meta( esc_html( $id ), 'idonate_donor_'.esc_html( $key_name ), true );
						
						$data[$key_name] = wp_get_attachment_url( $attachmentID );
						
					}else{
						$data[$key_name] = get_user_meta( esc_html( $id ), 'idonate_donor_'.esc_html( $key_name ), true );
					}
					
				}
				
			}
			
			$data = wp_json_encode( $data );
			echo $data;
			die();
			
		}
		
		// Country and states ajax
		public function idonate_country_to_states_ajax(){
			
			if( isset( $_POST['country'] ) ){
				
				include( IDONATE_COUNTRIES.'states/'.$_POST['country'].'.php' );
			}
			
			global $states;
			echo  json_encode( $states[$_POST['country']] );
			die();
			
		}
		
		
	}
	
	
	$ob = new IDonate_ajax_handler();
	
}
?>