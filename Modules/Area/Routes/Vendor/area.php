<?php

Route::group(['prefix' => 'area'], function () {

    Route::get('get-child-area-by-parent', 'Vendor\AreaController@getChildAreaByParent')
        ->name('vendor.area.get_child_area_by_parent');

});
