<?php

namespace CoreFunctionality;

/**
 * Plugin Name: Core Functionality
 * Description: This contains all your site's core functionality so that it is theme independent.
 * Version: 0.1.0
 * Author: Fabian Todt
 *
 */

define('CORE_FUNCTIONALITY_PATH', plugin_dir_path(__FILE__));
require_once(CORE_FUNCTIONALITY_PATH . '/includes/tgm-plugin-activation.php');
require_once(CORE_FUNCTIONALITY_PATH . '/includes/general.php');
