<?php
function wangguard_bp_signup_message(){
		if ( bp_is_register_page() ) {
			if ( get_site_option('wangguard-notice-signup')=='1') {
				if  ( get_site_option('wangguard-notice-signup-text')!=='') {
					$wggmessage = get_site_option('wangguard-notice-signup-text');
					} else {
						$wangguardlink = 'http://www.wangguard.com';
						$wggmessage = __( 'This website is protected by <a href=' . $wangguardlink . '>WangGuard</a>, don\'t try to signup with a Proxy, VPN or TOR Network or you will be blocked', 'wangguard-registration-add-on'); 
					}?>
			<p class="message register"><?php echo $wggmessage; ?></p><?php
			}
		}
	}
add_action('template_notices', 'wangguard_bp_signup_message');
?>