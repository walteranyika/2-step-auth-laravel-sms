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

use AfricasTalking\SDK\AfricasTalking;

Route::get('/', function () {

        $username = env('SMS_USER');
        $apiKey   = env('SMS_KEY');

       // $username ='team001';
       // $apiKey   = '83b4b04cea9bc5811396cbe67d7a23b24f9e7bf71ad945540fc70d22ede08a5e';
        $AT       = new AfricasTalking($username, $apiKey);
        $sms      = $AT->sms();
        $result   = $sms->send([
            'to'      => '+254723740215',
            'message' => 'Happy Hello There'
        ]);
        //dd($result);

    return view('welcome');
});

Auth::routes();

Route::get('/code', 'Auth\\LoginController@showCodeForm');
Route::post('/code', 'Auth\\LoginController@storeCodeForm');


Route::get('/home', 'HomeController@index')->name('home');

