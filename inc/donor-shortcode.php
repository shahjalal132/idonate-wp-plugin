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
  
add_shortcode( 'donortable', 'idonate_donor_table' );
function idonate_donor_table( $atts ){
	


	$attr = shortcode_atts( array(
		'container' => false,
	), $atts );
	

	$donor_number = get_option( 'idonate_general_option_name' );
	$formText = textset_option();

	if( ! empty( $text = $formText['donor_vmt'] ) ) {
		$formText = $text;
	}else{
		$formText = __( 'Donor Details', 'idonate' );
	}

	ob_start();
	
	if( !empty( $attr['container'] ) ):
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12 donor-wrap-table">
		<?php 
		endif;
		?>
		<div class="table-responsive">
			<table id="table_id" class="table donor-table table-bordered display">
				<thead>
					<tr>
						<th><?php esc_html_e( 'No', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'Name', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'Blood Group', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'Mobile No', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'Country', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'State', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'City', 'idonate' ); ?></th>
						<th><?php esc_html_e( 'Action', 'idonate' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$args = array(
					'role' => 'donor',
					'meta_key'	   => 'idonate_donor_status',
					'meta_value'   => '1',
				);
				$users = get_users( $args );
					
				?>

				<?php 
				$i = 0;
				foreach( $users as $user ):
				
				$countrycode 	= get_user_meta( $user->ID, 'idonate_donor_country', true );
				$stateCode 		= get_user_meta( $user->ID, 'idonate_donor_state', true );
				$countryname 	= idonate_country_name_by_code( $countrycode );
				$statename 	 	= idonate_states_name_by_code( $countrycode, $stateCode );
				

				$i++;	

				// availability
				$av = get_user_meta( $user->ID, 'idonate_donor_availability', true );
				
				if( 'available' == $av ){
					$abclass = 'available';
					$signal  = '<i class="fa fa-check"></i>';
				}else{
					$abclass = 'unavailable';
					$signal = '<i class="fa fa-times"></i>';
				}


				
				?>
					<tr>
						<td><?php echo esc_html( $i ); ?></td>
						<td><?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_full_name', true ) );  ?></td>
						<td><?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ) );  ?></td>
						<td><?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_mobile', true ) );  ?></td>
						<td><?php echo esc_html( $countryname );  ?></td>
						<td><?php echo esc_html( $statename );  ?></td>
						<td><?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_city', true ) );  ?></td>
						<td class="text-center">
							<i class="fa fa-eye donor-preview open-popup-link" href="#tbleuser<?php echo esc_attr( $user->ID ); ?>"></i>
						</td>
					</tr>
					<!-- Modal -->
					<div id="tbleuser<?php echo esc_attr( $user->ID ); ?>" class="white-popup mfp-hide">
						<div  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="popupContentWrapper" role="document">
			
							    <div class="modal-body">
									<div class="donor-profile">
										<div class="donor-img">
										<?php if(idonate_profile_img( $user->ID )) : ?>
						<?php 
						echo idonate_profile_img( $user->ID );
						?>
						<?php else : ?>
							<img src="<?php 
							echo plugin_dir_url( __DIR__ ).'img/donorplaceholder.jpeg'?>"/>
						<?php endif; ?>
										</div>
										<div class="modalContentDetails">
										<div class="personal-info text-center">
											<h3><?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?></h3>
											<p><?php echo $user->user_email; ?></p>
											<p><?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?></p>
											<p><span class="<?php echo esc_attr( $abclass ); ?>"><?php echo esc_html( $av ).wp_kses_post( $signal ) ; ?></span></p>
											<p><?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?></p>
										</div>
										<div class="address text-center">
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
											<?php 
											if( $countryname ):
											?>
											<p><strong><?php esc_html_e( 'Country :', 'idonate' ); ?></strong> <?php echo esc_html( $countryname ); ?></p>
											<?php 
											endif;
											if( $statename ):
											?>
											<p><strong><?php esc_html_e( 'State :', 'idonate' ); ?></strong> <?php echo esc_html( $statename ) ; ?></p>
											<?php 
											endif;
											?>
											<p><strong><?php esc_html_e( 'City :', 'idonate' ); ?></strong> <?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_city', true ) ) ; ?></p>
											<p><strong><?php esc_html_e( 'Address :', 'idonate' ); ?></strong> <?php echo get_user_meta( $user->ID, 'idonate_donor_address', true ); ?></p>
											
											<p><strong><?php esc_html_e( 'Email :', 'idonate' ); ?></strong> <?php echo $user->user_email; ?></p>
											<?php 
											$fb = get_user_meta( $user->ID, 'idonate_donor_fburl', true );
											$twitter = get_user_meta( $user->ID, 'idonate_donor_twitterurl', true );

											if( $fb || $twitter ) {
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
											}
											?>
										</div>
										</div>
									</div>
								</div>
							
						  </div>
						</div>
					</div>


				<?php 
				endforeach;
				?>
				</tbody>
			</table>
		</div>
		<?php 
		if( !empty( $attr['container'] ) ):
		?>
		</div>
	</div>
</div>
<?php 
endif;

$data = ob_get_clean();

return $data;

}
?>