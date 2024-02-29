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



	// Metabox fields object  Blood Request
	function metabox_field_obj(){
		
		return $obj = new Main_MetaBox();
		
	}
	
	// Prefix
	$prefix = 'idonate';
	
	// Init meta object
	$obj = metabox_field_obj();
	
	// Meta Box Create
	$obj->SetMetaBox = array(
		'uniq_id' 	=> 'blood_request_meta',
		'title' 	=> 'Request Info',
		'type' 		=> array( 'blood_request' ),
	);
	
	// Meta Fields
	$obj->SetMetaFields = array( 

		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'patient_name',
			'label' => esc_html__( 'Patient Name', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'patient_bloodgroup',
			'label' => esc_html__( 'Patient Blood Group', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'patient_age',
			'label' => esc_html__( 'Patient Age', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'patient_bloodneed',
			'label' => esc_html__( 'When Need Blood', 'idonate' ),
		),
		array(
			'type' 	=> 'number',
			'id' 	=> $prefix.'patient_bloodunit',
			'label' => esc_html__( 'Blood Units', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'patient_mobnumber',
			'label' => esc_html__( 'Mobile Number', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'hospital_name',
			'label' => esc_html__( 'Hospital Name', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'location',
			'label' => esc_html__( 'Location', 'idonate' ),
		),
		array(
			'type' 	=> 'text',
			'id' 	=> $prefix.'purpose',
			'label' => esc_html__( 'Purpose', 'idonate' ),
		),
		array(
			'type' 	=> 'textarea',
			'id' 	=> $prefix.'details',
			'label' => esc_html__( 'Details', 'idonate' ),
		),

	);
	


?>