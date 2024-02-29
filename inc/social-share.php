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
 
// share button code
function idonate_social_sharing_buttons( $title = '', $url = ''  ) {
    
    // Get page URL 
    
    if( ! empty( $url ) ) {
      $URL = $url;
    } else {
      $URL = get_permalink();
    }

    $Sitetitle = get_bloginfo('name');
    // Get page title
    
    if( ! empty( $title ) ) {
      $Title = $title;
    } else {
      $Title = str_replace( ' ', '%20', get_the_title());
    }

    
    
    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/intent/tweet?text='.esc_html( $Title ).'&amp;url='.esc_url( $URL ).'&amp;via='.esc_html( $Sitetitle );
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.esc_url( $URL );
     
    // Add sharing button at the end of page/page content
    $content  = '<div class="idonate-social-icons"><span><i class="fa fa-share"></i> </span>';
    $content  .= '<ul>';
    $content .= '<li class="twitter"><a href="'. esc_url( $twitterURL ) .'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
    $content .= '<li class="facebook"><a href="'.esc_url( $facebookURL ).'" target="_blank"><i class="fa fa-facebook"></i></a></li>';
    $content .= '</ul>';
    $content .= '</div>';
    
    echo $content;

};
