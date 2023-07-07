<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Response;

use App\Models\CryptoNetwork;
use App\Models\CurrencyType;
use App\Models\ClientWallet;
use App\Models\User;
use App\Models\PersonalDetails;
use App\Models\Source;
use App\Models\IdentityDocType;
use App\Models\ClientTitle;
use App\Models\Funding_payment;
use App\Models\Withdrawal;
use App\Models\FundingPaymentMethod;
use App\Models\P2PTransfer;



use Auth;
use DB;
use Carbon\Carbon;

use App\Models\Country;

class DataController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |protected function get all country list
    |--------------------------------------------------------------------------
    */ 
    public function countryList(){

        $data = Country::all();
    
    }

      /*
    |--------------------------------------------------------------------------
    |protected function get all country list
    |--------------------------------------------------------------------------
    */ 
    public function getClientTitles(){

        $data = PersonalDetails::all();
        return $data;
    }

    public function source(){

        $data = Source::all();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get all currency type
    |--------------------------------------------------------------------------
    */ 
    protected function currencyType(){

        $data = CurrencyType::all();
        return $data;

    }

    /*
    |--------------------------------------------------------------------------
    |protected function get all crypto network
    |--------------------------------------------------------------------------
    */ 
    protected function cryptoNetwork(){

        $data = CryptoNetwork::all();
        return $data;

    }

    /*
    |--------------------------------------------------------------------------
    |protected function get all client wallet
    |--------------------------------------------------------------------------
    */ 
    protected function clientWallet(){

        $data = ClientWallet::with('currencyType','cyptoNetwork')->where('client',Auth::id())->get();
        return $data;

    }


    /*
    |--------------------------------------------------------------------------
    |protected function get auth user details
    |--------------------------------------------------------------------------
    */ 
    protected function getAuthUserDetails(){ 

        $data = User::with('country')->where('id',Auth::id())->first();
        return $data;

    }
 
    /* 
    |--------------------------------------------------------------------------
    |protected function get auth user details
    |--------------------------------------------------------------------------
    */ 
    protected function getKycDetails(){

        $data = User::with('getClientTitle','getClientFundSource','getIdentityDocType','country','getKyckycStatus', 'getFrontImage','getBackImage','getSelfieImage')->where('id',Auth::id())->first();
        return response()->json($data); 
        // return $data;

    }


    /*
    |--------------------------------------------------------------------------
    |protected function get Identity Doc Types
    |--------------------------------------------------------------------------
    */ 
    protected function getIdentityDocTypes(){

        $data = IdentityDocType::all();
        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    |protected function get undingPayment
    |--------------------------------------------------------------------------
    */ 
    protected function getMyFundingPayment($clintId){
         $data = Funding_payment::with('getFundingPaymentMethod')->orderBy('created_at', 'ASC')
        ->where('client',$clintId)
        ->get();
   
        return $data;

    }

    
    /*
    |--------------------------------------------------------------------------
    |protected function get Withdrawal
    |--------------------------------------------------------------------------
    */ 
    protected function getWithdrawal($clintId){
        $data = Withdrawal::orderBy('created_at', 'ASC')
       ->where('client',$clintId)
       ->get();
       return $data;
   }

    /*
    |--------------------------------------------------------------------------
    |protected function get Uni-Level Rewards
    |--------------------------------------------------------------------------
    */ 
    protected function getUniLevelRewards($clintId,$fundingType){
        $data = DB::table('referral_reward')
                    ->join('funding_payment', 'referral_reward.funding_payment', '=', 'funding_payment.id')
                    ->join('client', 'client.id', '=', 'funding_payment.client')
                    ->select('referral_reward.client','referral_reward.amount','referral_reward.earning_percentage','funding_payment.client', 'funding_payment.approved_date', 'funding_payment.trading_amount','client.membership_no')
                    ->where('referral_reward.client',$clintId)
                    ->where('funding_payment.funding_type',$fundingType)
                    ->get();
        return $data;
   }

   /*
    |--------------------------------------------------------------------------
    |protected function get  Rewards
    |--------------------------------------------------------------------------
    */
   protected function getBvRewards($clintId){
    $data = DB::table('bv_reward')
                ->join('funding_payment', 'bv_reward.funding_payment', '=', 'funding_payment.id')
                ->join('client', 'client.id', '=', 'funding_payment.client')
                ->select('funding_payment.approved_date',
                        'client.membership_no',
                        'funding_payment.trading_amount',
                        'bv_reward.earning_percentage',
                        'bv_reward.left_bv_rewards',
                        'bv_reward.right_bv_rewards', 
                        'bv_reward.balanced_amount', 
                        'bv_reward.amount',
                        'bv_reward.funding_side',
                        'funding_payment.funding_type')
                ->where('bv_reward.client',$clintId)
                ->get();
    return $data;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Daily Rewards
    |--------------------------------------------------------------------------
    */

    protected function getDailyRewards($clintId){
        $data = DB::table('daily_reward')
                    ->join('funding_payment', 'daily_reward.funding_payment', '=', 'funding_payment.id')
                    ->select('funding_payment.trading_amount',
                            'daily_reward.reward_date',
                            'daily_reward.amount',)
                    ->where('daily_reward.client',$clintId)
                    ->orderBy('reward_date','ASC')
                    ->get();
        return $data;
   }


      /*
   |--------------------------------------------------------------------------
   |protected function get Bv Elegibility
   |--------------------------------------------------------------------------
   */

   protected function getBvElegibility($clintId){
           

    $left_sponsor  = User::where('sponsor', $clintId)->where('sponsor_side', 0)->first();
    $right_sponsor = User::where('sponsor', $clintId)->where('sponsor_side', 1)->first();
     
    if($left_sponsor && $right_sponsor){
        return "Eligible";
    }
    return "Not Eligible";
}

            
    /*
    |--------------------------------------------------------------------------
    |protected function get Total Bv Side
    |--------------------------------------------------------------------------
    */

    protected function getTotalBvSide($clintId,$side){
        if ($side==0) {
            $total_bv_side = DB::select( DB::raw("SELECT IFNULL(SUM(left_bv_rewards),0) AS value FROM `bv_reward` WHERE client=  :client AND funding_side = :side"), 
                                array(
                                    'client' => $clintId,
                                    'side'  => $side,
                                ));
        }
        if ($side==1) {
            $total_bv_side = DB::select( DB::raw("SELECT IFNULL(SUM(right_bv_rewards),0) AS value FROM `bv_reward` WHERE client=  :client AND funding_side = :side"), 
                                array(
                                    'client' => $clintId,
                                    'side'  => $side,
                                ));
        }
            
        return $total_bv_side;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Total Bv Side
    |--------------------------------------------------------------------------
    */

    protected function rewardsCounts($clintId){

        $referral_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward`
            WHERE client=  :client"), 
                    array(
                        'client' => $clintId,
                    ));
        $bv_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward` 
            WHERE client = :client"), 
                    array(
                        'client' => $clintId,
                    ));
        $daily_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward` 
            WHERE client = :client"), 
                    array(
                        'client' => $clintId,
                    ));
        $total_earnings =  $referral_rewards[0]->value + $bv_rewards[0]->value + $daily_rewards[0]->value ;
        $response_array = array(
                            'referral_rewards'=>number_format($referral_rewards[0]->value,2),
                            'bv_rewards'=>  number_format($bv_rewards[0]->value,2),
                            'daily_rewards' => number_format($daily_rewards[0]->value,2),
                            'total_earnings' => number_format($total_earnings,2),
                        );
        //  return response()->json($response_array);
        return $response_array;

    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Total Withdrawals
    |--------------------------------------------------------------------------
    */

    protected function getTotalWithdrawals($clintId){
        $total_withdrawals = DB::select( DB::raw("SELECT IFNULL(SUM(withdraw_amount),0) AS value FROM withdrawal WHERE client=  :client AND status = :status"), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                ));
        return $total_withdrawals;
    }

    
  
    /*
    |--------------------------------------------------------------------------
    |protected function get Top-Ups by Wallet
    |--------------------------------------------------------------------------
    */

    protected function getTopUpsbyWallet($clintId){
        $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_payment_method=  :funding_payment_method "), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                    'funding_payment_method' => 2,
                                ));
        return $top_upsby_wallet;  
    }


    public function getExsistFundingPayment(){

        $data  = Funding_payment::where('client',Auth::id())->exists();
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Main Head Investment
    |--------------------------------------------------------------------------
    */

    protected function getMainInvestment($clintId,  $funding_type){
        $main_investment = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_type = :funding_type"), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                    'funding_type' => $funding_type
                                ));
        return $main_investment;

    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Total Client Top-Up
    |--------------------------------------------------------------------------
    */

    protected function getTotalClientTopUp($clintId){
        $total_client_top_up = DB::select( DB::raw("SELECT IFNULL(SUM(funding_amount),0) AS value FROM funding_payment WHERE client=  :client"), 
                                    array(
                                        'client' => $clintId,
                                    ));
            return $total_client_top_up;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get Total Service charge
    |--------------------------------------------------------------------------
    */
    protected function getTotalServiceCharge($clintId){
        $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(service_charge),0) AS value FROM funding_payment WHERE client=  :client AND status = :status AND funding_payment_method=  :funding_payment_method "), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                    'funding_payment_method' => 2,
                                ));
        return $top_upsby_wallet;  
    }


    /*
    |--------------------------------------------------------------------------
    |protected function get Total Withdrawl Service charge
    |--------------------------------------------------------------------------
    */
    protected function getTotalWithdrawlServiceCharge($clintId){
        $top_upsby_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(transaction_fee),0) AS value FROM withdrawal WHERE client=  :client AND status = :status"), 
                                array(
                                    'client' => $clintId,
                                    'status'  => 1,
                                ));
        return $top_upsby_wallet;  
    }


    /*
    |--------------------------------------------------------------------------
    |protected function get approved date of a client
    |--------------------------------------------------------------------------
    */
    protected function getApprovedDate($clintId){
        $approved_date = Funding_payment::where('client',Auth::id())->first('approved_date');
        $activated_date = 'Still not activated';
        if ($approved_date && $approved_date->approved_date) {
            $date = Carbon::createFromFormat('Y-m-d', $approved_date->approved_date);
            $daysToAdd = 7;
            $activated_date = $date->addDays($daysToAdd)->format('Y-m-d')." 00:00:00";
        }
        
        return $activated_date;  
    }
    

    /*
    |--------------------------------------------------------------------------
    |protected function get p2p sent
    |--------------------------------------------------------------------------
    */ 
    protected function getP2Psent(){
        $data = P2PTransfer::orderBy('created_at', 'ASC')
        ->with('getTo:id,full_name,membership_no')
       ->where('from',Auth::id())
       ->get();
       return $data;
   }
 
    /*
    |--------------------------------------------------------------------------
    |protected function get p2p received
    |--------------------------------------------------------------------------
    */ 
    protected function getP2Preceived(){
        $data = P2PTransfer::orderBy('created_at', 'ASC')
        ->with('getFrom:id,full_name,membership_no')
       ->where('to',Auth::id())
       ->get();
       return $data;
   }


}




