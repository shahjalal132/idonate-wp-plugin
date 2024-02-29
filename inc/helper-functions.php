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

// Create blood request type 
add_action( 'plugins_loaded', 'idonate_blood_request_type' );
function idonate_blood_request_type() {
	
	$args = array(
		'publicly_queryable' => true,
		'menu_icon' 		 => 'dashicons-editor-insertmore',
		'show_ui'       	 => true,
		'show_in_menu'       => false,
		'supports' 			 => array( 'title' )
	);
	
	$args = array(
		'post_type'		 => 'blood_request',
		'plural_name'    => esc_html__( 'Blood Request', 'idonate' ),
		'singular_name'  => esc_html__( 'Blood Request', 'idonate' ),
		'args'       	 => $args,
		'textdomain' 	 => 'idonate',
	);
	
	$object = new TaT_Posttype( $args );
	
}

// Idonate custom meta id callback
function idonate_meta_id( $id = '' ) {
    
    $value = get_post_meta( get_the_ID(), $id, true );
    
    return $value;
}

// Idonate blood request single page table helper
function idonate_blood_request_table( $class ='' ,$label, $val, $html = ''  ) {

	if( ! empty( $html ) ) {
		$val = wp_kses_post( $val );
	} else {
		$val = esc_html( $val );
	}
	
	$html = '';
	
	$html .= '<tr>';
	$html .= '<td class="tbllabel '.esc_attr( $class ).'">'.esc_html( $label ).'</td>';
	$html .= '<td class="'.esc_attr( $class ).'">'.$val.'</td>';
	$html .= '</tr>';
	
	
	return $html;
}
	
// Inline Css callback 
function idonate_inline_css( $css ) {
	
	$inlinestyle = '';
	if( $css ){
		$inlinestyle .= '<script typotica type="text/javascript">';
			$inlinestyle .= '( function($){
				$("head").append( "<style>'.$css.'</style>" );
			})(jQuery);';
		$inlinestyle .= '</script>';
	}
	echo $inlinestyle;
	
}

// Single page template
add_filter( 'single_template', 'idonate_custom_post_type_single_template' );
function idonate_custom_post_type_single_template($single_template) {
     global $post;

     if ($post->post_type == 'blood_request') {
          $single_template = IDONATE_DIR_NAME . '/templates/single-blood_request.php';
     }
     return $single_template;
}


// Template Include
add_filter( 'template_include', 'idonate_custom_post_type_template' );
function idonate_custom_post_type_template( $template ) {
		global $post;
		
		$requestOption = get_option( 'idonate_request_option_name' );
		$donotOption = get_option( 'idonate_pageset_option_name' );
		
		// Request page
		if( ! empty( $requestOption['rp_request_page'] ) ) {
			$requestPage = $requestOption['rp_request_page'];
		}else{
			$requestPage = 'request';
		}
		
		// Request post form page
		if( ! empty( $requestOption['rf_form_page'] ) ) {
			$requestPostPage = $requestOption['rf_form_page'];
		}else{
			$requestPostPage = 'post-request';
		}
		
		// Blood Request
		if( is_page( $requestPage ) ) {
			$template = IDONATE_DIR_NAME . '/templates/blood-request.php';
		}
		// Post blood request
		if( is_page( $requestPostPage ) ) {
			$template = IDONATE_DIR_NAME . '/templates/post-blood-request.php';
		}
		
		
		/*************
			Donor 
		**************/
		
		// Register Donor
		$registerDonor = 'donor-register';
		if( ! empty( $page = $donotOption['donor_register_page'] ) ) {
			$registerDonor = $page;
		}
		
		if( is_page( $registerDonor ) ){
			$template = IDONATE_DIR_NAME . '/templates/register-donor.php';
		}
		// Donor Profile
		$donorProfile = 'donor-profile';
		if( ! empty( $page = $donotOption['donor_profile_page'] ) ) {
			$donorProfile = $page;
		}
		
		if( is_page( $donorProfile ) ){
			$template = IDONATE_DIR_NAME . '/templates/donor-profile.php';
		}
		
		// Donor Profile Edit
		$donorEdit = 'donor-edit';
		if( ! empty( $page = $donotOption['donor_edit_page'] ) ) {
		$donorEdit = $page;
		
		}
		
		if( is_page( $donorEdit ) ){
			$template = IDONATE_DIR_NAME . '/templates/edit-donor.php';
		}
		
		// Show Donor
		$donor = 'donors';
		if( ! empty( $page = $donotOption['donor_page'] ) ) {
			$donor = $page;
		}
		if( is_page( $donor ) ){
			$template = IDONATE_DIR_NAME . '/templates/donors.php';
		}
		
		// Show Login
		$donor = 'donor-login';
		if( ! empty( $page = $donotOption['login_page'] ) ) {
			$donor = $page;
		}
		if( is_page( $donor ) ){
			$template = IDONATE_DIR_NAME . '/templates/donor-login.php';
		}
		
   
   		// Single Donor Template
          
  		$donor = 'donor-info';
		// if( !empty( $page = $donotOption['login_page'] ) ) {
		// $donor = $page;
		// }
		
		if( is_page( $donor ) ){
			$template = IDONATE_DIR_NAME . '/templates/template-user.php';
		}
		return $template;
}


