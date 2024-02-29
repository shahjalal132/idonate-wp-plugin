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

  
	add_action( 'admin_enqueue_scripts', 'tatcmf_admin_scripts' );
  
	function tatcmf_admin_scripts(){
	  
	  wp_enqueue_style( 'tatcmf-style', IDONATE_DIR_URL.'inc/meta-fields/css/tatcmf-style.css', array(), '1.0', false  );
	  
	}
  
?>