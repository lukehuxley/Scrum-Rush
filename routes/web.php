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

Route::group(['middleware' => 'verify_scrum_master'], function () {
    Route::get('/scrum-master', 'ScrumMaster@index');
    Route::get('/scrum-master/end-scrum', 'ScrumMaster@endScrum');
});

Route::group(['middleware' => 'verify_scrum_voter'], function () {
    Route::post('/scrum/vote', 'ScrumVoter@submitVote');
    Route::get('/scrum', 'ScrumVoter@index');
    Route::get('/scrum/leave', 'ScrumVoter@leaveScrum');
});

Route::get('/scrum/{uuid}', 'ScrumVoter@joinScrumForm');
Route::post('/scrum/{uuid}', 'ScrumVoter@joinScrum');
