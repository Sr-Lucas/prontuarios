<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers\Api')->group(function () {

    Route::post('/login', 'Auth\LoginController@login')->name('login');

    Route::post('/administrators', 'AdministratorController@store');

    Route::get('/files/{filepath}', 'FileController@show');

    Route::middleware(['jwt.auth'])->group(function() {

        Route::resource('/doctors', 'DoctorController');
        Route::resource('/patients', 'PatientController');
        Route::resource('/expertises', 'DoctorExpertiseController');

        /**
         * ExamResult ROUTES
         */
        Route::post('/attendanceRequests/{id}/examResults', 'ExamResultController@store');
        Route::get('/attendanceRequests/{attendance_request_id}/examResults', 'ExamResultController@index');
        Route::delete('/examResults/{id}', 'ExamResultController@destroy');

        /**
         * AttendanteRequests ROUTES
         */
        Route::get('/attendanceRequests', 'AttendanceRequestController@index');
        Route::get('/attendanceRequests/{id}', 'AttendanceRequestController@show');
        Route::post('/doctors/{doctor_id}/attendanceRequests', 'AttendanceRequestController@store');
        Route::put('/attendanceRequests/{id}', 'AttendanceRequestController@update');
        Route::delete('/attendanceRequests/{id}', 'AttendanceRequestController@destroy');

        /**
         * Patient Addresses ROUTES
        */
        Route::get('/patients/{patient_id}/addresses', 'PatientAddressController@index');
        Route::post('/patients/{patient_id}/addresses', 'PatientAddressController@store');
        Route::put('/addresses/{id}', 'PatientAddressController@update');
        Route::delete('/addresses/{id}', 'PatientAddressController@destroy');

        /**
         * Administrator ROUTES
         */
        Route::get('/administrators', 'AdministratorController@index');
        Route::get('/administrators/{id}', 'AdministratorController@show');
        Route::put('/administrators/{id}', 'AdministratorController@update');
        Route::delete('/administrators/{id}', 'AdministratorController@destroy');
    });

});
