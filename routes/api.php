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

Route::get('/scrum/status', 'Api@getScrumStatus');

Route::group(['middleware' => 'verify_scrum_voter'], function () {
    Route::post('/scrum/vote-points', 'Api@submitPointsVote');
    Route::post('/scrum/vote-priority', 'Api@submitPriorityVote');
});

Route::group(['middleware' => 'verify_scrum_master'], function () {
    Route::post('/scrum-master/start-scrum', 'Api@startScrum');
    Route::post('/scrum-master/start-new-round', 'Api@startNewRound');
    Route::post('/scrum-master/end-round', 'Api@endRound');
});