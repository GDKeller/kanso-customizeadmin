<?php
/*
Plugin Name: Kanso (簡素)
Description: One of seven tenets of the Wabi-sabi aesthetic - Simplicity & elimination of clutter.
Author: Keller Digital
Version: 1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ================== DECLARE & IMPORT ================== */
global $kanso_redux;

require(WP_PLUGIN_DIR . '/kanso/custom-login.php');     // Load custom login features
require_once('options/admin-init.php');                 // Load the Redux Options
//require_once(WP_PLUGIN_DIR . '/kanso/dash/load-kanso-dash.php');



/* ================== STYLE OPTIONS PANEL ================== */
// Load custom Redux options panel styles
add_action('admin_enqueue_scripts', 'kanso_panel_style');
function kanso_panel_style() {
    global $kanso_redux;
    wp_enqueue_style('kanso-admin-theme', plugins_url('css/panel.css', __FILE__));
}



/* ================== DASHBOARD CUSTOMIZATION ================== */

// Remove Welcome Panel
remove_action( 'welcome_panel', 'wp_welcome_panel' );

// Remove Dashboard widgets
add_action( 'wp_dashboard_setup', 'kanso_remove_dashboard_meta' );
function kanso_remove_dashboard_meta() {
    //if (!current_user_can('update_core')) {
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Plugins
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        //remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' ); // Incoming Links
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Press
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' ); // Recent Drafts
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
        //remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // Right Now
        //remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Activity
        remove_meta_box( 'arve_dashboard_widget', 'dashboard', 'normal' ); // ARVE
        remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side' ); // Redux
        //remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' ); // Gravity Forms
        remove_meta_box( 'pmpro_db_widget', 'dashboard', 'normal' ); // PaidMembershipsPro
    //}
}



/* ================== ADMIN MENU LAYOUTS ================== */
add_action( 'admin_menu' , 'kanso_admin_menu_user_item' );
function kanso_admin_menu_user_item() {
    global $kanso_redux;
    if( $kanso_redux['global-enable-switch'] == 1 && $kanso_redux['adminlayout-enable-switch'] == 1 ) {
        global $menu;
        $current_user = wp_get_current_user() ;
        $stuff .= get_avatar($current_user);
        $stuff .= "<h2 >" . $current_user->user_login .  "</h2>" ;
        $stuff .= "<h3>" . date( "h:i A", current_time( "timestamp" ) . "</h3>" );
        $menu[0] = array( __($stuff), 'manage_options', 'profile.php', '', 'user_info', '', 'div', );
    }
}
add_action( 'after_setup_theme', 'kanso_adminlayout_userphoto' );
function kanso_adminlayout_userphoto() {
    global $kanso_redux;
    if( $kanso_redux['global-enable-switch'] == 1 && $kanso_redux['adminlayout-enable-switch'] == 1 ) {
        wp_enqueue_style('adminlayout-styles', plugin_dir_url(__FILE__).'css/layouts/userphoto.css');
    }
}


/* ================== ADMIN COLORS & THEMES ================== */

add_action( 'after_setup_theme', 'kanso_custom_dash' );
function kanso_custom_dash() {
    global $kanso_redux;
    if( $kanso_redux['global-enable-switch'] == 1 && $kanso_redux['admincolors-enable-switch'] == 1 ) {
        if( $kanso_redux['admin-colors-select'] == gunmetal ) {
            wp_enqueue_style('customdash-gunmetal', plugin_dir_url(__FILE__).'css/themes/gunmetal.css');
        } else if( $kanso_redux['admin-colors-select'] == blue ) {
            wp_enqueue_style('customdash-blue', plugin_dir_url(__FILE__).'css/themes/blue.css');
        } else if( $kanso_redux['admin-colors-select'] == red ) {
            wp_enqueue_style('customdash-red', plugin_dir_url(__FILE__).'css/themes/red.css');
        }
    }
}



/* ================== ADMIN TOOLBAR CUSTOMIZATION ================== */

