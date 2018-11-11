<?php

Route::group(['module' => 'Vacation', 'middleware' => ['api'], 'namespace' => 'App\Modules\Vacation\Controllers'], function() {

    Route::resource('vacation', 'VacationController');

});
