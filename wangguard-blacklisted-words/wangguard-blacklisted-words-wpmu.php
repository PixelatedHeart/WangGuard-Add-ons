<?PHP
/**
 * Add BP BLACKLISTED WORDS
 *
 * @author 		WangGuard
 * @package 	WangGuard/Add-on
 * @version     1.0
 */

function wangguard_blacklisted_words_wpmu_user_name($result) {

	
		$words = array_filter(get_site_option( 'wangguard_blacklisted_words_list'));
       		if (!empty($words)){
		$user_name = $_POST['user_name'];

		//check domain against the list of selected blocked domains
		$blocked = wangguard_look_for_bl_word($user_name);
		
		if ($blocked) {
			$result['errors']->add('user_name',   __('<strong>ERROR</strong>: Your user name has words not Allowed in this site.', 'wangguard'));
		}
		
		return $result;
	}
}

function wangguard_blacklisted_words_wpmu_user_email($result) {

	$words = array_filter(get_site_option( 'wangguard_blacklisted_words_list'));
       		if (!empty($words)){
		$user_email = $_POST['user_email'];

		//check domain against the list of selected blocked domains
		$blocked = wangguard_look_for_bl_word($user_email);
		
		if ($blocked) {
			$result['errors']->add('user_email',   __('<strong>ERROR</strong>: Your email has words not Allowed in this site.', 'wangguard'));
		}
		
	return $result; 
	}
}

function wangguard_blacklisted_words_wpmu_blogname($result) {

	
		$words = array_filter(get_site_option( 'wangguard_blacklisted_words_list'));
       		if (!empty($words)){
		$blogname = $_POST['blogname'];

		//check domain against the list of selected blocked domains
		$blocked = wangguard_look_for_bl_word($blogname);
		
		if ($blocked) {
			$result['errors']->add('blogname',   __('<strong>ERROR</strong>: Your domain name has words not Allowed in this site.', 'wangguard'));
		}
		
	return $result; 
	}
}

function wangguard_blacklisted_words_wpmu_blog_title($result) {

	
		$words = array_filter(get_site_option( 'wangguard_blacklisted_words_list'));
       		if (!empty($words)){
       		$blog_title = $_POST['blog_title'];

		//check domain against the list of selected blocked domains
		$blocked = wangguard_look_for_bl_word($blog_title);
		
		if ($blocked) {
			$result['errors']->add('blog_title',   __('<strong>ERROR</strong>: Your title has words not Allowed in this site.', 'wangguard'));
		}
		
	return $result; 
}
}

$words = array_filter(get_site_option( 'wangguard_blacklisted_words_list'));
       		if (!empty($words)){
       			add_filter('wpmu_validate_user_signup', 'wangguard_blacklisted_words_wpmu_user_name',120);
	   			add_filter('wpmu_validate_user_signup', 'wangguard_blacklisted_words_wpmu_user_email',130);
	   			add_filter('wpmu_validate_blog_signup', 'wangguard_blacklisted_words_wpmu_blogname',90);
	   			add_filter('wpmu_validate_blog_signup', 'wangguard_blacklisted_words_wpmu_blog_title',100);
}
?>