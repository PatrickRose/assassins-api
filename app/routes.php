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

Route::group(array('prefix' => 'api',
                   'before' => 'secretKey'),
             function() {

        Route::post('join',
                    array('as' => 'join-game',
                          'uses' => 'GameController@joinGame'));

        Route::post('info',
                    array('as' => 'game-info',
                          'uses' => 'GameController@getGameInfo'));


    });