// plugin settings link
add_filter( "plugin_action_links_".IDONATE_BASENAME."", 'idonate_add_settings_link' );
function idonate_add_settings_link( $links ) {
    $settings_link = '<a href="'.esc_url( admin_url('?page=idonate-setting-admin') ).'">' . esc_html__( 'Settings', 'idonate' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}

// Create page when plugin activated
function idonate_create_page_plugin_activated(){
	
	// Default Pages Create
	
	$pages = array(
		'Post Request',
		'Request',
		'Donors',
		'Donor Register',
		'Donor Edit',
		'Donor Login',
		'Donor Profile',
		'Donor Info',
	);
	
	
	foreach( $pages as $page ){
		
		$Requestargs = array(
			'post_type'	  => 'page',
			'post_title'  => wp_strip_all_tags( $page ),
			'post_status' => 'publish',
		);
		
		wp_insert_post( $Requestargs );
		
		
	}
	
	
}
// Delete page when plugin deactivated
function idonate_delete_page_plugin_deactivated(){
	
	// Pages
	$pages = array(
		'post-request',
		'request',
		'donors',
		'donor-register',
		'donor-edit',
		'donor-login',
		'donor-profile',
		'donor-info',
	);
	
	//
	foreach( $pages as $page ){
		$page_data	= get_page_by_path( $page );
		
		wp_delete_post( $page_data->ID );
	}
	
}

/**
 * Embed JS Template With ID
 *
 *
 */

function idonate_get_js_template( $file_path, $id ){
	if( file_exists( $file_path ) ){
		echo '<script type="text/html" id="tmpl-'.esc_attr($id).'">'."\n";
		include_once( $file_path );
		echo '</script>'."\n";
	}
}

/**
 * Blood Group
 *
 */
function idonate_blood_group(){
	
	$blood_group = array(
		'A+',
		'A-',
		'B+',
		'B-',
		'O+',
		'O-',
		'AB+',
		'AB-',
		'A1+',
		'A1-',
		'A1B+',
		'A1B-',
		'A2+',
		'A2-',
		'A2B+',
		'A2B-'
	);
	
	return $blood_group;
	

} 
/**
 * Media Uploader
 *
 */

function idonate_media_upload( $user_id ){
 
	$attachment_id = media_handle_upload( 'profileimg', $user_id );
	//media upload
	update_user_meta( $user_id, 'idonate_donor_profilepic', $attachment_id );
 
}

/**
 * Donor Profile Image
 *
 */
function idonate_profile_img( $id = '' ){

	$attachmentID =  get_user_meta( $id, 'idonate_donor_profilepic', true ); 


	$img = '';
	
	if( ! is_wp_error( $attachmentID ) ){
	
		$img = wp_get_attachment_image( $attachmentID, 'donor-img' );
	}
		
	return $img;

} 

/**
 * Donor login redirect
 **/
function idonate_redirect_login_page( $redirect_to, $request, $user  ) {

	$page = get_option( 'idonate_pageset_option_name' );
	
	$login_page  = '/';
	
	if( !empty( $page = $page['login_redirect'] ) ){
		
		$login_page  = $page;
	}


	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'donor', $user->roles ) ) {
			// redirect them to the default place
			return home_url( $login_page );
		} else {
			return $redirect_to;;
		}
	} else {
		return $redirect_to;
	}


}
add_action('login_redirect','idonate_redirect_login_page', 10, 3 );

/**
 * Donor login failed redirect
 *
 */
