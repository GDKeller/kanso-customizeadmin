<?php

function start_cache () {
        ob_start();
    }
add_action('admin_head', 'start_cache');
function end_header_cache () {
        $header_html = ob_get_contents();
        ob_end_clean();
        include apply_filters('kanso_dash-header', WP_PLUGIN_DIR . '/kanso/dash/admin-header.php');
    }
    add_action('admin_notices', 'end_header_cache');


    add_action('eab-admin_toolbar-render', 'wp_admin_bar_render');