<?php 
$generalOpt = get_option( 'idonate_general_option_name' );
?>
<!-- Contact Us Form -->
<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
	<h3><?php esc_html_e( 'Donor Edit', 'idonate' ); ?></h3>
	<hr>

	<div class="dp-row">
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Full Name', 'idonate' ); ?></label>
			<input id="full_name" name="full_name" value="{{data.full_name}}" placeholder="Name" type="text">
		</div>
		<div class="dp-col-6" data-select="{{data.bloodgroup}}">
			<label><?php esc_html_e( 'Blood Group', 'idonate' ); ?></label>
			<select id="bloodgroup" class="form-control" name="bloodgroup">
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
	<div class="dp-row">
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Gender', 'idonate' ); ?></label>
			<select id="gender" class="form-control gender" name="gender" data-select="{{data.gender}}">
				<option value="Male" <?php echo "{{data.gender == 'Male' ? 'selected' : '' }}" ?> ><?php esc_html_e( 'Male', 'idonate' ); ?></option>
				<option value="Female" <?php echo "{{data.gender == 'Female' ? 'selected' : '' }}" ?> ><?php esc_html_e( 'Female', 'idonate' ); ?></option>
				<option value="Other" <?php echo "{{data.gender == 'Other' ? 'selected' : '' }}" ?>><?php esc_html_e( 'Other', 'idonate' ); ?></option>
			</select>
		</div>
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Date Of Birth', 'idonate' ); ?></label>

			<input id="datebirthedit" name="date_birth" value="{{data.date_birth}}" class="form-control" placeholder="<?php esc_html_e( 'Date Of Birth', 'idonate' ); ?>" type="text">
		</div>
	</div>
	<div class="dp-row">
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Mobile Number', 'idonate' ); ?></label>
			<input id="mobile" name="mobile" placeholder="Mobile Number" value="{{data.mobile}}" type="text">
		</div>
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Land Line Number', 'idonate' ); ?></label>
			<input id="landline" name="landline" placeholder="Land Line Number" value="{{data.landline}}" type="text">
		</div>
	</div>
	<?php 
	if( ! empty( $generalOpt['idonate_countryhide'] ) ) :
	?>
	<div class="dp-row">
		<div class="dp-col-6" data-select="{{data.contycode}}">
			<label><?php esc_html_e( 'Select Country', 'idonate' ); ?></label>
			<select id="country" class="form-control country" name="country">
				<?php 
				echo idonate_countries_options();
				?>
			</select>
		</div>
		<div class="dp-col-6" data-select="{{data.statecode}}">
			<label><?php esc_html_e( 'Select State', 'idonate' ); ?></label>
			<select class="form-control state" id="state" name="state">
				<option><?php esc_html_e( 'Select Country First', 'idonate' ); ?></option>
			</select>
		</div>
	</div>
	<?php 
	endif;
	?>
	<div class="dp-row">
		<div class="dp-col-12">
			<label><?php esc_html_e( 'City', 'idonate' ); ?></label>
			<input id="city" name="city" value="{{data.city}}" placeholder="City" type="text" >
		</div>
	</div>
	<div class="dp-row">
		<div class="dp-col-12">
			<label><?php esc_html_e( 'Address', 'idonate' ); ?></label>
			<textarea rows="4" name="address" class="form-control">{{data.address}}</textarea>
		</div>
	</div>
	
	<div class="dp-row">
		<div class="dp-col-6">
			<label><?php esc_html_e( 'E-Mail ID', 'idonate' ); ?></label>
			<input id="email" name="email" value="{{data.email}}" placeholder="E-Mail" type="text">
		</div>
		<div class="dp-col-6">
			<label><?php esc_html_e( 'User Name', 'idonate' ); ?></label>
			<input id="user_name" name="user_name" value="{{data.user_name}}" placeholder="User Name" type="text" readonly>
		</div>
	</div>
	<div class="dp-row">
		<div class="dp-col-6">
			<label><?php esc_html_e( 'New Password', 'idonate' ); ?></label>
			<input id="password" name="newpassword" placeholder="New Password" type="text">
		</div>
		<div class="dp-col-6">
			<label><?php esc_html_e( 'Re-type New Password', 'idonate' ); ?></label>
			<input id="retypepassword" name="retypenewpassword" placeholder="Re-type New Password" type="text">
		</div>
	</div>
	<div class="dp-row">
		<div class="dp-col-6" data-select="{{data.availability}}">
			<label><?php esc_html_e( 'Please confirm your availability to donate blood', 'idonate' ); ?></label>
			<select class="form-control" name="availability">
				<option value="Select"><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
				<option value="available"><?php esc_html_e( 'Available', 'idonate' ); ?></option>
				<option value="unavailable"><?php esc_html_e( 'Unavailable', 'idonate' ); ?></option>
			</select>
		</div>
		<div class="dp-col-6">
			<# 
			var img = 'http://placehold.it/180';
			if( data.profilepic ){
				img = data.profilepic
			}
			
			#>
		
			<label><?php esc_html_e( 'Upload Profile Picture', 'idonate' ); ?></label>
			<input type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
			
			<img class="upload-preview" src="{{img}}" alt="your image" />
		</div>
	</div>
	<?php 
	// WP Nonce
	wp_nonce_field( 'request_nonce_action', 'request_submit_nonce_check' );
	?>	
	<input type="hidden" name="donor_id" value="{{data.id}}" />
	<input class="submit" type="submit" name="donorupdate_submit" value="Submit" />
</form>
			