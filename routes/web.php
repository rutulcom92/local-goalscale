<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', '\App\Http\Controllers\Auth\LoginController@showLandingPage');
Auth::routes();
Route::get('/user/password/set', 'Auth\SetPasswordController@showSetForm')->name('user.password.set');
Route::post('/user/password/set', 'Auth\SetPasswordController@reset')->name('user.password.update');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('contact-us', '\App\Http\Controllers\Controller@contactUsLanding')->name('contactus');

Route::group(['middleware' => 'auth'], function(){
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
	Route::post('dashboard/image-upload/{id}', 'Dashboard\DashboardController@imageUpload')->name('dashboard.image-upload');
	Route::post('dashboard/contact-us', 'Dashboard\DashboardController@contactUs')->name('dashboard.contactus');
	Route::get('/dashboard/welcome-to-goal', 'Dashboard\DashboardController@welcomeToGoalCreate')->name('dashboard.welcome-to-goal.create');
	Route::post('dashboard/welcome-to-goal', 'Dashboard\DashboardController@welcomeToGoalStore')->name('dashboard.welcome-to-goal.store');
	Route::get('/dashboard/about-us', 'Dashboard\DashboardController@aboutUsCreate')->name('dashboard.about-us.create');
	Route::post('dashboard/about-us', 'Dashboard\DashboardController@aboutUsStore')->name('dashboard.about-us.store');
	Route::group(['middleware' => 'can:accessProgramModule'], function(){
		Route::resource('/program', 'Program\ProgramController');
	});

	Route::group(['prefix'=>'admin/profile'], function(){
		Route::post('/validate-email','Dashboard\DashboardAdminProfileController@validateEmail')->name('admin.profile.validateEmail');
		Route::get('/', 'Dashboard\DashboardAdminProfileController@index')->name('admin.profile.index');
		Route::post('/update', 'Dashboard\DashboardAdminProfileController@profileUpdate')->name('admin.profile.update');
	});

	Route::group(['middleware' => 'can:accessOrganizationModule'], function(){

		Route::group(['prefix'=>'event'], function(){
			Route::get('/', 'Events\EventController@index')->name('event.index');
			Route::post('/list', 'Events\EventController@list')->name('event.list');
		});
		
		Route::resource('/organization', 'Organization\OrganizationController');
		Route::resource('/organization/admin', 'Organization\OrganizationAdminController');
		Route::group(['prefix'=>'admin'], function(){
			Route::post('/validate-email','Organization\OrganizationAdminController@validateEmail')->name('admin.validateEmail');
		});

		Route::group(['prefix'=>'organization'], function(){
			Route::post('/list', 'Organization\OrganizationController@list')->name('organization.list');
			Route::post('/validate-email','Organization\OrganizationController@validateEmail')->name('organization.validateEmail');
			Route::post('/supervisor/list/{id}', 'Organization\OrganizationSupervisorController@list')->name('organization.supervisor.list');
			Route::post('/provider/list/{id}', 'Organization\OrganizationProviderController@list')->name('organization.provider.list');
			Route::post('/participant/list/{id}', 'Organization\OrganizationParticipantController@list')->name('organization.participant.list');
			Route::post('/program/list/{id}', 'Organization\OrganizationProgramController@list')->name('organization.program.list');
			Route::post('/admin/list/{id}', 'Organization\OrganizationAdminController@list')->name('organization.admin.list');
			Route::post('/goal/list/{id}', 'Organization\OrganizationGoalController@list')->name('organization.goal.list');
		});

		Route::post('/user/import', 'User\UserController@import')->name('user.import');
		Route::post('/user/import/post', 'User\UserController@importPost')->name('user.import.post');
	});

	Route::group(['prefix'=>'supervisor'], function(){
		Route::post('/validate-email','Supervisor\SupervisorController@validateEmail')->name('supervisor.validateEmail');
	});
	Route::group(['prefix'=>'supervisor/profile'], function(){
		Route::get('/', 'Supervisor\SupervisorProfileController@index')->name('supervisor.profile.index');
		Route::post('/update', 'Supervisor\SupervisorProfileController@profileUpdate')->name('supervisor.profile.update');
	});

	Route::group(['middleware' => 'can:accessSupervisorModule'], function(){
		Route::group(['prefix'=>'event'], function(){
			Route::get('/', 'Events\EventController@index')->name('event.index');
			Route::post('/list', 'Events\EventController@list')->name('event.list');
		});
		
		Route::resource('/supervisor', 'Supervisor\SupervisorController')->middleware('auth.orgAdmin');
		Route::group(['prefix'=>'supervisor'], function(){
			Route::post('/list', 'Supervisor\SupervisorController@list')->name('supervisor.list');
			Route::post('/get-organization-programs', 'Supervisor\SupervisorController@getOrganizationPrograms')->name('supervisor.get-organization-programs');
			Route::post('/provider/list/{id}', 'Supervisor\SupervisorProviderController@list')->name('supervisor.provider.list');
			Route::post('/program/list/{id}', 'Supervisor\SupervisorProgramController@list')->name('supervisor.program.list');
			Route::post('/goal/list/{id}', 'Supervisor\SupervisorGoalController@list')->name('supervisor.goal.list');
		});
	});

	Route::group(['prefix'=>'provider'], function(){
		Route::post('/validate-email','Provider\ProviderController@validateEmail')->name('provider.validateEmail');
	});
	Route::group(['prefix'=>'provider/profile'], function(){
		Route::get('/', 'Provider\ProviderProfileController@index')->name('provider.profile.index');
		Route::post('/update', 'Provider\ProviderProfileController@profileUpdate')->name('provider.profile.update');
	});

	Route::group(['middleware' => 'can:accessProviderModule'], function(){
		Route::resource('/provider', 'Provider\ProviderController')->middleware('auth.orgAdmin');
		Route::group(['prefix'=>'provider'], function(){
			Route::post('/list', 'Provider\ProviderController@list')->name('provider.list');
			Route::post('/get-organization-programs', 'Provider\ProviderController@getOrganizationPrograms')->name('provider.get-organization-programs');
			Route::post('/participant/list/{id}', 'Provider\ProviderParticipantController@list')->name('provider.participant.list');
			Route::post('/get-providertype-organizations', 'Provider\ProviderController@getProviderOrganizations')->name('provider.get-providertype-organizations');
			Route::post('/get-programs-supervisors', 'Provider\ProviderController@getProviderSupervisors')->name('provider.get-programs-supervisors');
			Route::post('/goal/list/{id}', 'Provider\ProviderGoalController@list')->name('provider.goal.list');
		});
	});

	Route::group(['prefix'=>'participant'], function(){
		Route::post('/validate-email','Participant\ParticipantController@validateEmail')->name('participant.validateEmail');
	});
	Route::group(['prefix'=>'participant/profile'], function(){
		Route::get('/', 'Participant\ParticipantProfileController@index')->name('participant.profile.index');
		Route::post('/update', 'Participant\ParticipantProfileController@profileUpdate')->name('participant.profile.update');
	});

	Route::group(['middleware' => 'can:accessParticipantModule'], function(){
		Route::resource('/participant', 'Participant\ParticipantController')->middleware('auth.orgAdmin');
		Route::group(['prefix'=>'participant'], function(){
			Route::post('/list', 'Participant\ParticipantController@list')->name('participant.list');
			Route::post('/get-organization-programs', 'Participant\ParticipantController@getOrganizationPrograms')->name('participant.get-organization-programs');
			Route::post('/get-programs-providers', 'Participant\ParticipantController@getParticipantProviders')->name('participant.get-programs-providers');
			Route::post('/goal/list/{id}', 'Participant\ParticipantGoalController@list')->name('participant.goal.list');
		});
	});

	Route::group(['middleware' => 'can:accessGoalModule'], function(){
		Route::post('/goal/list', 'Goal\GoalController@list')->name('goal.list');
		Route::post('/goal/get-activities', 'Goal\GoalController@getActivities')->name('goal.get-activities');
		Route::post('/goal/get-graphdetails', 'Goal\GoalController@getGraphDetails')->name('goal.get-graph-details');
		Route::post('/goal/get-provider-participants', 'Goal\GoalController@getProviderParticipants')->name('goal.provider.participants');
		Route::get('/goal/get-activity/reply', 'Goal\GoalController@getActivityReplay')->name('goal.get-activity-replay');
		Route::post('/goal/get-activity/reply/{id}', 'Goal\GoalController@activityReplay')->name('goal.activity.replay');
		Route::post('/goal/close-status/{id}', 'Goal\GoalController@closeStatus')->name('goal.change-status-close');
		Route::post('/goal/details/export/{id}', 'Goal\GoalController@goalDetailExport')->name('goal.details.export');
		Route::resource('/goal', 'Goal\GoalController')->middleware('auth.orgAdmin');

		Route::post('/goal/import', 'Goal\GoalController@import')->name('goal.import');
		Route::post('/goal/import/post', 'Goal\GoalController@importPost')->name('goal.import.post');

		Route::get('/goal/{id}/view', 'Goal\GoalController@view')->name('goal.view');

		Route::post('/goal/{id}/update', 'Goal\GoalController@updateGoal')->name('goal.updategoal');
	});


	Route::group(['middleware' => 'can:accessReportModule'], function(){
		Route::post('/reports/get-topic-presenting-challenge/graph-details', 'Report\ReportController@getTopicPresentingChallengeGraphDetails')->name('reports.get-goal-topic-presenting-challenge-graph-details');
		Route::post('/reports/get-topic-specialized-intervention/graph-details', 'Report\ReportController@getTopicSpecializedInterventionGraphDetails')->name('reports.get-goal-topic-specialized-intervention-graph-details');
		Route::post('/reports/get-presenting-challenge-specialized-intervention/graph-details', 'Report\ReportController@getPresentingChallengeSpecializedInterventionGraphDetails')->name('reports.get-goal-presenting-challenge-specialized-intervention-graph-details');

		Route::post('/reports/get-average-goal-change-by-program/graph-details', 'Report\OrganizationReport@getAverageGoalChangeByProgram')->name('reports.get-average-goal-change-by-program-graph-details');

		Route::post('/reports/get-goal-performance-by-program/graph-details', 'Report\OrganizationReport@getGoalPerformanceByProgram')->name('reports.get-goal-performance-by-program-graph-details');

		Route::post('/reports/get-goal-progress-by-program-providertype/graph-details', 'Report\OrganizationReport@getGoalProgresByProgramAndProviderType')->name('reports.get-goal-progress-by-program-providertype-graph-details');

		Route::get('/reports', 'Report\ReportController@index')->name('reports');
	});

	Route::resource('/program', 'Program\ProgramController')->middleware('auth.orgAdmin');

	Route::group(['prefix'=>'program'], function(){
		Route::post('/list', 'Program\ProgramController@list')->name('program.list');
		Route::post('/supervisor/list/{id}', 'Program\ProgramSupervisorController@list')->name('program.supervisor.list');
		Route::post('/provider/list/{id}', 'Program\ProgramProviderController@list')->name('program.provider.list');
		Route::post('/user/list/{id}', 'Program\ProgramUserController@list')->name('program.user.list');
		Route::post('/goal/list/{id}', 'Program\ProgramGoalController@list')->name('program.goal.list');
		Route::post('/validate-email','Program\ProgramController@validateEmail')->name('program.validateEmail');
	});
});

