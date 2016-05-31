<?php
defined('ABSPATH') or die('Cheatin&#8217; uh?');

add_action('add_meta_boxes','wptxu_metaboxes');
function wptxu_metaboxes(){

	add_meta_box('wptxu_tx_api_metaboxe', __('Transifex API', 'wpt-tx-updater'), 'wptxu_get_translation', 'wptxu-project', 'normal', 'high');

}

