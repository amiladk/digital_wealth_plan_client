<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

use App\Models\CurrencyType;
use App\Models\CryptoNetwork;
use App\Models\User;
use App\Models\TransactionSettings;
use App\Models\Funding_payment;
use App\Models\PasswordReset;
use App\Models\P2PTransfer;


use DB;
use Auth;

class ViewController extends DataController
{

    public function default($data)
    {
        // Defalut css
        $css =array(
            config('site-specific.jquery-jvectormap-css'),
            config('site-specific.flatpickr-min-css'),
            config('site-specific.preloader-min-css'),
            config('site-specific.bootstrap-min-css'),
            config('site-specific.icons-min-css'),
            config('site-specific.app-min-css'),
            config('site-specific.custom-css'),
            config('site-specific.sweetalert-css'),


        );
        //Default script
        $script =array(
            config('site-specific.jquery-min-js'),
            config('site-specific.sweetalert-js'),
            config('site-specific.jquery-validation-min-js'),
            config('site-specific.additional-methods-js'),
            config('site-specific.bootstrap-bundle-min-js'),
            config('site-specific.metisMenu-min-js'),
            config('site-specific.simplebar-min-js'),
            config('site-specific.waves-min-js'),
            config('site-specific.feather-min-js'),
            config('site-specific.pace-min-js'),
            config('site-specific.pass-addon-init-js'),
            config('site-specific.apexcharts-min-js'),
            config('site-specific.jquery-jvectormap-1-2-2-min-js'),
            config('site-specific.jquery-jvectormap-world-mill-en-js'),
            // config('site-specific.dashboard-init-js'),
            config('site-specific.app-js'),
            config('site-specific.custom-js'),

        );

        if(isset($data['css'])){
            $data['css'] = array_merge($css,$data['css']);
        }else{
            $data['css'] = $css;
        }
        if(isset($data['script'])){
            $data['script'] = array_merge($script,$data['script']);
        }else{
            $data['script'] = $script;
        }
        $data['exsist_funding_payment'] = $this->getExsistFundingPayment();
        $data['user_details'] = $this->getAuthUserDetails();

        return View::make('template', $data);

    }

    public function login()
    {

        return View::make('login');
    }

    public function forgetPassword()
    {

        return View::make('forget-password');
    }

    public function passwordReset($token)
    {

        $decrypted = Crypt::decryptString($token);
        
        $explode   = explode("?",$decrypted);

        if(Carbon::now()->addHour(0)->format('Y-m-d H:i:s') < $explode[2] ==false){
            PasswordReset::where('email', $explode[1])->delete();
            return redirect('/login')->with('error', 'Oops! Password reset link is expired');
        }

        $query  = PasswordReset::where('email'  , $explode[1])
                                 ->where('token' , $token)
                                 ->first();
        if($query){
            $data['token'] =  $query->token;
            return View::make('password-reset',$data);
        }else{
            return redirect('/login')->with('error', 'Oops! Data not found');
        }
    }

    public function termsCondition()
    {
        return View::make('terms-condition');
    }

    public function signUp(Request $request)
    {
        $data =array(
            'sponsor'=>null,
            'sponsor_side'=>null
        );

        if (isset($request->ref) && isset($request->ref_s)) {
            $data['sponsor'] = $request->ref;
            $data['sponsor_side'] = $request->ref_s;
        }
        return View::make('sign_up',$data);
    }

    public function dashboard(Request $request)
    {


        $data =array(
            'title'             => 'Dashboard',
            'view'              => 'dashboard',
            'css'               => array(config('site-specific.intlTelInput-css')),
            'script'            => array(config('site-specific.dashboard-init-js'),
                                         config('site-specific.intlTelInput-min-js')),
            'created_date'      => User::where('id',Auth::id())->first('created_at'),
            // 'approved_date'     => $this->getApprovedDate(Auth::id())
        );
        return $this->default($data);
    }

    public function topUp(Request $request)
    {

        $data =array(
            'title'             => 'Top Up',
            'view'              => 'top-up',
            'css'               => array(config('site-specific.dropzone-min-css'),config('site-specific.cropper-min-css')),
            'script'            => array(config('site-specific.pristine-min-js'),
                                        config('site-specific.dropzone-min-js'),
                                        config('site-specific.flatpickr-min-js'),
                                        config('site-specific.cropper-min-js'),
                                        config('site-specific.top-up-init-js'),
                                        config('site-specific.form-validation-init')),
            'currencytypes'     => CurrencyType::where('is_active',1)->with(['networkMap.cryptoNetwork'])->get(),
            // 'cryptoNetworks'    => CryptoNetwork::where('is_active',1)->get(),
            'availableBalance'  => User::find(auth()->user()->id)->wallet,
            'minimumFundingAmount'=>$this->getTransactionSetting('minimum_funding_amount'),
            'serviceCharge'     => TransactionSettings::where('field','service_charge')->first()->value,
        );

        return $this->default($data);

    }

