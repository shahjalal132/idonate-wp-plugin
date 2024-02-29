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

if( !class_exists( 'TaT_Donor' ) ){
	
	class TaT_Donor{
		
		public function __construct( ){
			
			add_action( 'admin_footer', array( $this, 'donor_noform_popup' ) );
			add_action( 'admin_footer', array( $this, 'jstmpl_donor_profile_view' ) );
			add_action( 'admin_footer', array( $this, 'jstmpl_donor_profile_edit' ) );
			add_action( 'admin_footer', array( $this, 'jstmpl_donor_profile_delete' ) );
		

		}
		
		public function donor_noform_popup(){
			include_once( IDONATE_DIR_PATH.'js-templates/modal-noform-popup.php' );
			
		}
		
		public function donor_form_popup(){
			include_once( IDONATE_DIR_PATH.'js-templates/modal-form-popup.php' );
			
		}
		public function jstmpl_donor_profile_view(){
			idonate_get_js_template( IDONATE_DIR_PATH.'js-templates/donor-profile-view.php', 'donor-view-template' );
		}
		
		public function jstmpl_donor_profile_edit(){
			idonate_get_js_template( IDONATE_DIR_PATH.'js-templates/donor-profile-edit.php', 'donot-edit-template' );
		}
		
		public function jstmpl_donor_register(){
			idonate_get_js_template( IDONATE_DIR_PATH.'js-templates/donor-profile-register.php', 'donor-register-template' );
		}
		
		public function jstmpl_donor_profile_delete(){
			idonate_get_js_template( IDONATE_DIR_PATH.'js-templates/donor-profile-delete.php', 'donor-delete-template' );
		}

		
	}
	
}








?>