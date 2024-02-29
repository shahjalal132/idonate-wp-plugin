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
  
// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}

idonate_is_user_logged_in();

$formText = textset_option();

if( !empty( $text = $formText['donor_lft'] ) ){
	$formText = $text;
}else{
	$formText = __( 'Donor Login', 'idonate' );
}


get_header();
?>

<div class="container">
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="request-form">
				<div id="donorPanelForm" class="idonate-login">
					<h3><?php echo esc_html( $formText ); ?></h3>
					<hr>
					<?php 
					$args = array( 
						'id_username' => 'user',
						'id_password' => 'pass',
					);
					wp_login_form($args);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php 
get_footer();
?>