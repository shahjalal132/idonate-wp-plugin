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


// Post blood request form data
function idonate_blood_request_form_handel() {

	$generalOpt = get_option( 'idonate_general_option_name' );

	// These files need to be included as dependencies when on the front end.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

		
	if( isset( $_POST['request_submit_nonce_check'] ) && wp_verify_nonce( $_POST['request_submit_nonce_check']  , 'request_nonce_action' ) ){  // nonce check
				
			$response = idonate_recaptcha_response();
			
			if( ! empty( $response['status'] ) ) {
			
				$is_OK = true;
				
				//  Empty title check
				if( ! empty( $_POST['title'] ) ) {
					$title = $_POST['title'];
				}else{
					$is_OK = false;
				}
				//  Empty patient name check
				if( ! empty( $_POST['patientname'] ) ) {
					$patientname = $_POST['patientname'];
				}else{
					$is_OK = false;
				}
				//  Empty patient age check
				if( ! empty( $_POST['patientage'] ) && (int) $_POST['patientage'] ) {
					$patientage = $_POST['patientage'];
				}else{
					$is_OK = false;
				}
				//  Empty blood group check
				if( ! empty( $_POST['bloodgroup'] ) ) {
					$bloodgroup = $_POST['bloodgroup'];
				}else{
					$is_OK = false;
				}
				//  Empty when need blood check
				if( ! empty( $_POST['needblood'] ) ) {
					$needblood = $_POST['needblood'];

				}else {
					$is_OK = false;
				}
				//  Empty blood units check
				if( ! empty( $_POST['bloodunits'] ) && (int) $_POST['bloodunits'] ) {
					$bloodunits = $_POST['bloodunits'];
				}else{
					$is_OK = false;
				}
				//  Empty purpose check
				if( ! empty( $_POST['purpose'] ) ) {
					$purpose = $_POST['purpose'];
				}else{
					$is_OK = false;
				}
				//  Empty mobile number check
				if( ! empty( $_POST['mobilenumber'] ) ) {
					$mobilenumber = $_POST['mobilenumber'];
				}else{
					$is_OK = false;
				}
				//  Empty hospital name check
				if( ! empty( $_POST['hospitalname'] ) ) {
					$hospitalname = $_POST['hospitalname'];
				}else{
					$is_OK = false;
				}
				if( ! empty( $generalOpt['idonate_bloodrequestcountryhide'] ) ) {
					//  Empty Country check
					if( ! empty( $_POST['country'] ) ) {
						$country = $_POST['country'];
					}else{
						$is_OK = false;
					}
					//  Empty State check
					if( ! empty( $_POST['state'] ) ) {
						$state = $_POST['state'];
					}else{
						$is_OK = false;
					}
				}
				
				//  Empty city check
				if( ! empty( $_POST['city'] ) ) {
					$city = $_POST['city'];
				}else{
					$is_OK = false;
				}
				//  Empty location/address check
				if( ! empty( $_POST['location'] ) ) {
					$location = $_POST['location'];
				}else{
					$is_OK = false;
				}
				//  Empty Details check
				if( ! empty( $_POST['details'] ) ) {
					$details = $_POST['details'];
				}else{
					$is_OK = false;
				}
				
				// Insert Post
				if( $is_OK ) {
					
					$args = array(
						'post_type' 	=> 'blood_request',
						'post_title' 	=> sanitize_text_field( $title ),
						'post_status' 	=> 'publish',
					);
					
					$insert_ID = wp_insert_post( $args );
					
					if( $insert_ID ){

						// Post status 
						$option = get_option( 'idonate_general_option_name' );
						$status = '1';
						if( !empty( $option['donor_request_status'] ) ){
							$status = '0';
						}

						$options = get_option( 'idonate_request_option_name' );
						if(  !empty( $options['rf_form_img_upload'] )  ) {
							// Media upload handle
							$attachment_id = media_handle_upload( 'requestpic', $insert_ID );		
							//media upload update
							update_post_meta( $insert_ID, 'idonate_request_picture', $attachment_id );

						}
						
						update_post_meta( $insert_ID, 'idonatepatient_name', sanitize_text_field( $patientname ) );
						update_post_meta( $insert_ID, 'idonatepatient_bloodgroup', sanitize_text_field( $bloodgroup ) );
						update_post_meta( $insert_ID, 'idonatepatient_age', sanitize_text_field( $patientage ) );
						update_post_meta( $insert_ID, 'idonatepatient_bloodneed', sanitize_text_field( $needblood ) );
						update_post_meta( $insert_ID, 'idonatepatient_bloodunit', sanitize_text_field( $bloodunits ) );
						update_post_meta( $insert_ID, 'idonatepurpose', sanitize_text_field( $purpose ) );
						update_post_meta( $insert_ID, 'idonatepatient_mobnumber', sanitize_text_field( $mobilenumber ) );
						update_post_meta( $insert_ID, 'idonatehospital_name', sanitize_text_field( $hospitalname ) );
						

						if( ! empty( $generalOpt['idonate_bloodrequestcountryhide'] ) ) {
							update_post_meta( $insert_ID, 'idonatecountry', sanitize_text_field( $country ) );
							update_post_meta( $insert_ID, 'idonatestate', sanitize_text_field( $state ) );
						}
						update_post_meta( $insert_ID, 'idonatecity', sanitize_text_field( $city ) );
						update_post_meta( $insert_ID, 'idonatelocation', sanitize_text_field( $location ) );
						update_post_meta( $insert_ID, 'idonatedetails', sanitize_text_field( $details ) );
						update_post_meta( $insert_ID, 'idonate_status', sanitize_text_field( $status ) );
						
						return esc_html__( 'Thank you! Your request has been submitted.', 'idonate' );
					}else{
						return esc_html__( 'Sorry, an error occurred while processing your request.', 'idonate' );
					}
					
					
				}else{
					return esc_html__( 'Sorry, your request submission failed. Some fields may be empty.', 'idonate' );
				}
			
			}else{
				return !empty( $response['msg'] ) ? $response['msg'] : '';
			}
				
	}else{
		return esc_html__( 'Sorry, an error occurred while processing your request.', 'idonate' );
	}// End check nonce
	
	
	
	
}


?>