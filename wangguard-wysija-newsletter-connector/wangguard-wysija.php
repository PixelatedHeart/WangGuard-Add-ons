<?php
/*
Plugin Name: WangGuard Wysija subscribers verifier
Plugin URI: http://www.wangguard.com
Description: <strong>Block out Sploggers from your Wysija subscribers</strong>. Verify Wysija subscribers before adding them to your Wysija subscribers list, use WangGuard service to verify that each new subscriber is not reported as a known Splogger. WangGuard plugin version 1.5.3 or higher is required, download it for free from <a href="http://wordpress.org/extend/plugins/wangguard/">http://wordpress.org/extend/plugins/wangguard/</a>.
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



/**
 * wangguard_wysija_verify: function that gets called from the wysija_beforeAddSubscriber filter
 * 
 * Checks if an email is reported as Splogger on WangGuard.
 * Server errors or missing api key errors are silently discarted and is assumed the user is not reported.
 * 
 * @param boolean $isValid
 * @param string $email
 * @return boolean
 */
function wangguard_wysija_verify( $isValid , $email ) {
    //email has been flagged as  not valid in a previous hook
    if(!$isValid) return $isValid;
	
	if (!function_exists('wangguard_verify_email') ||
		!function_exists('wangguard_getRemoteIP') ||
		!function_exists('wangguard_getRemoteProxyIP')) return $isValid;
	
	$ret = wangguard_verify_email($email, wangguard_getRemoteIP() , wangguard_getRemoteProxyIP());
    return $ret != 'reported';
}

//add filter for validating wysija emails
add_filter('wysija_beforeAddSubscriber','wangguard_wysija_verify',10,2);


//Admin init function
function wangguard_wysija_notices() {
	if (!is_plugin_active("wangguard/wangguard-admin.php")) {
		echo "
		<div  class='updated fade'><p><strong>".__('WangGuard - Wysija Newsletter Connector is almost ready.', 'wangguard-wysija')."</strong> ". __('You must install and activate <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> 1.5.3 or higher to use this plugin.', 'wangguard-wysija')."</p></div>
		";
	}
	else {
		$data = @get_plugin_data(ABSPATH . PLUGINDIR . "/wangguard/wangguard-admin.php");
		$version = @$data['Version'];
		if ($version)
		if (version_compare($version , '1.5.3') == -1)
			echo "
			<div  class='updated fade'><p><strong>".__('WangGuard - Wysija Newsletter Connector is almost ready.', 'wangguard-wysija')."</strong> ". __('You need to upgrade <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> to version 1.5.3 or higher to use this plugin.', 'wangguard-wysija')."</p></div>
			";
	}
	
	if (!is_plugin_active("wysija-newsletters/index.php")) {
		echo "
		<div  class='updated fade'><p><strong>".__('WangGuard - Wysija Newsletter Connector is almost ready.', 'wangguard-wysija')."</strong> ". __('You must install and activate <a href="http://wordpress.org/extend/plugins/wysija-newsletters/">Wysija Newsletters</a> 2.1.9 or higher to use this plugin.', 'wangguard-wysija')."</p></div>
		";
	}
	else {
		$data = @get_plugin_data(ABSPATH . PLUGINDIR . "/wysija-newsletters/index.php");
		$version = @$data['Version'];
		if ($version)
		if (version_compare($version , '2.1.9') == -1)
			echo "
			<div  class='updated fade'><p><strong>".__('WangGuard - Wysija Newsletter Connector is almost ready.', 'wangguard-wysija')."</strong> ". __('You need to upgrade <a href="http://wordpress.org/extend/plugins/wysija-newsletters/">Wysija Newsletters</a> to version 2.1.9 or higher to use this plugin.', 'wangguard-wysija')."</p></div>
			";
	}
}
add_action('admin_notices', 'wangguard_wysija_notices');

?>