<?PHP
/**
 * Add BP DOMAIN CHECK
 *
 * @author 		WangGuard
 * @package 	WangGuard/Add-on
 * @version     1.0
 */

function wangguard_limit_domain_registration_bp_blocked_add_on(){
		global $bp;
		
		$signup_email = $_REQUEST['signup_email'];
        
        $blocked = wangguard_is_domain_blocked_add_on($signup_email);
		
		if ($blocked) {
			$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe( __("<strong>ERROR</strong>: Domain not allowed.", 'wangguard'));
        }     
        if (isset ($bp->signup->errors['signup_email']))$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe($bp->signup->errors['signup_email']);  
}

function wangguard_limit_domain_registration_allowed_bp_add_on(){
		global $bp;
        
        $signup_email = $_REQUEST['signup_email'];
        
        $allowed = wangguard_is_domain_allowed_add_on($signup_email);
		
		if ($allowed == false) {
			$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe(__("<strong>ERROR</strong>: Domain not allowed Limitación a uno.", 'wangguard'));
        }
        if (isset ($bp->signup->errors['signup_email']))$bp->signup->errors['signup_email'] = wangguard_fix_bp_slashes_maybe($bp->signup->errors['signup_email']);      
}
//add_action('wangguard_wp_signup_validate', 'wangguard_limit_domain_regisration_blocked_allowed_add_on');
add_action('bp_signup_validate', 'wangguard_limit_domain_registration_bp_blocked_add_on',10,3);
add_action('bp_signup_validate', 'wangguard_limit_domain_registration_allowed_bp_add_on',10,3);
?>