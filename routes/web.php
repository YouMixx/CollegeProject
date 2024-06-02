<?php

use App\Http\Controllers\Admin\GenerateDocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/certificate/generate/{student}', [GenerateDocumentController::class, 'generateCertificate']);
Route::get('/certificate/view/{student}', [GenerateDocumentController::class, 'viewCertificate']);
Route::get('/certificate/download/{student}', [GenerateDocumentController::class, 'downloadCertificate']);

Route::get('/document-company/generate/{company}', [GenerateDocumentController::class, 'generateDocumentCompany']);
Route::get('/document-company/view/{company}', [GenerateDocumentController::class, 'viewDocumentCompany']);