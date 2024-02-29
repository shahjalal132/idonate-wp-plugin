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

get_header();
?>
<section class="request-single-page ptb-80">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-sm-4 p-0 text-center">
				<img class="mb-3" src="<?php echo plugin_dir_url( __DIR__ ).'img/request.jpg'?>"/>
			</div>
			<div class="col-sm-8 p-0">
				<div class="request-info-wrapper">
				<?php 
				if( have_posts() ):
				while( have_posts() ):
					the_post();
				?>
				
				<div class="request-info text-left">
					<?php 
					// Title
					if( get_the_title() ){
						echo '<h2>'.esc_html( get_the_title() ).'</h2>';
					}
					// Post Date
					if( get_the_date() ){
						echo '<span> Post Date: '.esc_html( get_the_date() ).'</span>';
					}
					//
					$details = idonate_meta_id( 'idonatedetails' );
					if( $details ){
						echo '<p>'.esc_html( $details ).'</p>';
					}
					//
					
					$pic 	= idonate_meta_id( 'idonate_request_picture' );
					if( !is_wp_error( $pic ) && !empty( $pic ) ) {
						echo '<div style="margin-top: 35px;" class="single-profile-img text-center">';
							echo wp_get_attachment_image( $pic, 'full' );
						echo '</div>';
					}
					
					?>
					
				</div>
				
				<div class="infotable">
					<div class="table-responsive">
					  <table class="table table-bordered">
						<?php
						// Name
						$name = idonate_meta_id( 'idonatepatient_name' );
						if( $name ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Patient Name', 'idonate' ) ,$name );
						}
						// Age
						$age = idonate_meta_id( 'idonatepatient_age' );
						if( $age ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Patient Age', 'idonate' ) ,$age );
						}
						// Blood Group
						$bgroup = idonate_meta_id( 'idonatepatient_bloodgroup' );
						if( $bgroup ){
							echo idonate_blood_request_table( 'table-danger', esc_html__('Blood Group', 'idonate' ) ,$bgroup );
						}
						// When Need Blood ?
						$need = idonate_meta_id( 'idonatepatient_bloodneed' );
						if( $need ){
							echo idonate_blood_request_table( 'table-danger', esc_html__('When Need Blood ?', 'idonate' ) ,$need );
						}
						// Blood Units
						$units = idonate_meta_id( 'idonatepatient_bloodunit' );
						if( $units ){
							echo idonate_blood_request_table( 'table-danger', esc_html__('Blood Unit / Bag (S)', 'idonate' ) ,$units );
						}
						// Purpose
						$purpose = idonate_meta_id( 'idonatepurpose' );
						if( $purpose ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Purpose', 'idonate' ) ,$purpose );
						}
						// Mobile Number
						$mobnumber = idonate_meta_id( 'idonatepatient_mobnumber' );
						if( $mobnumber ){
							echo idonate_blood_request_table( 'table-danger', esc_html__('Mobile Number', 'idonate' ) ,$mobnumber );
						}
						// Email
						$email = idonate_meta_id( 'idonatepatient_email' );
						if( $email ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Email', 'idonate' ) ,$email );
						}
						// Hospital Name
						$hospital = idonate_meta_id( 'idonatehospital_name' );
						if( $hospital ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Hospital Name', 'idonate' ) ,$hospital );
						}
						// Country
						$countrycode = idonate_meta_id( 'idonatecountry' );
						$country = idonate_country_name_by_code( $countrycode );
						
						if( $country ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Country', 'idonate' ) ,$country );
						}
						// State
						$statecode = idonate_meta_id( 'idonatestate' );
						$state = idonate_states_name_by_code( $countrycode, $statecode );
						if( $state ){
							echo idonate_blood_request_table( 'table-info', esc_html__('State', 'idonate' ) ,$state );
						}
						// City
						$city = idonate_meta_id( 'idonatecity' );
						if( $city ){
							echo idonate_blood_request_table( 'table-info', esc_html__('City', 'idonate' ) ,$city );
						}
						// Location/Address
						$location = idonate_meta_id( 'idonatelocation' );
						if( $location ){
							echo idonate_blood_request_table( 'table-info', esc_html__('Address', 'idonate' ) ,$location );
						}
						
						?>
					  </table>
					</div>
					<?php
					// Social share
					idonate_social_sharing_buttons();
					?>
				</div>
				</div>
				<?php 
				endwhile;
				endif;
				?>
			</div>
		</div>
	</div>
</section>
<?php 
get_footer();
?>