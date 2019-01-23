<?php
/**
* @package AtiBlogTest
* @version 1.0
*/
/*
Plugin Name: guruPlugin
Plugin URI: https://guruPlugin.com/plugin
Description: This is my test plugin
Author: Gurjyot
Version: 1.0
Author URI: https://guruPlugin.com/plugin
License: GPLv2 or later
Text-domain:AtiBlogTest
*/

if(! defined('ABSPATH')){
	die;
}


	function complete_registration() {
    global $reg_errors, $first_name, $last_name, $nickname, $email, $phone, $numberofguest;
		
   
        $userdata = array(
        'first_name'    =>   $first_name,
        'last_name	'    =>   $last_name,
        'nickname'     =>   $nickname,
        'email'      =>   $email,
        'phone'    =>   $phone,
        'numberofguest'     =>   $numberofguest,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    	
	}
  add_action('admin_menu','complete_registration');  

	function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['nickname'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['numberofguest']
        );
         
       
        global $first_name, $last_name, $nickname, $email, $phone, $numberofguest;
        $first_name   =   sanitize_text_field( $_POST['first_name'] );
        $last_name   =   sanitize_text_field( $_POST['last_name'] );
        $nickname      =   sanitize_text_field( $_POST['nickname'] );
        $email    =   sanitize_email( $_POST['email'] );
        $phone =   sanitize_number( $_POST['phone'] );
        $numberofguest  =   sanitize_number( $_POST['numberofguest'] );
     
        
        complete_registration(
        $first_name,
        $last_name,
        $nickname,
        $email,
        $phone,
        $numberofguest
       
        );
    }
 
    registration_form(
        $first_name,
        $last_name,
        $nickname,
        $email,
        $phone,
        $numberofguest
        );
}

if(class_exists('guruPlugin'))
	$guruPlugin=new guruPlugin();

function registration_form() {

    return '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
    </style>
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="firstname">First Name</label>
    <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
    </div>
     
    <div>
    <label for="website">Last Name</label>
    <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
    </div>
    
    <div>
    <label for="nickname">Nickname</label>
    <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
    </div>
     
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>
     
    <div>
    <label for="phone">Phone</label>
    <input type="number" name="phone" value="' . ( isset( $_POST['phone']) ? $phone : null ) . '">
    </div>
    
    <div>
    <label for="numberofguets">Number of Guests</label>
    <input type="number" name="numberofguests" value="' . ( isset( $_POST['numberofguests']) ? $numberofguests : null ) . '">
    </div>
    
    
    <input type="submit" name="submit" value="Reserve"/>
    </form>
    ';
}
    
    



add_shortcode( 'cr_custom_registration', 'registration_form' );
 

function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}



?>
