<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/history.atom', 'RssFeedController@index');


Route::get('/', 'HomeController@index')->name('index');
Route::get('/history/{date}', 'HomeController@full_history')->name('history');
Route::get('/incidents/{code}', 'HomeController@incident')->name('incident-code');


Route::get('/subscribe', 'HomeController@get_subscribe')->name('get-subscribe');
Route::post('/subscribe', 'HomeController@post_subscribe')->name('post-subscribe');
Route::get('/subscribe/{code}', 'HomeController@manage_subscribe')->name('manage-subscribe');
Route::post('/subscribe/{code}', 'HomeController@manage_subscribe_update')->name('manage-subscribe-store');
Route::get('/subscribe/{code}/confirm', 'HomeController@manage_subscribe_reconfirm')->name('manage-subscribe-confirm');
Route::get('/subscribe/{code}/confirm/{code_security}', 'HomeController@manage_subscribe_confirm')->name('manage-subscribe-active');
Route::get('/subscribe/{code}/cancel', 'HomeController@manage_subscribe_cancel')->name('manage-subscribe-cancel');
Route::post('/subscribe/{code}/cancel', 'HomeController@manage_subscribe_cancel_confirm')->name('manage-subscribe-cancel-confirm');
Route::get('/subscribe/{code}/cancel/{code_security}', 'HomeController@manage_subscribe_cancel_confirm_code')->name('manage-subscribe-cancel-confirm-code');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/admin/dashboard', 'DashboardController@index')->name('authenticated.dashboard');

Route::get('/admin/incidents', 'IncidentsController@index')->name('authenticated.incidents');
Route::get('/admin/incidents/new', 'IncidentsController@create')->name('authenticated.incidents.new');
Route::post('/admin/incidents/new', 'IncidentsController@store')->name('authenticated.incidents.new.store');
Route::get('/admin/incidents/{id}/edit', 'IncidentsController@edit')->name('authenticated.incidents.edit');
Route::post('/admin/incidents/{id}/update', 'IncidentsController@update')->name('authenticated.incidents.update');
Route::get('/admin/incidents/{id}/delete', 'IncidentsController@destroy')->name('authenticated.incidents.delete');
Route::get('/admin/incidents/new/{id}/template', 'IncidentsController@use_template')->name('authenticated.incidents.use.template');
Route::get('/admin/incidents/{id}/update-view', 'IncidentsController@update_view')->name('authenticated.incidents.update.view');
Route::get('/admin/incidents/{id}/update-index', 'IncidentsController@update_index')->name('authenticated.incidents.update.index');
Route::get('/admin/incidents/{id}/update-create', 'IncidentsController@update_create')->name('authenticated.incidents.update.create');
Route::post('/admin/incidents/{id}/update-store', 'IncidentsController@update_store')->name('authenticated.incidents.update.store');
Route::get('/admin/incidents/{id_incident}/update-index/{id}/edit', 'IncidentsController@update_edit')->name('authenticated.incidents.update.edit');
Route::post('/admin/incidents/{id_incident}/update-index/{id}/update', 'IncidentsController@update_update')->name('authenticated.incidents.update.update');
Route::get('/admin/incidents/{id_incident}/update-index/{id}/delete', 'IncidentsController@update_delete')->name('authenticated.incidents.update.delete');
Route::get('/admin/incidents/{id_incident}/update-index/{id}/delete-recheck', 'IncidentsController@update_delete_recheck')->name('authenticated.incidents.update.delete.recheck');


Route::get('/admin/components/groups', 'ComponentsController@groups_index')->name('authenticated.components.groups');
Route::post('/admin/components-groups-update', 'ComponentsController@groups_index_update')->name('authenticated.components.index.groups.update');
Route::get('/admin/components/groups/new', 'ComponentsController@groups_create')->name('authenticated.components.groups.new');
Route::post('/admin/components/groups/new', 'ComponentsController@groups_store')->name('authenticated.components.groups.new.store');
Route::get('/admin/components/groups/{id}/edit', 'ComponentsController@groups_edit')->name('authenticated.components.groups.edit');
Route::post('/admin/components/groups/{id}/update', 'ComponentsController@groups_update')->name('authenticated.components.groups.edit');
Route::get('/admin/components/groups/{id}/delete', 'ComponentsController@groups_destroy')->name('authenticated.components.groups.delete');

