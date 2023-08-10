<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TypePaymentController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CommoditeController;
use App\Http\Controllers\HebergementOptionController;
use App\Http\Controllers\HebergementController;
use App\Http\Controllers\TypePropertieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReservationController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Route::get('/update-user-profile', [AuthController::class, 'update']);    
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    // Route::get('/hello', [AuthController::class, 'userProfile']);    
    Route::put('/users/{id}', [AuthController::class, 'update']);

});

Route::controller(CountryController::class)->group(function () {
    Route::get('country', 'index');
    Route::post('country', 'store');
    Route::get('country/{id}', 'show');
    Route::put('country/{id}', 'update');
    Route::delete('country/{id}', 'destroy');
}); 


Route::controller(PaymentController::class)->group(function () {
    Route::get('payment', 'index');
    Route::post('payment', 'store');
    Route::get('payment/{id}', 'show');
    Route::put('payment/{id}', 'update');
    Route::delete('payment/{id}', 'destroy');
}); 

Route::controller(TypePaymentController::class)->group(function () {
    Route::get('typepayment', 'index');
    Route::post('typepayment', 'store');
    Route::get('typepayment/{id}', 'show');
    Route::put('typepayment/{id}', 'update');
    Route::delete('typepayment/{id}', 'destroy');
}); 

Route::controller(TypePropertieController::class)->group(function () {
    Route::get('typePropertie', 'index');
    Route::post('typePropertie', 'store');
    Route::get('typePropertie/{id}', 'show');
    Route::put('typePropertie/{id}', 'update');
    Route::delete('typePropertie/{id}', 'destroy');
}); 

Route::controller(CommoditeController::class)->group(function () {
    Route::get('commodite', 'index');
    Route::post('commodite', 'store');
    Route::get('commodite/{id}', 'show');
    Route::put('commodite/{id}', 'update');
    Route::delete('commodite/{id}', 'destroy');
}); 

Route::controller(HebergementOptionController::class)->group(function () {
    Route::get('hebergementOption', 'index');
    Route::post('hebergementOption', 'store');
    Route::get('hebergementOption/{id}', 'show');
    Route::put('hebergementOption/{id}', 'update');
    Route::delete('hebergementOption/{id}', 'destroy');
}); 

Route::controller(HebergementController::class)->group(function () {
    Route::get('hebergement', 'index');
    Route::post('hebergement', 'store');
    Route::get('hebergement/{id}', 'show');
    Route::put('hebergement/{id}', 'update');
    Route::delete('hebergement/{id}', 'destroy');
    Route::get('hebergement-type/{typeLogement}',  'getByTypeLogement');
    Route::get('hebergements-user',  'getByUserId');
}); 


Route::controller(ReservationController::class)->group(function () {
    Route::get('reservation', 'index');
    Route::post('reservation', 'store');
    Route::get('reservation/{id}', 'show');
    Route::put('reservation/{id}', 'update');
    Route::delete('reservation/{id}', 'destroy');
}); 

Route::controller(MessageController::class)->group(function () {
    Route::get('/messages',  'index');
    Route::post('/messages',  'store');
    Route::get('/messages/{messageList}',  'show');
    Route::post('/messages/{messageList}',  'reply');
});

Route::controller(ImageController::class)->group(function () {
    Route::post('/images', 'store');
    Route::put('/images/{id}',  'update');
    Route::delete('/images/{id}', 'destroy');
    Route::get('/hebergements/{id}/images',  'getImageHebergement');
});

Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('filename', '.*');


