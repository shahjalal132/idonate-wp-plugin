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

if( !class_exists( 'TaT_Enqueue' ) ){
	
	class TaT_Enqueue{
		
		public function __construct( $args = array() ){
		
			add_action( 'wp_enqueue_scripts', array( $this, 'tal_frontend_enqueue_scripts' ) );
			
			if( ( isset( $_GET['page'] ) && $_GET['page'] == 'idonate-setting-admin' ) ||
			( isset( $_GET['page'] ) && $_GET['page'] == 'idonate-donor' ) ){
				add_action( 'admin_enqueue_scripts', array( $this, 'tal_admin_enqueue_scripts' ) );
			}
			
		}
		// Front-End enqueue scripts
		public function tal_frontend_enqueue_scripts(){
			
			$option = get_option( 'idonate_general_option_name' );
					
			// style
			if(  !empty( $option['load_bootstrap'] )  ){
				
				wp_enqueue_style( 'bootstrap', IDONATE_DIR_URL.'css/bootstrap.min.css', array(), '4.0.0', false );
			}
			if( !empty( $option['load_fontawesome'] ) ){
				wp_enqueue_style( 'font-awesome', IDONATE_DIR_URL.'css/font-awesome.min.css', array(), '1.0', false );
			}
			
			wp_enqueue_style( 'select2', IDONATE_DIR_URL.'css/select2.min.css', array(), '1.0', false );
			
			wp_enqueue_style( 'magnific-popup', IDONATE_DIR_URL.'css/magnific-popup.css', array(), '2.3.1', false );

			wp_enqueue_style( 'idonate', IDONATE_DIR_URL.'css/idonate.css', array(), '1.0', false );
			
			// Jquery ui css
			wp_enqueue_style('jquery-ui', IDONATE_DIR_URL.'css/jquery-ui.min.css', array(), '1.12.1', false ); 

			wp_enqueue_style( 'datatables', IDONATE_DIR_URL.'css/datatables.css', array(), '1.0', false );
			
			// Scripts
			if(  !empty( $option['load_bootstrap'] )  ){
			wp_enqueue_script( 'bootstrap', IDONATE_DIR_URL.'js/bootstrap.min.js', array('jquery'), '4.0.0', true );
			}
			wp_enqueue_script( 'select2', IDONATE_DIR_URL.'js/select2.min.js', array('jquery'), '3.7.7', true );
			// recaptcha
			if( !empty( $option['idonate_recaptcha_active'] ) ){
				wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', array('jquery' ), '1.0', true );
			}
						
			wp_enqueue_script( 'magnific-popup', IDONATE_DIR_URL.'js/jquery.magnific-popup.js', array('jquery' ), '2.3.1', true );

			wp_enqueue_script( 'datatables', IDONATE_DIR_URL.'js/datatables.min.js', array('jquery' ), '1.0', true );
			
			wp_enqueue_script( 'idonate-min', IDONATE_DIR_URL.'js/idonate-min.js', array('jquery','jquery-ui-datepicker'), '3.7.7', true );
			
			$data = array(
				'statesurl' => admin_url('admin-ajax.php')
			);
			
			wp_localize_script(
				'idonate-min',
				'localData',
				$data
			
			);
			
		}
		// Admin enqueue scripts
		public function tal_admin_enqueue_scripts(){
			
			// style			
			wp_enqueue_style('jquery-ui', IDONATE_DIR_URL.'css/jquery-ui.min.css', array(), '1.12.1', false ); 
			wp_enqueue_style( 'bootstrap', IDONATE_DIR_URL.'/css/bootstrap.min.css', array(), '3.7.7', false );
			wp_enqueue_style( 'select2', IDONATE_DIR_URL.'/css/select2.min.css', array(), '1.0', false );
			wp_enqueue_style( 'idonate-admin', IDONATE_DIR_URL.'/css/idonate-admin.css', array(), '1.0', false );
			wp_enqueue_style( 'datatables', IDONATE_DIR_URL.'/css/datatables.css', array(), '1.0', false );
			
			wp_enqueue_style( 'wp-color-picker' );
			// Underscore.js enqueue
			wp_enqueue_script( 'wp-util' );
			 
			wp_enqueue_script( 'bootstrap', IDONATE_DIR_URL.'/js/bootstrap.min.js', array('jquery'), '3.7.7', true );
			wp_enqueue_script( 'select2', IDONATE_DIR_URL.'/js/select2.min.js', array('jquery' ), '1.0', true );
			wp_enqueue_script( 'datatables', IDONATE_DIR_URL.'/js/datatables.min.js', array('jquery' ), '1.0', true );
			wp_enqueue_script( 'idonate-admin', IDONATE_DIR_URL.'/js/idonate-admin.js', array('jquery', 'wp-color-picker','jquery-ui-datepicker' ), '1.0', true );
			

			// Scripts
			
			$data = array(
				'statesurl' => admin_url('admin-ajax.php')
			);
			
			wp_localize_script(
				'idonate-admin',
				'localData',
				$data
			
			);
			
			
		}
		
		
	}
	$obj = new TaT_Enqueue();
}


?>