<?php

namespace CoreFunctionality;

/**
 * Dont Update the Plugin if there is a plugin in the WordPress repository with the same name.
 *
 * @param  array $r Existing request arguments
 * @param  string $url Request URL
 * @return array Filtered request arguments
 */
function dontUpdatePlugin($r, $url)
{
    if (0 !== strpos($url, 'https://api.wordpress.org/plugins/update-check/')) {
        return $r; // Not a plugin update request. Bail immediately.
    }
    $plugins = json_decode($r['body']['plugins'], true);
    unset($plugins['plugins'][plugin_basename(__FILE__)]);
    $r['body']['plugins'] = json_encode($plugins);
    return $r;
}
add_filter('http_request_args', '\\CoreFunctionality\\dontUpdatePlugin', 5, 2);

/**
 * Registers required plugins via TGM Plugin Activation Framework
 * See their documentation for further details how to add plugins & configure the framework
 *
 * @return void
 */
function registerRequiredPlugins()
{

    $plugins = [
        // array(
        //     'name'         => 'Advanced Custom Fields Pro', // The plugin name.
        //     'slug'         => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
        //     'source'       => WP_PLUGIN_DIR . '/advanced-custom-fields-pro', // The plugin source.
        //     'required'     => true, // If false, the plugin is only 'recommended' instead of required.
        //     'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
        //     // 'external_url' => 'http://www.advancedcustomfields.com/pro/', // If set, overrides default API URL and points to an external URL.
        // ),
    ];

    $config = [
        'id'           => 'core-functionality',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'required-plugins', // Menu slug.
        'parent_slug'  => 'plugins.php',            // Parent menu slug.
        'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => [
            'page_title'                      => __('Install Required Plugins', 'core-functionality'),
            'menu_title'                      => __('Required Plugins', 'core-functionality'),
            /* translators: %s: plugin name. */
            'installing'                      => __('Installing Plugin: %s', 'core-functionality'),
            /* translators: %s: plugin name. */
            'updating'                        => __('Updating Plugin: %s', 'core-functionality'),
            'oops'                            => __('Something went wrong with the plugin API.', 'core-functionality'),
            'notice_can_install_required'     => _n_noop(
                /* translators: 1: plugin name(s). */
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'core-functionality'
            ),
            'notice_can_install_recommended'  => _n_noop(
                /* translators: 1: plugin name(s). */
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'core-functionality'
            ),
            'notice_ask_to_update'            => _n_noop(
                /* translators: 1: plugin name(s). */
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'core-functionality'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                /* translators: 1: plugin name(s). */
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'core-functionality'
            ),
            'notice_can_activate_required'    => _n_noop(
                /* translators: 1: plugin name(s). */
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'core-functionality'
            ),
            'notice_can_activate_recommended' => _n_noop(
                /* translators: 1: plugin name(s). */
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'core-functionality'
            ),
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'core-functionality'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'core-functionality'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'core-functionality'
            ),
            'return'                          => __('Return to Required Plugins Installer', 'core-functionality'),
            'plugin_activated'                => __('Plugin activated successfully.', 'core-functionality'),
            'activated_successfully'          => __('The following plugin was activated successfully:', 'core-functionality'),
            /* translators: 1: plugin name. */
            'plugin_already_active'           => __('No action taken. Plugin %1$s was already active.', 'core-functionality'),
            /* translators: 1: plugin name. */
            'plugin_needs_higher_version'     => __('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'core-functionality'),
            /* translators: 1: dashboard link. */
            'complete'                        => __('All plugins installed and activated successfully. %1$s', 'core-functionality'),
            'dismiss'                         => __('Dismiss this notice', 'core-functionality'),
            'notice_cannot_install_activate'  => __('There are one or more required or recommended plugins to install, update or activate.', 'core-functionality'),
            'contact_admin'                   => __('Please contact the administrator of this site for help.', 'core-functionality'),

            'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
        ],
    ];

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', '\\CoreFunctionality\\registerRequiredPlugins');
