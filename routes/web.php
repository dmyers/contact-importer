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
    $core_fields = \App\Contact::CORE_FIELDS;
    return view('app', compact('core_fields'));
});

Route::get('contacts', 'ContactsController@index');
Route::post('contacts/upload', 'ContactsController@upload');
Route::post('contacts/import', 'ContactsController@import');

Route::get('campaigns', 'CampaignsController@index');
Route::post('campaigns', 'CampaignsController@create');
Route::post('campaigns/{id}/publish', 'CampaignsController@publish');

Route::get('numbers', 'NumbersController@index');