add_action('admin_enqueue_scripts', 'kanso_custom_topbar_backend');
function kanso_custom_topbar_backend() {
    global $kanso_redux;
    if( $kanso_redux['customtopbar-enable-switch'] == 1 && $kanso_redux['topbar-display'] == 3 ) {
        wp_enqueue_style('kanso-killtopbar', plugins_url('css/killtopbar.css', __FILE__));
    }
}

add_action( 'wp_loaded', 'kanso_custom_topbarlayout_floating');
function kanso_custom_topbarlayout_floating() {
    global $kanso_redux;
    if( $kanso_redux['customtopbar-enable-switch'] == 1 ) {
        if ($kanso_redux['toolbar-layout-select'] == 'floating-right' ) {
            wp_enqueue_style('topbarlayout-frontend', plugins_url('css/admin-bar/floating-topright.css', __FILE__));
        } elseif ($kanso_redux['toolbar-layout-select'] == 'floating-left' ) {
            wp_enqueue_style('topbarlayout-frontend', plugins_url('css/admin-bar/floating-topleft.css', __FILE__));
        }
    }
}

add_action( 'wp_loaded', 'kanso_hide_toolbar_frontend' );
function kanso_hide_toolbar_frontend() {
    global $kanso_redux;
    // Remove frontend top toolbar if options 2 or 3 are selected
    if( $kanso_redux['customtopbar-enable-switch'] == 1 && ( $kanso_redux['topbar-display'] == 2 || $kanso_redux['topbar-display'] == 3 ) ) {
        add_filter('show_admin_bar', '__return_false');
    }
}

/* ------------------ Remove links from top toolbar ------------------ */
add_action( 'admin_bar_menu', 'kanso_remove_toolbar_nodes', 999 );
function kanso_remove_toolbar_nodes( $wp_admin_bar ) {
    
    global $kanso_redux;
    if( $kanso_redux['customtopbar-enable-switch'] == 1 && ( $kanso_redux['toolbar-layout-select'] == 'floating-right' || $kanso_redux['toolbar-layout-select'] == 'floating-left' ) ) {
        global $wp_admin_bar;   
        if ( !is_object( $wp_admin_bar ) )
            return;

        // Clean the AdminBar
        $nodes = $wp_admin_bar->get_nodes();
        foreach( $nodes as $node )
        {
                // 'top-secondary' is used for the User Actions right side menu
                if( !$node->parent || 'top-secondary' == $node->parent ) {
                    //$wp_admin_bar->remove_menu( $node->id );
                }           
        }
        $wp_admin_bar->remove_node( 'site-name' ); // Site
        $wp_admin_bar->remove_node( 'customize' ); // Customize
        $wp_admin_bar->remove_node( 'wp-logo' ); // WordPress
        $wp_admin_bar->remove_node( 'new-content' ); // Add New content
        $wp_admin_bar->remove_node( 'comments' ); // Comments
        $wp_admin_bar->remove_node( 'updates' ); // Updates
        $wp_admin_bar->remove_node( 'edit' ); // Edit
    }

    elseif( $kanso_redux['customtopbar-enable-switch'] == 1 && $kanso_redux['toolbar-customlinks-switch'] == 1 ) {
        if( $kanso_redux['topbar-disable-nodes']['site'] == 1 ) {
            $wp_admin_bar->remove_node( 'site-name' ); // Site
        }
        if( $kanso_redux['topbar-disable-nodes']['customize'] == 1 ) {
            $wp_admin_bar->remove_node( 'customize' ); // Customize
        }
        if( $kanso_redux['topbar-disable-nodes']['wordpress'] == 1 ) {
            $wp_admin_bar->remove_node( 'wp-logo' ); // WordPress
        }
        if( $kanso_redux['topbar-disable-nodes']['content'] == 1 ) {
            $wp_admin_bar->remove_node( 'new-content' ); // Add New content
        }
        if( $kanso_redux['topbar-disable-nodes']['comments'] == 1 ) {
            $wp_admin_bar->remove_node( 'comments' ); // Comments
        }
        if( $kanso_redux['topbar-disable-nodes']['updates'] == 1 ) {
            $wp_admin_bar->remove_node( 'updates' ); // Updates
        }
        if( $kanso_redux['topbar-disable-nodes']['edit'] == 1 ) {
            $wp_admin_bar->remove_node( 'edit' ); // Edit
        }
        //$wp_admin_bar->remove_node( 'itsec_admin_bar_menu' ); // iThemes Security
        //$wp_admin_bar->remove_node( 'headway' ); // Headway
        //$wp_admin_bar->remove_node( 'w3tc' ); // W3 Total Cache
        //$wp_admin_bar->remove_node( 'wpseo-menu' ); // Yoast SEO
    }
}



