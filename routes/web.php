<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Web Route / Authenticated and Permissioned routes
|--------------------------------------------------------------------------
*/ 

Route::group([
    'middleware' => 'authroute',
    'namespace'=>'App\Http\Controllers',

],function ($router) {

    Route::get ('/'                             , 'ViewController@dashboard')->name('dashboard');

    Route::get ('/top-up'                       , 'ViewController@topUp')->name('top-up');

    Route::get ('/kyc-verification'             , 'ViewController@kycVerification')->name('kyc-verification');

    Route::get ('/genealogy'                    , 'ViewController@Geneology')->name('geneology');
    
    Route::get ('/discalimer-notice'            , 'ViewController@discalimerNotice')->name('discalimer-notice');

    Route::get ('/withdrawals'                  , 'ViewController@withdrawals')->name('withdrawals');
    
    Route::get ('/profile'                      , 'ViewController@profile')->name('profile');

    // Route::get ('/print-notice'         , 'ViewController@printNotice')->name('print-notice');

    Route::get ('/print-notice/{id}'            , 'ViewController@printNotice')->name('print-notice');

    Route::get ('/kyc-verified-details'         , 'ViewController@kycVerificationDetails')->name('kyc-verified-details');

    Route::get ('/my-funding'                   , 'ViewController@myFunding')->name('my-funding');

    Route::get ('/client-summary'               , 'ViewController@clientSummary')->name('client-summary');

    Route::get ('/pending-approval'             , 'ViewController@pendingApproval')->name('pending-approval');

    Route::get ('/p2p-transfer'                 , 'ViewController@p2pTransfer')->name('p2p-transfer');

    /*-------------------------------------------------------------------------------------
    ActionController
    -------------------------------------------------------------------------------------*/

    Route::post ('/action/client-wallet'                , 'ActionController@clientWallet');

    Route::post ('/action/withdrawal'                   , 'ActionController@withdrawal');

    Route::post ('/action/withdrawal-delete'            , 'ActionController@withdrawalDelete');

    Route::post ('/action/client-wallet-edit'           , 'ActionController@clientWalletEdit');

    Route::post ('/action/top-up'                       , 'ActionController@topUp')->name('top-up-action');

    Route::post ('/action/p2p-transfer'                 , 'ActionController@p2pTransfer');


    /*-------------------------------------------------------------------------------------
    AuthController
    -------------------------------------------------------------------------------------*/
    Route::post ('/action/update-password'              , 'AuthController@updatePassword');

    Route::post ('/action/get-verified-email-submit'    , 'AuthController@getVerfiedEmailSubmit');

    Route::get('/get-verified-email/{token}'            , 'AuthController@getVerfiedEmail');



    /*
    |--------------------------------------------------------------------------
    | AjaxController
    |--------------------------------------------------------------------------
    */ 
    Route::post('/ajax/update-kyc-personal-info'                         , 'AjaxController@updateKycPersonalInfo');
    
    Route::post('/ajax/update-kyc-source-of-funds'                       , 'AjaxController@updateKycSourceOfFunds'); 
    
    Route::post('/ajax/update-kyc-terms-and-condition'                   , 'AjaxController@updateKycTermsAndCondition'); 

    Route::post('/ajax/upload-kyc-crop-images'                           , 'AjaxController@uploadKycCropImages'); 

    Route::GET('/ajax/dashbord-counts'                                   , 'AjaxController@getDashbordCounts');
    
    Route::GET('/ajax/rewards-counts'                                    , 'AjaxController@rewardsCounts');
    
    Route::GET('/ajax/purchased-plans-counts'                            , 'AjaxController@getPurchasedplansDetails');  
     
    Route::GET('/ajax/get-geneology'                                     , 'AjaxController@getGeneology'); 

    Route::GET('/ajax/withdrawals-plans-counts'                          , 'AjaxController@getWithdrawalsPlansCounts');  

    Route::GET('/ajax/search-client'                                     , 'AjaxController@searchClient');

    Route::post('/ajax/change-auth-user-theme-mode'                      , 'AjaxController@changeAuthUserThemeMode');

    Route::post('/ajax/send-otp'                                         , 'AjaxController@sendOtp');
    
    Route::GET('/ajax/verify-otp'                                       , 'AjaxController@verifyOtp');
});


/*
|--------------------------------------------------------------------------
| Web Route /  Non-authenticated routes
|--------------------------------------------------------------------------
*/ 
Route::group([

    'namespace'=>'App\Http\Controllers',

],function ($router) {

    /*-------------------------------------------------------------------------------------
    ViewController
    -------------------------------------------------------------------------------------*/

    Route::get('/login'                     , 'ViewController@login')->name('login');

    Route::get ('/sign-up'                  , 'ViewController@signUp')->name('sign-up');

    Route::get ('/terms-condition'          , 'ViewController@termsCondition')->name('terms-condition');

    Route::get('/forget-password'           , 'ViewController@forgetPassword')->name('froget-password');

    Route::get('/password-reset/{token}'    , 'ViewController@passwordReset')->name('password-reset');

    
    /*-------------------------------------------------------------------------------------
    ActionController
    -------------------------------------------------------------------------------------*/
    Route::get('/image/{filename}'                   , 'ActionController@getStorgeImage')->name('image.displayImage');


    /*-------------------------------------------------------------------------------------
    AuthController
    -------------------------------------------------------------------------------------*/

    Route::post('/register'                 , [AuthController::class, 'signUp']);

    Route::post('/dologin'                  , [AuthController::class, 'doLogin']);

    Route::get('/logout'                    , [AuthController::class, 'doLogout']);

    Route::post('/froget-password-submit'   , [AuthController::class, 'forgetPasswordSubmit']);

    Route::post('/password-reset-submit'    , [AuthController::class, 'passwordResetSubmit']);


    //migration routes
    Route::get('/migrate-client'           , [AuthController::class, 'migrateClients']);
    Route::get('/migrate-team-map'         , [AuthController::class, 'migrateTeamCounts']);

});


 



