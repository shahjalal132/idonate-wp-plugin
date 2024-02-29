<?php 
if( !class_exists('Idonate_DashboardWidgets') ){
class Idonate_DashboardWidgets{
	
	function __construct(){
		
		add_action( 'wp_dashboard_setup', array( $this, 'add_donor_panding_widget' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_blood_request_panding_widget' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_statistics_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dashboard_scripts' ) );
		add_action( 'wp_ajax_panding_donor_action', array( $this, 'panding_donor_action' ) );
		add_action( 'wp_ajax_nopriv_panding_donor_action', array( $this, 'panding_donor_action' ) );
		add_action( 'wp_ajax_panding_blood_request_action', array( $this, 'panding_blood_request_action' ) );
		add_action( 'wp_ajax_nopriv_panding_blood_request_action', array( $this, 'panding_blood_request_action' ) );
	}
	
	// 
	public static function add_dashboard_widgets( $widget_slug, $widget_title, $widget_callback ){
		wp_add_dashboard_widget(
                $widget_slug,     // Widget slug.
                $widget_title,    // Title.
                $widget_callback // Display function.
        );	
	}

	// Statistics Widget
	public function add_statistics_widget(){
		self::add_dashboard_widgets( 'idonate-statistics', 'Idonate Statistics', array( $this, 'idonate_statistics_callback' ) );
	}
	// Panding Donor callback
	public function idonate_statistics_callback () {

		// Total Donor
		$totalUser = count_users();
		$totalDonor = !empty( $totalUser['avail_roles']['donor'] ) ? $totalUser['avail_roles']['donor'] : '';
		
		// Total Current Blood request
		$totaRequest = wp_count_posts('blood_request'); 

		// Active User
		$args = array(
			'meta_key' => 'idonate_donor_availability',
			'meta_value' => 'available',
		);

		$activeDonor = get_users( $args );
		$totalActiveDonor =  !empty( $activeDonor ) ? count( $activeDonor ) : '';

		?>
		<div class="statistics-wrap">
			<ul>
				<li><span class="dashicons dashicons-groups"></span> <span class="right"><?php esc_html_e( 'Total Donor : ', 'idonate' ); echo esc_html( $totalDonor );?></span></li>
				<li><span class="dashicons dashicons-universal-access"></span> <span class="right"><?php esc_html_e( 'Available Donor : ', 'idonate' ); echo esc_html( $totalActiveDonor ) ?></span></li>
				<li><span class="dashicons dashicons-image-filter"></span> <span class="right"><?php esc_html_e( 'Current Request : ', 'idonate' ); echo esc_html( $totaRequest->publish ); ?></span></li>
				
			</ul>
		</div>
		<?php
	}
	// Panding Donor Widget
	public function add_donor_panding_widget(){
		self::add_dashboard_widgets( 'idonate-pdw', 'Pandding Donor List', array( $this, 'panding_donor_callback' ) );
	}
	// Panding Donor callback
	public function panding_donor_callback(){
		echo '<h2 class="panding-list-heading">Donor Panding List</h2>';
				$args = array(
					'role'         => 'donor',
					'meta_key'	   => 'idonate_donor_status',
					'meta_value'   => '0',
					'order'        => 'ASC',
					
				 );
				
				// Get donor
				$users = get_users( $args );
								
				if( is_array( $users ) && count( $users ) > 0 ){
					echo '<ul class="panding-list">';
				foreach( $users as $user ){
						$name = get_user_meta( $user->ID, 'idonate_donor_full_name', true );
							$listid = 'list'.esc_attr( $user->ID );
						echo '<li id="'.esc_attr( $listid ).'" class="list-item" data-listid="#'.esc_attr( $listid ).'"><span>'.esc_html( $name ).'</span><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal'.esc_attr( $user->ID ).'">'.esc_html__( 'Preview', 'idonate' ).'</button>'.$this->donor_modal($user).'</li>';
					}
					echo '</ul>';
				}
	}
	// Panding Blood Request Widget
	public function add_blood_request_panding_widget(){
		self::add_dashboard_widgets( 'idonate-pbrw', 'Panding Blood Request List ', array( $this, 'blood_request_panding_callback' ) );
	}
	// Panding Blood Request callback
	public function  blood_request_panding_callback(){
		echo '<h2 class="panding-list-heading">Blood Request Panding List</h2>';
		
		$args = array(
			'post_type' 	=> 'blood_request',
			'meta_key'		=> 'idonate_status',
			'meta_value'	=> '0'
		);
		
		$loop = new WP_Query( $args );
		
		if( $loop->have_posts() ){
			echo '<ul class="panding-list">';
		while( $loop->have_posts() ){
			$loop->the_post();
				$listid = 'list'.esc_attr( get_the_ID() );
				echo '<li id="'.esc_attr( $listid ).'" data-listid="#'.esc_attr($listid).'" class="list-item"><span>'.esc_html( get_the_title() ).'</span><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal'.esc_attr( get_the_ID() ).'">'.esc_html__( 'Preview', 'idonate' ).'</button>'.$this->blood_request_modal().'</li>';
			}
			echo '</ul>';
		}
	}
	
	// Donor modal
	public function donor_modal( $user ){
		
		$countryCode = get_user_meta( $user->ID, 'idonate_donor_country', true );
		$statecode   = get_user_meta( $user->ID, 'idonate_donor_state', true );
		
		$country = idonate_country_name_by_code( $countryCode );
		
		$state 	 = idonate_states_name_by_code( $countryCode, $statecode );
		
		// availability
		$av = get_user_meta( $user->ID, 'idonate_donor_availability', true );
		
		if( 'available' == $av ){
			$abclass = 'available';
			$signal  = '<i class="fa fa-check"></i>';
		}else{
			$abclass = 'unavailable';
			$signal = '<i class="fa fa-times"></i>';
		}
		ob_start();
		?>
		<!-- Modal -->
		<div class="idonate-dpdw-modal fade" id="modal<?php echo esc_attr( $user->ID ); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="#modal<?php echo esc_attr( $user->ID ); ?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="donor-profile">
						<?php
						$userpic = idonate_profile_img( absint( $user->ID ) );
						if( ! empty( $userpic ) ):
						 ?>
						<div class="donor-img">
							<?php
							echo $userpic;
							?>
						</div>
						<?php 
						endif;
						?>
						<div class="address">
							<p><strong><?php esc_html_e( 'Name : ', 'idonate' ); ?></strong><?php echo get_user_meta( $user->ID, 'idonate_donor_full_name', true ); ?></p>
							<p><strong><?php esc_html_e( 'Gender : ', 'idonate' ); ?></strong><?php echo get_user_meta( $user->ID, 'idonate_donor_gender', true ); ?></p>
							<p><strong><?php esc_html_e( 'Date Of Birth : ', 'idonate' ); ?></strong><?php echo get_user_meta( $user->ID, 'idonate_donor_date_birth', true ); ?></p>
							<p><strong><?php esc_html_e( 'Email : ', 'idonate' ); ?></strong><?php echo $user->user_email; ?></p>
							<p><strong><?php esc_html_e( 'Mobile : ', 'idonate' ); ?></strong><?php echo get_user_meta( $user->ID, 'idonate_donor_mobile', true ); ?></p>
							<p><strong><?php esc_html_e( 'Availability  : ', 'idonate' ); ?></strong><span class="<?php echo esc_attr( $abclass ); ?>"><?php echo esc_html( $av ).wp_kses_post( $signal ) ; ?></span></p>
							<p><strong><?php esc_html_e( 'Blood Group : ', 'idonate' ); ?></strong><?php echo get_user_meta( $user->ID, 'idonate_donor_bloodgroup', true ); ?></p>
						
							<?php 
							$landline = get_user_meta( $user->ID, 'idonate_donor_landline', true );
							if( $landline ):
							?>
							<p><strong><?php esc_html_e( 'Land Line Number :', 'idonate' ); ?></strong> <?php echo $landline; ?></p>
							<?php 
							endif;
							if( $country ):
							?>
							<p><strong><?php esc_html_e( 'Country :', 'idonate' ); ?></strong> <?php echo esc_html( $country ); ?></p>
							<?php 
							endif;
							if( $state ):
							?>
							<p><strong><?php esc_html_e( 'State :', 'idonate' ); ?></strong> <?php echo esc_html( $state ) ; ?></p>
							<?php 
							endif;
							?>
							<p><strong><?php esc_html_e( 'City :', 'idonate' ); ?></strong> <?php echo esc_html( get_user_meta( $user->ID, 'idonate_donor_city', true ) ) ; ?></p>
							<p><strong><?php esc_html_e( 'Address :', 'idonate' ); ?></strong> <?php echo get_user_meta( $user->ID, 'idonate_donor_address', true ); ?></p>
							<p><strong><?php esc_html_e( 'User Name:', 'idonate' ); ?></strong> <?php echo $user->user_login; ?></p>
							<p><strong><?php esc_html_e( 'Email :', 'idonate' ); ?></strong> <?php echo $user->user_email; ?></p>
						</div>
					</div>
				
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn delete btn-default" data-uid="<?php echo esc_attr( $user->ID ); ?>" data-donoraction="delete"><?php esc_html_e( 'Delete', 'idonate' ); ?></button>
				<button type="button" class="btn btn-default" data-uid="<?php echo esc_attr( $user->ID ); ?>" data-donoraction="approve"><?php esc_html_e( 'Approve', 'idonate' ); ?></button>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		return ob_get_clean();
	}
	
	// Blood Request modal
	public function blood_request_modal(  ){
		$bgroup = idonate_meta_id( 'idonatepatient_bloodgroup' );
		$need = idonate_meta_id( 'idonatepatient_bloodneed' );
		$units = idonate_meta_id( 'idonatepatient_bloodunit' );
		$mobnumber = idonate_meta_id( 'idonatepatient_mobnumber' );

		ob_start();
		?>
		<!-- Modal -->
		<div class="idonate-dpdw-modal fade" id="modal<?php echo esc_attr( get_the_ID() ); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="#modal<?php echo esc_attr( get_the_ID() ); ?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="top-info">
					<h4 class="modal-title" id="myModalLabel"><?php the_title(); ?></h4>
					<img width="60" src="<?php echo esc_url( IDONATE_DIR_URL ); ?>img/heart-01.png" />
				</div>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<?php
						// Name
						$name = idonate_meta_id( 'idonatepatient_name' );
						if( $name ){
							echo idonate_blood_request_table( 'info', esc_html__('Patient Name:', 'idonate' ) ,$name );
						}
						// Age
						$age = idonate_meta_id( 'idonatepatient_age' );
						if( $age ){
							echo idonate_blood_request_table( 'info', esc_html__('Patient Age:', 'idonate' ) ,$age );
						}
						// Blood Group
						$bgroup = idonate_meta_id( 'idonatepatient_bloodgroup' );
						if( $bgroup ){
							echo idonate_blood_request_table( 'danger', esc_html__('Blood Group:', 'idonate' ) ,$bgroup );
						}
						// When Need Blood ?
						$need = idonate_meta_id( 'idonatepatient_bloodneed' );
						if( $need ){
							echo idonate_blood_request_table( 'danger', esc_html__('When Need Blood ?:', 'idonate' ) ,$need );
						}
						// Blood Units
						$units = idonate_meta_id( 'idonatepatient_bloodunit' );
						if( $units ){
							echo idonate_blood_request_table( 'danger', esc_html__('Blood Unit / Bag (S):', 'idonate' ) ,$units );
						}
						// Purpose
						$purpose = idonate_meta_id( 'idonatepurpose' );
						if( $purpose ){
							echo idonate_blood_request_table( 'info', esc_html__('Purpose: ', 'idonate' ) ,$purpose );
						}
						// Mobile Number
						$mobnumber = idonate_meta_id( 'idonatepatient_mobnumber' );
						if( $mobnumber ){
							echo idonate_blood_request_table( 'danger', esc_html__('Mobile Number: ', 'idonate' ) ,$mobnumber );
						}
						// Email
						$email = idonate_meta_id( 'idonatepatient_email' );
						if( $email ){
							echo idonate_blood_request_table( 'info', esc_html__('Email: ', 'idonate' ) ,$email );
						}
						// Hospital Name
						$hospital = idonate_meta_id( 'idonatehospital_name' );
						if( $hospital ){
							echo idonate_blood_request_table( 'info', esc_html__('Hospital Name: ', 'idonate' ) ,$hospital );
						}
						// Country
						$countrycode = idonate_meta_id( 'idonatecountry' );
						$country = idonate_country_name_by_code( $countrycode );
						
						if( $country ){
							echo idonate_blood_request_table( 'info', esc_html__('Country: ', 'idonate' ) ,$country );
						}
						// State
						$statecode = idonate_meta_id( 'idonatestate' );
						$state = idonate_states_name_by_code( $countrycode, $statecode );
						if( $state ){
							echo idonate_blood_request_table( 'info', esc_html__('State: ', 'idonate' ) ,$state );
						}
						// City
						$city = idonate_meta_id( 'idonatecity' );
						if( $city ){
							echo idonate_blood_request_table( 'info', esc_html__('City: ', 'idonate' ) ,$city );
						}
						// Location/Address
						$location = idonate_meta_id( 'idonatelocation' );
						if( $location ){
							echo idonate_blood_request_table( 'info', esc_html__('Address:', 'idonate' ) ,$location );
						}
						
						?>
					  </table>
					

				
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default delete" data-uid="<?php echo esc_attr( get_the_ID() ); ?>" data-reqaction="delete"><?php esc_html_e( 'Delete', 'idonate' ); ?></button>
				<button type="button" class="btn btn-default" data-uid="<?php echo esc_attr( get_the_ID() ); ?>" data-reqaction="approve"><?php esc_html_e( 'Approve', 'idonate' ); ?></button>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		return ob_get_clean();
	}
	// enqueue script
	public function dashboard_scripts(){
		wp_enqueue_style( 'dashboard-widget', IDONATE_DIR_URL.'css/idonate-dashboard-widget.css' );
		wp_enqueue_script( 'dashboard-widget', IDONATE_DIR_URL.'js/idonate-dashboard-widget.js', array('jquery'), '1.0', true );
		
		wp_localize_script( 'dashboard-widget', 'idonate_dashboardwidget', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		));
	}
	// Panding donor action ajax
	public function panding_donor_action(){
		$result = '';
		// user status
		if( isset( $_POST['target'] ) && $_POST['target'] == 'delete' ){
			if( isset( $_POST['userid'] ) ){
				$id = wp_delete_user( $_POST['userid']);
				
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'deleted',
						'msg'	 => 'Successfully deleted'
					);
				}
			}
		}elseif( isset( $_POST['target'] ) && $_POST['target'] == 'approve' ){
			if( isset( $_POST['userid'] ) ){
				$id = update_user_meta( $_POST['userid'] , 'idonate_donor_status', esc_attr('1') );
				
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'approved',
						'msg'	 => 'Successfully approved'
					);
				}
			}
		}
		
		if( is_array( $result ) ){
			$result = wp_json_encode( $result );
		}
		
		echo $result;
		 die();
	}
	// Panding blood request action ajax
	public function panding_blood_request_action(){
		
		$result = '';
		// Blood request action
		if( isset( $_POST['target'] ) && $_POST['target'] == 'delete' ){
			if( isset( $_POST['userid'] ) ){
				$id = wp_delete_post( $_POST['userid']);
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'delete',
						'msg'	 => 'Successfully delete'
					);
				}
			}
		}elseif( isset( $_POST['target'] ) && $_POST['target'] == 'approve' ){
			if( isset( $_POST['userid'] ) ){
								
				$id =	update_post_meta( $_POST['userid'], 'idonate_status', '1' );
				
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'approved',
						'msg'	 => 'Successfully approved'
					);
				}
				
			}
		}
		
		if( is_array( $result ) ){
			$result = wp_json_encode( $result );
		}
		
		echo $result;
		
		die();
	}
}

$obj = new Idonate_DashboardWidgets();

}
?>