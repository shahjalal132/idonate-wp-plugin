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

add_shortcode( 'blood-request' , 'shortcode_blood_request' );
function shortcode_blood_request() {
	
$option = get_option( 'idonate_request_option_name' );

	// Wrapper page
	if( !empty( $option['rp_request_page_wrp_class'] ) ){
		$wrpClass =  $option['rp_request_page_wrp_class'];
	}else{
		$wrpClass = '';
	}

	// request per page
	if( !empty( $option['rp_request_per_page'] ) ){
		$rperpage =  $option['rp_request_per_page'];
	}else{
		$rperpage = '10';
	}

	// Background Color
	if( !empty( $option['rp_page_bgcolor'] ) ){
		$bgColor =  'background-color:'.esc_attr( $option['rp_page_bgcolor'] ).';';
	}else{
		$bgColor = '';
	}

	// Style Tag
	if( $bgColor ){
		$style = 'style="'.$bgColor.'"';
		
	}else{
		$style = '';
	}

	ob_start();
	?>
	<section class="request-page <?php echo esc_attr( $wrpClass ); ?> ptb-80" <?php echo wp_kses_post( $style ); ?>>
		<div class="container">
				<?php 
				if( is_front_page() ){
					
					$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				}else{
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					
				}
				
				$args = array(
					'post_type' => 'blood_request',
					'paged'		=> $paged,
					'posts_per_page' => esc_attr( $rperpage ),
					'meta_key'	=> 'idonate_status',
					'meta_value'	=> '1'
				);
				
				$loop = new WP_Query( $args );
				
				if( $loop->have_posts() ):
					echo '<div class="row">';
				while( $loop->have_posts() ):
					$loop->the_post();
					
				$bgroup 	= idonate_meta_id( 'idonatepatient_bloodgroup' );
				$need 		= idonate_meta_id( 'idonatepatient_bloodneed' );
				$units 		= idonate_meta_id( 'idonatepatient_bloodunit' );
				$mobnumber 	= idonate_meta_id( 'idonatepatient_mobnumber' );

				
				?>
			
				<div class="col-sm-4">
					<div class="single-request">
						<div class="profile">
							<div class="profile-img">
								<?php 
									$option = get_option( 'idonate_request_option_name' );
									if( ! empty( $option['rf_form_img_upload'] ) ) {

										$pic = idonate_meta_id( 'idonate_request_picture' );

										if( !is_wp_error( $pic ) && !empty( $pic ) ) {
											echo wp_get_attachment_image( $pic, 'request--img' );
										} else {
											echo '<img src="'.IDONATE_DIR_URL .'img/heart-01.png"  alt="request image"/>';
										}

									} else {
								?>
								<div class="image">
									<div class="circle-1"></div>
									<div class="circle-2"></div>
									<i class="fa icon fa-heartbeat"></i>
								</div>
								<?php 
								}
								?>
							</div>
							
							<div class="name"><?php the_title(); ?></div>
							<div class="job"><?php echo esc_html__( 'Post Date: ', 'idonate' ).get_the_date(); ?></div>
						</div>
						<div class="request-info-area">					
							<?php 
							// Blood Group
							if( $bgroup ){
								echo '<div class="request-info"><i class="fa fa-object-group"></i>'.esc_html( $bgroup ).'</div>';
							}
							// units
							if( $units ){
								echo '<div class="request-info"><i class="fa fa-tint"></i>'.esc_html__( 'Unit/Bag (S): ', 'idonate' ).esc_html( $units ).'</div>';
							}
							// When Need
							if( $need ){
								echo '<div class="request-info"><i class="fa fa-calendar"></i>'.esc_html( $need ).'</div>';
							}
							// Mobile Number
							if( $mobnumber ){
								echo '<div class="request-info"><i class="fa fa-mobile"></i>'.esc_html( $mobnumber ).'</div>';
							}
							
							?>			
						</div>
						<a href="<?php the_permalink(); ?>" class="btn-default btn"><?php esc_html_e( 'Details', 'idonate' ); ?></a>
					</div>

				</div>
				<?php 
				endwhile;
				echo '</div>';
				idonate_pagination($loop);
				wp_reset_postdata();
				endif;
				?>
		</div>
	</section>
	<?php

	return ob_get_clean();
}