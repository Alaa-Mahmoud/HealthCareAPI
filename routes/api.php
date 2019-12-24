<?php

Route::post('login', 'UserLoginController');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('medical-service-types', 'MedicalServiceTypeController@index');
    Route::apiResource('medical-services' , 'MedicalServiceController');
    Route::apiResource('invoices' , 'InvoiceController');
    Route::get('patients/invoices', 'PatientInvoiceController@index');
    Route::post('invoices/{invoice}/pay', 'PayInvoiceController');
});
