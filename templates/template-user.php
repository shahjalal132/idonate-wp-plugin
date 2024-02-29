<?php 
 /**
  * 
  * @package    iDonate - blood donor management system WordPress Plugin
  * @version    1.0
  * @author     ThemeAtelier
  * @Websites: https://themeatelier.net/
  *
  * Template Name: User Details
  *
  */
  
// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}

get_header();
?>
<section class="request-single-page ptb-80">
	<div class="container">
		<div class="row">
		
			<?php 

			if( isset( $_GET['donor_id'] ) ) {

				$user_id = $_GET['donor_id'];

			}

			$permalink = add_query_arg(
				array(
					'donor_id' => $user_id
				),
				get_permalink()
			);  

			$user = get_userdata( $user_id );


			$countryCode = get_user_meta( $user_id, 'idonate_donor_country', true );
			$statecode   = get_user_meta( $user_id, 'idonate_donor_state', true );
			
			$country = idonate_country_name_by_code( $countryCode );
			
			$state 	 = idonate_states_name_by_code( $countryCode, $statecode );


			// availability
			$av = get_user_meta( $user_id, 'idonate_donor_availability', true );
			
			if( 'available' == $av ){
				$abclass = 'available';
				$signal  = '<i class="fa fa-check"></i>';
			}else{
				$abclass = 'unavailable';
				$signal = '<i class="fa fa-times"></i>';
			}

			// Social Link
			$fb = get_user_meta( $user_id, 'idonate_donor_fburl', true );
			$twitter = get_user_meta( $user_id, 'idonate_donor_twitterurl', true );
			?>

			<div class="col-md-4 text-center">
				<div class="left__user">
					<div class="left__user__img">
			<?php if(idonate_profile_img( $user->ID )) : ?>
						<?php 
						echo idonate_profile_img( $user->ID );
						?>
						<?php else : ?>
							<img src="<?php 
							echo plugin_dir_url( __DIR__ ).'img/donorplaceholder.jpeg'?>"/>
						<?php endif; ?>
						</div>
						<?php
				
				// Name
				echo '<h2 class="mb-3">'.esc_html( get_user_meta( $user_id, 'idonate_donor_full_name', true ) ).'</h2>';
				echo '<p><b>Blood Group: </b>'.esc_html( get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ) ).'</p>';
				echo '<p class="blood-group"><i class="fa fa-universal-access"></i><span class="'.esc_attr( $abclass ).'">'. esc_html( $av ).wp_kses_post( $signal ).'</span></p>';

				echo '<p><b>Email: </b>'.esc_html( $user->user_email ).'</p>';
				echo '<p><b>Mobile: </b>'.esc_html( get_user_meta( $user_id, 'idonate_donor_mobile', true ) ).'</p>';

				if( $fb || $twitter ) {

					$socialMarkup = '';
					$socialMarkup .= '<p class="social-icon">'.esc_html__( 'Social Link: ', 'idonate' );

					if( $fb ) {
						$socialMarkup .= '<a target="_blank" href="'.esc_url( $fb ).'"><i class="fa fa-facebook"></i></a>';
					}
					if( $twitter ) {
						$socialMarkup .= '<a target="_blank" href="'.esc_url( $twitter ).'"><i class="fa fa-twitter"></i></a>';
					}
					$socialMarkup .= '</p>';

					echo $socialMarkup;
				}


				?>
				</div>
			</div>
<div class="col-md-8">
		<div class="single-page-donor">


			<div class="infotable">

				<div class="table-responsive">
				  <table class="table table-bordered">
					<?php
					// Name
					$name = get_user_meta( $user_id, 'idonate_donor_full_name', true );
					if( $name ){
						echo idonate_blood_request_table( 'table-info', esc_html__('Donor Name', 'idonate' ) ,$name );
					}
					// Last Donate
					$lastdonate = get_user_meta( $user->ID, 'idonate_donor_lastdonate', true );
					if( $lastdonate ){
						echo idonate_blood_request_table( 'table-danger', esc_html__('Last Donate', 'idonate' ) ,$lastdonate );
					}
					
					// Gender
					$gender = get_user_meta( $user_id, 'idonate_donor_gender', true );
					if( $gender ){
						echo idonate_blood_request_table( 'table-danger', esc_html__('Gender', 'idonate' ) ,$gender );
					}
					// Date of Birth
					$date_birth = get_user_meta( $user_id, 'idonate_donor_date_birth', true );
					if( $date_birth ){
						echo idonate_blood_request_table( 'table-danger', esc_html__('Date of Birth', 'idonate' ) ,$date_birth );
					}
					// Land Line Number
					$landline = get_user_meta( $user_id, 'idonate_donor_landline', true );
					if( $landline ){
						echo idonate_blood_request_table( 'table-info', esc_html__('Land Line Number', 'idonate' ) ,$landline );
					}
					// Country
					if( $country ){
						echo idonate_blood_request_table( 'table-danger', esc_html__('Country', 'idonate' ) ,$country );
					}
					// State
					if( $state ){
						echo idonate_blood_request_table( 'table-info', esc_html__( 'State', 'idonate' ) ,$state );
					}
					// City
					$city = get_user_meta( $user_id, 'idonate_donor_city', true );
					if( $city ){
						echo idonate_blood_request_table( 'table-info', esc_html__('City', 'idonate' ) ,$city );
					}
					// Address
					$address = get_user_meta( $user_id, 'idonate_donor_address', true );
					
					if( $address ){
						echo idonate_blood_request_table( 'table-info', esc_html__('Address', 'idonate' ) ,$address );
					}

					?>
				  </table>
				</div>
				<?php
				// Social share
				idonate_social_sharing_buttons( $name, $permalink );
				?>
			</div>

			</div>
		</div>
		</div>
	</div>
</section>
<?php 
get_footer();
?>