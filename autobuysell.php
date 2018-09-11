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
// add_action('plugins_loaded','abs_creat_tble');






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









/* !5. ACTIONS */




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
   



function abs_api_setting() {
	$output = '
		<div class="abs-welcome-admin-age">
		 <form id="abs_api_fml" action="#" method="">
		 <label><h3>Autobuysell API#</h3></label>
		 <input type = "text" name="abs_api_text" size="100"><br><br>
		 <input type="submit" value="Save">
		 </form
		</div>

	';
	echo $output;
}



// /* !9. SETTINGS */


function abs_creat_tble () {
	//creat tables
    global $wpdb;    
     require_once( ABSPATH . './wp-config.php' );
     $custom_table = $wpdb->prefix . 'custom_table_name';
        $sql = "CREATE TABLE IF NOT EXISTS $custom_table (
    id mediumint(9) NOT NULL,
    col1 varchar(50) NOT NULL,
    col2 varchar(500) NOT NULL,
    ) $charset_collate;";

        dbDelta($sql);
}


/* !10. MISCELLANEOUS */

