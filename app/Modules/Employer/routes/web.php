<?php

Route::group(['module' => 'Employer', 'middleware' => ['web'], 'namespace' => 'App\Modules\Employer\Controllers'], function() {

    Route::resource('employer', 'EmployerController');

    Route::get('/employer/show/{id}', 'EmployerController@index')->name('index');
    Route::get('/employer/{id}/list', 'EmployerController@showEmployerList')->name('employerList');
    Route::post('/employer/add/vacation/{id}', 'EmployerController@handleAddNewVacation')->name('addNewVacation');
    Route::post('/employer/update/vacation/{id}', 'EmployerController@handleUpdateVacation')->name('updateVacation');

});
