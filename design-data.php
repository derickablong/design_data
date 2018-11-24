<?php
/**
* Plugin Name: Design Data
* Description: Plugin for make my gear
* Version: 1.0
* Author: Derick Ablong
* Text Domain: mmg-dd
*
*/
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'DD_VERSION', '1.1' );
define( 'DDDIR', plugin_dir_path( __FILE__ ) );
define( 'MMG_DD_URI', plugins_url() . '/design-data-v.'. DD_VERSION );
define( 'DD_TABLE', 'design_data' );

/**
 * Design Data Plugin
 */
class MMG_DESIGN_DATA
{


	/**
	 * Constructor
	 * Default function to call on 
	 * instantiate
	 */
	function __construct()
	{
		
		$this->load_dependencies();
		$this->add_hook();		

	}



	/**
	 * Load File Dependencies
	 * Primary php files
	 */
	public function load_dependencies()
	{


		include DDDIR . 'php/mmg_options.php';


		if( is_admin() ) {								
			
			include DDDIR . 'php/mmg_install.php';						
			include DDDIR . 'php/mmg_page.php';
			include DDDIR . 'php/mmg_actions.php';

		}	
		

	}



	/**
	 * Add Hooks
	 * Adds functions to relavent hooks and filters
	 */
	public function add_hook()
	{		
		add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );	
		add_action( 'admin_init', array( $this, 'design_data_scripts' ) );
		add_action( 'admin_init', 'mmg_design_data_woocommerce' );			
	}



	/**
	 * Admin Menu
	 * Add wp-admin menu on sidebar
	 */
	public function setup_admin_menu()
	{
		if ( function_exists( 'add_menu_page' ) ) {
			add_menu_page( 
				'Design Data', 
				__( 'Design Data', 'mmg-dd' ), 
				'moderate_comments', 
				'mmg_design_data', 
				'mmg_design_data_page', 
				MMG_DD_URI . '/assets/img/icon.png'
			);
		}
	}



	/**
	 * Design Data
	 * Add wp-admin menu on sidebar
	 */
	public function design_data_scripts()
	{
		
		wp_enqueue_style(
			'mmg-dd-css',
			MMG_DD_URI . '/assets/css/dd.css',
			array(),
			DD_VERSION
		);
			
	}




}

$mmgDesignData = new MMG_DESIGN_DATA();
register_activation_hook( __FILE__, array( 'MMG_DD_Install', 'install' ) );