function idonate_login_failed() {
	
	$page = get_option( 'idonate_pageset_option_name' );
	
	$login_page  = home_url( '/' );
	
	if( !empty( $page = $page['login_page'] ) ){
		
		$login_page  = home_url( $page );
	}
  
	wp_redirect( $login_page . '?login=failed' );
	exit;
  
}
add_action( 'wp_login_failed', 'idonate_login_failed' );

/**
 * Donor logout redirect
 **/
function logout_page() {
	
	$page = get_option( 'idonate_pageset_option_name' );
	
	$login_page  = home_url( '/' );
	
	if( !empty( $page = $page['logout_redirectpage'] ) ){
		$login_page  = home_url( $page );
	}
	
  
  wp_redirect( $login_page . "?loggedout=true" );
  exit();
}
add_action('wp_logout','logout_page');

/**
 * Profile edit permalink
 **/
function profile_edit_permalink(){
	$page = get_option( 'idonate_pageset_option_name' );
	
	$getpage = 'donor-edit';
	
	if( !empty( $page['donor_edit_page'] ) ){
		$getpage = $page['donor_edit_page'];
	}
	
	
	return $getpage;
	
}
/**
 * profile permalink
 **/
function profile_permalink(){
	$page = get_option( 'idonate_pageset_option_name' );
	
	$getpage = 'donor-profile';
	
	if( !empty( $page['donor_profile_page'] ) ){
		$getpage = $page['donor_profile_page'];
	}
	
	
	return $getpage;
	
}

/**
 * Donor logged in 
 **/
 function idonate_is_user_logged_in(){
	
	if( is_user_logged_in() ){
	
		$page = get_option( 'idonate_pageset_option_name' );
		
		$getpage = 'donor-profile';
		
		if( !empty( $page['donor_profile_page'] ) ){
			$getpage = $page['donor_profile_page'];
		}
		
		wp_redirect( $getpage );
	
	}
 }

/**
 * Check user logged in to donor show
 **/
 function idonate_user_logged_in_donor_show(){
 	$general = get_option( 'idonate_general_option_name' );

 	if( !empty ( $general['idonate_donorshowlogin'] ) ) {

		if( ! is_user_logged_in() ){
			return false;
		}

 	}else {
 		return true;
 	}
	
 }
 
/**
 * Auto request Delete after pass data
 *
 */
 function idonate_auto_request_delete(){
	 
	$args = array(
		'post_type' => 'blood_request',
		'posts_per_page' => '-1'
	);
	
	
	$requests = get_posts( $args );
	
	$currentDate =  strtotime( date( get_option( 'date_format' ), current_time( 'timestamp', 1 ) ) );

	
	foreach( $requests as $request) {
		
		$neededdate = get_post_meta( $request->ID, 'idonatepatient_bloodneed', true );
				
		if( $currentDate > strtotime( $neededdate ) ){

			wp_delete_post( $request->ID ); 
		}

	}

	
 }
 add_action( 'init', 'idonate_auto_request_delete' );

 /**
 * Custom Post pagination
 *
 */
function idonate_pagination( $custom_query ) {

	if( is_front_page() ){
		$paged = 'page';
	}else{
		$paged = 'paged';
	}

	$total_pages = $custom_query->max_num_pages;
	$big = 999999999; // need an unlikely integer

	if ($total_pages > 1){
		$current_page = max(1, get_query_var($paged));
		
		echo '<div class="row"><div class="col-sm-12"><div class="idonate-pagination">';
		echo paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?'.$paged.'=%#%',
			'current' => $current_page,
			'total' => $total_pages,
		));
		echo '</div></div></div>';
	}
}
 /**
 * Donor pagination
 *
 */
function idonate_donor_pagination( $total_users, $number, $paged ) {


	if($total_users > $number):

	  $pl_args = array(
		 'base'     => add_query_arg('paged','%#%'),
		 'format'   => '',
		 'total'    => ceil($total_users / $number),
		 'current'  => max(1, $paged),
	  );

	  // for ".../page/n"
	  if($GLOBALS['wp_rewrite']->using_permalinks())
		$pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)).'page/%#%/', 'paged');
	
	echo '<div class="row"><div class="col-sm-12"><div class="idonate-pagination">';
		echo paginate_links($pl_args);
	echo '</div></div></div>';
	endif;

}

 // Add image size
 add_action( 'after_setup_theme', 'idonate_add_image_size' );
 function idonate_add_image_size(){
	add_image_size( 'donor-img', 360, 240, true );
	add_image_size( 'request--img', 300, 210, true );
 }
?>