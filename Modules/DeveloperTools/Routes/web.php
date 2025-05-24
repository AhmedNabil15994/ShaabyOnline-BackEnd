<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'developer.'], function () {

    ///**********************************************
    // routes out of Auth with guard developer
    ///**********************************************
    // Route::group(['prefix' => 'login', 'middleware' => ['guest:developer']], function () {

    //     // Show Login Form
    //     Route::get('/', 'LoginController@showLogin')
    //         ->name('view.login');

    //     // Submit Login
    //     Route::post('/', 'LoginController@postLogin')
    //         ->name('login');
    // });
    //////////////////////////////////////////////////




    ///**********************************************
    //  routes out in Auth with guard developer
    ///**********************************************
    Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access', 'tocaan.user'])->group(function () {

        //theme colors
        Route::group(['prefix' => 'themes', 'as' => 'themes.', 'namespace' => 'Themes'], function () {

            Route::group(['prefix' => 'colors', 'as' => 'colors.'], function () {
                Route::get('/', 'ColorController@index')->name('index');
                Route::put('/', 'ColorController@update')->name('update');
            });
        });
    });
    //////////////////////////////////////////////////
});
