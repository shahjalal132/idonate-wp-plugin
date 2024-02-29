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
    die( IDONATE_ALERT_MSG );
}

add_shortcode( 'register-donor' , 'shortcode_register_donor' );
function shortcode_register_donor() {

	$formText = textset_option();

	if( ! empty( $text = $formText['donor_prft'] ) ) {
		$formText = $text;
	}else {
		$formText = __( 'Blood Donors Register', 'idonate' );
	}

	// 
	$generalOpt = get_option( 'idonate_general_option_name' );

	ob_start();
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div class="request-form">
					<div class="submit-info">
						<h2><?php echo esc_html( $formText ); ?></h2>
						<p><?php esc_html_e( 'Please fill the following information to register donor.', 'idonate' ); ?></p>
						<?php 
						if( isset( $_POST['donor_submit'] ) ){
							$res = idonate_donor_add();
							echo idonate_response_msg( $res, 'add' );
							
						}
						?>
						<hr>
					</div>
					<div id="donorPanelForm">
						<!-- Contact Us Form -->
						<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
							<div class="dp-row">
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Full Name', 'idonate' ); ?></label>
										<input id="full_name" name="full_name" class="form-control" placeholder="<?php esc_html_e( 'Name', 'idonate' ); ?>" type="text">
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Gender', 'idonate' ); ?></label>
										<select id="gender" class="form-control gender" name="gender">
											<option value="Male"><?php esc_html_e( 'Male', 'idonate' ); ?></option>
											<option value="Female"><?php esc_html_e( 'Female', 'idonate' ); ?></option>
											<option value="Other"><?php esc_html_e( 'Other', 'idonate' ); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Date Of Birth', 'idonate' ); ?></label>
										<input id="datebirth" name="date_birth" class="form-control" placeholder="<?php esc_html_e( 'Date Of Birth', 'idonate' ); ?>" type="text">
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Blood Group', 'idonate' ); ?></label>
										<select class="form-control" name="bloodgroup">
											<option value="Select"><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
											<?php 
											$GetBloodGroup = idonate_blood_group();
											$options = '';
											foreach( $GetBloodGroup as $bloodgroup ){
												$options .= '<option value="'.esc_attr( $bloodgroup ).'">'.esc_html( $bloodgroup ).'</option>';
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
										<input id="mobile" name="mobile" class="form-control" placeholder="<?php esc_html_e( 'Mobile Number', 'idonate' ); ?>" type="text">
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Land Line Number', 'idonate' ); ?></label>
										<input id="landline" name="landline" class="form-control" placeholder="<?php esc_html_e( 'Land Line Number', 'idonate' ); ?>" type="text">
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
											echo idonate_countries_options();
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Select State', 'idonate' ); ?></label>
										<select class="form-control state" id="state" name="state">
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
										<input id="city" name="city" class="form-control" placeholder="<?php esc_html_e( 'City', 'idonate' ); ?>" type="text">
									</div>
								</div>
							</div>
							<div class="dp-row">
								<div class="form-group">
									<div class="dp-col-12">
										<label><?php esc_html_e( 'Address', 'idonate' ); ?></label>
										<textarea rows="4" name="address" class="form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="dp-row">
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'E-Mail ID', 'idonate' ); ?></label>
										<input id="email" name="email" class="form-control" placeholder="<?php esc_html_e( 'E-Mail', 'idonate' ); ?>" type="text">
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'User Name', 'idonate' ); ?></label>
										<input id="user_name" name="user_name" class="form-control" placeholder="<?php esc_html_e( 'User Name', 'idonate' ); ?>" type="text">
									</div>
								</div>
							</div>
							<div class="dp-row">
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Password', 'idonate' ); ?></label>
										<input id="password" name="password" class="form-control" placeholder="<?php esc_html_e( 'Password', 'idonate' ); ?>" type="text">
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Re-type Password', 'idonate' ); ?></label>
										<input id="retypepassword" name="retypepassword" class="form-control" placeholder="<?php esc_html_e( 'Re-type Password', 'idonate' ); ?>" type="text">
									</div>
								</div>
							</div>
							<div class="dp-row">
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Please confirm your availability to donate blood', 'idonate' ); ?></label>
										<select class="form-control" name="availability">
											<option value="Select"><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
											<option value="available"><?php esc_html_e( 'Available', 'idonate' ); ?></option>
											<option value="unavailable"><?php esc_html_e( 'Unavailable', 'idonate' ); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="dp-col-6">
										<label><?php esc_html_e( 'Upload Profile Picture', 'idonate' ); ?></label>
										<input type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
										<img class="upload-preview" src="<?php echo IDONATE_DIR_URL . 'img' ?>/idonate-preview-image.jpg" alt="your image" />
									</div>
								</div>
								<?php 
								$option = get_option( 'idonate_general_option_name' );
								if( !empty( $option['idonate_recaptcha_active'] ) ){
									$sitekey = !empty( $option['idonate_recaptcha_sitekey'] ) ? $option['idonate_recaptcha_sitekey'] : '';
									echo '<div class="g-recaptcha" data-sitekey="'.esc_attr( $sitekey ).'"></div>';
								}
								?>
							</div>
							<?php 
							// WP Nonce
							wp_nonce_field( 'request_nonce_action', 'request_submit_nonce_check' );
							?>
							<div class="dp-row text-center">
								<input class="submit btn mt-30 btn-default btn-center" type="submit" name="donor_submit" value="<?php esc_html_e( 'Submit', 'idonate' ); ?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
}