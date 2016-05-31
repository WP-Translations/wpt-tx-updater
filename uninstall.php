<?php
// If uninstall not called from WordPress exit
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete all user meta related to WPT Transifex Updater
delete_metadata( 'user', '', 'wptxu_transifex_auth', '', true );