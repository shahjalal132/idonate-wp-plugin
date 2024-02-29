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

add_shortcode( 'idonate_statistics' , 'shortcode_statistics' );
function shortcode_statistics() {
	
	// Total Donor
	$totalUser = count_users();
	$totalDonor = !empty( $totalUser['avail_roles']['donor'] ) ? $totalUser['avail_roles']['donor'] : '';

	// Total Current Blood request
	$totaRequest = wp_count_posts('blood_request'); 

	// Active User
	$userargs = array(
		'meta_key' => 'idonate_donor_availability',
		'meta_value' => 'available',
	);

	$activeDonor = get_users( $userargs );
	$totalActiveDonor =  !empty( $activeDonor ) ? count( $activeDonor ) : ''; 


	ob_start();
	?>
	<div class="blood-statistics-widget">
		<div class="single-statistics"><span class="fa fa-users"></span> <span class="right"><?php esc_html_e( 'Total Donor : ', 'idonate' ); echo esc_html( $totalDonor );?></span></div>		
		<div class="single-statistics"><span class="fa fa-universal-access"></span> <span class="right"><?php esc_html_e( 'Available Donor : ', 'idonate' ); echo esc_html( $totalActiveDonor ) ?></span></div>		
		<div class="single-statistics"><span class="fa fa-folder"></span> <span class="right"><?php esc_html_e( 'Current Request : ', 'idonate' ); echo esc_html( $totaRequest->publish ); ?></span></div>
	</div>
	<?php

	return ob_get_clean();
}