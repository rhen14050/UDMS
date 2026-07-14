<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\UdPpcInputController;
// use 

Route::get('/', function () {
    return view('blank');
})->name('blank');

Route::get('/user', function () {
    return view('user');
})->name('user');


Route::get('/ud_monitoring', function () {
    return view('ud_monitoring');
})->name('ud_monitoring');

Route::get('/get_ud_ppc_inputs_details', 'UdPpcInputController@getUdPpcInputsDetails')->name('get_ud_ppc_inputs_details');
Route::get('/get_ud_control_number', 'UdPpcInputController@getUdControlNumber')->name('get_ud_control_number');
// Route::get('/delete_ud_ppc_input', 'UdPpcInputController@deleteUdPpcInput')->name('delete_ud_ppc_input');
Route::delete('/delete_ud_ppc_input/{id}', 'UdPpcInputController@deleteUdPpcInput')
    ->name('delete_ud_ppc_input');

Route::get('/get_prod_name_by_po', 'UdPpcInputController@getProdNameByPo')->name('get_prod_name_by_po');

Route::post('/save_ud_details', 'UdPpcInputController@saveUdDetails')->name('save_ud_details');
Route::get('/get_ud_details', 'UdPpcInputController@getUdDetails')->name('get_ud_details');
Route::get('/get_attendees_by_rapidx', 'UdPpcInputController@getAttendeesByRapidX')->name('get_attendees_by_rapidx');

// Route::get('/export-ud-monitoring', [UdPpcInputController::class, 'export'])->name('export.ud.monitoring');
Route::get('/export-ud-monitoring', [UdPpcInputController::class, 'export'])
    ->name('export.ud.monitoring');

Route::get('sei_attachment/download/{id}', [UdPpcInputController::class, 'downloadSeiAttachment'])
->name('sei_attachment.download');

Route::get('ids_attachment/download/{id}', [UdPpcInputController::class, 'downloadIdsAttachment'])
->name('ids_attachment.download');

Route::get('orientation_attachment/download/{id}', [UdPpcInputController::class, 'downloadOrientationAttachment'])
->name('orientation_attachment.download');

Route::get('orcto_attachment/download/{id}', [UdPpcInputController::class, 'downloadOrctoAttachment'])
->name('orcto_attachment.download');