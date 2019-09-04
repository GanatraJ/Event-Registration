<?php
/**
* Plugin Name: Event Registration
* Plugin URI: https://wordpress.org/plugins/
* Description: A Simple Event Registration plugin that allows create & register for events.
* Version: 1.0.0
* Author: John Doe
* Author URI: https://wordpress.org/plugins/
* Text Domain: event-registration
* License: GPLv2 or later
* Domain Path:  /languages
*/
    
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2019 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam magna massa, tempor id ornare quis, interdum ut nisl.';
	exit;
}
global $er_db_version;
$er_db_version = '1.0';

define( 'ER__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/*load resources*/

function er_enqueue_function( ) {
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
    wp_enqueue_style('jquery-ui');
    
    wp_enqueue_style('eventstyle', plugins_url( 'css/eventstyle.css' , __FILE__ ), array(), null);
    
}
add_action( 'admin_enqueue_scripts', 'er_enqueue_function' ); //For Admin panel
add_action('wp_enqueue_scripts', 'er_enqueue_function'); //For Front-end
/**
 * Register a custom menu page.
 */
function register_er_menu_page(){
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page(__( 'Event Registration', 'event-registration' ),'Event Registration','manage_options','event_registration','er_menu_page','dashicons-welcome-add-page',26); 
    //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function); 
    add_submenu_page( 'event_registration', __( 'Event Locations', 'event-registration' ), 'Locations', 'manage_options', 'event_location', 'er_location_page');
    add_submenu_page( 'event_registration', __( 'Event Categories', 'event-registration' ), ' Categories', 'manage_options', 'event_categories', 'er_category_page');
    // Register the hidden submenu.
    add_submenu_page('event_registration', __( 'Event Locations Edit', 'event-registration' ), '', 'manage_options', 'event_location_edit', 'er_locationedit_page');
    add_submenu_page('event_registration', __( 'Event Categories Edit', 'event-registration' ), '', 'manage_options', 'event_category_edit', 'er_categoryedit_page');
    add_submenu_page('event_registration', __( 'Event Insert', 'event-registration' ), '', 'manage_options', 'event_insert', 'er_insert_page');
    add_submenu_page('event_registration', __( 'Event Edit', 'event-registration' ), '', 'manage_options', 'event_edit', 'er_edit_page');
    add_submenu_page('event_registration', __( 'Event Registrants', 'event-registration' ), '', 'manage_options', 'event_registrant', 'er_registrant_page');
    add_submenu_page('event_registration', __( 'Event Registrants Edit', 'event-registration' ), '', 'manage_options', 'event_registrant_edit', 'er_registrant_edit_page');

}
add_action( 'admin_menu', 'register_er_menu_page' );
 
/**
 * Display a custom menu page
 */
function er_menu_page(){
    if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	/*echo '<div class="wrap">';
	echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam magna massa, tempor id ornare quis, interdum ut nisl.</p>';
	echo '</div>'; */
	
	include 'includes/event/index.php';
}
function er_location_page(){
    include 'includes/event-location/index.php';
}
function er_locationedit_page(){
    include 'includes/event-location/edit.php';
}
function er_category_page(){
    include 'includes/event-categories/index.php';
}
function er_categoryedit_page(){
    include 'includes/event-categories/edit.php';
}
function er_insert_page(){
    include 'includes/event/insert.php';
}
function er_edit_page(){
    include 'includes/event/edit.php';
}
function er_registrant_page(){
    include 'includes/event-registrants/index.php';
}
function er_registrant_edit_page(){
    include 'includes/event-registrants/edit.php';
}
function er_wp_admin_submenu_filter( $submenu_file ) {

    global $plugin_page;

    $hidden_submenus = array(
        'event_location_edit' => true,
        'event_category_edit' => true,
        'event_insert' => true,
        'event_edit' => true,
        'event_registrant' => true,
        'event_registrant_edit' => true,
    );

    // Select another submenu item to highlight (optional).
    /*if ( $plugin_page && isset( $hidden_submenus[ $plugin_page ] ) ) {
        $submenu_file = 'event_registration';
    }*/

    // Hide the submenu.
    foreach ( $hidden_submenus as $submenu => $unused ) {
        remove_submenu_page( 'event_registration', $submenu );
    }

    return $submenu_file;
}
add_filter( 'submenu_file', 'er_wp_admin_submenu_filter' );

/**
 * Activation & deactivation hook
 */
register_activation_hook(__FILE__, 'er_activePlug');
register_deactivation_hook(__FILE__, 'er_deactivePlug');

function er_activePlug(){
    global $wpdb;
	global $er_db_version;
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    $charset_collate = $wpdb->get_charset_collate();
    
    // Create table for events
    $table_name = $wpdb->prefix . 'event';
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		title varchar(255) NOT NULL,
		type varchar(255) NOT NULL,
		date varchar(255) NOT NULL,
		summary varchar(255) NOT NULL,
		description varchar(255) NOT NULL,
		location mediumint(9) NOT NULL,
		status tinyint(1) NOT NULL,
		capacity int(11) NOT NULL,
		event_category tinyint(1) NOT NULL,
		price int(11) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
    dbDelta( $sql );
    
    // Create table for event locations
	$table_name = $wpdb->prefix . 'event_location';
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		address varchar(255) NOT NULL,
		city varchar(255) NOT NULL,
		phone_number mediumint(11) NOT NULL,
		location_name varchar(255) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
    dbDelta( $sql );
    
    // Create table for event categories
    $table_name1 = $wpdb->prefix . 'event_categories';
	$sql = "CREATE TABLE $table_name1 (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name varchar(255) NOT NULL,
		description varchar(255) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
    dbDelta( $sql );
    
    // Create table for event registrants
    $addontable = $wpdb->prefix . 'event_registrants';
    $sql = "CREATE TABLE " . $addontable . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
    		event_id mediumint(9) NOT NULL,
    		first_name varchar(255) NOT NULL,
    		last_name varchar(255) NOT NULL,
    		email varchar(255) NOT NULL,
    		phone_no int(11) NOT NULL,
    		address varchar(255) NOT NULL,
    		city varchar(255) NOT NULL,
    		state_province varchar(255) NOT NULL,
    		country varchar(255) NOT NULL,
            PRIMARY KEY  (id)
    ) ". $charset_collate .";";
    dbDelta($sql);
    
	add_option( 'er_db_version', $jal_db_version );
}
function er_deactivePlug(){}


