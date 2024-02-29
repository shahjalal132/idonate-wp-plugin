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


class Main_MetaBox{
		
		
	public $SetMetaBox;
	public $SetMetaFields = array();
	
	function __construct(){
		add_action( 'add_meta_boxes', array( $this, 'add_new_metabox' ) );
		add_action('save_post', array( $this, 'save_metadata' ) );
		
		
		
	}
	
	public function add_new_metabox(){
		
		$args = $this->SetMetaBox;
		
		// Meta box default argument
		$default = array(
			'uniq_id' 	=> 'post_meta_id',
			'title' 	=> 'Post meta box',
			'callback' 	=> array( $this, 'metabox_html_field' ),
			'type' 		=> array( 'post' ),
		);
		
		$args = wp_parse_args( $args, $default );
		
		foreach( $args['type'] as $screen ){
		
			add_meta_box(
				$args['uniq_id'],	// Uniq ID
				$args['title'],	// Box Title
				$args['callback'],	// Content Callback
				$screen	// Post Type
			);
		
		}
		
	}
	
	// Content callback
	public function metabox_html_field(){
		
			foreach( $this->SetMetaFields as $fieldtype ){
					
				switch( $fieldtype['type'] ){
					case 'text':
					case 'number':
						tatCmf_text_field( $fieldtype );
						break;
					case 'textarea':
						tatCmf_textarea_field( $fieldtype );
						break;
				}
				
			}
			
			
		
	}

	// Save Data
	public function save_metadata( $post_id ){
				
		foreach( $this->SetMetaFields as $fieldname ){
			
			if( isset( $_POST[$fieldname['id']] ) ){
			
			update_post_meta(
				$post_id,
				$fieldname['id'],
				$_POST[$fieldname['id']]
			);
			
			}
		}

		
	}

	

	
	
}

?>