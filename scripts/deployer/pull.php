<?php

task( 'pull:dump', function () {

    writeln( 'Creating a new database dump (approx. 10s)' );
    run( 'cd current/web && wp db export' );

} );

task( 'pull:fetch_dump', function () {

    writeln( 'Getting database dump (approx. 10s)' );
    runLocally( 'scp root@www.andreasek.se:/mnt/persist/www/andreasek.se/current/web/andreasek.sql andreasek.sql', 999 );

} );

task( 'pull:resolve_dump', function () {

    writeln( 'Restore database inside vagrant (approx. 10s)' );
    runLocally( 'cd ../vagrant && vagrant ssh -c "mysql -u root -proot aek < /var/www/aek.dev/andreasek.sql" && cd ../aek.dev', 999 );

} );

task( 'pull:set_vagrant_wp', function () {

    writeln( 'Restore wp after pull (approx. 60s)' );
    runLocally( 'cd ../vagrant && vagrant ssh -c "cd /var/www/aek.dev/web && wp search-replace www.andreasek.se aek.dev && cd ../aek.dev',
        999 );

} );

task( 'pull:uploads', function () {

    writeln( 'Getting uploads, long duration first time! (approx. 60-999s)' );
    runLocally( 'rsync -re ssh root@www.andreasek.se:/mnt/persist/www/andreasek.se/shared/web/app/uploads web/app',
        999 );

} );

task( 'pull', [
    'pull:dump',
    'pull:fetch_dump',
    'pull:resolve_dump',
    'pull:set_vagrant_wp',
    'pull:uploads',
] );

