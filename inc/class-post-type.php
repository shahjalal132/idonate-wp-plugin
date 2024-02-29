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

if( !class_exists( 'TaT_Posttype' ) ){
	
	class TaT_Posttype{
		
		public $post_type_name;
		public $reg_type_name;
		public $pluralName;
		public $singularName;
		public $labels;
		public $args;
		public $prefix;
		public $textdom;
		
		
		public function __construct( $args = array() ){
			
			//
			$default = array(
				'post_type'		 => '',
				'plural_name'    => '',
				'singular_name'  => '',
				'args'       	 => array(),
				'labels'     	 => array(),
				'prefix'     	 => '',
				'textdomain' 	 => 'textdomain',
			);
			
			$args = wp_parse_args( $args, $default );
			
			//
			
			$this->post_type_name = self::tal_postTypeName_prepare( $args['post_type'] );
			$this->labels   	  = $args['labels'];
			$this->pluralName     = $args['plural_name'];
			$this->singularName   = $args['singular_name'];
			$this->args     	  = $args['args'];
			$this->prefix   	  = $args['prefix'];
			$this->textdom  	  = $args['textdomain'];
			$prefix 			  = $this->prefix;
			
			// check prefix
			if( $prefix ){
				$this->reg_type_name = $prefix .'_'.$this->post_type_name;
			}else{
				$this->reg_type_name = $this->post_type_name;
			}
			
			// post type initialize
			if( !post_type_exists( $this->post_type_name ) ){
				
				add_action( 'init', array( $this, 'tal_register_post_type' ) );
				
			}
		   
		}
		// Post type register
		public function tal_register_post_type(){
			
			$name = $this->singularName;
			$namePlural = $this->pluralName;
			
			$defaultlabels = array(
				'name'               => esc_html_x( $namePlural, $this->textdom ),
				'singular_name'      => esc_html_x( $name, $this->textdom ),
				'menu_name'          => esc_html_x( $namePlural, $this->textdom ),
				'name_admin_bar'     => esc_html_x( $name, $this->textdom ),
				'add_new'            => esc_html_x( 'Add New', $name, $this->textdom ),
				'add_new_item'       => esc_html__( 'Add New '.$name, $this->textdom ),
				'new_item'           => esc_html__( 'New '.$name, $this->textdom ),
				'edit_item'          => esc_html__( 'Edit '.$name, $this->textdom ),
				'view_item'          => esc_html__( 'View '.$name, $this->textdom ),
				'all_items'          => esc_html__( 'All '.$namePlural, $this->textdom ),
				'search_items'       => esc_html__( 'Search'.$namePlural, $this->textdom ),
				'parent_item_colon'  => esc_html__( 'Parent '.$namePlural.':', $this->textdom ),
				'not_found'          => esc_html__( 'No '.$name.' found.', $this->textdom ),
				'not_found_in_trash' => esc_html__( 'No '.$name.' found in Trash.', $this->textdom )
			);
			
			$labels = wp_parse_args( $this->labels, $defaultlabels );
			
			$defaultargs = array(
				'labels'             => $labels,
				'description'        => esc_html__( 'Description.', $this->textdom ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $this->tal_slug_prepare( $this->reg_type_name ) ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			);
			
			$args = wp_parse_args( $this->args, $defaultargs );
			
			register_post_type( $this->reg_type_name, $args );
			
		}
		
		// register taxonomy 
		public function tal_register_taxonomy( $args = array() ){
		
			$default = array(
				'taxname'   	=> '',
				'plural_name'   => '',
				'singular_name' => '',
				'taxargs'   => array(),
				'taxlabels' => array(),
			);
		
			$args = wp_parse_args(  $args , $default );
		
			if( !empty( $args['taxname'] ) ){
				$singularName = $args['singular_name'];
				$PluralName   = $args['plural_name'];
				$postTypeName = $this->reg_type_name;
				$taxName      = self::tal_postTypeName_prepare( $args['taxname'] );
			}
			
		
			// Add new taxonomy
			$defaultLabels = array(
				'name'              => esc_html_x( $PluralName, $this->textdom ),
				'singular_name'     => esc_html_x( $singularName, $this->textdom ),
				'search_items'      => esc_html__( 'Search '.$PluralName, $this->textdom ),
				'all_items'         => esc_html__( 'All '.$PluralName, $this->textdom ),
				'parent_item'       => esc_html__( 'Parent '.$singularName, $this->textdom ),
				'parent_item_colon' => esc_html__( 'Parent '.$singularName.':', $this->textdom ),
				'edit_item'         => esc_html__( 'Edit '.$singularName, $this->textdom ),
				'update_item'       => esc_html__( 'Update '.$singularName, $this->textdom ),
				'add_new_item'      => esc_html__( 'Add New '.$singularName, $this->textdom ),
				'new_item_name'     => esc_html__( 'New Genre '.$singularName, $this->textdom ),
				'menu_name'         => esc_html__( $PluralName, $this->textdom ),
			);
			//
			$labels = wp_parse_args(  $args['taxlabels'], $defaultLabels );
			
			$defaultArgs = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $this->tal_slug_prepare( $taxName ) ),
			);
			
			$args = wp_parse_args( $args['taxargs'], $defaultArgs );
			
			
			// register taxonomy
			if( ! taxonomy_exists( $taxName ) ){
				
				add_action( 'init',
				
					function() use( $taxName , $postTypeName, $args ){
						
						register_taxonomy( $taxName, $postTypeName, $args );
					}

				);
				
			}else{
			   
				add_action( 'init',
				
					function() use( $taxName , $postTypeName ){
						
						register_taxonomy_for_object_type( $taxName , $postTypeName );
					}

				);
			   
			}
			
		
		}
		
		// Post type name prepare
		private static function tal_postTypeName_prepare( $name ){
			
			$prepare = strtolower( str_replace( ' ', '_', $name ) );
			
			return $prepare;
			
		}
		// Label Plural name
		private static function tal_pluralName( $name ){
			
			$name = self::tal_namePrepare( $name );
			
			$last = substr( $name, -1 );
			
			if( $last == 'y' ){
				
				$cut = substr( $name, 0, 1 );
				
				$pluralName = $cut.'ies';
				
			}else{
				$pluralName = $name.'s';
			}
			
			return $pluralName;
			
		}
		// label name prepare
		private static function tal_namePrepare( $name ){
			
			$namePrepare = ucwords( str_replace( '_', ' ', $name ) );
			
			return $namePrepare;
			
		}
		// slug prepare
		private function tal_slug_prepare( $name ){
			
			$slugPrepare =  str_replace( '_', '-', $name );
			
			return $slugPrepare;
		}
		
		
	}
}
?>