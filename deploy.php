<?php

/**
 * A Deployer recipe to be used with vanilla WordPress installations
 * (with a normal WP installation = not Bedrock/Cobblestone)
 * For more Information see README.md
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/gaambo/deployer-wordpress/recipes/simple.php';

use function Deployer\after;
use function Deployer\before;
use function Deployer\import;
use function Deployer\invoke;
use function Deployer\localhost;
use function Deployer\on;
use function Deployer\task;
use function Gaambo\DeployerWordpress\Utils\Localhost\getLocalhost;

/**
 * CONFIGURATION
 * see README.md and src/set.php for other options to overwrite
 * and https://deployer.org/docs/configuration.html for default configuration
 */


// hosts & config
import('util/deploy.yml');

// OPTIONAL: overwrite localhost config'
localhost()
    ->set('public_url', "{{local_url}}")
    ->set('dump_path', 'data/db_dumps')
    ->set('bin/wp', __DIR__ . '/dev/cli.sh wp')
    ->set('public_host', 'wp.local')
    ->set('backup_path', 'data/backups')
    ->set('deploy_path', __DIR__)
    ->set('release_path', __DIR__ . '/public')
    // set current_path to hardcoded release_path on local so release_or_current_path works; {{release_path}} does not work here?
    ->set('current_path', function () {
        return getLocalhost()->get('release_path');
    });

/**
 * TASKS
 */

// only push themes and mu-plugins
task('deploy:update_code', [
    'themes:push', 'mu-plugins:push'
]);

// build theme assets via npm locally
before('deploy:update_code', function () {
    on(localhost(), function () {
        // invoke('theme:assets:vendors');
        invoke('theme:assets:build');
    });
});

// install mu-plugin vendors after deploying (on remote host)
after('deploy:update_code', 'mu-plugin:vendors'); // defined in tasks/mu-plugin.php
