<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['verify_scrum', 'verify_scrum_voter']], function () {

    Route::get('/{uuid}/status', 'ScrumVoter@getScrumStatus');
    Route::post('/{uuid}/vote-points', 'ScrumVoter@submitPointsVote');

    Route::group(['middleware' => 'verify_scrum_master'], function () {
        Route::post('/{uuid}/start-scrum', 'ScrumMaster@startScrum');
        Route::post('/{uuid}/start-new-round', 'ScrumMaster@startNewRound');
        Route::post('/{uuid}/end-round', 'ScrumMaster@endRound');
    });

});
