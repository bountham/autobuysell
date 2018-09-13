<?php 

/*
Plugin Name: Autobuysell
Plugin URI: http://wordpressplugincourse.com/plugins/autobuysell
Description: Let's user buy and sale Cars.
Version: 1.0
Author: Vone Bountham
Author URI: https://www.premierautovisalia.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: Autobuysell
*/

/* !1. HOOKS */
 add_action('admin_menu','abs_admin_menus');
// register activate/deactivate/uninstall functions
register_activation_hook( __FILE__, 'abs_activate_plugin' );







/* !2. SHORTCODES */




/* !3. FILTERS */

function abs_admin_menus(){

	/* main menu */

		$top_menus_item = 'abs_welcome_page';

		 add_menu_page('', 'Autobuysell','manage_options',$top_menus_item,$top_menus_item, 'dashicons-chart-bar');

	/* submenus items */
	 //welcome to autobuysell
		 add_submenu_page($top_menus_item,'', 'Welcome','manage_options', $top_menus_item, $top_menus_item);
	//api Setting
		 add_submenu_page($top_menus_item,'', 'API Setting','manage_options','abs_api_setting','abs_api_setting');
		 
		//add_submenu_page($top_menus_item,'', 'CarsList','manage_options','abs_creat_tble','abs_creat_tble');


}


/* !4. EXTERNAL SCRIPTS */
function abs_autobuysell_api_request() {
     //get api from autobuysell
    $response = wp_remote_get( 'https://dev.app.autobuysell.net/api/vehicles/example');

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    $counts = count($data);
    

  for ($i=0; $i < $counts; $i++) { 
  	$vehicles = $data[$i]['vehicle'];
  	$business = $data[$i]['business'];
  	 echo "<br>";
     echo "VEHICLES TYPES:";
     echo "<br>";

      // loop thru all vehicles types
  	foreach ($vehicles as $key => $value) {	
     	echo "{$key} = {$value}";
     	echo "<br>";
     }
      echo "<br>";
      echo "BUSINESS ADDRESS :";
      echo "<br>";

      // loop thru all Business for each Vehicles
     foreach ($business as $key => $value) {
     	echo "{$key} = {$value}";
     	echo "<br>";

     }
  	
  }
     
}















/* !6. HELPERS */




/* !7. CUSTOM POST TYPES */




/* !8. ADMIN PAGES */
function abs_welcome_page(){
     
	$output = '

		<div class = "abs-welcome-admin-age">
		<h2>Welcome to Autobuysell</h2>

		<p>Lorem Ipsum Neque porro quisquam est qui dolorem ipsum quia dolor sit amet <br>
		There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain</p>
		</div>
	';
	echo $output;
    }
   



function abs_api_setting( $args, $content="") {
  
	$output = '

		   <div class="abs_insert_api">
		 <form id="abs_api_fml" action="/wp-admin/admin-ajax.php?action=abs_save_api" method="post">

		 <label><h3>Autobuysell API#</h3></label>
    		 <input type = "text" name="abs_api_number" size="100"><br><br>
    		 <input type="submit" value="Save">
		 </form
		</div>

	';
	echo $output;
}



// /* !9. create table when the plugin are active*/

function abs_creat_tble () {
	//creat tables
    global $wpdb;  

    //setup return value
    $return_value = false;

 try {

   $table_name = $wpdb->prefix . "abs_cars_db";
   $charset_collate = $wpdb->get_charset_collate();

   //sql for our table creation
   $sql = "CREATE TABLE $table_name (
      id mediumint(11) NOT NULL AUTO_INCREMENT,
      api_number mediumint(11) NOT NULL,
      list_id mediumint(11) NOT NULL,
      attachment_id mediumint(11) NOT NULL,
      car_model mediumint(11) DEFAULT 0 NOT NULL ,
      UNIQUE KEY id (id)
      ) $charset_collate;";

    // make sure we include wordpress functions for dbDelta  
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // dbDelta will create a new table if none exists or update an existing one
    dbDelta($sql);

    // return true
    $return_value = true;
   
 } catch (Exception $e) {
  //php error 

  echo "not working";
   
 }
    
//return result
 return $return_value;


}

// hint: runs on plugin activation
function abs_activate_plugin() {
  
  // setup custom database tables
  abs_creat_tble();
  // insert api into db
  abs_save_api()

  
}


/* !10. MISCELLANEOUS */

