<?php

Route::group(['prefix' => 'area'], function () {

    Route::get('get-child-area-by-parent', 'FrontEnd\AreaController@getChildAreaByParent')
        ->name('frontend.area.get_child_area_by_parent');

});
