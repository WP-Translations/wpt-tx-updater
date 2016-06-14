<?php
// If uninstall not called from WordPress exit
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete all user meta related to WPT Transifex Updater
delete_metadata( 'user', '', 'wptxu_transifex_auth', '', true );
delete_metadata( 'user', '', 'wptxu_transifex_user', '', true );

// Delete all project meta related to WPT Transifex Updater
delete_metadata( 'post', '', 'wptxu_project_type', '', true );
delete_metadata( 'post', '', 'wptxu_mo_filename', '', true );