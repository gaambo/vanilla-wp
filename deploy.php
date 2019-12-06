<?php
/**
 * A Deployer recipe to be used with vanilla WordPress installations (with a normal WP installation = not Bedrock/Cobblestone)
 * For more Information see it's README.md
 */

namespace Deployer;

require_once __DIR__ . '/vendor/autoload.php';

require_once 'recipe/common.php';

require_once 'set.php';
require_once 'tasks/themes.php';
require_once 'tasks/mu-plugins.php';
require_once 'tasks/database.php';
require_once 'tasks/files.php'; // required uplods, plugins & wp functions

require_once 'utils/files.php';
require_once 'utils/rsync.php';
use function \Gaambo\DeployerWordpress\Utils\Files\pushFiles;
use function \Gaambo\DeployerWordpress\Utils\Files\getRemotePath;

// CONFIGURATION
// see gaambos Deployer Wordpress Recipes README.md and src/set.php for other options to overwrite
// and https://deployer.org/docs/configuration.html for default configuration

set('keep_releases', 3);
set('release_name', function () {
    return date('YmdHis'); // you could also use the composer.json version here
});

set('composer_options', 'install --no-dev');

// overwrite path to uploads dir which normally sits in shared folder
set('uploads/path', '{{release_path}}');

// hosts
inventory('util/hosts.yml'); // !!! COPY `hosts.example.yml` in util directory!!!

// use localhost host to configure some local paths
localhost()
    ->stage('dev')
    ->set('bin/wp', __DIR__ . '/util/wpcli.sh')
    ->set('public_url', 'http://test.local') // !!! PLEASE EDIT !!!
    ->set('dump_path', 'data/db_dumps')
    ->set('release_path', __DIR__ . '/public')
    ->set('document_root', __DIR__ . '/public')
    ->set('backup_path', __DIR__ . '/data/backups');

// custom theme & mu-plugin options
set('theme/name', 'THEME'); // !!! PLEASE EDIT !!!
set('mu-plugin/name', 'core-functionality'); // !!! PLEASE EDIT !!!

// TASKS

// Pushes migration scripts to server
task('scripts:push', function () {
    upload('./scripts', '~/migration/');
})->desc('Pushes migration scripts to server');

// Overwrite deployment with rsync (instead of git)
// only push custom code - and update everything else on prod server
// you can also add wp:push and plugins:push tasks to push wp core files and plugins
task('deploy:update_code', ['themes:push', 'mu-plugins:push']);

// install theme vendors and run theme assets (npm) build script LOCAL
task('theme:assets:vendors:rebuild', function () {
    // rebuilds binaries (In case of change of OS - eg windows to bash)
    \Gaambo\DeployerWordpress\Utils\Npm\runCommand('{{document_root}}/{{themes/dir}}/{{theme/name}}', 'rebuild jpegtran-bin');
    \Gaambo\DeployerWordpress\Utils\Npm\runCommand('{{document_root}}/{{themes/dir}}/{{theme/name}}', 'rebuild optipng-bin');
})->local();
// set theme:assets tasks to run local
task('theme:assets:vendors')->local();
after('theme:assets:vendors', 'theme:assets:vendors:rebuild');
task('theme:assets:build')->local();
before('deploy:update_code', 'theme:assets');

// install theme vendors (composer) on server
after('deploy:update_code', 'theme:vendors'); // defined in tasks/theme.php

// install mu-plugin vendors after deploying (on remote host)
after('deploy:update_code', 'mu-plugin:vendors'); // defined in tasks/mu-plugin.php

// OPTIONAL: push all uploads to server
// after('deploy:update_code', 'uploads:push');

// OPTIONAL: push database to server, have to wait for wp-config-local.php to be symlinked from shared
// after('deploy:shared', 'db:push');

// MAIN TASK
// very similar to Deployer default deploy flow
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:writable',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy WordPress Site');
after('deploy', 'success');
