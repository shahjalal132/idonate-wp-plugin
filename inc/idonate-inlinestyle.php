<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
} 
 /**
  * 
  * @package    iDonate - blood donor management system WordPress Plugin
  * @version    1.0
  * @author     ThemeAtelier
  * @Websites: https://themeatelier.net/
  *
  */


// enqueue css
function idonate_inline_custom_css(){
    
		$option = get_option( 'idonate_displayset_option_name' );
		
		$maincolor = '#ef1414';
		if( !empty( $option['donor_maincolor'] ) ){
			$maincolor = $option['donor_maincolor'];
		}

		//
		$formbgcolor = '';
		if( !empty( $option['donor_formbgcolor'] ) ){
			$formbgcolor = $option['donor_formbgcolor'];
		}
		//
		$bordercolor = '';
		if( !empty( $option['donor_bordercolor'] ) ){
			$bordercolor = $option['donor_bordercolor'];
		}
		//
		$textcolor = '';
		if( !empty( $option['donor_textcolor'] ) ){
			$textcolor = $option['donor_textcolor'];
		}
		
		wp_enqueue_style( 'idonate-color-schemes', IDONATE_DIR_URL.'/css/color-schemes.css' );
		
        $customcss ="
			.request-form .btn-default:focus,
			.request-form .btn-default:hover,
			.btn-default:focus,
			.single-request .btn-default:hover,
			.request-single-page .infotable span:before,
			.request-single-page .infotable span:after,
			.infotable .idonate-social-icons ul li a,
			.popupContentWrapper,
			.btn-area-bprof a,
			.dataTables_wrapper .dataTables_paginate a.paginate_button.current, 
			.dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover,
			.btn-primary:not(:disabled):not(.disabled).active, 
			.btn-primary:not(:disabled):not(.disabled):active, 
			.idonate-login .button:hover,
			.show>.btn-primary.dropdown-toggle,
			.donors-info .btn.btn-primary:hover,
			.donor-search .btn.btn-primary,
			.donor-table .btn-info:hover,
			.btn-area a,
			.idonate-pagination a.page-numbers:hover,
			.btn-default:hover{
				background-color: {$maincolor};
			}
			.dataTables_wrapper .dataTables_paginate a.paginate_button.current, 
			.dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover,
			.btn-primary:not(:disabled):not(.disabled).active, 
			.btn-primary:not(:disabled):not(.disabled):active, 
			.show>.btn-primary.dropdown-toggle,
			.idonate-login .button,
			.request-form .btn-default,
			.btn-default,
			.request-form .btn-default:focus,
			.request-form .btn-default:hover,
			.donors-info .btn.btn-primary,
			.donor-search .btn.btn-primary,
			.btn-default:focus,
			.donors .modal-header .close,
			.donor-table .btn-info,
			.single-request .btn-default,
			.btn-default:hover {
				border-color: {$maincolor};
			}
			.donor-preview:hover,
			.request-info .fa,
			.request-single-page .infotable  span,
			.single-statistics {
				color: {$maincolor};
			}
			.request-form{
				background-color: {$formbgcolor};
			}
			.address p {
				border-color: {$bordercolor};
			}
			.request-form #donorPanelForm label,
			.idonate-login label {
				color: {$textcolor};
			}
        ";
       
    wp_add_inline_style( 'idonate-color-schemes', $customcss );
    
}
add_action( 'wp_enqueue_scripts', 'idonate_inline_custom_css' );