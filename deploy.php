<?php
date_default_timezone_set('Europe/Stockholm');

include_once 'scripts/deployer/common.php';
include_once 'scripts/deployer/pull.php';

server( 'development', 'aek.dev.dev' )
    ->env('deploy_path','/var/www/aek.dev')
    ->env('branch', 'master')
    ->user( 'vagrant', 'vagrant' );

server( 'production', 'c3583.cloudnet.se' )
    ->env('deploy_path','/mnt/persist/www/andreasek.se')
    ->user( 'root' )
    ->env('branch', 'master')
    ->pubKey();

set('repository', 'git@github.com:EkAndreas/aek.dev.git');

// Symlink the .env file for Bedrock
set('env', 'prod');
set('keep_releases', 10);
set('shared_dirs', ['web/app/uploads']);
set('shared_files', ['.env', 'web/.htaccess', 'web/robots.txt']);
set('env_vars', '/usr/bin/env');

task('deploy:restart', function () {
    //run("curl -s http://www.skolporten.se/wp/wp-admin/admin-ajax.php?action=purge");
    run("sudo service apache2 restart");
    //run("sudo service varnish restart");
})->desc('Restarting apache2 and varnish');

task( 'deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:shared',
    'deploy:symlink',
    'cleanup',
    'deploy:restart',
    'success'
] )->desc( 'Deploy your Bedrock project, eg dep deploy production' );

