<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ApiController as ApiV1;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/v1/invoices', [ApiV1::class, 'invoices']);

Route::post('/v1/certificate-fe-xml-tosign', [ApiV1::class, 'certificate_fe_xml_tosign']);
Route::get('/v1/certificate-fe-xml-tosign', [ApiV1::class, 'certificate_fe_xml_tosign']);
Route::post('/v1/cancel-fel', [ApiV1::class, 'cancel_fel']);
//Route::get('/v1/cancel-fel', [ApiV1::class, 'cancel_fel']);

Route::get('/v1/sharedinfo', [ApiV1::class, 'sharedinfo']);
Route::get('/v1/get-document', [ApiV1::class, 'get_document']);

Route::get('/v1/get-info-ruc', [ApiV1::class, 'get_info_ruc']);

Route::get('/v1/pa/ubicaciones', [ApiV1::class, 'pa_ubicaciones']);












Route::post('/v1/credit-notes', [ApiV1::class, 'creditNote']);
Route::post('/v1/debit-notes', [ApiV1::class, 'debitNote']);
