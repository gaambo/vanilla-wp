<?php

/**
 * Removes unused default roles or roles added by plugins
 *
 */
// remove default unused roles
remove_role('subscriber');

/**
 * Adds custom capabilities to the existing core role administrator
 *
 */
$admin = get_role('administrator');
$admin_capabilities = array(
    'edit_special_settings'
);
foreach ($admin_capabilities as $cap) {
    $admin->add_cap($cap, true);
}
