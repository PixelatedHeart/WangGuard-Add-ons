<?php
/*
Plugin Name: WangGuard Registration Nocice Add-on
Plugin URI: http://www.wangguard.com
Description: Add a notice in the Registration page. WangGuard plugin version 1.6 or higher is required, download it for free from <a href="http://wordpress.org/extend/plugins/wangguard/">http://wordpress.org/extend/plugins/wangguard/</a>.
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



function wangguard_registration_admin_notices() {
	if ( !defined('WANGGUARD_VERSION') ) {
		echo "
		<div  class='updated fade'><p><strong>".__('WangGuard Registration Nocice Add-on is almost ready.', 'wangguard-registration-add-on')."</strong> ". __('You must install and activate <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> 1.6 or higher to use this plugin.', 'wangguard-registration-add-on')."</p></div>
		";
	}
	else {
		if ( defined('WANGGUARD_VERSION') ) {$version = WANGGUARD_VERSION;}
		if ($version)
		if (version_compare($version , '1.6') == -1)
			echo "
			<div  class='updated fade'><p><strong>".__('WangGuard Registration Nocice Add-on is almost ready.', 'wangguard-registration-add-on')."</strong> ". __('You need to upgrade <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> to version 1.6 or higher to use this plugin.', 'wangguard-registration-add-on')."</p></div>
			";
	}
}
add_action('admin_notices', 'wangguard_registration_admin_notices');

//function wangguard_registration_admin_notices_init() {

// Save the new settings
function wangguard_save_registration_notices_fileds(){

			update_site_option('wangguard-notice-signup', @$_POST['wangguard-notice-signup']=='1' ? 1 : 0 );
			update_site_option('wangguard-notice-signup-text', @$_POST['wangguard-notice-signup-text']);

			}
add_action('wangguard_save_setting_option', 'wangguard_save_registration_notices_fileds');


//Add setting to WangGuard Setting page
function wangguard_registration_notices_fileds() { ?>
					<p>
						<input type="checkbox" name="wangguard-notice-signup" id="wangguard-notice-signup" value="1" <?php echo wangguard_get_option("wangguard-notice-signup")=='1' ? 'checked' : ''?> />
						<label for="wangguardexpertmode"><?php _e("<strong>Signup Notice.</strong><br/>By checking this option WangGuard will show a notice in the signup page. Below You can customize this notice", 'wangguard') ?></label>
					</p>
					
					<strong><?php _e('Customize notice in the signup page', 'wangguard'); ?></strong><br />
					
					<p><textarea id="wangguard-notice-signup-text" name="wangguard-notice-signup-text" rows="6" cols="100"><?php echo get_site_option('wangguard-notice-signup-text'); ?></textarea>
					</p>
				<?php	}

add_action('wangguard_setting','wangguard_registration_notices_fileds' );

/********************************************************************/
/*** ADD MESSAGE IN THE REGISTRATION FORM BEGINS **/
/********************************************************************/


function wangguard_signup_message($message){
		if ( get_site_option("wangguard-notice-signup")=='1') {
		if (strpos($message, 'register') !== FALSE) {
			if  ( get_site_option("wangguard-notice-signup-text")!=='') {
				$wggmessage = get_site_option("wangguard-notice-signup-text");
			} else {
			$wggmessage = "This website is protected by <a href='http://www.wangguard.com/'>WangGuard</a>, don’t try to
signup with a Proxy, VPN or TOR Network or you will be blocked.";
				}
			return '<p class="message register">' . $wggmessage . '</p>';
		}
		else {
			return $message;
		}
	}
	}
add_action('login_message', 'wangguard_signup_message');	
/********************************************************************/
/*** ADD MESSAGE IN THE REGISTRATION FORM ENDS **/
/********************************************************************/



?>