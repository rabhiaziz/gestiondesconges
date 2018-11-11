<?php

Route::group(['module' => 'Vacation', 'middleware' => ['web'], 'namespace' => 'App\Modules\Vacation\Controllers'], function() {

    Route::resource('vacation', 'VacationController');

});
