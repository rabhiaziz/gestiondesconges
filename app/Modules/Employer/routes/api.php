<?php

Route::group(['module' => 'Employer', 'middleware' => ['api'], 'namespace' => 'App\Modules\Employer\Controllers'], function() {

    Route::resource('employer', 'EmployerController');

});