    public function kycVerification(Request $request)
    {
        if(Auth::user()->kyc_status != '' && Auth::user()->kyc_status != 2){
            return redirect()->route('kyc-verified-details');
        }

        $data =array(
            'title'             => 'KYC Verification',
            'view'              => 'kyc-verification',
            'css'               => array(config('site-specific.dropzone-min-css'),config('site-specific.cropper-min-css'),config('site-specific.intlTelInput-css'),
                                        config('site-specific.mobiscroll-javascript-min-css')),
            'script'            => array(config('site-specific.jquery-bootstrap-wizard-min-js'),config('site-specific.prettify-js'),config('site-specific.mobiscroll-javascript-min-js'),
                                        // config('site-specific.form-wizard-init-js'),config('site-specific.form-advanced-init-js'),
                                        config('site-specific.dropzone-min-js'),config('site-specific.flatpickr-min-js'),config('site-specific.intlTelInput-min-js'),
                                        config('site-specific.cropper-min-js'),config('site-specific.kyc-verification-js')),
            'client_titles'     => $this->getClientTitles(),
            'client_fund_sources'=> $this->source(),
            'user'              => $this->getAuthUserDetails(),
            'identity_doc_types'=> $this->getIdentityDocTypes(),
        );

        return $this->default($data);

    }

    public function Geneology(Request $request)
    {

        $data =array(
            'title'             => 'Genealogy',
            'view'              => 'geneology',
            'css'               => array(config('site-specific.geneology-style')),
            'script'            => array(config('site-specific.geneology-init-js')),
        );
        return $this->default($data);

    }

    public function discalimerNotice(Request $request)
    {

        $data =array(
            'title'             => 'Disclaimer Notice',
            'view'              => 'discalimer-notice',
            'css'               => array(),
            'script'            => array(),
        );
        return $this->default($data);

    }



    public function withdrawals(Request $request)
    {
        if(Auth::user()->kyc_status != 1){
            return redirect()->route('pending-approval');
        }

        $data =array(
            'title'             => 'Withdrawals',
            'view'              => 'withdrawals',
            'css'               => array(),
            'script'            => array(config('site-specific.form-validation-init'),config('site-specific.withdrawals-init-js')),
            'currency_type'     => $this->currencyType(),
            'crypto_network'    => $this->cryptoNetwork(),
            'client_wallets'    => $this->clientWallet(),
        );

        return $this->default($data);

    }

    public function profile(Request $request)
    {

        $data =array(
            'title'             => 'Profile',
            'view'              => 'profile',
            'css'               => array(config('site-specific.dropzone-min-css')),
            'script'            => array(config('site-specific.dropzone-min-js'),config('site-specific.form-validation-init')),
            'user'              => $this->getAuthUserDetails(),
        );

        return $this->default($data);

    }

    public function printNotice($id){

        $data =array(
            'funding_payment'   => Funding_payment::with('getUser')->find($id),
        );

        return View::make('print-discalimer-notice',$data);
    }

    public function kycVerificationDetails(Request $request)
    {

        $data =array(
            'title'             => 'KYC Verified Details',
            'view'              => 'kyc-verification-details',
            'user_details'      => $this->getKycDetails(),
        );
        return $this->default($data);

    }

    public function myFunding(Request $request)
    {
        $clientId = Auth::id();
        $client   = User::find($clientId);
        $data =array(
            'title'                 => 'My Fundings',
            'view'                  => 'my-funding',
            'css'                   => array(config('site-specific.dataTables-bootstrap4-min-css'),config('site-specific.buttons-bootstrap4-min-css'),
                                        config('site-specific.responsive-bootstrap4-min-css')),
            'script'                => array(config('site-specific.jquery-dataTables-min-js'),config('site-specific.dataTables-bootstrap4-min-js'),config('site-specific.dataTables-buttons-min-js'),
                                        config('site-specific.buttons-bootstrap4-min-js'),config('site-specific.jszip-min-js'),config('site-specific.pdfmake-min-js'),
                                        config('site-specific.vfs_fonts-js'),config('site-specific.buttons-html5-min-js'),config('site-specific.buttons-print-min-js'),
                                        config('site-specific.buttons-colVis-min-js'),config('site-specific.dataTables-responsive-min-js'),config('site-specific.responsive-bootstrap4-min-js'),
                                        config('site-specific.datatables-init-js')),
            'my_funding_payments'   => $this->getMyFundingPayment($clientId),
            'kyc_status'       => $client->kyc_status,
        );
        return $this->default($data);

    }

