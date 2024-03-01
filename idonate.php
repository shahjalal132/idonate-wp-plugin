<?php
/*
Plugin Name:  IDonatePro - blood request and blood donor management system WordPress plugin
Plugin URI:   https://themeatelier.net/plugins/idonate/
Description:  IDonatePro blood request and blood donor management system WordPress plugin. Easy to use, easy to customize.
Version:      3.0.2
Author:       ThemeAtelier
Author URI:   https://themeatelier.net/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  idonate
Domain Path:  /languages
*/


// Block Direct access
if (!defined('ABSPATH')) {
	die('You should not access this file directly!.');
}

// Define Constants for direct access alert message.

if (!defined('IDONATE_ALERT_MSG'))
	define('IDONATE_ALERT_MSG', __('You should not access this file directly.!', 'idonate'));


// Define constants for plugin directory path.
if (!defined('IDONATE_DIR_PATH'))
	define('IDONATE_DIR_PATH', plugin_dir_path(__FILE__));

// Define constants for plugin dirname.
if (!defined('IDONATE_DIR_NAME'))
	define('IDONATE_DIR_NAME', dirname(__FILE__));

// Define constants for plugin directory path.
if (!defined('IDONATE_DIR_URL'))
	define('IDONATE_DIR_URL', plugin_dir_url(__FILE__));

// Define constants for plugin basenam.
if (!defined('IDONATE_BASENAME'))
	define('IDONATE_BASENAME', plugin_basename(__FILE__));

// Define constants for countries and states.
if (!defined('IDONATE_COUNTRIES'))
	define('IDONATE_COUNTRIES', IDONATE_DIR_PATH . 'inc/countries/');

// Script enqueue class include
require_once IDONATE_DIR_PATH . 'inc/class-enqueue.php';

// Admin file include 
require_once IDONATE_DIR_PATH . 'admin/admin.php';

// Meta field related file include
require_once IDONATE_DIR_PATH . 'inc/meta-fields/main-meta.php';
require_once IDONATE_DIR_PATH . 'inc/meta-fields/tatcmf.php';
require_once IDONATE_DIR_PATH . 'inc/meta-fields/tatcmf-config.php';
require_once IDONATE_DIR_PATH . 'inc/meta-fields/fields/text-fields.php';
require_once IDONATE_DIR_PATH . 'inc/meta-fields/fields/textarea-fields.php';

// Short code file include
require_once IDONATE_DIR_PATH . 'inc/shortcode/shortcode-register-donor.php';
require_once IDONATE_DIR_PATH . 'inc/shortcode/shortcode-post-blood-request.php';
require_once IDONATE_DIR_PATH . 'inc/shortcode/shortcode-donors.php';
require_once IDONATE_DIR_PATH . 'inc/shortcode/shortcode-blood-request.php';
require_once IDONATE_DIR_PATH . 'inc/shortcode/shortcode-statistics.php';

// Post type class file include
require_once IDONATE_DIR_PATH . 'inc/class-post-type.php';

// Donor class file include
require_once IDONATE_DIR_PATH . 'inc/class-donor.php';

// Dashboar dwidgets class file include
require_once IDONATE_DIR_PATH . 'inc/class-idonate-dashboardwidgets.php';

// Idonate helper function file include
require_once IDONATE_DIR_PATH . 'inc/helper-functions.php';

// Social share file include
require_once IDONATE_DIR_PATH . 'inc/social-share.php';

// donor function file include
require_once IDONATE_DIR_PATH . 'inc/donor-functions.php';

// donor inline style file include
require_once IDONATE_DIR_PATH . 'inc/idonate-inlinestyle.php';

// Post request form data handle file include
require_once IDONATE_DIR_PATH . 'inc/form-data-handle.php';

// ajax handle file include
require_once IDONATE_DIR_PATH . 'inc/IDonate_ajax_handler.php';
// Widget
require_once IDONATE_DIR_PATH . 'inc/widget-blood-requiest.php';
require_once IDONATE_DIR_PATH . 'inc/widget-statistics.php';
// Countries
require_once IDONATE_COUNTRIES . 'countries.php';
// Countries
require_once IDONATE_DIR_PATH . 'inc/donor-shortcode.php';

// Create page after plugin activate
function idonate_plugin_activate()
{

	// Create page when plugin activated
	idonate_create_page_plugin_activated();
	// User Role
	//idonate_user_role();
	add_role('donor', 'Donor', array('read' => true, 'level_0' => true));
}
register_activation_hook(__FILE__, 'idonate_plugin_activate');

// Delete page after plugin deactivate
function idonate_deactivation_activate()
{

	// Delete page when plugin deactivated
	idonate_delete_page_plugin_deactivated();
}
register_deactivation_hook(__FILE__, 'idonate_deactivation_activate');

// require display donors file
require_once IDONATE_DIR_PATH . 'inc/idonor-display-donors.php';
require_once IDONATE_DIR_PATH . 'inc/class-enqueue-asstes.php';
