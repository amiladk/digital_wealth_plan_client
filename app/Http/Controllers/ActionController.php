<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

use Response;
use Validator;
use Throwable;
use Auth;
use Session;
use Mail;
use Carbon\Carbon;


use App\Models\ClientWallet;
use App\Models\Withdrawal;
use App\Models\PersonalDetails;
use App\Models\Source;
use App\Models\Funding_payment;
use App\Models\CryptoNetwork;
use App\Models\User;
use App\Models\Image;
use App\Models\P2PTransfer;
use App\Models\OTP;




class ActionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |private function verif yOtp
    |--------------------------------------------------------------------------
    */
    // private function verifyOtp($otp_data){
    //     $otp = Otp::where('client',Auth::id())->first();
    //     if(Carbon::now()->format('Y-m-d H:i:s') < $otp->created_at->addHour(1)->format('Y-m-d H:i:s')  == false ){
    //         Otp::where('client', Auth::id())->delete();
    //         return array('success'=>false, 'msg' => 'Oops! Your OTP Code is expired');
    //     }
    //     if($otp->otp_code != $otp_data){
    //         return array('success'=>false, 'msg' => 'Your OTP Code Not Verified Please Try Again!');
    //     }
    //     Otp::where('client', Auth::id())->delete();

    //     return array('success'=>true);
    // }


    /*
    |--------------------------------------------------------------------------
    | Public function / Add Client Wallet
    |--------------------------------------------------------------------------
    */
    public function clientWallet(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'currency_type'    => 'required',
                'cypto_network'    => 'required',
                'wallet_address'   => 'required',
                
            ]);

            if($validator->fails()){
                return redirect()->route('withdrawals')->with('error', implode(" / ",$validator->messages()->all()));
            }
            
          
            DB::beginTransaction($validator);


            $client_wallet = ClientWallet::create(array_merge(
                $validator->validated(),
                [
                 'client'      =>  Auth::id(),
                ]
            ));

            DB::commit();
            return redirect()->back()->with('success', 'Your Wallet Address added successfully!');
        }
        catch (\Throwable $e){
            DB::rollback();
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    public function withdrawal(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'withdraw_amount'   => 'required',
                'currency_type'     => 'required',
                'cypto_network'     => 'required',
                'wallet_address'    => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('withdrawals')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

            $this->updateWallets([Auth::id()]);

            $client = User::find(Auth::id());

            $client_wallet = ClientWallet::with('cyptoNetwork')->where('client',Auth::id())->first();

            $withdraw_amount    = $request->withdraw_amount;
            $transaction_fee    = $client_wallet->cyptoNetwork->withdrawal_fee;
            $recieving_amount   = $withdraw_amount - $transaction_fee;

            if ((int)$withdraw_amount > (int)$client->wallet) {
                return redirect()->route('withdrawals')->with('error', "Withdrawal amount should be less than available balance!");
            }

            $withdrawal = Withdrawal::create(array_merge(
                $validator->validated(),
                [
                 'client'             => Auth::id(),
                 'transaction_fee'    => $transaction_fee,
                 'recieving_amount'   => $recieving_amount,
                 'status'             => 0,
                ]
            ));

            $this->updateWallets([Auth::id()]);

            DB::commit();
            // $data = Funding_payment::with('getUser')->where('id',$CurrencyType->id)->first();

            $data = Withdrawal::with('getUser')->where('id',$withdrawal->id)->first();
            $this->sendEmail('Withdrawal Created',Auth::user()->email,'email-withdrawal',$data);
            return redirect()->route('dashboard')->with('success', 'Withdrawal created successfully!');

        }
        catch (\Throwable $e){
            DB::rollback();
            // return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    public function withdrawalDelete(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'id'                => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('withdrawals')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

                $client_wallet = ClientWallet::where('id', $request->id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Client Wallet deleted successfully!');

        }
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function / Add KYC Verification
    |--------------------------------------------------------------------------
    */
    public function kyc_verification(Request $request){

        //return response()->json($request);

        try {

            $validator = Validator::make($request->all(), [
                'client_title'      => 'required',
                'full_name'         => 'required',
                'dob'               => 'required',
                'phone_number'      => 'required',
                'address'           => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('kyc-verification')->with('error', implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction($validator);

            $client_title = PersonalDetails::create(array_merge(
                $validator->validated(),
                [
                    'title'=>$client_title,
                ]
            ));

            $client_fund_source = Source::create(array_merge(
                $validator->validated(),
                [
                    'title'=>$client_fund_source,
                ]
            ));

            DB::commit();

            return redirect()->back()->with('success', ' successfully!');

        }
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function / Edit Client Wallet
    |--------------------------------------------------------------------------
    */
    public function clientWalletEdit(Request $request){

        try {

            $validation_array = [
                'currency_type'    => 'required',
                'cypto_network'    => 'required',
                'wallet_address'   => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
                return redirect()->route('withdrawals')->with('error', implode(" / ",$validator->messages()->all()));
            }

           

            DB::beginTransaction();

            $client_wallet = ClientWallet::find($request->id);

            $client_wallet->client             = Auth::id();
            $client_wallet->currency_type      = $request->currency_type;
            $client_wallet->cypto_network      = $request->cypto_network;
            $client_wallet->wallet_address     = $request->wallet_address;
            $client_wallet->save();

            DB::commit();

            return redirect()->back()->with('success', 'Client Wallet updated successfully!');

        }
        catch (\Throwable $e){
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }
    }



    public function topUp(Request $request){
        try {
            $validation_conditions = [
                'funding_amount'   => 'required',
                'funding_payment_method' => 'required',
                'agree_disclaimer' => 'required',
            ];

            if ($request->funding_payment_method==1) {
                $validation_conditions['currency_type'] = 'required';
                $validation_conditions['network'] = 'required';
                $validation_conditions['image'] = 'required';
                $validation_conditions['image_name'] = 'required';
            }

            $validator = Validator::make($request->all(), $validation_conditions);

            if($validator->fails()){
                return redirect()->route('top-up')->with('error', implode(" / ",$validator->messages()->all()));
            }

            $Funding_payment = Funding_payment::where('client',Auth::id())->where('status',0)->first();
            if($Funding_payment){
                return redirect()->route('top-up')->with('error', "Your submitted funding was still not approved. You can place your next funding after the approval or disapproval of the current funding.");
            }

            DB::beginTransaction();

            //uploding payment proof image
            if($request->has('image') && $request->has('image_name')){
                $image_id = $this->uploadImage64Base($validator->valid()['image'],$validator->valid()['image_name'],'local-images');
            }
            $service_charges= $this->getTransactionSetting('service_charge');
            $minimum_funding_amount= $this->getTransactionSetting('minimum_funding_amount');
            $funding_amount = $request->funding_amount;
            $funding_type = $this->getFundingType(auth()->user()->id);
            $daily_reward_multiplier = $this->getTransactionSetting('daily_reward_multiplier');
            $daily_reward_distribution = $this->getTransactionSetting('daily_reward_distribution');
            if ($funding_type==1) {
                $other_reward_multiplier = $this->getTransactionSetting('funding_reward_multiplier');
            }
            if ($funding_type==2) {
                $other_reward_multiplier = $this->getTransactionSetting('topup_reward_multiplier');
            }
            $funding_data = array(
                'client'        =>auth()->user()->id,
                'status'        => 0,
                'funding_type'  => $funding_type,
                'trading_amount'=>$funding_amount - $service_charges,
                'network_fee'   =>0,
                'service_charge'=>$service_charges,
                'wallet_address'=>null
            );
            if ($request->funding_payment_method==1) {
                $crypto_network = CryptoNetwork::find($request->network);
                $funding_data['trading_amount'] = $funding_amount - $service_charges - $crypto_network->network_fee;
                $funding_data['network_fee'] = $crypto_network->network_fee;
                $funding_data['wallet_address'] = $crypto_network->company_wallet_address;
                $funding_data['payment_proof'] =  $image_id;

            }
            //checking whether trading amount qualifies minimum funding amount limit
            if($funding_data['trading_amount']<$minimum_funding_amount){
                return redirect()->route('top-up')->with('error', "Funding amount should be greater than $".$minimum_funding_amount);
            }
            $funding_data['daily_reward_limit'] = $funding_data['trading_amount'] * $daily_reward_multiplier;
            $funding_data['other_reward_limit'] = $funding_data['trading_amount'] * $other_reward_multiplier;
            $funding_data['daily_reward_amount'] = round($funding_data['daily_reward_limit'] / $daily_reward_distribution,2);
            $funding_data['bv_funding_percentage'] = $this->getBvRewardPercentage($funding_data['trading_amount'],1);
            $funding_data['bv_topup_percentage'] = $this->getBvRewardPercentage($funding_data['trading_amount'],2);

            $CurrencyType = Funding_payment::create(
                array_merge($validator->validated(),$funding_data)
            );

            $this->updateWallets([Auth::id()]);

            DB::commit();

            $data = Funding_payment::with('getUser')->where('id',$CurrencyType->id)->first();
            $this->sendEmail('Funding Created',Auth::user()->email,'email-top-up',$data);
            return redirect()->back()->with('success', 'Your funding created successfully!');
        }
        catch (\Throwable $e){
            DB::rollback();
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }

    /*
    |--------------------------------------------------------------------------
    |private function get funding type: 1=funding,2=topup
    |--------------------------------------------------------------------------
    */
    private function getFundingType($userId){
        $data = Funding_payment::where('client',$userId)->where('status','!=',2)->get();
        if ($data->isEmpty()) {
            return 1;
        }else{
            return 2;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Private Function / Image Upload top-up
    |--------------------------------------------------------------------------
    */
    private function uploadImage64Base($image,$filename,$diskName){

        $base64_image = $image;

        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);

            $data = base64_decode($data);

            //generate unic id
            $unique_name = md5($filename. time());

            //store image in file storeage
            Storage::disk($diskName)->put($unique_name.'.webp',  $data);
            $image_name = $unique_name.'.webp';

            $image_data =array(
                'image_name' =>  $image_name,
            );

            $image = Image::create($image_data);
            return $image->id;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Get Storage Images
    |--------------------------------------------------------------------------
    */

    public function getStorgeImage($filename)
    {
        $path =  storage_path('app/images/'. $filename);
        //$path =  _DIR_ . '/../../../uploads/files/'.$filename;

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;

    }



    public function p2pTransfer(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'transfer_amount'   => 'required',
                'client_select'     => 'required',
            ]);

            if($validator->fails()){
                return redirect()->route('p2p-transfer')->with('error', implode(" / ",$validator->messages()->all()));
            }
            $user             = User::find(Auth::id());
            $receiving_client = User::where('membership_no',$request->client_select)->where('membership_no', '!=' , $user->membership_no)->first('id');

            if(!$receiving_client){
                return redirect()->route('p2p-transfer')->with('error', "Member Was Not Found!");
            }

            $p2p_transaction_fee = $this->getTransactionSetting('p2p_transaction_fee');

            $transfer_amount    = $request->transfer_amount;
            $transaction_fee    = $p2p_transaction_fee;
            $recieving_amount   = $transfer_amount - $transaction_fee;

            if ((int)$transfer_amount <= (int)$p2p_transaction_fee) {
                return redirect()->route('p2p-transfer')->with('error', "Sending amount should be greater than transaction fee!");
            }

            if ((int)$transfer_amount > (int)$user->wallet) {
                return redirect()->route('p2p-transfer')->with('error', "Transaction amount should be less than available balance!");
            }

          

            DB::beginTransaction($validator);

            $p2p_transfer = P2PTransfer::create(array_merge(
                $validator->validated(),
                [
                    'from'               => Auth::id(),
                    'to'                 => $receiving_client->id,
                    'transfer_amount'    => $transfer_amount,
                    'transaction_fee'    => $transaction_fee,
                    'received_amount'    => $recieving_amount,
                ]
            ));

            $this->updateWallets([Auth::id(),$receiving_client->id]);
            DB::commit();
            return redirect()->route('p2p-transfer')->with('success', 'P2P trasaction created successfully!');
        }
        catch (\Throwable $e){
            return response()->json($e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


}