Route::get('/admin/components', 'ComponentsController@components_index')->name('authenticated.components');
Route::post('/admin/components-update', 'ComponentsController@components_index_update')->name('authenticated.components.index.update');
Route::get('/admin/components/new', 'ComponentsController@components_create')->name('authenticated.components.new');
Route::post('/admin/components/new', 'ComponentsController@components_store')->name('authenticated.components.new.store');
Route::get('/admin/components/{id}/edit', 'ComponentsController@components_edit')->name('authenticated.components.edit');
Route::post('/admin/components/{id}/update', 'ComponentsController@components_update')->name('authenticated.components.edit');
Route::get('/admin/components/{id}/delete', 'ComponentsController@components_destroy')->name('authenticated.components.delete');

Route::get('/admin/templates', 'IncidentTemplatesController@index')->name('authenticated.templates');
Route::get('/admin/templates/new', 'IncidentTemplatesController@create')->name('authenticated.templates.new');
Route::post('/admin/templates/new', 'IncidentTemplatesController@store')->name('authenticated.templates.new.store');
Route::get('/admin/templates/{id}/edit', 'IncidentTemplatesController@edit')->name('authenticated.templates.edit');
Route::post('/admin/templates/{id}/update', 'IncidentTemplatesController@update')->name('authenticated.templates.edit');
Route::get('/admin/templates/{id}/delete', 'IncidentTemplatesController@destroy')->name('authenticated.templates.delete');

Route::get('/admin/schedule', 'ScheduleController@index')->name('authenticated.schedule');
Route::get('/admin/schedule/new', 'ScheduleController@create')->name('authenticated.schedule.new');
Route::post('/admin/schedule/new', 'ScheduleController@store')->name('authenticated.schedule.new.store');
Route::get('/admin/schedule/{id}/edit', 'ScheduleController@edit')->name('authenticated.schedule.edit');
Route::post('/admin/schedule/{id}/update', 'ScheduleController@update')->name('authenticated.schedule.edit');
Route::get('/admin/schedule/{id}/delete', 'ScheduleController@destroy')->name('authenticated.schedule.delete');

Route::get('/admin/subscribes', 'SubscribesController@index')->name('authenticated.subscribes');
Route::get('/admin/subscribes/{id}/delete', 'SubscribesController@destroy')->name('authenticated.subscribes.delete');
Route::get('/admin/subscribes/details', 'SubscribesController@index_subscribes_sent')->name('authenticated.subscribes.details');

Route::get('/admin/failedjobs', 'FailedJobsController@index')->name('authenticated.failedjobs');
Route::get('/admin/failedjobs/{id}/view-playload', 'FailedJobsController@view_playload')->name('authenticated.failedjobs.playload');
Route::get('/admin/failedjobs/{id}/view-exception', 'FailedJobsController@view_exception')->name('authenticated.failedjobs.exception');

Route::get('/admin/users', 'TeamController@index')->name('authenticated.users');
Route::get('/admin/users/new', 'TeamController@create')->name('authenticated.users.new');
Route::post('/admin/users/new', 'TeamController@store')->name('authenticated.users.store');
Route::get('/admin/users/{id}/edit', 'TeamController@edit')->name('authenticated.users.edit');
Route::post('/admin/users/{id}/edit', 'TeamController@update')->name('authenticated.users.update');
Route::get('/admin/users/{id}/delete', 'TeamController@destroy')->name('authenticated.users.delete');

Route::get('/admin/settings', 'SettingsController@index')->name('authenticated.settings');
Route::get('/admin/settings/edit', 'SettingsController@edit')->name('authenticated.settings.edit');
Route::post('/admin/settings/edit', 'SettingsController@update')->name('authenticated.settings.update');
Route::post('/admin/footer-links-update', 'SettingsController@links_index_update')->name('authenticated.settings.links.sort.update');
Route::get('/admin/settings/links/new', 'SettingsController@links_create')->name('authenticated.settings.links.new');
Route::post('/admin/settings/links/new', 'SettingsController@links_store')->name('authenticated.settings.links.new');
Route::get('/admin/settings/links/{id}/delete', 'SettingsController@links_delete')->name('authenticated.settings.links.delete');
Route::get('/admin/settings/links/{id}/edit', 'SettingsController@links_edit')->name('authenticated.settings.links.edit');
Route::post('/admin/settings/links/{id}/update', 'SettingsController@links_update')->name('authenticated.settings.links.update');