    public function clientSummary(Request $request)
    {

        $clintId = Auth::id();
        $client   = User::find($clintId);

        $total_left_bv             = $this->getTotalBvSide($clintId,0);
        $total_right_bv            = $this->getTotalBvSide($clintId,1);
        $balanced_bv               = min($total_left_bv[0]->value,$total_right_bv[0]->value);
        $left_after_bv_balance     = $total_left_bv[0]->value - $balanced_bv ;
        $right_after_bv_balance    = $total_right_bv[0]->value - $balanced_bv ;
        $main_head_investment      = $this->getMainInvestment($clintId,1);
        $total_top_up_Investments  = $this->getMainInvestment($clintId,2);
        $total_investments         = $main_head_investment[0]->value + $total_top_up_Investments[0]->value;
        $top_upsby_wallet          = $this->getTopUpsbyWallet($clintId);
        $total_withdrawals         = $this->getTotalWithdrawals($clintId);
        $total_client_top_up       = $this->getTotalClientTopUp($clintId);
        $total_service_charge      = $this->getTotalServiceCharge($clintId);
        $total_withdrawl_service_charge = $this->getTotalWithdrawlServiceCharge($clintId);

        $data =array(
            'title'                     => 'User Summary',
            'view'                      => 'client-summary',
                'css'                   => array(config('site-specific.dataTables-bootstrap4-min-css'),
                                                    config('site-specific.buttons-bootstrap4-min-css'),
                                                    config('site-specific.responsive-bootstrap4-min-css')),
                'script'                => array(config('site-specific.jquery-dataTables-min-js'),
                                                    config('site-specific.dataTables-bootstrap4-min-js'),
                                                    config('site-specific.dataTables-buttons-min-js'),
                                                    config('site-specific.buttons-bootstrap4-min-js'),
                                                    config('site-specific.jszip-min-js'),
                                                    config('site-specific.pdfmake-min-js'),
                                                    config('site-specific.vfs_fonts-js'),
                                                    config('site-specific.buttons-html5-min-js'),
                                                    config('site-specific.buttons-print-min-js'),
                                                    config('site-specific.buttons-colVis-min-js'),
                                                    config('site-specific.dataTables-responsive-min-js'),
                                                    config('site-specific.responsive-bootstrap4-min-js'),
                                                    config('site-specific.datatables-init-js')),
            'client_top_ups'            => $this->getMyFundingPayment($clintId),
            'client_withdrawals'        => $this->getWithdrawal($clintId),
            'unilevel_funding_rewards'  => $this->getUniLevelRewards($clintId,1),
            'unilevel_topup_rewards'    => $this->getUniLevelRewards($clintId,2),
            'bv_rewards'                => $this->getBvRewards($clintId),
            'daily_rewards'             => $this->getDailyRewards($clintId),
            'client'                    => $client,
            'bv_elegibilty'             => $this->getBvElegibility($clintId),
            'total_left_chain_bv'       => number_format($total_left_bv[0]->value,2),
            'total_right_chain_bv'      => number_format($total_right_bv[0]->value,2),
            'blance_bv'                 => number_format($balanced_bv,2),
            'left_after_bv_balance'     => number_format($left_after_bv_balance,2),
            'right_after_bv_balance'    => number_format($right_after_bv_balance,2),
            'reward_counts'             => $this->rewardsCounts($clintId),
            'total_withdrawals'         => number_format($total_withdrawals[0]->value,2),
            'top_upsby_wallet'          => number_format($top_upsby_wallet[0]->value,2),
            'main_head_investment'      => number_format($main_head_investment[0]->value,2),
            'total_top_up_Investments'  => number_format($total_top_up_Investments[0]->value,2),
            'total_investments'         => number_format($total_investments,2),
            'total_available_balance'   => number_format($client->wallet,2),
            'total_holding_balance'     => number_format($client->holding_wallet,2),
            'total_client_top_up'       => number_format($total_client_top_up[0]->value,2),
            'total_service_charge'      => number_format($total_service_charge [0]->value,2),
            'total_withdrawl_service_charge' => number_format($total_withdrawl_service_charge [0]->value,2),
            'left_user_direct_count'    => User::where('sponsor',Auth::id())->where('sponsor_side', 0)->count(),
            'right_user_direct_count'   => User::where('sponsor',Auth::id())->where('sponsor_side', 1)->count(),
            'p2p_sent'                  => number_format(P2PTransfer::where('from',Auth::id())->sum('received_amount'),2),
            'p2p_received'              => number_format(P2PTransfer::where('to',Auth::id())->sum('received_amount'),2),
            'p2p_sent_details'          => $this->getP2Psent(),
            'p2p_received_details'      => $this->getP2Preceived(),
        );
        // return response()->json($data['client_top_ups']);
        return $this->default($data);
    }

    public function pendingApproval(Request $request)
    {
        $data =array(
            'title'             => 'Pending Approval',
            'view'              => 'pending-approval',
        );

        return $this->default($data);
    }

    public function p2pTransfer(Request $request)
    {
        $data =array(
            'title'                 => 'P2P Transfer',
            'view'                  => 'p2p-transfer',
            'p2p_transaction_fee'   =>$this->getTransactionSetting('p2p_transaction_fee'),
            'script'                => array(config('site-specific.p2p-transfer-init-js')),
            'p2p_sent'              => $this->getP2Psent(),
            'p2p_received'          => $this->getP2Preceived(),
        );
        return $this->default($data);
    }

}

