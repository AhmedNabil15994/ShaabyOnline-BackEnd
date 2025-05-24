<?php

Route::get('/', 'FrontEnd\HomeController@index')->name('frontend.home');
// Route::get('/landing', 'FrontEnd\HomeController@landing')->name('frontend.landing');
Route::get('products/autocomplete', 'FrontEnd\HomeController@autocompleteProducts')->name('frontend.home.filter');
