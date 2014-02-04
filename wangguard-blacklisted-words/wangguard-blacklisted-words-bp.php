<?PHP
/**
 * Add BP BLACKLISTED WORDS
 *
 * @author 		WangGuard
 * @package 	WangGuard/Add-on
 * @version     1.0
 */

function wangguard_bp_blacklisted_words_user_name_add_on(){
		global $bp;
		
		$signup_email = $_REQUEST['signup_username'];
        $blocked = wangguard_look_for_bl_word($signup_email);
   		if ($blocked) {
				$bp->signup->errors['signup_username'] = wangguard_fix_bp_slashes_maybe( __("<strong>ERROR</strong>: Your user name has words not Allowed in this site.", 'wangguard'));
        }     
        if (isset ($bp->signup->errors['signup_email']))$bp->signup->errors['signup_username'] = wangguard_fix_bp_slashes_maybe($bp->signup->errors['signup_username']);  
}

function wangguard_bp_blacklisted_words_email_add_on(){
		global $bp;
		
		$signup_email = $_REQUEST['signup_email'];
        $blocked = wangguard_look_for_bl_word($signup_email);
   		if ($blocked) {
				$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe( __("<strong>ERROR</strong>: Your email has words not Allowed in this site.", 'wangguard'));
        }     
        if (isset ($bp->signup->errors['signup_email']))$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe($bp->signup->errors['signup_email']);  
}
add_action('bp_signup_validate', 'wangguard_bp_blacklisted_words_user_name_add_on');
add_action('bp_signup_validate', 'wangguard_bp_blacklisted_words_email_add_on');
?>