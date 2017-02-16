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

Route::get('/', 'WelcomeController@index');

Route::post('/create-scrum', 'ScrumMaster@createScrum');

Route::group(['middleware' => ['verify_scrum']], function () {

    Route::group(['middleware' => ['verify_scrum_master']], function () {
        Route::get('/{uuid}/end-scrum', 'ScrumMaster@endScrum');
    });

    Route::group(['middleware' => ['verify_scrum_voter']], function () {
        Route::get('/{uuid}/leave-scrum', 'ScrumVoter@leaveScrum');
    });

    Route::post('/{uuid}/join-scrum', 'ScrumVoter@joinScrum');
    Route::get('/{uuid}', 'ScrumVoter@showScrum');

});