/**
 * Delete Action
 */
add_action( 'wp_ajax_nopriv_er_delaction', 'er_delaction' );
add_action( 'wp_ajax_er_delaction', 'er_delaction' );
function er_delaction() {
    if(isset($_POST['del_id']) && isset($_POST['del_tbl']) && isset($_POST['event_type']))
    {
        global $wpdb;
        $del_id = $_POST['del_id'];
        $del_tbl = $_POST['del_tbl'];
        $event_type = $_POST['event_type'];
        
        $output = '';  
        $wpdb->delete( $del_tbl, array( 'id' => $del_id ) );
        
        if($del_tbl == 'wp_event'){
            $wpdb->delete( 'wp_event_registrants', array( 'event_id' => $del_id ) );
        }
        
        $output = '<div id="message" class="updated notice is-dismissible">
                    <p><strong>'.$event_type.' Deleted Successfully.</strong></p>
                    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                  </div>';  
        echo $output;  
    }
    die();
}

/**
 * Event register Action 
 */
add_action( 'wp_ajax_nopriv_er_register', 'er_register' );
add_action( 'wp_ajax_er_register', 'er_register' );
function er_register() {
    if(isset($_POST['eventid']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address']) 
        && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['country']) )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_registrants';
        $event_table = $wpdb->prefix . 'event';
        
        $erID = $_POST['eventid'];
	    $er_fname = $_POST['fname'];
	    $er_lname = $_POST['lname'];
	    $er_email = $_POST['email'];
	    $er_phone = $_POST['phone'];
	    $er_address = $_POST['address'];
	    $er_city = $_POST['city'];
	    $er_state = $_POST['state'];
	    $er_country = $_POST['country'];
	    
	    $sql = "INSERT INTO $table_name (`event_id`, `first_name`, `last_name`, `email`, `phone_no`, `address`, `city`, `state_province`, `country`) 
                    VALUES ($erID,'$er_fname', '$er_lname', '$er_email', $er_phone, '$er_address', '$er_city', '$er_state', '$er_country')";
	    $wpdb->query($sql);
	        
        $output = '';  
        $output = '<div id="message" class="updated-notice">
    				<p><strong>Registered Successfully.</strong></p>
    			</div>';  
    	
    	//fetch event detail
	    $id = $erID;
	    $result = $wpdb->get_results ( "SELECT * FROM ".$event_table." WHERE id = $id " );
        foreach ( $result as $event ){
            $er_title = $event->title;
	        $er_date = $event->date;
    	    
    	    $er_date = date_create($er_date); 
    	    $er_date = date_format($er_date,"j F Y");
        }  
    	
    	//admin email
    	$admin_email = get_option( 'admin_email' ); 
            
    	$subject = 'Event Registration';
    	$headers = 'From: '.$admin_email . "\r\n";
    	$headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $to = $admin_email;
        $message = "Hello, 
                    <p>".$er_fname." ".$er_lname." registered for ".$er_title." on date ".$er_date."</p>
                    <p>Thank You</p>";
        mail($to,$subject,$message, $headers);
    	
    	//user email
        $to = $er_email;
        $message = "Hi, 
                    <p>".$er_fname." ".$er_lname." you have successfully registered for registered for ".$er_title." on date ".$er_date."</p>
                    <p>Here is the information you provided</p>".
                    "<b>First Name: </b><span>".$er_fname."</span><br/><b>Last Name: </b><span>".$er_lname."</span><br/>".
                    "<b>E-mail address: </b><span>".$er_email."</span><br/><b>Phone Number: </b><span>".$er_phone."</span><br/>".
                    "<b>Address: </b><span>".$er_address."</span><br/><b>City: </b><span>".$er_city."</span><br/>".
                    "<b>State\Province: </b><span>".$er_state."</span><br/><b>Country: </b><span>".$er_country."</span><br/>".
                    "<p>If you have any questions please contact us via our website.</p>
                    <p>Thank You</p>";
        mail($to,$subject,$message, $headers);
            
        echo $output;  
    }
    die();
}


/**
 * Event Front End Action
 */
add_action( 'wp_ajax_nopriv_er_detail', 'er_detail' );
add_action( 'wp_ajax_er_detail', 'er_detail' );
function er_detail() {
    if(isset($_POST['event_id']) )
    {
        global $wpdb;
        ob_start();
        $event_id = $_POST['event_id'];
        
        $output = '';  
        require_once ( plugin_dir_path(__FILE__) . '/includes/event-registrants/register-form.php');
        $output .= ob_get_clean();
        
        require_once ( plugin_dir_path(__FILE__) . '/includes/event/event-detail.php');
        $output .= ob_get_clean();
        
        echo $output; 
    }
    die();
}

/**
 * Front End Event Listing & Registration
 */
add_shortcode( 'event_listing', 'event_listing_func' );
function event_listing_func( $atts ){
	
	ob_start();
    require_once ( plugin_dir_path(__FILE__) . '/includes/shortcode.php');
    $content = ob_get_clean();
    return $content;
    
    //return "foo and bar";
}