/* ------------------ Change "Howdy" ------------------ */
add_filter('gettext', 'change_howdy', 10, 3);
function change_howdy($translated, $text, $domain) {
    global $kanso_redux;
    if (!is_admin() || 'default' != $domain) { // frontend
        $howdy = "Howdy,";
        $text = $kanso_redux['howdy-text'];
        return str_replace( $howdy, $text, $translated);
    }
    if (false !== strpos($translated, 'Howdy')) { // backend admin
        $howdy = "Howdy,";
        $text = $kanso_redux['howdy-text'];
        return str_replace( $howdy, $text, $translated);
    }
    return $translated;
}



/* ================== ADMIN MENU CUSTOMIZATION ================== */

add_action( 'admin_menu', 'kanso_custom_menu_page_removing' );
function kanso_custom_menu_page_removing() {
        //remove_menu_page( 'link-manager.php' );     // Links Manage -- REMOVED FROM CORE: now has to be added as a plugin
        //remove_menu_page( 'themes.php' );           // Appearance -- (!) There are other ways to do this
        //remove_menu_page( itsec );                  // iThemes Security -- Very specific, consider revising
}



/* ================== ADMIN FOOTER ================== */

// Replace admin footer text
add_filter('admin_footer_text', 'kanso_left_admin_footer_text_output'); //left side
function kanso_left_admin_footer_text_output($text) {
    global $kanso_redux;
        
    if($kanso_redux['footer-text-switch'] == 1 && $kanso_redux['footer-text-empty'] == 0) {
        $text = $kanso_redux['footer-text-left'];
        return $text;
    }
    elseif($kanso_redux['footer-text-switch'] == 1 && $kanso_redux['footer-text-empty'] == 1) {
        $text = '';
        return $text;
    }
    return $text;
}

add_filter('update_footer', 'kanso_right_admin_footer_text_output', 11); //right side
function kanso_right_admin_footer_text_output($text) {
    global $kanso_redux;
    if($kanso_redux['footertext-enable-switch'] == 1 && $kanso_redux['footer-text-empty'] == 0) {
        $text = $kanso_redux['footer-text-right'];
        return $text;
    }
     elseif($kanso_redux['footertext-enable-switch'] == 1 && $kanso_redux['footer-text-empty'] == 1) {
        $text = '';
        return $text;
    }
    return $text;
}



/* ================== MISC ================== */

// Remove WP Core update nag for non-admin users
add_action( 'admin_head', 'kanso_hide_update_notice_to_all_but_admin_users', 1 );
function kanso_hide_update_notice_to_all_but_admin_users()
{
    if (!current_user_can('update_core')) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}







//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
//add_action( 'admin_menu', 'my_plugin_menu' );
//add_menu_page( $page_title = 'User Info', $menu_title = 'User Info', $capability = '', $menu_slug = 'user_info', $function = 'my_plugin_menu', $icon_url = '', $position = '1' );

// add_action( 'admin_menu', 'kanso_user_menu' );
// function kanso_user_menu(){
//     add_menu_page('Page title', 'Top-level menu title', 'manage_options', 'my-top-level-handle', 'kanso_user_function', '', '1');
// }


// /** Step 3. */
// function kanso_user_function() {
//     //if ( !current_user_can( 'manage_options' ) )  {
//     //    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
//     //}
//     echo '<div class="wrap">';
//     echo '<p>Here is where the form would go if I actually had options.</p>';
//     echo '</div>';
// }