<?php 
 /**
  * 
  * @package    iDonate - blood donor management system WordPress Plugin
  * @version    1.0
  * @author     ThemeAtelier
  * @Websites: https://themeatelier.net/
  *
  *
  */
  
// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}

if( ! is_user_logged_in() || current_user_can( 'donor' ) != 1 ) {
	wp_safe_redirect( site_url() );
}

$userID = get_current_user_id();

$userData = get_userdata( $userID );


$formText = textset_option();

if( ! empty( $text = $formText['donor_peft'] ) ){
	$formText = $text;
}else{
	$formText = __( 'Edit Donors Information', 'idonate' );
}

//
$msg = '';
if( isset( $_POST['donor_submit'] ) ){
	$res = idonate_donor_edit();
	$msg = '<p>'. idonate_response_msg( $res, 'update' ).'</p>';
	
}

$generalOpt = get_option( 'idonate_general_option_name' );

get_header();
?>

<div class="container">
	<div class="row">
		<div class="col-sm-6 offset-3">
			<div class="request-form">
				<div id="donorPanelForm">
					<div class="donor-edit-form-heading">
						<h3><?php echo esc_html( $formText ); ?></h3>
						<div class="btn-area-bprof">
							<a href="<?php echo esc_html( site_url( profile_permalink() ) ); ?>"><?php esc_html_e( 'Back Profile', 'idonate' ); ?></a>
						</div>
					</div>
					<!-- Contact Us Form -->
					<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
						<?php 
						echo $msg;
						?>
						<hr>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Last Donate', 'idonate' ); ?></label>
									<input type="text" class="form-control date-picker" id="lastdonate" value="<?php echo get_user_meta( $userID, 'idonate_donor_lastdonate', true ); ?>" name="lastdonate" placeholder="<?php esc_html_e( 'Last Donate Date', 'idonate' ); ?>">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Full Name', 'idonate' ); ?></label>
									<input id="full_name" name="full_name" value="<?php echo get_user_meta( $userID, 'idonate_donor_full_name', true ); ?>" class="form-control" placeholder="Name" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Gender', 'idonate' ); ?></label>
									<select id="gender" class="form-control gender" name="gender">
										<?php $gender = get_user_meta( $userID, 'idonate_donor_gender', true ); ?>
										<option value="Male" <?php selected( $gender, 'Male' ) ?>><?php esc_html_e( 'Male', 'idonate' ); ?></option>
										<option value="Female" <?php selected( $gender, 'Female' ) ?>><?php esc_html_e( 'Female', 'idonate' ); ?></option>
										<option value="Other" <?php selected( $gender, 'Other' ) ?>><?php esc_html_e( 'Other', 'idonate' ); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Date Of Birth', 'idonate' ); ?></label>
									<input id="datebirth" name="date_birth" value="<?php echo get_user_meta( $userID, 'idonate_donor_date_birth', true ); ?>" class="form-control" placeholder="<?php esc_html_e( 'Date Of Birth', 'idonate' ); ?>" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Blood Group', 'idonate' ); ?></label>
									<select class="form-control" name="bloodgroup">
										<option value="Select"><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
										<?php 
										$selectedgroup = get_user_meta( $userID, 'idonate_donor_bloodgroup', true );
										$GetBloodGroup = idonate_blood_group();
										$options = '';
										foreach( $GetBloodGroup as $bloodgroup ){
											
											if( $selectedgroup == $bloodgroup ){
												$selected = 'selected';
											}else{
												$selected = '';
											}
											
											$options .= '<option value="'.esc_attr( $bloodgroup ).'" '.esc_attr( $selected ).'>'.esc_html( $bloodgroup ).'</option>';
										}
										echo $options;
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Mobile Number', 'idonate' ); ?></label>
									<input id="mobile" name="mobile" value="<?php echo get_user_meta( $userID, 'idonate_donor_mobile', true ); ?>" class="form-control" placeholder="Mobile Number" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Land Line Number', 'idonate' ); ?></label>
									<input id="landline" name="landline" value="<?php echo get_user_meta( $userID, 'idonate_donor_landline', true ); ?>" class="form-control" placeholder="Land Line Number" type="text">
								</div>
							</div>
						</div>
						<?php 
						if( ! empty( $generalOpt['idonate_countryhide'] ) ) :
						?>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Select Country', 'idonate' ); ?></label>
									<select id="country" class="form-control country" name="country">
										<?php 
										$SelectedCounCode = get_user_meta( $userID, 'idonate_donor_country', true );
										echo idonate_countries_options( $SelectedCounCode );
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Select State', 'idonate' ); ?></label>
									<?php $stateCode = get_user_meta( $userID, 'idonate_donor_state', true ); ?>
									<select class="form-control state" data-state="<?php echo esc_attr( $stateCode ); ?>" id="state" name="state">
										<option><?php esc_html_e( 'Select Country First', 'idonate' ); ?></option>
									</select>
								</div>
							</div>
						</div>
						<?php 
						endif;
						?>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-12">
									<label><?php esc_html_e( 'City', 'idonate' ); ?></label>
									<input id="city" name="city" value="<?php echo get_user_meta( $userID, 'idonate_donor_city', true ); ?>" class="form-control" placeholder="<?php esc_html_e( 'City', 'idonate' ); ?>" type="text">
								</div>
							</div>
						</div>
						<div class="dp-row">
							<div class="dp-col-12">
								<label><?php esc_html_e( 'Address', 'idonate' ); ?></label>
								<textarea rows="4" name="address" class="form-control"><?php echo get_user_meta( $userID, 'idonate_donor_address', true ); ?></textarea>
							</div>
						</div>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'E-Mail ID', 'idonate' ); ?></label>
									<input id="email" name="email" value="<?php echo $userData->user_email; ?>" class="form-control" placeholder="E-Mail" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'User Name', 'idonate' ); ?></label>
									<input id="user_name" name="user_name" value="<?php echo $userData->user_login; ?>" class="form-control" placeholder="User Name" type="text">
								</div>
							</div>
						</div>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'New Password', 'idonate' ); ?></label>
									<input id="password" name="password" class="form-control" placeholder="New Password" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Re-type New Password', 'idonate' ); ?></label>
									<input id="retypepassword" name="retypepassword" class="form-control" placeholder="Re-type New Password" type="text">
								</div>
							</div>
						</div>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Facebook Url', 'idonate' ); ?></label>
									<input id="fburl" name="fburl" value="<?php echo get_user_meta( $userID, 'idonate_donor_fburl', true ); ?>" class="form-control" placeholder="Facebook Url" type="text">
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Twitter Url', 'idonate' ); ?></label>
									<input id="twitterurl" name="twitterurl" value="<?php echo get_user_meta( $userID, 'idonate_donor_twitterurl', true ); ?>" class="form-control" placeholder="Twitter Url" type="text">
								</div>
							</div>
						</div>
						<div class="dp-row">
							<div class="form-group">
								<div class="dp-col-6">
									<label><?php esc_html_e( 'Please confirm your availability to donate blood', 'idonate' ); ?></label>
									<?php 
									
									$options = array(
										'available' 	=> 'Available',
										'unavailable' 	=> 'Unavailable',
									);
									
									$selectedav = get_user_meta( $userID, 'idonate_donor_availability', true ); 
									
									?>
									<select class="form-control" name="availability">
										<option value=""><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
										<?php 
										foreach( $options as $key => $option ){
											
											if( $selectedav == $key ){
												$selected = 'selected';
											}else{
												$selected = '';
											}
											
											echo '<option value="'.esc_attr( $key ).'" '.esc_attr( $selected ).'>'.esc_attr( $option ).'</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="dp-col-6 upload-pic-area">
									<label><?php esc_html_e( 'Upload Profile Picture', 'idonate' ); ?></label>
									<input type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
									<?php 
									echo idonate_profile_img( $userID );
									?>
								</div>
							</div>
						</div>
						<input type="hidden" value="<?php echo esc_html( $userID ); ?>" name="donor_id" />
						<?php 
						// WP Nonce
						wp_nonce_field( 'request_nonce_action', 'request_submit_nonce_check' );
						?>
						<input class="submit btn mt-30 btn-default btn-center" type="submit" name="donor_submit" value="Submit" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php 
get_footer();
?>