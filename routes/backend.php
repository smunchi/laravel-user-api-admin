<?php

Route::get('gifts', 'GiftController@index')->name('backend.gift.index');
Route::get('gifts/{giftPlan}', 'GiftController@show')->name('backend.gift.show');

Route::get('users', 'UserController@index')->name('backend.user.index');
Route::get('users/{user}', 'UserController@show')->name('backend.user.show');
