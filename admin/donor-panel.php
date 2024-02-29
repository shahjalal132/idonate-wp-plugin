<?php
/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */




$obj = new TaT_Donor();
?>

<div class="donor-panel">
	<?php
	// Response
	if ( isset( $_POST['donor_submit'] ) ) {
		$res = idonate_donor_add();
		echo idonate_response_msg( $res, 'add' );

	}
	if ( isset( $_POST['donorupdate_submit'] ) ) {
		$res = idonate_donor_edit();
		echo idonate_response_msg( $res, 'update' );
	}
	if ( isset( $_GET['action'] ) ) {
		echo idonate_response_msg( intval( $_GET['action'] ), 'delete' );
	}

	$generalOpt = get_option( 'idonate_general_option_name' );
	?>
	<div class="admin-donor-add">
		<div id="abc">
			<div id="donorPanelForm">
				<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
					<div class="close" onclick="div_hide()">X</div>
					<h3>
						<?php esc_html_e( 'Blood Donors Register', 'idonate' ); ?>
					</h3>
					<hr>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Full Name', 'idonate' ); ?>
							</label>
							<input id="full_name" name="full_name" placeholder="Name" type="text">
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Blood Group', 'idonate' ); ?>
							</label>
							<select name="bloodgroup">
								<option value="Select">
									<?php esc_html_e( '-----Select-----', 'idonate' ); ?>
								</option>
								<?php
								$GetBloodGroup = idonate_blood_group();
								$options       = '';
								foreach ( $GetBloodGroup as $bloodgroup ) {
									$options .= '<option value="' . esc_attr( $bloodgroup ) . '">' . esc_html( $bloodgroup ) . '</option>';
								}
								echo $options;
								?>
							</select>
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Gender', 'idonate' ); ?>
							</label>
							<select id="gender" class="form-control gender" name="gender">
								<option value="Male">
									<?php esc_html_e( 'Male', 'idonate' ); ?>
								</option>
								<option value="Female">
									<?php esc_html_e( 'Female', 'idonate' ); ?>
								</option>
								<option value="Other">
									<?php esc_html_e( 'Other', 'idonate' ); ?>
								</option>
							</select>
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Date Of Birth', 'idonate' ); ?>
							</label>
							<input id="datebirth" name="date_birth" class="form-control"
								placeholder="<?php esc_html_e( 'Date Of Birth', 'idonate' ); ?>" type="text">
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Mobile Number', 'idonate' ); ?>
							</label>
							<input id="mobile" name="mobile"
								placeholder="<?php esc_attr_e( 'Mobile Number', 'idonate' ); ?>" type="text">
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Land Line Number', 'idonate' ); ?>
							</label>
							<input id="landline" name="landline"
								placeholder="<?php esc_attr_e( 'Land Line Number', 'idonate' ); ?>" type="text">
						</div>
					</div>
					<?php
					if ( !empty( $generalOpt['idonate_countryhide'] ) ) :
						?>
						<div class="dp-row">
							<div class="dp-col-6">
								<label>
									<?php esc_html_e( 'Select Country', 'idonate' ); ?>
								</label>
								<select id="country" class="form-control country" name="country">
									<?php
									echo idonate_countries_options();
									?>
								</select>
							</div>
							<div class="dp-col-6">
								<label>
									<?php esc_html_e( 'Select State', 'idonate' ); ?>
								</label>
								<select class="form-control state" id="state" name="state">
									<option>
										<?php esc_html_e( 'Select Country First', 'idonate' ); ?>
									</option>
								</select>
							</div>
						</div>
					<?php
					endif;
					?>
					<div class="dp-row">
						<div class="dp-col-12">
							<label>
								<?php esc_html_e( 'City', 'idonate' ); ?>
							</label>
							<input id="city" name="city" placeholder="<?php esc_attr_e( 'City', 'idonate' ); ?>"
								type="text">
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-12">
							<label>
								<?php esc_html_e( 'Address', 'idonate' ); ?>
							</label>
							<textarea rows="4" name="address" class="form-control"></textarea>
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'E-Mail ID', 'idonate' ); ?>
							</label>
							<input id="email" name="email" placeholder="<?php esc_attr_e( 'E-Mail', 'idonate' ); ?>"
								type="text">
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'User Name', 'idonate' ); ?>
							</label>
							<input id="user_name" name="user_name"
								placeholder="<?php esc_attr_e( 'User Name', 'idonate' ); ?>" type="text">
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Password', 'idonate' ); ?>
							</label>
							<input id="password" name="password"
								placeholder="<?php esc_attr_e( 'Password', 'idonate' ); ?>" type="text">
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Re-type Password', 'idonate' ); ?>
							</label>
							<input id="retypepassword" name="retypepassword"
								placeholder="<?php esc_attr_e( 'Re-type Password', 'idonate' ); ?>" type="text">
						</div>
					</div>
					<div class="dp-row">
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Please confirm your availability to donate blood', 'idonate' ); ?>
							</label>
							<select class="form-control" name="availability">
								<option value="Select">
									<?php esc_html_e( '-----Select-----', 'idonate' ); ?>
								</option>
								<option value="available">
									<?php esc_html_e( 'Available', 'idonate' ); ?>
								</option>
								<option value="unavailable">
									<?php esc_html_e( 'Unavailable', 'idonate' ); ?>
								</option>
							</select>
						</div>
						<div class="dp-col-6">
							<label>
								<?php esc_html_e( 'Upload Profile Picture', 'idonate' ); ?>
							</label>
							<input type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
							<img class="upload-preview" src="http://placehold.it/180" alt="your image" />
						</div>
					</div>
					<?php
					// WP Nonce
					wp_nonce_field( 'request_nonce_action', 'request_submit_nonce_check' );
					?>
					<input class="submit" type="submit" name="donor_submit" value="Submit" />
				</form>
			</div>
		</div>
		<button id="popup" onclick="div_show()">
			<?php esc_html_e( 'Add New', 'idonate' ); ?>
		</button>
	</div>
	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>
					<?php esc_html_e( 'ID', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Name', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Blood Group', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Availability', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Mobile No', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'State', 'idonate' ); ?>
				</th>
				<th>
					<?php esc_html_e( 'Action', 'idonate' ); ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$args  = array(
				'role' => 'donor',
			);
			$users = get_users( $args );

			?>

			<?php
			$i = 0;
			foreach ( $users as $user ) :
				$countrycode = get_user_meta( $user->ID, 'idonate_donor_country', true );
				$stateCode   = get_user_meta( $user->ID, 'idonate_donor_state', true );

				$statename = idonate_states_name_by_code( $countrycode, $stateCode );

				?>
				<tr>
					<td>
						<?php echo esc_html( $i ); ?>
					</td>
					<td>
						<?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?>
					</td>
					<td>
						<?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?>
					</td>
					<td>
						<?php echo get_user_meta( $user->ID, 'idonate_donor_availability', true ); ?>
					</td>
					<td>
						<?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?>
					</td>
					<td>
						<?php echo $statename; ?>
					</td>
					<td>
						<a class="btn btn-primary dedit" onclick="div_donor_show()" data-donor-view="1"
							data-donor-id="<?php echo esc_attr( $user->ID ); ?>">View</a>
						<a class="btn btn-primary dedit" onclick="div_donor_show()" data-donor-edit="1"
							data-donor-id="<?php echo esc_attr( $user->ID ); ?>">Edit</a>
						<a class="btn btn-primary dedit" onclick="div_donor_show()" data-donor-delete="1"
							data-donor-id="<?php echo esc_attr( $user->ID ); ?>">Delete</a>
					</td>
				</tr>
				<?php
				$i++;
			endforeach;
			?>
		</tbody>
	</table>



</div>