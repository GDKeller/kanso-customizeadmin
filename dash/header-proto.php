<?php

	

?>
	<link type="text/css" href="<?php echo PLUGINS_URL() . '/kanso/dash/css/common.css' ;?>" rel="stylesheet">
	<link type="text/css" href="<?php echo PLUGINS_URL() . '/kanso/css/wp-admin.css' ;?>" rel="stylesheet">
	<!-- <link type="text/css" href="<?php echo WP_PLUGIN_DIR ?>/css/jquery.cleditor.css" rel="stylesheet" /> -->






<?php


@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
if ( ! defined( 'WP_ADMIN' ) )
	require_once( dirname( __FILE__ ) . '/admin.php' );

/**
 * In case admin-header.php is included in a function.
 *
 * @global string    $title
 * @global string    $hook_suffix
 * @global WP_Screen $current_screen
 * @global WP_Locale $wp_locale
 * @global string    $pagenow
 * @global string    $wp_version
 * @global string    $update_title
 * @global int       $total_update_count
 * @global string    $parent_file
 */
global $title, $hook_suffix, $current_screen, $wp_locale, $pagenow, $wp_version,
	$update_title, $total_update_count, $parent_file;

// Catch plugins that include admin-header.php before admin.php completes.
if ( empty( $current_screen ) )
	set_current_screen();

get_admin_page_title();
$title = esc_html( strip_tags( $title ) );

if ( is_network_admin() )
	$admin_title = sprintf( __( 'Network Admin: %s' ), esc_html( get_current_site()->site_name ) );
elseif ( is_user_admin() )
	$admin_title = sprintf( __( 'User Dashboard: %s' ), esc_html( get_current_site()->site_name ) );
else
	$admin_title = get_bloginfo( 'name' );

if ( $admin_title == $title )
	$admin_title = sprintf( __( '%1$s &#8212; WordPress' ), $title );
else
	$admin_title = sprintf( __( '%1$s &lsaquo; %2$s &#8212; WordPress' ), $title, $admin_title );

/**
 * Filter the title tag content for an admin page.
 *
 * @since 3.1.0
 *
 * @param string $admin_title The page title, with extra context added.
 * @param string $title       The original page title.
 */
$admin_title = apply_filters( 'admin_title', $admin_title, $title );

wp_user_settings();

_wp_admin_html_begin();
?>
<title><?php echo $admin_title; ?></title>
<?php

wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_script('utils');
wp_enqueue_script( 'svg-painter' );

$admin_body_class = preg_replace('/[^a-z0-9_-]+/i', '-', $hook_suffix);
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>',
	pagenow = '<?php echo $current_screen->id; ?>',
	typenow = '<?php echo $current_screen->post_type; ?>',
	adminpage = '<?php echo $admin_body_class; ?>',
	thousandsSeparator = '<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>',
	decimalPoint = '<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>',
	isRtl = <?php echo (int) is_rtl(); ?>;
</script>
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<?php

/**
 * Enqueue scripts for all admin pages.
 *
 * @since 2.8.0
 *
 * @param string $hook_suffix The current admin page.
 */
do_action( 'admin_enqueue_scripts', $hook_suffix );

/**
 * Fires when styles are printed for a specific admin page based on $hook_suffix.
 *
 * @since 2.6.0
 */
do_action( "admin_print_styles-$hook_suffix" );

/**
 * Fires when styles are printed for all admin pages.
 *
 * @since 2.6.0
 */
do_action( 'admin_print_styles' );

/**
 * Fires when scripts are printed for a specific admin page based on $hook_suffix.
 *
 * @since 2.1.0
 */
do_action( "admin_print_scripts-$hook_suffix" );

/**
 * Fires when scripts are printed for all admin pages.
 *
 * @since 2.1.0
 */
do_action( 'admin_print_scripts' );

/**
 * Fires in head section for a specific admin page.
 *
 * The dynamic portion of the hook, `$hook_suffix`, refers to the hook suffix
 * for the admin page.
 *
 * @since 2.1.0
 */
do_action( "admin_head-$hook_suffix" );

/**
 * Fires in head section for all admin pages.
 *
 * @since 2.1.0
 */
do_action( 'admin_head' );

if ( get_user_setting('mfold') == 'f' )
	$admin_body_class .= ' folded';

if ( !get_user_setting('unfold') )
	$admin_body_class .= ' auto-fold';

if ( is_admin_bar_showing() )
	$admin_body_class .= ' admin-bar';

if ( is_rtl() )
	$admin_body_class .= ' rtl';

if ( $current_screen->post_type )
	$admin_body_class .= ' post-type-' . $current_screen->post_type;

if ( $current_screen->taxonomy )
	$admin_body_class .= ' taxonomy-' . $current_screen->taxonomy;

