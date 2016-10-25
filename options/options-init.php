<?php

    /**
     * For full documentation, please visit: http://docs.reduxframework.com/
     * For a more extensive sample-config file, you may look at:
     * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "kanso_redux";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        'opt_name' => 'kanso_redux',
        'display_name' => 'Kanso',
        'display_version' => '1.0.0',
        'page_slug' => 'kanso',
        'page_title' => 'Kanso',
        'intro_text' => 'Konichiwa!',
        'footer_text' => 'Domo Arigato.',
        'menu_type' => 'submenu',
        'menu_title' => 'Kanso',
        'allow_sub_menu' => TRUE,
        'page_parent' => 'options-general.php',
        'page_parent_post_type' => 'your_post_type',
        'customizer' => TRUE,
        'admin_bar'    => FALSE,
        'default_mark' => '*',
        'hints' => array(
            'icon_position' => 'right',
            'icon_size' => 'normal',
            'tip_style' => array(
                'color' => 'light',
            ),
            'tip_position' => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect' => array(
                'show' => array(
                    'duration' => '500',
                    'event' => 'mouseover',
                ),
                'hide' => array(
                    'duration' => '500',
                    'event' => 'mouseleave unfocus',
                ),
            ),
        ),
        'output' => TRUE,
        'output_tag' => TRUE,
        'settings_api' => TRUE,
        'cdn_check_time' => '1440',
        'compiler' => TRUE,
        'page_permissions' => 'manage_options',
        'save_defaults' => TRUE,
        'show_import_export' => TRUE,
        'database' => 'options',
        'transient_time' => '3600',
        'network_sites' => TRUE,
        'ajax_save' => false,
        'dev_mode' => false,

    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    /*
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
        'title' => 'Visit us on GitHub',
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/reduxframework',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/redux-framework',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );
    */



    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'admin_folder' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'admin_folder' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'admin_folder' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'admin_folder' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'admin_folder' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */


    Redux::setSection( $opt_name, array(
        'title' => __( 'General', 'kanso-options' ),
        'id'    => 'general-options',
        'desc'  => __( 'Enable/disable specific (or all) features.', 'kanso-options' ),
        'icon'  => 'el el-home',
        'fields'     => array(
            array(
                'id'       => 'global-enable-switch',
                'type'     => 'switch',
                'title'    => 'Enable All Features',
                'description' => 'Switch to "off" to completely disable everything this plugin does (useful for testing)',
                'on'       => 'Enabled',
                'off'      => 'Disabled',
                'default'  => '1',
            ),
            array(
                'required' => array('global-enable-switch','=','1'),
                'id'       => 'adminlayout-enable-switch',
                'type'     => 'switch',
                'title'    => 'Custom Admin Area & Menu Layouts',
                'description' => 'Enables custom menu layouts',
                'default'  => '1',
            ),
            array(
                'required' => array('global-enable-switch','=','1'),
                'id'       => 'customtopbar-enable-switch',
                'type'     => 'switch',
                'title'    => 'Custom Top Toolbar',
                'description' => 'Custom topbar layouts & display',
                'default'  => '1',
            ),
            array(
                'required' => array('global-enable-switch','=','1'),
                'id'       => 'footertext-enable-switch',
                'type'     => 'switch',
                'title'    => 'Custom Admin Area Footer Text',
                'description' => 'Customize footer text in the admin area',
                'default'  => '1',
            ),
            array(
                'required' => array('global-enable-switch','=','1'),
                'id'       => 'admincolors-enable-switch',
                'type'     => 'switch',
                'title'    => 'Custom Admin Area Colors',
                'description' => 'Custom colors in the admin area',
                'default'  => '1',
            ),
        )
) );

  
    Redux::setSection( $opt_name, array(
        'title' => __( 'Admin Layout', 'kanso-options' ),
        'id'    => 'adminlayout-section',
        'desc'  => __( 'This is admin layout.', 'kanso-options' ),
        'icon'  => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom Layout', 'kanso-options' ),
        'desc'       => __( 'Cutsomize the layout ', 'kanso-options' ),
        'id'         => 'layout-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'required' => array(
                    array('global-enable-switch','=','0'),
                ),
                'id' => 'adminlayout-disabled_warning',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "All Features" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
                'required' => array(
                    array('global-enable-switch','=','1'),
                    array('adminlayout-enable-switch','=','0'),
                ),
                'id' => 'adminlayout-disabled_warning2',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "Custom Admin Area & Menu Layouts" in the General section to access this feature.', 'kanso-options'),
            ),
        )
) );



    Redux::setSection( $opt_name, array(
        'title' => __( 'Menus', 'kanso-options' ),
        'id'    => 'menus',
        'desc'  => __( 'This is menu.', 'kanso-options' ),
        'icon'  => 'el el-home'
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => __( 'Top Toolbar', 'kanso-options' ),
        'desc'       => __( 'Customize the topbar ', 'kanso-options' ),
        'id'         => 'topbar-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'required' => array(
                    array('global-enable-switch','=','0'),
                ),
                'id' => 'toolbar-disabled_warning',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "All Features" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
                'required' => array(
                    array('global-enable-switch','=','1'),
                    array('customtopbar-enable-switch','=','0'),
                ),
                'id' => 'toolbar-disabled_warning2',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "Custom Top Toolbar" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
               'required' => array('customtopbar-enable-switch','=','1'),
               'id' => 'section-start-toolbar-layout',
               'type' => 'section',
               'title' => __('Layout & Display', 'kanso-options'),
               'subtitle' => __('', 'kanso-options'),
               'indent' => true,
            ),
                array(
                    'required' => array('customtopbar-enable-switch','=','1'),
                    'id'       => 'toolbar-layout-select',
                    'type'     => 'button_set',
                    'title'    => 'Toolbar Layout',
                    'subtitle' => 'Postion, size and style',
                    'description' => 'Select the configuraton of the top Toolbar',
                    'default'  => 'floating-right',
                    'options'  => array(
                        'normal'            => 'Normal',
                        'floating-right'    => 'Floating (Top Right)',
                        'floating-left'    => 'Floating (Top Left)',
                    )
                ),
                array(
                    'required' => array(
                        array('customtopbar-enable-switch','=','1'),
                    ),
                    'id'       => 'topbar-display',
                    'type'     => 'button_set',
                    'title'    => 'Visibility',
                    'description' => 'Select option',
                    'options' => array(
                        '1' => 'SHOW front & back (default)', 
                        '2' => 'Hide on Frontend', 
                        '3' => 'Hide on Front AND Backend'
                     ), 
                    'default' => '1'
                ),
            array(
                'required' => array('customtopbar-enable-switch','=','1'),
                'id'     => 'section-end-toolbar-layout',
                'type'   => 'section',
                'indent' => false,
            ),

            array(
               'required' => array('customtopbar-enable-switch','=','1'),
               'id' => 'section-start-toolbar-topleft',
               'type' => 'section',
               'title' => __('Toolbar Left ', 'kanso-options'),
               'subtitle' => __('Top left menu', 'kanso-options'),
               'indent' => true,
            ),
                array(
                    'required' => array('customtopbar-enable-switch','=','1'),
                    'id'       => 'toolbar-customlinks-switch',
                    'type'     => 'switch',
                    'title'    => 'Custom Toolbar Menu',
                    'description' => 'Change the menu items in the top Toolbar (left)',
                    'default'  => '1',
                ),
                array(
                    'required' => array(
                                    array('customtopbar-enable-switch', '=', '1'),
                                    array('toolbar-customlinks-switch', '=', '1'),
                                ),
                                
                    'id'       => 'topbar-disable-nodes',
                    'type'     => 'checkbox',
                    'title'    => 'Remove top toolbar items',
                    'description' => 'DISABLE an item by checking it\'s associated box',
                    'default'  => '0',// 1 = on | 0 = off
                    'options'  => array(
                        'wordpress' => 'WordPress',
                        'site' => 'Site',
                        'customize' => 'Customize',
                        'updates' => 'Updates',
                        'comments' => 'Comments',
                        'content' => 'Content',
                        'edit' => 'Edit',
                    ),
                ),
            array(
                'required' => array('customtopbar-enable-switch','=','1'),
                'id'     => 'section-end-toolbar-topleft',
                'type'   => 'section',
                'indent' => false,
            ),

            array(
               'required' => array('customtopbar-enable-switch','=','1'),
               'id' => 'section-start-toolbar-topright',
               'type' => 'section',
               'title' => __('Toolbar Right', 'kanso-options'),
               'subtitle' => __('Top Secondary', 'kanso-options'),
               'indent' => true,
            ),
                array(
                    'required' => array('customtopbar-enable-switch','=','1'),
                    'id'       => 'toolbar-welcomemessage-switch',
                    'type'     => 'switch',
                    'title'    => 'Custom Welcome Message',
                    'description' => 'Change "Howdy" user message in right toolbar',
                    'default'  => '1',
                ),
                array(
                    'required' => array(
                        array('customtopbar-enable-switch','=','1'),
                        array('toolbar-welcomemessage-switch','=','1'),
                    ),
                    'id'       => 'howdy-text',
                    'type'     => 'text',
                    'title'    => __( 'Toolbar Welcome Message', 'kanso-options' ),
                    'desc'     => __( 'Change "Howdy" to something different', 'kanso-options' ),
                    'default'  => 'Welcome,',
                ),
            array(
                'required' => array('customtopbar-enable-switch','=','1'),
                'id'     => 'section-end-toolbar-topright',
                'type'   => 'section',
                'indent' => false,
            ),
        )
) );


    Redux::setSection( $opt_name, array(
        'title' => __( 'Branding', 'kanso-options' ),
        'id'    => 'branding',
        'desc'  => __( 'This is branding.', 'kanso-options' ),
        'icon'  => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => __( 'Admin Footers', 'kanso-options' ),
        'desc'       => __( 'Customize the footers on admin pages ', 'kanso-options' ),
        'id'         => 'footer-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'required' => array(
                    array('global-enable-switch','=','0'),
                ),
                'id' => 'footertext-disabled_warning',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "All Features" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
                'required' => array(
                    array('global-enable-switch','=','1'),
                    array('footertext-enable-switch','=','0'),
                ),
                'id' => 'footertext-disabled_warning2',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "Custom Admin Area Footer Text" in the General section to access this feature.', 'kanso-options'),
            ),
                array(
                'required' => array('footertext-enable-switch','=','1'),
                'id'       => 'footer-text-empty',
                'type'     => 'checkbox',
                'title'    => 'Remove footer text altogether?',
                'description' => 'Checking this box will result in both footer fields being empty.',
                'default'  => '0',// 1 = on | 0 = off
            ),


             array(
                'required' => array('footer-text-empty','=','0'),
                'id'       => 'footer-text-section-start',
                'type'     => 'section',
                'title'    => 'Custom Text',
                'indent'   => true,
            ),
            array(
                'required' => array('footer-text-empty','=','0'),
                'id'       => 'footer-text-left',
                'type'     => 'text',
                'title'    => __( 'Left Footer Text', 'kanso-options' ),
                'desc'     => __( 'Text to display', 'kanso-options' ),
                'default'  => 'Default Text',
            ),
            array(
                'required' => array('footer-text-empty','=','0'),
                'id'       => 'footer-text-right',
                'type'     => 'text',
                'title'    => __( 'Right Footer Text', 'kanso-options' ),
                'desc'     => __( 'Text to display', 'kanso-options' ),
                'default'  => 'Default Text',
            ),
             array(
                'id'       => 'footer-text-section-end',
                'type'     => 'section',
                'indent'   => false,
            ),
        )
    ) );

     Redux::setSection( $opt_name, array(
        'title'      => __( 'Admin Colors', 'kanso-options' ),
        'desc'       => __( 'Customize the admin colors ', 'kanso-options' ),
        'id'         => 'admin-colors-subsection',
        'subsection' => true,
        'fields'     => array(
            array(
                'required' => array(
                    array('global-enable-switch','=','0'),
                ),
                'id' => 'admincolors-disabled_warning',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "All Features" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
                'required' => array(
                    array('global-enable-switch','=','1'),
                    array('admincolors-enable-switch','=','0'),
                ),
                'id' => 'admincolors-disabled_warning2',
                'type' => 'info',
                'style' => 'critical',
                'icon' => 'el-icon-info-sign',
                'title' => __('Section Disabled', 'kanso-options'),
                'desc' => __('Please enable "Custom Admin Area Colors" in the General section to access this feature.', 'kanso-options'),
            ),
            array(
                'required' => array('admincolors-enable-switch','=','1'),
                'id'       => 'admin-colors-select',
                'type'     => 'button_set',
                'title'    => 'Select color theme',
                'description' => 'Select option',
                'options' => array(
                    'gunmetal' => 'Gunmetal', 
                    'blue' => 'Blue', 
                    'red' => 'Red'
                 ), 
                'default' => 'gunmetal'
            ),
        )
    ) );

   

    /*
     * <--- END SECTIONS
     */

// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );

// Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/'.$opt_name.'/compiler', 'kanso_compiler_action', 10, 3);
    //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'kanso_compiler_action' ), 10, 3);

/**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'kanso_compiler_action' ) ) {
        function kanso_compiler_action( $options, $css, $changed_values ) {
            //echo '<h1>The compiler hook has run!</h1>';
            //echo "<pre>";
            //print_r( $changed_values ); // Values that have changed since the last save
            //echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }