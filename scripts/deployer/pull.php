<?php

task( 'pull:dump', function () {

    writeln( 'Creating a new database dump (approx. 60s)' );
    run( 'mysqldump -u skolporten -pArkitekt1 skolporten > ~/backup/skolporten.sql' );

} );

task( 'pull:fetch_dump', function () {

    writeln( 'Getting database dump (approx. 60s)' );
    runLocally( 'scp skolporten@www.skolporten.se:/home/httpd/skolporten/backup/skolporten.sql skolporten.sql', 999 );

} );

task( 'pull:resolve_dump', function () {

    writeln( 'Restore database inside vagrant (approx. 60s)' );
    runLocally( 'cd ../vagrant && vagrant ssh -c "mysql -u root -proot skolporten < /var/www/skolporten/skolporten.sql" && cd ../skolporten.dev', 999 );

} );

task( 'pull:set_vagrant_wp', function () {

    writeln( 'Restore wp after pull (approx. 60s)' );
    runLocally( 'cd ../vagrant && vagrant ssh -c "cd /var/www/skolporten/web && wp search-replace www.skolporten.se skolporten.dev && wp plugin deactivate w3-total-cache && wp plugin activate query-monitor && wp rewrite flush" && cd ../skolporten.dev',
        999 );

} );

task( 'pull:uploads', function () {

    writeln( 'Getting uploads, long duration first time! (approx. 60-999s)' );
    runLocally( 'rsync -re ssh skolporten@www.skolporten.se:/home/httpd/skolporten/skolporten.se/shared/web/app/uploads web/app',
        999 );

} );

task( 'pull', [
    'pull:dump',
    'pull:fetch_dump',
    'pull:resolve_dump',
    'pull:set_vagrant_wp',
    'pull:uploads',
] );

