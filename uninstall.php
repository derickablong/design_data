<?php
/**
 * Uninstall
 *
 * @author Market Better
 * @package design-library 
 * @version 1.1
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

global $wpdb;


$table_name = $wpdb->prefix . "design_data";
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );