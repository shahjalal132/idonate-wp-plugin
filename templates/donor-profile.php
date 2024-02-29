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


if( !is_user_logged_in() || current_user_can( 'donor' ) != 1 ){
	wp_safe_redirect( site_url() );
}

$userID = get_current_user_id();

$userData = get_userdata( $userID );

$countrycode = get_user_meta( $userID, 'idonate_donor_country', true );

$statecode  = get_user_meta( $userID, 'idonate_donor_state', true );

$country = idonate_country_name_by_code( $countrycode );


$state = idonate_states_name_by_code( $countrycode, $statecode );

get_header();

?>

<div class="container">
	<div class="row">
		<div class="col-sm-8 offset-2">
			<div class="donor-profile">
				<div class="btn-area">
					<a href="<?php echo esc_html( site_url( profile_edit_permalink() ) ); ?>"><?php esc_html_e( 'Edit', 'idonate' ); ?></a>
					<a href="<?php echo wp_logout_url(); ?>"><?php esc_html_e( 'Logout', 'idonate' ); ?></a>
				</div>
				<div class="donor-img">
					<?php 
					echo idonate_profile_img( $userID );
					?>
				</div>
				<div class="personal-info text-center">
					<h3><?php echo get_user_meta( $userID, 'idonate_donor_full_name', true ); ?></h3>
					<p><?php echo $userData->user_email; ?></p>
					<p><?php echo get_user_meta( $userID, 'idonate_donor_mobile', true ); ?></p>
					<p><?php echo get_user_meta( $userID, 'idonate_donor_availability', true ); ?></p>
					<p><?php echo get_user_meta( $userID, 'idonate_donor_bloodgroup', true ); ?></p>
				</div>
				<div class="address text-center">
					<?php 
					$fb = get_user_meta( $userID, 'idonate_donor_fburl', true );
					$twitter = get_user_meta( $userID, 'idonate_donor_twitterurl', true );
					?>
					<?php 
					if( $fb || $twitter ): 
					?>
					<p class="social-icon"><strong><?php esc_html_e( 'Social Media :', 'idonate' ); ?></strong>
						<?php
						// FB Url 
						if( $fb ) {
							echo '<a target="_blank" href="'.esc_url( $fb ).'"><i class="fa fa-facebook"></i></a>';
						}
						// Twitter
						if( $twitter ) {
							echo '<a target="_blank" href="'.esc_url( $twitter ).'"><i class="fa fa-twitter"></i></a>';
						}
						?> 
					</p>
					<?php 
					endif;
					?>
					<?php
									$lastdonate = get_user_meta( $user->ID, 'idonate_donor_lastdonate', true ); 
									if( $lastdonate ):
									?>
									<p><strong><?php esc_html_e( 'Last Donate :', 'idonate' ); ?></strong> <?php echo esc_html( $lastdonate ); ?></p>
									<?php endif;?>

									<?php
									$gender = get_user_meta( $user->ID, 'idonate_donor_gender', true ); 
									if( $gender ):
									?>
									<p><strong><?php esc_html_e( 'Gender :', 'idonate' ); ?></strong> <?php echo esc_html( $gender ); ?></p>
									<?php endif; ?>

									<?php
										$dob = get_user_meta( $user->ID, 'idonate_donor_date_birth', true ); if( $dob ): ?>
										<p><strong><?php esc_html_e( 'Date Of Birth :', 'idonate' ); ?></strong> <?php echo esc_html( $dob ); ?></p>
									<?php endif; ?>
									
									<?php
										$landline = get_user_meta( $user->ID, 'idonate_donor_landline', true ); if( $landline ): ?>
									<p><strong><?php esc_html_e( 'Land Line Number :', 'idonate' ); ?></strong> <?php echo esc_html( $landline ); ?></p>
									<?php endif; ?>
					<p><strong><?php esc_html_e( 'Country :', 'idonate' ); ?></strong> <?php echo esc_html( $country ); ?></p>
					<p><strong><?php esc_html_e( 'State :', 'idonate' ); ?></strong> <?php echo esc_html( $state ); ?></p>
					<p><strong><?php esc_html_e( 'City :', 'idonate' ); ?></strong> <?php echo esc_html( get_user_meta( $userID, 'idonate_donor_city', true ) ); ?></p>
					<p><strong><?php esc_html_e( 'Address :', 'idonate' ); ?></strong> <?php echo esc_html( get_user_meta( $userID, 'idonate_donor_address', true ) ); ?></p>
					<p><strong><?php esc_html_e( 'User Name:', 'idonate' ); ?></strong> <?php echo esc_html( $userData->user_login ); ?></p>
					<p><strong><?php esc_html_e( 'Email :', 'idonate' ); ?></strong> <?php echo esc_html( $userData->user_email ); ?></p>
				</div>
			</div>				
		</div>
	</div>
</div>
<?php 
get_footer();
?>