$admin_body_class .= ' branch-' . str_replace( array( '.', ',' ), '-', floatval( $wp_version ) );
$admin_body_class .= ' version-' . str_replace( '.', '-', preg_replace( '/^([.0-9]+).*/', '$1', $wp_version ) );
$admin_body_class .= ' admin-color-' . sanitize_html_class( get_user_option( 'admin_color' ), 'fresh' );
$admin_body_class .= ' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

if ( wp_is_mobile() )
	$admin_body_class .= ' mobile';

if ( is_multisite() )
	$admin_body_class .= ' multisite';

if ( is_network_admin() )
	$admin_body_class .= ' network-admin';

$admin_body_class .= ' no-customize-support no-svg';

?>




</head>

<body id="wdeb-mode" class="wp-admin no-js <?php echo apply_filters( 'admin_body_class', '' ) . " $admin_body_class"; ?>">

<script type="text/javascript">
//<![CDATA[
(function(){
var c = document.body.className;
c = c.replace(/no-js/, 'js');
document.body.className = c;
})();
//]]>
</script>

<div id="wpwrap">

<?php
/**
 * Displays Administration Menu.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * The current page.
 *
 * @global string $self
 */
$self = preg_replace('|^.*/wp-admin/network/|i', '', $_SERVER['PHP_SELF']);
$self = preg_replace('|^.*/wp-admin/|i', '', $self);
$self = preg_replace('|^.*/plugins/|i', '', $self);
$self = preg_replace('|^.*/mu-plugins/|i', '', $self);

/**
 * For when admin-header is included from within a function.
 *
 * @global array  $menu
 * @global array  $submenu
 * @global string $parent_file
 * @global string $submenu_file
 */
global $menu, $submenu, $parent_file, $submenu_file;

/**
 * Filter the parent file of an admin menu sub-menu item.
 *
 * Allows plugins to move sub-menu items around.
 *
 * @since MU
 *
 * @param string $parent_file The parent file.
 */
$parent_file = apply_filters( 'parent_file', $parent_file );

/**
 * Filter the file of an admin menu sub-menu item.
 *
 * @since 4.4.0
 *
 * @param string $submenu_file The submenu file.
 * @param string $parent_file  The submenu item's parent file.
 */
$submenu_file = apply_filters( 'submenu_file', $submenu_file, $parent_file );

get_admin_page_parent();

/**
 * Display menu.
 *
 * @access private
 * @since 2.7.0
 *
 * @global string $self
 * @global string $parent_file
 * @global string $submenu_file
 * @global string $plugin_page
 * @global string $typenow
 *
 * @param array $menu
 * @param array $submenu
 * @param bool  $submenu_as_parent
 */
?>














<div id="adminmenumain" role="navigation" aria-label="<?php esc_attr_e( 'Main menu' ); ?>">
	<a href="#wpbody-content" class="screen-reader-shortcut"><?php _e( 'Skip to main content' ); ?></a>
	<a href="#wp-toolbar" class="screen-reader-shortcut"><?php _e( 'Skip to toolbar' ); ?></a>
	<div id="adminmenuback"></div>
	<div id="adminmenuwrap">
		<div class="userinfo" style="color:white;text-align:center;">
			<?php

				$current_user = wp_get_current_user();
				echo get_avatar($current_user);
				echo '<h2 style="color:white;">' . $current_user->user_login . '</h2>' ;
				echo date( 'h:i A', current_time( 'timestamp' ) );

			?>
			
		</div>

		<ul id="adminmenu">

		<?php

		_wp_menu_output( $menu, $submenu );
		/**
		 * Fires after the admin menu has been output.
		 *
		 * @since 2.5.0
		 */
		do_action( 'adminmenu' );

		?>
		</ul>
	</div>
</div>




<div id="wpcontent">

<?php
/**
 * Fires at the beginning of the content section in an admin page.
 *
 * @since 3.0.0
 */
do_action( 'in_admin_header' );
?>

	<div id="wpbody" role="main">
	<?php
	unset($title_class, $blog_name, $total_update_count, $update_title);

	$current_screen->set_parentage( $parent_file );

	?>

		<div id="wpbody-content" aria-label="<?php esc_attr_e('Main content'); ?>" tabindex="0">
		<?php

		$current_screen->render_screen_meta();

		if ( is_network_admin() ) {
			/**
			 * Print network admin screen notices.
			 *
			 * @since 3.1.0
			 */
			do_action( 'network_admin_notices' );
		} elseif ( is_user_admin() ) {
			/**
			 * Print user admin screen notices.
			 *
			 * @since 3.1.0
			 */
			do_action( 'user_admin_notices' );
		} else {
			/**
			 * Print admin screen notices.
			 *
			 * @since 3.1.0
			 */
			do_action( 'admin_notices' );
		}

		/**
		 * Print generic admin screen notices.
		 *
		 * @since 3.1.0
		 */
		do_action( 'all_admin_notices' );

		if ( $parent_file == 'options-general.php' )
			require(ABSPATH . 'wp-admin/options-head.php');
