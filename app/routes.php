<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
 */

Route::get('/', function()
           {
    return View::make('hello');
  });

Route::model('game', 'Game');

Route::get('start/{game}',
	   array('uses' => 'GameController@startGame'));

Route::group(array('prefix' => 'api',
                   'before' => 'secretKey'),
             function() {

    Route::post('join',
                array('uses' => 'GameController@joinGame'));

    Route::post('info',
                array('uses' => 'GameController@getGameInfo'));

    Route::post('submitReport',
                array('uses' => 'GameController@submitReport'));

    Route::post('getEvents',
                array('uses' => 'GameController@getEvents'));

    Route::post('login',
		array('uses' => 'PlayerController@login'));

    Route::post('getAllGames',
		array('uses' => 'GameController@getAll'));

  });
