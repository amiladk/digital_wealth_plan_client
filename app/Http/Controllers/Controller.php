<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

use App\Models\TransactionSettings;
use App\Models\BvRewardPercentage;
use App\Models\User;
use App\Models\Funding_payment;
use Mail;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //pass array of client ids
    protected function updateWallets($client_ids){
        foreach ($client_ids as $key => $client) {
            $referral_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward` WHERE client=  :client"),
            array(
                'client' => $client,
            ))[0]->value;
            $bv_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward` WHERE client = :client"),
            array(
                'client' => $client,
            ))[0]->value;
            $daily_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward` WHERE client = :client"),
            array(
                'client' => $client,
            ))[0]->value;
            $withdrawals = DB::select( DB::raw("SELECT IFNULL(SUM(withdraw_amount),0) AS value FROM `withdrawal` WHERE (status=1 OR status=0) AND client = :client"),
            array(
                'client' => $client,
            ))[0]->value;
            $reward_limit = DB::select( DB::raw("SELECT SUM(other_reward_limit) AS value FROM `funding_payment` WHERE status=1 AND client = :client"),
            array(
                'client' => $client,
            ))[0]->value;
            $wallet_purchase = DB::select( DB::raw("SELECT SUM(funding_amount) AS value FROM `funding_payment` WHERE (status=1 OR status=0) AND funding_payment_method=2 AND client = :client"),
            array(
                'client' => $client,
            ))[0]->value;

            $p2p_sent = DB::select( DB::raw("SELECT SUM(transfer_amount) AS value FROM `p2p_transfer` WHERE `from` = :client"),
            array(
                'client' => $client,
            ))[0]->value;

            $p2p_received = DB::select( DB::raw("SELECT SUM(received_amount) AS value FROM `p2p_transfer` WHERE `to` = :client"),
            array(
                'client' => $client,
            ))[0]->value;

            if ($this->isBvElegible($client)) {
                $total_rewards = $referral_rewards + $bv_rewards;
                $total_balance = $referral_rewards + $bv_rewards + $daily_rewards - $withdrawals - $wallet_purchase;
                $available_reward_limit = $reward_limit - $withdrawals - $wallet_purchase;
                $wallet = $total_balance;
                $holding_wallet = 0;

                if ($total_balance > $available_reward_limit) {
                    $wallet = $available_reward_limit;
                    $holding_wallet = $total_balance - $wallet;
                }
            }else{
                $total_rewards = $referral_rewards;
                $total_balance = $referral_rewards + $daily_rewards - $withdrawals - $wallet_purchase;
                $available_reward_limit = $reward_limit - $withdrawals - $wallet_purchase;
                $wallet = $total_balance;
                $holding_wallet = $bv_rewards;

                if ($total_balance > $available_reward_limit) {
                    $wallet = $available_reward_limit;
                    $holding_wallet = $holding_wallet + ($total_balance - $wallet);
                }
            }
            $wallet = $wallet + $p2p_received - $p2p_sent;

            User::where('id', $client)->update(['wallet' => $wallet, 'holding_wallet'=>$holding_wallet]);
            $this->calAchievedRewards($client,$total_rewards);
        }
    }


    protected function isBvElegible($clintId){

        $left_sponsor  = User::where('sponsor', $clintId)->where('is_active', 1)->where('sponsor_side', 0)->first();
        $right_sponsor = User::where('sponsor', $clintId)->where('is_active', 1)->where('sponsor_side', 1)->first();

        if($left_sponsor && $right_sponsor){
            return true;
        }
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get a transaction setting
    |--------------------------------------------------------------------------
    */
    protected function getTransactionSetting($field){
        return TransactionSettings::where('field',$field)->first()->value;;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function get bv reward percentage of a funding_payment
    |--------------------------------------------------------------------------
    */
    protected function getBvRewardPercentage($trading_amount,$funding_type){
        return BvRewardPercentage::where('greater_than','<=',$trading_amount)
                                    ->where('less_than','>=',$trading_amount)
                                    ->where('type',$funding_type)
                                    ->first()->percentage;
    }
    /*
    |--------------------------------------------------------------------------
    |protected function Send email
    |--------------------------------------------------------------------------
    */
    protected function sendEmail($subject,$user_mail,$blade,$data=null){

        Mail::send($blade,
        array(
            'data'     => $data,
            'base_url' => URL::to('/'),
        ), function($message) use ($user_mail,$subject)
        {
            $message->from(config('site-specific.site-mail-address'));
            $message->subject($subject);
            $message->to($user_mail);
        });

    }
    /*
    |--------------------------------------------------------------------------
    |protected function cal Achieved Rewards
    |--------------------------------------------------------------------------
    */
    protected function calAchievedRewards($client, $total_rewards){
        $funding_payments = Funding_payment::where('client', $client)->where('status', 1)->get();
        $remaining_rewards = $total_rewards;
        foreach ($funding_payments as $key => $item){
            $daily_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `daily_reward` WHERE funding_payment = :funding_payment"),
            array(
                'funding_payment' => $item->id,
            ))[0]->value;
            $remaining_rewards += $daily_rewards;
            if($remaining_rewards >= $item->other_reward_limit){
                $item->achieved_rewards  = $item->other_reward_limit;
                $item->other_rewards_completed = true;
            }else {
                $item->achieved_rewards = $remaining_rewards;  
            }
            $item->save();
            $remaining_rewards -= $item->achieved_rewards;
        }
        return 1;
    }

    /*
    |--------------------------------------------------------------------------
    |protected function Send email
    |--------------------------------------------------------------------------
    */
    protected function sendSms($message,  $to)
        {
    

        $ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL,"https://cloud.websms.lk/smsAPI"); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS,"sendsms=&apikey=jiQF1AmURqOEWiLvANuG92bFfnM72ZJM&apitoken=yyuN1678693089&type=sms&from=MyTrader&text=".$message."&to=".$to.""); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); 
			// receive server response ... 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			$server_output = curl_exec ($ch); 
			curl_close ($ch); 
			return json_decode($server_output,true);
        

    }
}