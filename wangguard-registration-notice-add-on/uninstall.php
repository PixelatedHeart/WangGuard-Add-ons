<?php
/**
 * Uninstall WangGuard Registration Notice Add-On
 * @version     1.0
 */
if( !defined('WP_UNINSTALL_PLUGIN') ) exit();


//Remove Options used by this Add_on

delete_site_option('wangguard-notice-signup');
delete_site_option('wangguard-notice-signup-text');
delete_site_option('wangguard-notice-signup-text-css');

?>