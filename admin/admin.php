<?php
class Idonate_Settings_Page
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $general_options;
    private $request_options;
    private $pageset_options;
    private $displayset_options;
    private $textset_options;
	
    /**
     * Start up
     */
    public function __construct()
    {
		
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
		add_menu_page(
			esc_html__( 'IDonate Settings Page', 'idonate' ),
			esc_html__( 'IDonate Settings', 'idonate' ),
			'manage_options',
			'idonate-setting-admin',
			array( $this, 'create_admin_page' ),
			'dashicons-universal-access',
			6
		);
		// Add blood request post type into the sub menu of Idonate Settings menu.
		add_submenu_page(
			'idonate-setting-admin',
			esc_html__( 'Blood Request', 'idonate' ),
			esc_html__( 'Blood Request', 'idonate' ),
			'manage_options',
			'edit.php?post_type=blood_request',
			NULL
		);
		// Blood Donor Settings Page.
		add_submenu_page(
			'idonate-setting-admin',
			esc_html__( 'Blood Donor', 'idonate' ),
			esc_html__( 'Blood Donor', 'idonate' ),
			'manage_options',
			'idonate-donor',
			array( $this, 'idonate_donor_settings_page' )
		);
		
		
    }

	
	/**
	 * Donor Admin Page Callback
	 */
	 
	public function idonate_donor_settings_page(){
		//Load donor panel template
		load_template( IDONATE_DIR_PATH .'admin/donor-panel.php' );
	}
	
    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property general option
        $this->general_options = get_option( 'idonate_general_option_name' );
		
		// Set class property  request option
        $this->request_options = get_option( 'idonate_request_option_name' );
		
		// Set class property  page settings option
        $this->pageset_options = get_option( 'idonate_pageset_option_name' );
		
		// Set class property  display settings option
        $this->displayset_options = get_option( 'idonate_displayset_option_name' );
		
		// Set class property  text settings option
        $this->textset_options = get_option( 'idonate_textset_option_name' );
		
        ?>
        <div class="wrap">

            <ul class="settings-menu">
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=general') ); ?>"><?php esc_html_e( 'General', 'idonate' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=request') ); ?>"><?php esc_html_e( 'Blood Request', 'idonate' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=display_settings') ); ?>"><?php esc_html_e( 'Display Settings', 'idonate' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=page_settings') ); ?>"><?php esc_html_e( 'Page Settings', 'idonate' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=text_settings') ); ?>"><?php esc_html_e( 'Text Settings', 'idonate' ); ?></a></li>
			</ul>   

			<?php 
			// add error/update messages
	        
			// check if the user have submitted the settings
			if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated"
			add_settings_error( 'idonate_messages', 'idonate_message', __( 'Settings Saved', 'idonate' ), 'updated' );
			}
			
			// show error/update messages
			settings_errors( 'idonate_messages' );
			?>
            <form class="admin-idonate" method="post" action="options.php">
			
            <?php
                // This prints out all hidden setting fields
               
				if( isset( $_GET['tab'] ) && $_GET['tab'] == 'request' ){
					
					settings_fields( 'idonate_option_group_request' );
					do_settings_sections( 'idonate-request-setting-admin' );
					
					
				}elseif( isset( $_GET['tab'] ) && $_GET['tab'] == 'display_settings' ){
					
					settings_fields( 'idonate_option_group_display_settings' );
					do_settings_sections( 'idonate-displayset-admin' );
					
				}elseif( isset( $_GET['tab'] ) && $_GET['tab'] == 'page_settings' ){
					
					settings_fields( 'idonate_option_group_page_settings' );
					do_settings_sections( 'idonate-pageset-setting-admin' );
					
				}elseif( isset( $_GET['tab'] ) && $_GET['tab'] == 'text_settings' ){
					settings_fields( 'idonate_option_group_text_settings' );
					do_settings_sections( 'idonate-textset-setting-admin' );
				}else{
					// general page
					settings_fields( 'idonate-general-option-group' );
					do_settings_sections( 'idonate-general-setting-admin' );
					
				}
                                
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
	
		// general group register setting
        register_setting(
            'idonate-general-option-group', // Option group
            'idonate_general_option_name', // Option name
            array( $this, 'sanitize_general' ) // Sanitize
        );
		
		// request group register setting
        register_setting(
            'idonate_option_group_request', // Option group
            'idonate_request_option_name', // Option name
            array( $this, 'sanitize_request' ) // Sanitize
        ); 
		
		// display settings group register setting
        register_setting(
            'idonate_option_group_display_settings', // Option group
            'idonate_displayset_option_name', // Option name
            array( $this, 'sanitize_displayset' ) // Sanitize
        );
		
		// page settings group register setting
        register_setting(
            'idonate_option_group_page_settings', // Option group
            'idonate_pageset_option_name', // Option name
            array( $this, 'sanitize_pageset' ) // Sanitize
        ); 
		
		// text settings group register setting
        register_setting(
            'idonate_option_group_text_settings', // Option group
            'idonate_textset_option_name', // Option name
            array( $this, 'sanitize_textset' ) // Sanitize
        );   
		
		
		/**
		 *  Settings Section
		 *
		 **/
		 
		// Idonate General Settings Section
        add_settings_section(
            'setting_section_general', // ID
            'General Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-general-setting-admin' // Page
        );
		
		// Blood Request Settings Section
        add_settings_section(
            'setting_section_request', // ID
            'Blood Request Form Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-request-setting-admin' // Page
        );  
		
		// Donor display settings Section
        add_settings_section(
            'setting_section_displayset', // ID
            'Donor Display Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-displayset-admin' // Page
        );  
		
		// Donor page settings Section
        add_settings_section(
            'setting_section_pageset', // ID
            'Donor Page Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-pageset-setting-admin' // Page
        );  
		
		// Donor Text settings Section
        add_settings_section(
            'setting_section_textset', // ID
            'Donor Text Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-textset-setting-admin' // Page
        );  
		
		/**
		 *  General Settings field
		 *
		 **/
		add_settings_field(
			'load_bootstrap',
			'Load Bootstrap',
			array($this, 'load_bootstrap_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'load_fontawesome',
			'Load Fontawesome',
			array($this, 'load_fontawesome_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'donor_request_status',
			'Blood request post need approve',
			array($this, 'donor_request_status_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'donor_register_status',
			'Donor register need approve',
			array($this, 'donor_register_status_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_active',
			'Form recaptcha active',
			array($this, 'idonate_recaptcha_active_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_secretkey',
			'Recaptcha secret key',
			array($this, 'idonate_recaptcha_secretkey_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_sitekey',
			'Recaptcha site key',
			array($this, 'idonate_recaptcha_sitekey_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'donor_per_page',
			'Donor Per Page',
			array($this, 'donotr_per_page_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
        add_settings_field(
            'donor_view_button',
            'Donor View Details Button',
            array($this, 'donor_view_button_callback'),
            'idonate-general-setting-admin',
            'setting_section_general'
        );
        add_settings_field(
            'idonate_countryhide',
            'Show donor register form country and state field',
            array($this, 'idonate_countryhide_callback'),
            'idonate-general-setting-admin',
            'setting_section_general'
        );
        add_settings_field(
            'idonate_bloodrequestcountryhide',
            'Show blood request form country and state field',
            array($this, 'idonate_bloodrequestcountryhide_callback'),
            'idonate-general-setting-admin',
            'setting_section_general'
        );
        add_settings_field(
            'idonate_donorshowlogin',
            'Need user login to show donor ?',
            array($this, 'idonate_donorshowlogin_callback'),
            'idonate-general-setting-admin',
            'setting_section_general'
        );

        add_settings_field(
            'idonate_country',
            'Use single country',
            array($this, 'idonate_country_callback'),
            'idonate-general-setting-admin',
            'setting_section_general'
        );
		
		/**
		 *  Page Settings field
		 *
		 **/
        add_settings_field(
            'donor_page', 
            'Donor Page', 
            array( $this, 'donor_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'donor_register_page', 
            'Donor Register Page', 
            array( $this, 'donor_register_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'donor_edit_page', 
            'Donor Profile Edit Page', 
            array( $this, 'donor_edit_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'donor_profile_page', 
            'Donor Profile Page', 
            array( $this, 'donor_profile_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'login_page', 
            'Login Page', 
            array( $this, 'login_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'login_redirect', 
            'After Login Redirect Page', 
            array( $this, 'login_redirect_page_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
        add_settings_field(
            'logout_redirectpage', 
            'After Logout Redirect Page', 
            array( $this, 'logout_redirectpage_callback' ), 
            'idonate-pageset-setting-admin', 
            'setting_section_pageset'
        );
		 
		/**
		 *  Text Settings field
		 *
		 **/
        add_settings_field(
            'donor_vmt', 
            'Donor View Modal title', 
            array( $this, 'donor_vmt_callback' ), 
            'idonate-textset-setting-admin', 
            'setting_section_textset'
        );
        add_settings_field(
            'donor_peft', 
            'Donor Profile Edit Form Title', 
            array( $this, 'donor_peft_callback' ), 
            'idonate-textset-setting-admin', 
            'setting_section_textset'
        );
        add_settings_field(
            'donor_prft', 
            'Donor Register Form Title', 
            array( $this, 'donor_prft_callback' ), 
            'idonate-textset-setting-admin', 
            'setting_section_textset'
        );
        add_settings_field(
            'donor_lft', 
            'Donor Login Form Title', 
            array( $this, 'donor_lft_callback' ), 
            'idonate-textset-setting-admin', 
            'setting_section_textset'
        );
		 
		/**
		 *  Display Settings field
		 *
		 **/
        add_settings_field(
            'donor_maincolor', 
            'Main Color', 
            array( $this, 'donor_maincolor_callback' ), 
            'idonate-displayset-admin', 
            'setting_section_displayset'
        );
		add_settings_field(
            'donor_bordercolor', 
            'Main Border Color', 
            array( $this, 'donor_bordercolor_callback' ), 
            'idonate-displayset-admin', 
            'setting_section_displayset'
        );
        add_settings_field(
            'donor_formbgcolor', 
            'Form Background Color', 
            array( $this, 'donor_formbgcolor_callback' ), 
            'idonate-displayset-admin', 
            'setting_section_displayset'
        );
        add_settings_field(
            'donor_textcolor', 
            'Form Text Color', 
            array( $this, 'donor_textcolor_callback' ), 
            'idonate-displayset-admin', 
            'setting_section_displayset'
        );
		
		/**
		 *  Blood request Settings field
		 *
		 **/
        add_settings_field(
            'rf_divider', // ID
            '', // Title 
            array( $this, 'idonate_admin_divider_rf_callback' ), // Callback
            'idonate-request-setting-admin', // Page
            'setting_section_request' // Section           
        );
        add_settings_field(
            'rf_form_title', // ID
            'Request Form Title', // Title 
            array( $this, 'rf_form_title_callback' ), // Callback
            'idonate-request-setting-admin', // Page
            'setting_section_request' // Section           
        );
        add_settings_field(
            'rf_sub_title', 
            'Request Form Sub Title', 
            array( $this, 'rf_sub_title_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rf_btn_label', 
            'Request Form Submit Button Label', 
            array( $this, 'rf_btn_label_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_page', 
            'Request Form Page', 
            array( $this, 'rf_form_page_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rf_form_wrp_class', 
            'Request Form Wrapper Class', 
            array( $this, 'rf_form_wrp_class_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_img_upload', 
            'Image Upload Field Show In Request Form', 
            array( $this, 'rf_form_img_field_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_bgcolor', 
            'Request Form Background Color', 
            array( $this, 'rf_form_bgcolor_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_color', 
            'Request Form Text Color', 
            array( $this, 'rf_form_color_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		// request Page
		add_settings_field(
            'rp_admin_divider', 
            '', 
            array( $this, 'idonate_admin_divider_rp_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
		add_settings_field(
            'rp_request_page', 
            'Blood Request Page', 
            array( $this, 'rp_request_page_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		add_settings_field(
            'rp_request_per_page', 
            'Blood Request Per Page', 
            array( $this, 'rp_request_perpage_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rp_request_page_wrp_class', 
            'Request Page Wrapper Class', 
            array( $this, 'rp_request_page_wrp_class_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rp_page_bgcolor', 
            'Request Page Background Color', 
            array( $this, 'rp_page_bgcolor_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		
    }

    /**
	 * General Tab
	 *
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_general( $input  )
    {
        $new_input = array();
		
		
        if( isset( $input['load_bootstrap'] ) )
            $new_input['load_bootstrap'] = absint( $input['load_bootstrap'] );
		
        if( isset( $input['load_fontawesome'] ) )
            $new_input['load_fontawesome'] = absint( $input['load_fontawesome'] );
		
        if( isset( $input['donor_request_status'] ) )
            $new_input['donor_request_status'] = absint( $input['donor_request_status'] );
		
        if( isset( $input['donor_register_status'] ) )
            $new_input['donor_register_status'] = absint( $input['donor_register_status'] );
		
        if( isset( $input['idonate_recaptcha_active'] ) )
            $new_input['idonate_recaptcha_active'] = absint( $input['idonate_recaptcha_active'] );
		
        if( isset( $input['idonate_recaptcha_secretkey'] ) )
            $new_input['idonate_recaptcha_secretkey'] =  $input['idonate_recaptcha_secretkey'];
		
        if( isset( $input['idonate_recaptcha_sitekey'] ) )
            $new_input['idonate_recaptcha_sitekey'] =  $input['idonate_recaptcha_sitekey'];
		
        if( isset( $input['donor_per_page'] ) )
            $new_input['donor_per_page'] = absint( $input['donor_per_page'] );

        if( isset( $input['donor_view_button'] ) )
            $new_input['donor_view_button'] =  $input['donor_view_button'];
		
        if( isset( $input['idonate_country'] ) )
            $new_input['idonate_country'] =  $input['idonate_country'];

        if( isset( $input['idonate_countryhide'] ) )
            $new_input['idonate_countryhide'] =  $input['idonate_countryhide'];
        
        if( isset( $input['idonate_bloodrequestcountryhide'] ) )
            $new_input['idonate_bloodrequestcountryhide'] =  $input['idonate_bloodrequestcountryhide'];
        
        if( isset( $input['idonate_donorshowlogin'] ) )
            $new_input['idonate_donorshowlogin'] =  $input['idonate_donorshowlogin'];
        	
	
        return $new_input;
    }

    /**
	 * Page Set Tab
	 *
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_pageset( $input  )
    {
        $new_input = array();
		
		
        if( isset( $input['donor_page'] ) )
            $new_input['donor_page'] = sanitize_text_field( $input['donor_page'] );
		
        if( isset( $input['donor_register_page'] ) )
            $new_input['donor_register_page'] = sanitize_text_field( $input['donor_register_page'] );
		
        if( isset( $input['donor_edit_page'] ) )
            $new_input['donor_edit_page'] = sanitize_text_field( $input['donor_edit_page'] );
		
        if( isset( $input['donor_profile_page'] ) )
            $new_input['donor_profile_page'] = sanitize_text_field( $input['donor_profile_page'] );
		
        if( isset( $input['login_page'] ) )
            $new_input['login_page'] = sanitize_text_field( $input['login_page'] );
		
        if( isset( $input['login_redirect'] ) )
            $new_input['login_redirect'] = sanitize_text_field( $input['login_redirect'] );
		
        if( isset( $input['logout_redirectpage'] ) )
            $new_input['logout_redirectpage'] = sanitize_text_field( $input['logout_redirectpage'] );
        	
	
        return $new_input;
    }

    /**
	 * Text Set Tab
	 *
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_textset( $input  )
    {
        $new_input = array();
		
		  
        if( isset( $input['donor_vmt'] ) )
            $new_input['donor_vmt'] = sanitize_text_field( $input['donor_vmt'] );
		
        if( isset( $input['donor_prft'] ) )
            $new_input['donor_prft'] = sanitize_text_field( $input['donor_prft'] );
		
        if( isset( $input['donor_peft'] ) )
            $new_input['donor_peft'] = sanitize_text_field( $input['donor_peft'] );
		
        if( isset( $input['donor_lft'] ) )
            $new_input['donor_lft'] = sanitize_text_field( $input['donor_lft'] );
		        	
	
        return $new_input;
    }

    /**
	 * Display Set Tab
	 *
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_displayset( $input  )
    {
        $new_input = array();
				  
        if( isset( $input['donor_maincolor'] ) )
            $new_input['donor_maincolor'] = sanitize_text_field( $input['donor_maincolor'] );
		
        if( isset( $input['donor_formbgcolor'] ) )
            $new_input['donor_formbgcolor'] = sanitize_text_field( $input['donor_formbgcolor'] );
		
        if( isset( $input['donor_bordercolor'] ) )
            $new_input['donor_bordercolor'] = sanitize_text_field( $input['donor_bordercolor'] );
		
        if( isset( $input['donor_textcolor'] ) )
            $new_input['donor_textcolor'] = sanitize_text_field( $input['donor_textcolor'] );
		        	
	
        return $new_input;
    }

    /**
	 * Request Tab
	 * 
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_request( $input  )
    {
        $new_input = array();
		
		// Blood Request settings data
		if( isset( $input['rf_form_title'] ) )
			$new_input['rf_form_title'] = sanitize_text_field( $input['rf_form_title'] );
		
		if( isset( $input['rf_sub_title'] ) )
			$new_input['rf_sub_title'] = sanitize_text_field( $input['rf_sub_title'] );
		
		if( isset( $input['rf_btn_label'] ) )
			$new_input['rf_btn_label'] = sanitize_text_field( $input['rf_btn_label'] );
		
		if( isset( $input['rf_form_page'] ) )
			$new_input['rf_form_page'] = sanitize_text_field( $input['rf_form_page'] );
		
		if( isset( $input['rf_form_wrp_class'] ) )
			$new_input['rf_form_wrp_class'] = sanitize_text_field( $input['rf_form_wrp_class'] );

        if( isset( $input['rf_form_img_upload'] ) )
            $new_input['rf_form_img_upload'] = sanitize_text_field( $input['rf_form_img_upload'] );
		
		if( isset( $input['rf_form_bgcolor'] ) )
			$new_input['rf_form_bgcolor'] = sanitize_text_field( $input['rf_form_bgcolor'] );
		
		if( isset( $input['rf_form_color'] ) )
			$new_input['rf_form_color'] = sanitize_text_field( $input['rf_form_color'] );
		
		if( isset( $input['rp_request_page'] ) )
			$new_input['rp_request_page'] = sanitize_text_field( $input['rp_request_page'] );
		
		if( isset( $input['rp_request_page_wrp_class'] ) )
			$new_input['rp_request_page_wrp_class'] = sanitize_text_field( $input['rp_request_page_wrp_class'] );
		
		if( isset( $input['rp_request_per_page'] ) )
			$new_input['rp_request_per_page'] = sanitize_text_field( $input['rp_request_per_page'] );
		
		if( isset( $input['rp_page_bgcolor'] ) )
			$new_input['rp_page_bgcolor'] = sanitize_text_field( $input['rp_page_bgcolor'] );
			
		
        return $new_input;
    }



	/*****************************************
		General Settings fields
	*****************************************/
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function load_bootstrap_callback()
    {
		if( isset( $this->general_options['load_bootstrap'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="load_bootstrap" value="1" name="idonate_general_option_name[load_bootstrap]" %s />',
            $checked
        );
    }
	
    public function load_fontawesome_callback()
    {
		if( isset( $this->general_options['load_fontawesome'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="load_fontawesome" value="1" name="idonate_general_option_name[load_fontawesome]" %s />',
            $checked
        );
    }
	
    public function donor_request_status_callback()
    {
		if( isset( $this->general_options['donor_request_status'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="donor_request_status" value="1" name="idonate_general_option_name[donor_request_status]" %s />',
            $checked
        );
    }
	
    public function donor_register_status_callback()
    {
		if( isset( $this->general_options['donor_register_status'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="donor_register_status" value="1" name="idonate_general_option_name[donor_register_status]" %s />',
            $checked
        );
    }
			
    public function idonate_recaptcha_active_callback()
    {
		$url = 'https://www.google.com/recaptcha/admin#list';
		
		if( isset( $this->general_options['idonate_recaptcha_active'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="idonate_recaptcha_active" value="1" name="idonate_general_option_name[idonate_recaptcha_active]" %s />',
            $checked
        );
		echo '<p>Create google recaptcha <a target="_blank" href="'.esc_url( $url ).'"> sitekey and secretkey</a> </p>';
    }
	
    public function idonate_recaptcha_secretkey_callback()
    {
		if( isset( $this->general_options['idonate_recaptcha_secretkey'] ) ){
			$secretkey = $this->general_options['idonate_recaptcha_secretkey'];
		}else{
			$secretkey = '';
		}
		
		//
        printf(
            '<input type="text" id="idonate_recaptcha_secretkey" value="%s" name="idonate_general_option_name[idonate_recaptcha_secretkey]"  />',
            $secretkey
        );
    }
	
    public function idonate_recaptcha_sitekey_callback()
    {
		if( isset( $this->general_options['idonate_recaptcha_sitekey'] ) ){
			$sitekey = $this->general_options['idonate_recaptcha_sitekey'];
		}else{
			$sitekey = '';
		}
		
		//
        printf(
            '<input type="text" id="idonate_recaptcha_sitekey" value="%s" name="idonate_general_option_name[idonate_recaptcha_sitekey]"  />',
            $sitekey
        );
    }
	
    public function donotr_per_page_callback()
    {
		if( isset( $this->general_options['donor_per_page'] ) ){
			$number = $this->general_options['donor_per_page'];
		}else{
			$number = '10';
		}
		
		//
        printf(
            '<input type="text" id="donor_per_page" value="%s" name="idonate_general_option_name[donor_per_page]"  />',
            $number
        );
    }
    public function donor_view_button_callback()
    {

        $pop = $link = '';

        if( isset( $this->general_options['donor_view_button'] )  ) {

            if( $this->general_options['donor_view_button'] == 'pop' ) {
                $pop = ' checked';
            } else {
                $link = ' checked';
            }


        }
        
        //
        printf(
            '<div class="idonate-admin-radio"><div class="single-radio"><label for="donor_view_button_pop">'.esc_html__( 'Pop Up', 'idonate' ).'</label><input type="radio" id="donor_view_button_pop" value="pop" name="idonate_general_option_name[donor_view_button]" %s /></div><div class="single-radio"><label for="donor_view_button_link">'.esc_html__( 'Single Page Link', 'idonate' ).'</label><input type="radio" id="donor_view_button_link" value="link" name="idonate_general_option_name[donor_view_button]" %s /></div></div>', $pop, $link
        );
    }
    
    public function idonate_country_callback()
    {

    ?>
    <select id="idonate_country" name="idonate_general_option_name[idonate_country]">
        <option value="all"><?php esc_html_e( 'All Countries', 'idonate' ); ?></option>
        <?php 
        $countries = idonate_all_countries();

        foreach( $countries as $key => $value ){
            
            $selected = ( isset ($this->general_options['idonate_country'] ) && $this->general_options['idonate_country'] == $key )? 'selected': '';
            
        echo '<option value="'.esc_html( $key ).'" '.esc_attr( $selected ).'>'.esc_html( $value ).'</option>';
            
        }
        
        ?>
    
    </select>
    <?php
    }
	
    public function idonate_countryhide_callback()
    {

        if( isset( $this->general_options['idonate_countryhide'] ) ){
            $checked = ' checked';
        }else{
            $checked = '';
        }
        
        //
        printf(
            '<input type="checkbox" id="idonate_countryhide" value="1" name="idonate_general_option_name[idonate_countryhide]" %s />',
            $checked
        );
    }
    public function idonate_bloodrequestcountryhide_callback()
    {

        if( isset( $this->general_options['idonate_bloodrequestcountryhide'] ) ) {
            $checked = ' checked';
        } else {
            $checked = '';
        }
        //
        printf(
            '<input type="checkbox" id="idonate_bloodrequestcountryhide" value="1" name="idonate_general_option_name[idonate_bloodrequestcountryhide]" %s />',
            $checked
        );
    }
	
    public function idonate_donorshowlogin_callback()
    {

        if( isset( $this->general_options['idonate_donorshowlogin'] ) ) {
            $checked = ' checked';
        } else {
            $checked = '';
        }
        //
        printf(
            '<input type="checkbox" id="idonate_donorshowlogin" value="1" name="idonate_general_option_name[idonate_donorshowlogin]" %s />',
            $checked
        );
    }
    
	
	/*****************************************
		Text Settings fields
	*****************************************/
	
	public function donor_vmt_callback()
    {
        printf(
            '<input type="text" id="donor_vmt" name="idonate_textset_option_name[donor_vmt]" value="%s" />',
            isset( $this->textset_options['donor_vmt'] ) ? esc_attr( $this->textset_options['donor_vmt']) : ''
        );
		
    }
	public function donor_prft_callback()
    {
        printf(
            '<input type="text" id="donor_prft" name="idonate_textset_option_name[donor_prft]" value="%s" />',
            isset( $this->textset_options['donor_prft'] ) ? esc_attr( $this->textset_options['donor_prft']) : ''
        );
		
    }
	public function donor_peft_callback()
    {
        printf(
            '<input type="text" id="donor_peft" name="idonate_textset_option_name[donor_peft]" value="%s" />',
            isset( $this->textset_options['donor_peft'] ) ? esc_attr( $this->textset_options['donor_peft']) : ''
        );
		
    }
	public function donor_lft_callback()
    {
        printf(
            '<input type="text" id="donor_lft" name="idonate_textset_option_name[donor_lft]" value="%s" />',
            isset( $this->textset_options['donor_lft'] ) ? esc_attr( $this->textset_options['donor_lft']) : ''
        );
		
    }
	
	
	/*****************************************
		Display Settings fields
	*****************************************/
	     
	public function donor_maincolor_callback()
    {	
		
        printf(
            '<input type="text" id="donor_maincolor" class="color-picker" name="idonate_displayset_option_name[donor_maincolor]" value="%s" />',
            isset( $this->displayset_options['donor_maincolor'] ) ? esc_attr( $this->displayset_options['donor_maincolor'] ) : ''
        );
		
    }
	public function donor_formbgcolor_callback()
    {
        printf(
            '<input type="text" id="donor_formbgcolor" class="color-picker" name="idonate_displayset_option_name[donor_formbgcolor]" value="%s" />',
            isset( $this->displayset_options['donor_formbgcolor'] ) ? esc_attr( $this->displayset_options['donor_formbgcolor']) : ''
        );
		
    }
	public function donor_bordercolor_callback()
    {
        printf(
            '<input type="text" id="donor_bordercolor" class="color-picker" name="idonate_displayset_option_name[donor_bordercolor]" value="%s" />',
            isset( $this->displayset_options['donor_bordercolor'] ) ? esc_attr( $this->displayset_options['donor_bordercolor']) : ''
        );
		
    }
	public function donor_textcolor_callback()
    {
        printf(
            '<input type="text" id="donor_textcolor" class="color-picker" name="idonate_displayset_option_name[donor_textcolor]" value="%s" />',
            isset( $this->displayset_options['donor_textcolor'] ) ? esc_attr( $this->displayset_options['donor_textcolor']) : ''
        );
		
    }
	
	/*****************************************
		Page Settings fields
	*****************************************/
	
	/** 
     * donor page callback
     */
    public function donor_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="donor_page" name="idonate_pageset_option_name[donor_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['donor_page']) && $this->pageset_options['donor_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name Donors', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	 
	/** 
     * donor register page callback
     */
    public function donor_register_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="donor_register_page" name="idonate_pageset_option_name[donor_register_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['donor_register_page']) && $this->pageset_options['donor_register_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name Donor Register', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	/** 
     * donor edit page callback
     */
    public function donor_edit_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="donor_edit_page" name="idonate_pageset_option_name[donor_edit_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['donor_edit_page']) && $this->pageset_options['donor_edit_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name Donor Edit', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	/** 
     * donor profile page callback
     */
    public function donor_profile_page_callback ()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="donor_profile_page" name="idonate_pageset_option_name[donor_profile_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['donor_profile_page']) && $this->pageset_options['donor_profile_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name Donor Profile', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	/** 
     * login page callback
     */
    public function login_page_callback ()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	  
	<select id="login_page" name="idonate_pageset_option_name[login_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['login_page']) && $this->pageset_options['login_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name Donor Login', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	 
	/** 
     * login redirect page callback
     */
    public function login_redirect_page_callback ()
    {
		
		$pages = get_pages();
				
		ob_start();
     ?>
	  
	<select id="login_redirect" name="idonate_pageset_option_name[login_redirect]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['login_redirect']) && $this->pageset_options['login_redirect'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		?>
	</select>
    
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	 
	/** 
     * logout redirect page callback
     */
    public function logout_redirectpage_callback ()
    {
		
		$pages = get_pages();
		ob_start();
     ?>
	  
	<select id="logout_redirectpage" name="idonate_pageset_option_name[logout_redirectpage]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->pageset_options['logout_redirectpage']) && $this->pageset_options['logout_redirectpage'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
	
    }
	
	

    /** 
     * Admin Section Information
     */
    public function idonate_section_info()
    {
		// if( isset( $_GET['tab'] ) && $_GET['tab'] == 'general' ){

            echo '<span class="show-shortcode">Available Shortcodes</span>';
			echo '<div class="shortcode-modual">';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode for donor list table</strong> <code>[donortable]</code></p></div>';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode to show blood request</strong> <code>[blood-request]</code></p></div>';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode to show donors</strong> <code>[donors]</code></p></div>';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode to show blood request post form</strong> <code>[post-blood-request]</code></p></div>';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode to show donor register form</strong> <code>[register-donor]</code></p></div>';
            echo '<div class="idonate-gen-info"><p class="idonate-info"><strong>Use this shortcode to show statistics</strong> <code>[idonate_statistics]</code></p></div>';
		    echo '</div>';
        // }
		
    }

	
	/*****************************************
		Blood Request Settings fields
	*****************************************/
	
	// Divider
    public function idonate_admin_divider_rf_callback()
    {
		$info = __( 'Blood Request Form Page Settings', 'idonate' );
		
        echo '<div class="id-admin-divider">'.esc_html( $info ).'</div>';
		
    }
	
    /** 
     * blood request form title callback
     */
    public function rf_form_title_callback()
    {
        printf(
            '<input type="text" id="rf_form_title" name="idonate_request_option_name[rf_form_title]" value="%s" />',
            isset( $this->request_options['rf_form_title'] ) ? esc_attr( $this->request_options['rf_form_title']) : ''
        );
    }

    /** 
     * blood request form sub title callback
     */
    public function rf_sub_title_callback()
    {
        printf(
            '<input type="text" id="rf_sub_title" name="idonate_request_option_name[rf_sub_title]" value="%s" />',
            isset( $this->request_options['rf_sub_title'] ) ? esc_attr( $this->request_options['rf_sub_title']) : ''
        );
		
    }
    /** 
     * blood request form button label callback
     */
    public function rf_btn_label_callback()
    {
        printf(
            '<input type="text" id="rf_btn_label" name="idonate_request_option_name[rf_btn_label]" value="%s" />',
            isset( $this->request_options['rf_btn_label'] ) ? esc_attr( $this->request_options['rf_btn_label']) : ''
        );
		
    }
    /** 
     * blood request form page callback
     */
    public function rf_form_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="rf_form_page" name="idonate_request_option_name[rf_form_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->request_options['rf_form_page']) && $this->request_options['rf_form_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name post request', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo  $html;	
		
	
    }
	
	/** 
     * blood request form wrapper class callback
     */
    public function rf_form_wrp_class_callback()
    {
        printf(
            '<input type="text" id="rf_form_wrp_class" name="idonate_request_option_name[rf_form_wrp_class]" value="%s" />',
            isset( $this->request_options['rf_form_wrp_class'] ) ? esc_attr( $this->request_options['rf_form_wrp_class']) : ''
        );
		
    }
    
    /** 
     * blood request form image upload field callback
     */
    public function rf_form_img_field_callback()
    {
        printf(
            '<input type="checkbox" id="rf_form_img_upload" name="idonate_request_option_name[rf_form_img_upload]"  %s />',
            isset( $this->request_options['rf_form_img_upload'] ) ? 'checked' : ''
        );
        
    }
	
	/** 
     * blood request form background color callback
     */
    public function rf_form_bgcolor_callback()
    {
        printf(
            '<input type="text" id="rf_form_bgcolor" class="color-picker" name="idonate_request_option_name[rf_form_bgcolor]" value="%s" />',
            isset( $this->request_options['rf_form_bgcolor'] ) ? esc_attr( $this->request_options['rf_form_bgcolor']) : ''
        );
		
    }
	/** 
     * blood request form color callback
     */
    public function rf_form_color_callback()
    {
        printf(
            '<input type="text" id="rf_form_color" class="color-picker" name="idonate_request_option_name[rf_form_color]" value="%s" />',
            isset( $this->request_options['rf_form_color'] ) ? esc_attr( $this->request_options['rf_form_color']) : ''
        );
		
    }
  
  
   /******************************
    *Blood Request Page Fields
	*****************************/
  
	// Divider
    public function idonate_admin_divider_rp_callback()
    {
		$info = 'Blood Request Page Settings';
		
        echo '<div class="id-admin-divider">'.esc_html( $info ).'</div>';
		
    }
    /** 
     * blood request page callback
     */
    public function rp_request_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="rp_request_page" name="idonate_request_option_name[rp_request_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->request_options['rp_request_page']) && $this->request_options['rp_request_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	</select>
    <p><?php esc_html_e( 'Default page name request', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 
	 echo $html;		
		
	
    }
	
	/** 
     * blood request per page callback
     */
    public function rp_request_perpage_callback()
    {
        printf(
            '<input type="text" id="rp_request_per_page" name="idonate_request_option_name[rp_request_per_page]" value="%s" />',
            isset( $this->request_options['rp_request_per_page'] ) ? esc_attr( $this->request_options['rp_request_per_page']) : ''
        );
		
    }
	
	/** 
     * blood request wrapper class callback
     */
    public function rp_request_page_wrp_class_callback()
    {
        printf(
            '<input type="text" id="rp_request_page_wrp_class" name="idonate_request_option_name[rp_request_page_wrp_class]" value="%s" />',
            isset( $this->request_options['rp_request_page_wrp_class'] ) ? esc_attr( $this->request_options['rp_request_page_wrp_class']) : ''
        );
		
    }
	
	/** 
     * blood request page background color callback
     */
    public function rp_page_bgcolor_callback()
    {
        printf(
            '<input type="text" id="rp_page_bgcolor" class="color-picker" name="idonate_request_option_name[rp_page_bgcolor]" value="%s" />',
            isset( $this->request_options['rp_page_bgcolor'] ) ? esc_attr( $this->request_options['rp_page_bgcolor']) : ''
        );
		
    }


	
	
}

if( is_admin() )
    $idonate_settings_page = new Idonate_Settings_Page();
