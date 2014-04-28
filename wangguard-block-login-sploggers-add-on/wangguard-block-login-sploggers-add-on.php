<?php
/*
Plugin Name: WangGuard Block login Sploggers Add-On
Plugin URI: http://www.wangguard.com
Description: Block login to sploggers detected in a WordPress non multisite. If you use WangGuard plugins and WordPress non multisite, this is a must have WangGuard add-on.
Version: 1.0.0
Author: WangGuard
Author URI: http://www.wangguard.com
License: GPL2
*/

/*  Copyright 2012  WangGuard (email : info@wangguard.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('WANGGUARD_BLOCK_LOGIN_SPLOGGERS_VERSION', '1.0');

function wangguard_block_login_sploggers_init() {

if (function_exists('load_plugin_textdomain')) {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain('wangguard-block-login-sploggers-add-on', false, $plugin_dir . "/languages/" );
	}
}
add_action('init', 'wangguard_block_login_sploggers_init');


function wangguard_block_login_sploggers_notices() {
	if ( !defined('WANGGUARD_VERSION') ) {
		echo "
		<div  class='error fade'><p><strong>".__('WangGuard Block Login Sploggers Add-On is almost ready.', 'wangguard-registration-add-on')."</strong> ". __('You must install and activate <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> 1.6-RC1 or higher to use this plugin.', 'wangguard-registration-add-on')."</p></div>
		";
	}
	else {
		if ( defined('WANGGUARD_VERSION') ) {$version = WANGGUARD_VERSION;}
		if ($version)
		if (version_compare($version , '1.6-RC1') == -1)
			echo "
			<div  class='error fade'><p><strong>".__('WangGuard Block Login Sploggers Add-On is almost ready.', 'wangguard-registration-add-on')."</strong> ". __('You need to upgrade <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> to version 1.6-RC1 or higher to use this plugin.', 'wangguard-registration-add-on')."</p></div>
			";
	}
}
add_action('admin_notices', 'wangguard_block_login_sploggers_notices');


//Check user status
function wangguard_block_login_sploggers_look_user_status($userid){
			global $wpdb;

			$table_name = $wpdb->base_prefix . "wangguarduserstatus";
			$status = $wpdb->get_var( $wpdb->prepare("select user_status from $table_name where ID = %d" , $userid) );
			
			if ( $status ) return $status;
                    
}



/********************************************************************/
/*** CHECK SPLOGGER USER IN THE WORDPRESS LOGIN FORM BEGINS **/
/********************************************************************/

function wangguard_block_login_sploggers_check_user_login( $user, $username, $password ) {    
    
    $user = get_user_by( 'login', $username );
    $userid = $user->ID;
    if ($userid) $status = wangguard_block_login_sploggers_look_user_status($userid);
    
    if ( $status == 'reported' ) {
        return new WP_Error(1, 'You are not allowed to login.<br />Contact with the webmaster');
    }
    return $user;
}
add_filter( 'authenticate', 'wangguard_block_login_sploggers_check_user_login', 30, 3 );

?>