<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CurrencyCategoryController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function(){

    Route::controller(AuthenticationController::class)->group(function(){
        Route::post('/auth/login','Login');
        Route::post('/auth/register','Register');
    });

    Route::middleware('auth:sanctum')->group(function(){
        Route::controller(AuthenticationController::class)->group(function(){
            Route::post('/auth/logout','Logout');
        });

        Route::controller(CurrencyCategoryController::class)->group(function(){
            Route::get('/currencies','GetAllCurrencies');
            Route::get('/categories','GetAllCategories');
        });

        Route::controller(WalletController::class)->group(function(){
            Route::post('/wallets','AddWalet');
            Route::put('/wallets/{walletsid}','UpdateWalet');
            Route::delete('/wallets/{walletsid}','DeleteWalet');
            Route::get('wallets','GetAllWallets');
            Route::get('wallets/{walletsid}','GetDetailWallets');
        });

        Route::controller(TransactionController::class)->group(function(){
            Route::post('/transactions','AddTransaction');
            Route::delete('/transactions/{deleteid}','DeleteTransaction');
            Route::get('/transactions','GetTransaction');
        });

        Route::controller(FinancialController::class)->group(function(){
            Route::get('/wallets/{walletId}/reports/summary/expense','SummaryByExpenseCategory');
            Route::get('/wallets/{walletId}/reports/summary/income','SummaryByIncomeCategory');
        });
    });
});
