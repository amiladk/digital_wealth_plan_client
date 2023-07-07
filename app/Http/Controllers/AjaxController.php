<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Image;
use App\Models\Country;
use App\Models\Withdrawal;
use Validator;
use Auth;
use App\Models\Funding_payment;
use App\Models\P2PTransfer;
use App\Models\Otp;
use Mail;
use Carbon\Carbon;

class AjaxController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    |Public function / Update KYC Personal Info, first form of the wizard
    |--------------------------------------------------------------------------
    */
    public function updateKycPersonalInfo(Request $request){

        // return response()->json($request);

        try {

            $validation_array = [
                'client_title'      => 'required',
                'full_name'         => 'required',
                'dob'               => 'required',
                'phone_number'      => 'required',
                'address'           => 'required',
                'first_name'        => 'required',
                'last_name'         => 'required',
                'country'           => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
               // return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
               return array('success'=>false, 'data'=>null, 'msg'=>implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();


            //checking country exists in country table and inserting if not
            $country = Country::where('name', $request->country)->first();

            if($country){
                $country = $country->id;
            }else{
                $country = Country::create(['name'=>$request->country]);
                $country = $country->id;
            }

            $user = User::find(Auth::id())->fill(array_merge(
                $validator  ->  validated(),
                [
                    'country'  => $country,
                ]
            ));
            $user->save();

            DB::commit();

            return array('success'=>true, 'data'=>null, 'msg'=>'Record updated successfully!');;

        }
        catch (\Throwable $e){
            DB::rollback();
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Dashbord Counts (Rewards, Holding Balance and user  )
    |--------------------------------------------------------------------------
    */

    public function getDashbordCounts(Request $request){

        try {
            $data = User:: select('holding_wallet','left_bv_rewards','right_bv_rewards','left_head_count','right_head_count','wallet')
                      ->where('id',Auth::id())
                      ->first();

            $left_user_direct_count = User::where('sponsor',Auth::id())
                                        ->where('sponsor_side', 0)
                                        ->count();

            $right_user_direct_count = User::where('sponsor',Auth::id())
                                        ->where('sponsor_side', 1)
                                        ->count();

            $p2p_sent               = P2PTransfer::where('from',Auth::id())->sum('received_amount');

            $p2p_received           = P2PTransfer::where('to',Auth::id())->sum('received_amount');

            $response_array = array(
                        'success' => true,
                        'holding_wallet' => number_format($data->holding_wallet, 2),
                        'left_bv_rewards' => number_format($data->left_bv_rewards, 2),
                        'right_bv_rewards' => number_format($data->right_bv_rewards, 2),
                        'left_head_count' => $data->left_head_count,
                        'right_head_count' => $data->right_head_count,
                        'wallet' => number_format($data->wallet, 2),
                        'left_bv_after_balance'=>number_format($data->left_bv_rewards - min($data->left_bv_rewards, $data->right_bv_rewards),2),
                        'right_bv_after_balance'=>number_format($data->right_bv_rewards - min($data->left_bv_rewards,$data->right_bv_rewards),2),
                        'left_user_direct_count'=>$left_user_direct_count,
                        'right_user_direct_count'=>$right_user_direct_count,
                        'p2p_sent'=>$p2p_sent,
                        'p2p_received'=>$p2p_received,
            );

            return response()->json($response_array);

        } catch (\Throwable $th) {
            //throw $th;
        }








    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Dashbord Counts (Daily Rewards,Referral Rewards and BV Rewards )
    |--------------------------------------------------------------------------
    */

    public function rewardsCounts(Request $request){

       try {
            $referral_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `referral_reward`
                WHERE client=  :client"),
                        array(
                            'client' => Auth::id(),
                        ));
            $bv_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0) AS value FROM `bv_reward`
                WHERE client = :client"),
                        array(
                            'client' => Auth::id(),
                        ));
            $daily_rewards = DB::select( DB::raw("SELECT IFNULL(SUM(amount),0)  AS value FROM `daily_reward`
                WHERE client = :client"),
                        array(
                            'client' => Auth::id(),
                        ));
            $withdrawals = DB::select( DB::raw("SELECT IFNULL(SUM(withdraw_amount),0)  AS value FROM `withdrawal`
                WHERE client = :client  AND status = :status"),
                        array(
                            'client' => Auth::id(),
                            'status' => 1,
                        ));
            $to_up_by_wallet = DB::select( DB::raw("SELECT IFNULL(SUM(funding_amount),0)  AS value FROM `funding_payment`
                WHERE client = :client  AND status = :status AND funding_payment_method = 2"),
                        array(
                            'client' => Auth::id(),
                            'status' => 1,
                        ));
            $total_fund = DB::select( DB::raw("SELECT IFNULL(SUM(trading_amount),0)  AS value FROM `funding_payment`
                WHERE client = :client  AND status = :status"),
                        array(
                            'client' => Auth::id(),
                            'status' => 1,
                        ));
            $total_earnings =  $referral_rewards[0]->value + $bv_rewards[0]->value + $daily_rewards[0]->value ;
            $response_array = array(
                                'success' => true,
                                'referral_rewards'  =>number_format($referral_rewards[0]->value, 2),
                                'bv_rewards'        => number_format($bv_rewards[0]->value, 2),
                                'daily_rewards'     => number_format($daily_rewards[0]->value, 2),
                                'total_earnings'    => number_format($total_earnings, 2),
                                'withdrawals'       => number_format($withdrawals[0]->value, 2),
                                'to_up_by_wallet'   => number_format($to_up_by_wallet[0]->value, 2),
                                'total_fund'        => number_format($total_fund[0]->value, 2)
                            );
            return response()->json($response_array);

       } catch (\Throwable $th) {
        //throw $th;
       }



    }

    /*
    |--------------------------------------------------------------------------
    |Public function / Dashbord --- (Purchased Plans)
    |--------------------------------------------------------------------------
    */

    public function getPurchasedplansDetails(Request $request){

        try {
            $data = Funding_payment:: select('funding_type','trading_amount','status', 'other_rewards_completed','created_at','funding_payment_method.title as funding_payment_method')
            ->join('funding_payment_method', 'funding_payment_method.id', '=', 'funding_payment.funding_payment_method')
            ->where('client',Auth::id())
            ->whereIn('status', [0, 1])
            ->get();

            foreach ($data as $key => $value) {
                $value['trading_amount']=number_format($value->trading_amount, 2);
            }

            $response_array = array(
                'success' => true,
                'data' => $data,

            );
            return response()->json($response_array);
        } catch (\Throwable $e) {
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }


    }


    /*
    |--------------------------------------------------------------------------
    |Public function / Update KYC Source Of Funds, third form of the wizard
    |--------------------------------------------------------------------------
    */
    public function updateKycSourceOfFunds(Request $request){

        try {

            $validation_array = [
                'client_fund_source' => 'required',
                'agree_laws_check.*' => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
               // return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
               return array('success'=>false, 'data'=>null, 'msg'=>implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            $user = User::find(Auth::id())->fill($validator->valid());
            $user->save();

            DB::commit();
            return array('success'=>true, 'data'=>null, 'msg'=>'Record updated successfully!');;
        }
        catch (\Throwable $e){
            DB::rollback();
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    |Public function / Update KYC Terms And Condition, forth form of the wizard
    |--------------------------------------------------------------------------
    */
    public function updateKycTermsAndCondition(Request $request){

        try {

            $validation_array = [
                'terms_and_condition.*' => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
               // return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
               return array('success'=>false, 'data'=>null, 'msg'=>implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            $user = User::find(Auth::id());
            $user->kyc_submit_date = date("Y-m-d");
            $user->kyc_status = 0;
            $user->save();

            DB::commit();
            return array('success'=>true, 'data'=>null, 'msg'=>'Record updated successfully!');;
        }
        catch (\Throwable $e){
            DB::rollback();
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    |Public function / Update KYC Terms And Condition, forth form of the wizard
    |--------------------------------------------------------------------------
    */
    public function uploadKycCropImages(Request $request){
        try {

            $validation_array = [
                'index'             => 'required',
                "image"             => 'required',
                "image_name"        => 'required',
                "identity_doc_type" => 'required',
                "nic_no"            => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
               // return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
               return array('success'=>false, 'data'=>null, 'msg'=>implode(" / ",$validator->messages()->all()));
            }

            DB::beginTransaction();

            $image = $this->uploadImage64Base($validator->valid()['image'],$validator->valid()['image_name'],'local-images');

            $user = User::find(Auth::id());
            $user->identity_doc_type = $validator->valid()['identity_doc_type'];
            $user->nic_no = $validator->valid()['nic_no'];
            if($validator->valid()['index'] == 1 || $validator->valid()['index'] == 3 || $validator->valid()['index'] == 5){
                $user->id_front = $image;
            }
            if($validator->valid()['index'] == 2 || $validator->valid()['index'] == 4){
                $user->id_back  = $image;
            }

            if($validator->valid()['index'] == 6){
                $user->selfie  = $image;
            }

           // $user->selfie   = $image;
            $user->save();

            DB::commit();
            return array('success'=>true, 'data'=>null, 'msg'=>'Record updated successfully!');
        }
        catch (\Throwable $e){
            DB::rollback();
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }
    }

    public function getGeneology (Request $request){

        $client_id = $request->client_id;

        $client = User::with(['leftChild.leftChild','leftChild.rightChild','rightChild.leftChild','rightChild.rightChild','getParent:id','getSponsor:id,membership_no','leftChild.getSponsor:id,membership_no','leftChild.leftChild.getSponsor:id,membership_no','leftChild.rightChild.getSponsor:id,membership_no','rightChild.getSponsor:id,membership_no','rightChild.leftChild.getSponsor:id,membership_no','rightChild.rightChild.getSponsor:id,membership_no'])->find($client_id);

        return array('success'=>true, 'data'=>$client, 'msg'=>'Record updated successfully!');
    }


    /*
    |--------------------------------------------------------------------------
    | Private Function / Image Upload
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
    |Public function / Wthdrawals
    |--------------------------------------------------------------------------
    */

    public function getWithdrawalsPlansCounts(Request $request){

        try {
            $data = Withdrawal:: select('created_at','withdraw_amount','status', 'transaction_fee','recieving_amount')
            ->where('client',Auth::id())
            ->get();

            $response_array = array(
                'success' => true,
                'data' => $data,

            );
            return response()->json($response_array);
        } catch (\Throwable $e) {
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }


    }


    public function searchClient(Request $request){

        $membership_no=$request->input_data;
        //$client = User::where('membership_no', 'LIKE', "$membership_no%")->get();
        $client = User::where('membership_no',$membership_no)->where('membership_no', '!=' ,Auth::user()->membership_no)->get();
        return response()->json($client);
    }

    public function changeAuthUserThemeMode(Request $request){

        try {
            DB::beginTransaction();
            $user = User::find(Auth::id());
            if(auth()->user()->preffered_theme == 0){
                $user->preffered_theme = 1;
            }
            else{
                $user->preffered_theme = 0;
            }
            $user->save();
            DB::commit();
            return array('success'=>true, 'data'=>null, 'msg'=>'Record updated successfully!');

        } catch (\Throwable $e) {
            return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
        }

    }

    private function generateOTP(){
        $otp = mt_rand(100000,999999);
        return $otp;
    }

    public function sendOtp(){
        try {
        Otp::where('client', Auth::id())->delete();
        $otp            = $this->generateOTP();
        $user_details   = Auth::user()->first_name;
        $to             = Auth::user()->phone_number;

        $data =array(
            'otp_code' =>  $otp,
            'client' => Auth::user()->id,
        );

        Otp::create($data);
        $result = array_merge($data,array('name'=>$user_details));
        $this->sendEmail('OTP Code',Auth::user()->email,'send-otp-email', $result,);
        $this->sendSms("Your OTP is : ".$otp." %0aIf you didn't make this request, please change your password with immediate effect.", $to);
        $response_array = array(
            'success' => true,
           // 'otp_code' => $otp,
            'user_details' =>$user_details
        );
        return response()->json($response_array);
    } catch (\Throwable $e) {
        return array('success'=>false, 'data'=>null, 'msg'=>"Something went wrong. Please try again later!".$e->getMessage());
    }
    }

    public function verifyOtp(Request $request ){
        $otp = Otp::where('client',Auth::id())->first();
        if(Carbon::now()->format('Y-m-d H:i:s') < $otp->created_at->addHour(1)->format('Y-m-d H:i:s')  == false ){
            Otp::where('client', Auth::id())->delete();
          return response()->json(array('success'=>false, 'msg' => 'Oops! Your OTP Code is expired'));
        }
        if($otp->otp_code != $request->input_otp){
            return response()->json(array('success'=>false, 'msg' => 'Your OTP Code Not Verified Please Try Again!'));
        }
        Otp::where('client', Auth::id())->delete();
        // return response()->json($otp);
        return response()->json(array('success'=>true,'msg' => 'Your OTP Code  Verified'));
        
    }


    /*
    |--------------------------------------------------------------------------
    |Public function / upload Client Kyc Images (API Request) 
    |--------------------------------------------------------------------------
    */
    public function uploadClientKycImages(Request $request){
        try {
        
            $validation_array = [
                "image"            => 'required',
                "file_name"        => 'required',
            ];

            $validator = Validator::make($request->all(), $validation_array);

            if($validator->fails()){
            return response()->json(['success' => false,'data'=> null,'message' => implode(" / ",$validator->messages()->all())], 422);
            }

            $base64_image = $request->image;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
                $data = substr($base64_image, strpos($base64_image, ',') + 1);

                $data = base64_decode($data);
                //generate unic id
                $unique_name = md5($request->file_name. time());

                //store image in file storeage
                Storage::disk('local-images')->put($unique_name.'.webp',  $data);
                $image_name = $unique_name.'.webp';

                $image_data =array(
                    'image_name' =>  $image_name,
                );
                $image = Image::create($image_data);
                return response(['success' => true,'data'=>  $image->id,'message' => 'Image Uploaded!'], 200);  
            }
            else{
                return response(['success' => false,'data'=> null,'message' => "This string isn't sintaxed as base64"], 422);
            }
        }catch (\Throwable $e) {
            return response(['success' => false,'data'=> null,'message' => "Opps!. Something went wrong. Please try again later!", 'error' => $e->getMessage()], 500);
        }
    }
}



