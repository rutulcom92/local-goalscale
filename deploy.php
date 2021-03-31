<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'wmu-goal-attainment');

// Project repository
set('repository', 'git@gitlab.com:SPARKBusinessWorks/wmu-goal-attainment.git');

inventory('hosts.yml');
// set('writable_use_sudo', true);
add('writable_dirs', ['uploads']);
add('shared_dirs', ['uploads','public/uploads']);
// Tasks
task('release_statement', function () {
	set('release_statement',run('cd {{release_path}} && git rev-parse --verify HEAD && git log -2 --pretty=%B'));
    run( 'echo "{{release_statement}}" > {{release_path}}/release_statement.txt');
});

task('build', function () {
    run('cd {{release_path}} && build');
});
task('deploy:apply_permissions', function () {
    // run('chmod 777 -R {{deploy_path}}/current/public/uploads');
});
task('clear_config', function () {
    run('php {{deploy_path}}/current/artisan config:clear');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
before('deploy:apply_permissions','release_statement');
after('cleanup', 'deploy:apply_permissions');
after('deploy:apply_permissions','clear_config');
