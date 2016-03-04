<?php
// If not called by WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

// Remove settings from database
delete_option('acf_rcpo_settings');
