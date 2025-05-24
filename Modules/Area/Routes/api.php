<?php


Route::group(['prefix' => 'areas'], function () {

    Route::get('countries', 'WebService\AreaController@countries')->name('api.areas.countries.index');
    Route::get('cities/{id}', 'WebService\AreaController@cities')->name('api.areas.cities.index');
    Route::get('states/{id}', 'WebService\AreaController@states')->name('api.areas.sates.index');

    Route::get('countries-with-cities-and-states', 'WebService\AreaController@getCountriesWithCitiesAndStates')->name('api.areas.countries_with_cities_and_states');

    /*Route::get('cities', 'WebService\AreaController@cities')->name('api.areas.cities.index');
    Route::get('states', 'WebService\AreaController@states')->name('api.areas.cities.index');*/

});

Route::get('countries', 'WebService\CountryController@index');

