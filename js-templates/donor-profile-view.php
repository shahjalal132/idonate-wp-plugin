<div class="donorinfo donor-view-wrapper">
	<div class="donor-view-inner">
		<h3><?php esc_html_e( 'Donor Information', 'idonate' ); ?></h3>
		<hr>
		<!-- Personal Info-->
		<# if( data.profilepic ){ #>
		<div class="donor-img">
			<img src="{{data.profilepic}}">
			
		</div>
		<# } #>
		<div class="dp-row">
			<label><?php esc_html_e( 'Full Name', 'idonate' ); ?></label>
			<p>{{data.full_name}}</p>				
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'Gender', 'idonate' ); ?></label>
			<p>{{data.gender}}</p>				
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'Date Of Birth', 'idonate' ); ?></label>
			<p>{{data.date_birth}}</p>				
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'Country', 'idonate' ); ?></label>
			<p>{{data.country}}</p>
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'State', 'idonate' ); ?></label>
			<p>{{data.state}}</p>
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'City', 'idonate' ); ?></label>
			<p>{{data.city}}</p>
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'Address', 'idonate' ); ?></label>
			<p>{{data.address}}</p>
		</div>
		<!-- Blood Info-->
		<div class="dp-row">
			<label><?php esc_html_e( 'Blood Group', 'idonate' ); ?></label>
			<p>{{data.bloodgroup}}</p>
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'Availability to donate blood', 'idonate' ); ?></label>
			<p>{{data.availability}}</p>
		</div>
		<!-- Contct Info-->
		<div class="dp-row">
				<label><?php esc_html_e( 'Mobile Number', 'idonate' ); ?></label>
				<p>{{data.mobile}}</p>
		</div>
		<div class="dp-row">
				<label><?php esc_html_e( 'Land Line Number', 'idonate' ); ?></label>
				<p>{{data.landline}}</p>
		</div>
		<!-- Account Info-->
		<div class="dp-row">
			<label><?php esc_html_e( 'E-Mail ID', 'idonate' ); ?></label>
			<p>{{data.email}}</p>
		</div>
		<div class="dp-row">
			<label><?php esc_html_e( 'User Name', 'idonate' ); ?></label>
			<p>{{data.user_name}}</p>
		</div>
	</div>
</div>
		