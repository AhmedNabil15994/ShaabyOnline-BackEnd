<?php

Route::group(['prefix' => 'coupons'], function () {

  	Route::post('/check_coupon' ,'WebService\CouponController@check_coupon')
  	->name('api.check_coupon');


});
