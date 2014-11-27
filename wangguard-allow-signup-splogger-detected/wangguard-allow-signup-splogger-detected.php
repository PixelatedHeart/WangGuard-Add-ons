<?php
/*
Plugin Name: WangGuard Allow Signup Sploggers Detected Add-On
Plugin URI: http://www.wangguard.com
Description: With this Add-On you can blacklist Words. WangGuard plugin version 1.6 or higher is required, download it for free from <a href="http://wordpress.org/extend/plugins/wangguard/">http://wordpress.org/extend/plugins/wangguard/</a>.
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

define('WANGGUARD_ALLOW_SIGNUP_SPLOGGER_DETECTED', '1.0');

function wangguard_allow_signup_splogger_detected_init() {

if (function_exists('load_plugin_textdomain')) {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain('wangguard-allow-signup-splogger-detected', false, $plugin_dir . "/languages/" );
	}
}
add_action('init', 'wangguard_allow_signup_splogger_detected_init');

function wangguard_allow_signup_splogger_detected_activate() {

	add_site_option('wangguard_allow_signup_emails_list','');
}
register_activation_hook( 'wangguard-allow-signup-splogger-detected/wangguard-allow-signup-splogger-detected.php', 'wangguard_allow_signup_splogger_detected_activate' );


function wangguard_allow_signup_splogger_detected_notices() {
	if ( !defined('WANGGUARD_VERSION') ) {
		echo "
		<div  class='error fade'><p><strong>".__('WangGuard Allow Signup Sploggers Detected Add-on is almost ready.', 'wangguard-allow-signup-splogger-detected')."</strong> ". __('You must install and activate <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> 1.6-RC1 or higher to use this plugin.', 'wangguard-allow-signup-splogger-detected')."</p></div>
		";
	}
	else {
		if ( defined('WANGGUARD_VERSION') ) {$version = WANGGUARD_VERSION;}
		if ( !empty($version) ) {
		if (version_compare($version , '1.6') == -1)
			echo "
			<div  class='error fade'><p><strong>".__('WangGuard Allow Signup Sploggers Detected Add-On is almost ready.', 'wangguard-allow-signup-splogger-detected')."</strong> ". __('You need to upgrade <a href="http://wordpress.org/extend/plugins/wangguard/">WangGuard</a> to version 1.6-RC1 or higher to use this plugin.', 'wangguard-allow-signup-splogger-detected')."</p></div>
			";
}
}
}
add_action('admin_notices', 'wangguard_allow_signup_splogger_detected_notices');


// Save the new settings
function wangguard_save_allow_signup_splogger_detected_fileds(){

			//Save allowed emails

			$wangguardnewallowemailsploggers = $_POST['wangguard_allow_emails_signup_list'];
			$wangguardlisttoarrayallowemailsploggers = explode("\n", maybe_serialize(strtolower($wangguardnewallowemailsploggers)));
			update_site_option('wangguard_allow_signup_emails_list', $wangguardlisttoarrayallowemailsploggers);
}
add_action('wangguard_save_setting_option', 'wangguard_save_allow_signup_splogger_detected_fileds');


//Add setting to WangGuard Setting page
function wangguard_allow_signup_splogger_detected_fileds() { ?>
					<h3>Allow emails to signup</h3>
					<p>
						<label for="wangguard_allow_emails_signup_list"><?php _e( 'Allowed emails. One per line', 'wangguard-allow-signup-splogger-detected' ) ?></label><br />

						<?php $wangguard_allow_emails_signup_list_array = get_site_option( 'wangguard_allow_signup_emails_list' );
						$wangguard_allow_emails_signup_list = str_replace( ' ', "\n", $wangguard_allow_emails_signup_list_array ); ?>
						<textarea name="wangguard_allow_emails_signup_list" id="wangguard_allow_emails_signup_list" cols="45" rows="5"><?php echo esc_textarea( $wangguard_allow_emails_signup_list == '' ? '' : implode( "\n", (array) $wangguard_allow_emails_signup_list ) ); ?></textarea>
					</p>
<?php
}
add_action('wangguard_setting','wangguard_allow_signup_splogger_detected_fileds' );

/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS REGISTRATION FORM BEGINS **/
/********************************************************************/

function wangguard_allow_signup_whitelisted(){
	$wggstopcheck = true;
			return $wggstopcheck;
}

function wangguard_allow_singup_splogger_check_email( $user_email ){

  $aploggerallowedtosignup = wangguard_look_for_allowed_email($user_email);

  if ( $aploggerallowedtosignup ) {

  		add_filter('pre_wangguard_validate_signup_form_wordpress_no_multisite', 'wangguard_allow_signup_whitelisted',10,3);
			}
}
add_action('pre_wangguard_validate_signup_form_wordpress_no_multisite', 'wangguard_allow_singup_splogger_check_email');

/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS REGISTRATION FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** ADD MESSAGE IN THE WORDPRESS MULTISITE REGISTRATION FORM BEGINS **/
/********************************************************************/

if (is_multisite()) {
		// require( dirname( __FILE__ ) . '/wangguard-blacklisted-words-wpmu.php' );
	}


/********************************************************************/

/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS BUDDYPRESS REGISTRATION FORM BEGINS **/
/********************************************************************/

function wangguard_bp_blacklisted_words_code() {
   // require( dirname( __FILE__ ) . '/wangguard-blacklisted-words-bp.php' );
}
add_action( 'bp_include', 'wangguard_bp_blacklisted_words_code' );



/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS BUDDYPRESS REGISTRATION FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** CHECK DOMAINS IN THE WOOCOMMERCE MY ACCOUNT FORM BEGINS **/
/********************************************************************/
function wangguard_blacklisted_words_woocommerce_add_on($user_name, $email, $errors){

		$user_email = $_POST['email'];

        $blocked = wangguard_check_bl_word_email($user_email);

		if ($blocked) {
			$errors->add('user_email',   __('<strong>ERROR</strong>: Your email has words not Allowed in this site.', 'wangguard-blacklisted-words'));
			return $errors;
        }
}
// if (get_option('woocommerce_enable_myaccount_registration')=='yes') add_action('woocommerce_before_customer_login_form', 'wangguard_blacklisted_words_woocommerce_add_on');
/********************************************************************/
/*** CHECK DOMAINS IN THE WOOCOMMERCE MY ACCOUNT FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** LOOK FOR EMAILS BEGINS **/
/********************************************************************/


function wangguard_look_for_allowed_email($user_email){

	$arrayallowedbemails = get_site_option('wangguard_allow_signup_emails_list');
	foreach ($arrayallowedbemails as $key => $value) {$arrayallowedbemails[$key] = trim ($value);}
	$search_for = $user_email;
	if (array_search ($search_for, $arrayallowedbemails, true)===false) {
				return false;
				} else {
					return true;
				}
}

/********************************************************************/
/*** LOOK FOR EMAILS ENDS **/
/********************************************************************/
?>