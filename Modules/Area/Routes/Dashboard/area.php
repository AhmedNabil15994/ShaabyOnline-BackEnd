<?php

Route::group(['prefix' => 'area'], function () {

    Route::get('get-child-area-by-parent', 'Dashboard\AreaController@getChildAreaByParent')
        ->name('dashboard.area.get_child_area_by_parent');

    Route::get('get-city-with-states-by-parent', 'Dashboard\AreaController@getCityWithStatesByParent')
        ->name('dashboard.area.get_city_with_states_by_parent');
});
