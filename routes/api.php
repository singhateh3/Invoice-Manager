<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

<<<<<<< HEAD
Route::post('/signup', [UserController::class, 'register']);
=======
Route::post('/register', [UserController::class, 'register']);
>>>>>>> 74530e6d76c15b465949f28fddf9fb212adaf1bd
Route::post('/login', [UserController::class, 'login']);
Route::post('/guest/invoice', [InvoiceController::class, 'GuestInvoice']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/invoice', InvoiceController::class);
    Route::apiResource('/company', CompanyController::class);
    Route::get('/my-invoices', [InvoiceController::class, 'myInvoices']);
<<<<<<< HEAD
    Route::post('/logout', [UserController::class, 'logout']);
=======
>>>>>>> 74530e6d76c15b465949f28fddf9fb212adaf1bd
});

Route::get('/company/invoices/{companyId}', [InvoiceController::class, 'companyInvoices']);
