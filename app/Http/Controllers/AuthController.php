<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Mail;

use Throwable;
use Validator;
use Auth;
use Session;

use App\Models\User;
use App\Models\Country;
use App\Models\ClientTeamMap;
use App\Models\PasswordReset;
use App\Models\Funding_payment;
use DB;

class AuthController extends Controller
{

    public function doLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->with('error', implode(" / ",$validator->messages()->all()));
        }

        if(filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            //login using email 
            $userdata = array(
                'email'  => $request->get('username'),
                'password'  => $request->get('password')
            );
        } else {
            //login using membership no
            $userdata = array(
                'membership_no'  => $request->get('username'),
                'password'  => $request->get('password')
            );
        }

        if (Auth::attempt($userdata)) {

           if(auth()->user()->is_active==0){
                $Funding_payment = Funding_payment::where('client',Auth::id())
                                    ->where(function($query){
                                        $query->where('status',0)->orWhere('status',1);
                                    })->first();
                if(!$Funding_payment){
                    $to     = Carbon::parse(auth()->user()->created_at);
                    $from   = Carbon::now()->format('Y-m-d H:i:s');
                    $diff_in_hours = $to->diffInHours($from);
                    if($diff_in_hours > 48){
                        Auth::logout();
                        return redirect()->route('login')->with('error', "Sorry, the package is disabled temporally. Please contact mytrader.biz helpdesk");
                    }
                }
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('error', "Email/ Member Id or password does not exist!");
    }


    public function doLogout()
    {
        Auth::logout(); 
        return redirect()->route('login'); 
    }


    public function signUp(Request $request){

        try {
            //backend validations
            $validator = Validator::make($request->all(), [
                'first_name'                => 'required',
                'last_name'                 => 'required', 
                'country'                   => 'required',       
                'email'                     => 'required|email|unique:App\Models\User',   
                'password'                  => 'required|confirmed|min:6',
                'password_confirmation'     => 'required',
                'sponsor'                   => 'required|exists:App\Models\User,id',
                'sponsor_side'              => 'required'
            ]);

            if($validator->fails()){
                return redirect()->route('sign-up',['ref'=>$request->sponsor,'ref_s'=>$request->sponsor_side])->with('error', implode(" / ",$validator->messages()->all()));
            }else if($request->sponsor_side!=='1' && $request->sponsor_side!=='0'){
                return redirect()->route('sign-up',['ref'=>$request->sponsor,'ref_s'=>$request->sponsor_side])->with('error', 'Your registration link is incorrect. Please contact your sponsor');
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

            //inserting basic info into client table
            $user = User::create(array_merge(
                $validator  ->  validated(),
                [
                    'password' => bcrypt($request->password),
                    'country'  => $country,
                ]
            )); 
            
            //creating client genealogy relationships
            $parent = $this->updateGenealogy($request->sponsor,(int)$request->sponsor_side,$user->id);

            //updating other data in client table
            $user->membership_no = config('site-specific.client-number-prefix').sprintf("%06s", $user->id);
            $user->parent = $parent;
            $user->save();

            //updating client_team_map and left/right head counts
            $this->updateTeamMap($user,$user->id);
            
            DB::commit();

            $userdata = array(
                'email'     => $request->get('email'),
                'password'  => $request->get('password')
            );

            if (Auth::attempt($userdata)) {
                return redirect()->route('dashboard')->with('success', 'User registered successfully!');
            }
          
        } catch (\Throwable  $e) {
            DB::rollback();
            // return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    public function updateGenealogy($sponsor_id,$sponsor_side,$client_id){
        $sponsor = User::find($sponsor_id);
        $parent = $this->findParent($sponsor,$sponsor_side,$client_id);
        if ($sponsor_side==0) {
            $parent->left_child = $client_id;
        }
        if ($sponsor_side==1) {
            $parent->right_child = $client_id;
        }
        $parent->save();
        return $parent->id;
    }


    private function findParent($parent,$sponsor_side,$client_id){
        // $data = array(
        //     'parent'        => $parent->id,
        //     'child'         => $client_id,
        //     'side'          => $sponsor_side
        // );
        // ClientTeamMap::create($data);
        // if ($sponsor_side===0) {
        //     $parent->left_head_count++;
        // }elseif ($sponsor_side===1) {
        //     $parent->right_head_count++;
        // }
        // $parent->save();

        //left side
        if ($sponsor_side==0) {
            if(($parent->leftChild)){
                $parent = $this->findParent($parent->leftChild,$sponsor_side,$client_id);
            }
        }

        //right side
        if ($sponsor_side==1) {
            if($parent->rightChild){
                $parent = $this->findParent($parent->rightChild,$sponsor_side,$client_id);
            }
        }
        
        return $parent;
    }


    private function updateTeamMap($client,$client_id){
        $parent = $client->getParent;
        if (!$parent) {
            return;
        }

        if ($parent->left_child==$client->id) {
            $sponsor_side = 0;
        }elseif ($parent->right_child==$client->id) {
            $sponsor_side = 1;
        }
        $data = array(
            'parent'        => $parent->id,
            'child'         => $client_id,
            'side'          => $sponsor_side
        );
        ClientTeamMap::create($data);
        if ($sponsor_side==0) {
            $parent->left_head_count++;
        }elseif ($sponsor_side==1) {
            $parent->right_head_count++;
        }
        $parent->save();

        if ($parent->getParent) {
            $this->updateTeamMap($client->getParent,$client_id);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Public function / Update Profile Password
    |--------------------------------------------------------------------------
    */ 
    public function updatePassword(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'current_password'      => 'required',
                'password'              => 'required|confirmed',
                
            ]);
    
            if($validator->fails()){
                return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
            }
    
                DB::beginTransaction();
    
                $user = User::find(Auth::id());

                if( Hash::check($request->current_password, $user->password)){
                    $user->password = bcrypt($request->password);
                    $return = redirect()->back()->with('success', 'Password changed!');
                }
                else{
                    $return = redirect()->back()->with('error', 'Current Password Doesn`t Match !');
                }

                $user->save();
                DB::commit();

                return $return;
        }
        catch (\Throwable $e){
            DB::rollback();
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function / get Verfied Email Submit
    |--------------------------------------------------------------------------
    */ 
    public function getVerfiedEmailSubmit(Request $request){
        // api_v3
        try {

            $user_mail = Auth::user()->email;

            $concatenate = Str::random(64).'?'.$user_mail.'?'. Carbon::now()->addHour(1)->format('Y-m-d H:i:s');       
            $token = Crypt::encryptString($concatenate);
            
            Mail::send('email-verification',
            array(
                'token'    => $token,// API token 
                'email'    => $user_mail,
                'base_url' => URL::to('/'),
                'name'     => Auth::user()->first_name,
            ), function($message) use ($user_mail)
            {
                $message->from(config('site-specific.site-mail-address'));
                $message->subject('verify account');
                $message->to($user_mail);
            });
            return redirect()->route('dashboard')->with('success', 'Verification Email has been sent. Please go to your email and follow the instructions!');
        }catch (\Throwable $e) { 
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', 'Oops! Something went wrong please try again later');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function / get Verfied Email
    |--------------------------------------------------------------------------
    */ 
    public function getVerfiedEmail($token)
    {
        try{
            
            $decrypted = Crypt::decryptString($token);
            $explode   = explode("?",$decrypted);
    
            if(Carbon::now()->addHour(0)->format('Y-m-d H:i:s') < $explode[2] ==false){
                return redirect()->route('dashboard')->with('error', 'link is expired!');
            }
            else{
                DB::beginTransaction();
                $user = User::where('email', $explode[1])->first();
                if($user){
                    $user->email_verified = true;
                    $user->save();
                }
                DB::commit();
                return redirect()->route('dashboard')->with('success', 'Email Verified!');
            }
        }
        catch (\Throwable $e){
            DB::rollback();
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', "Something went wrong. Please try again later!");
        }

    }




    /*
    |--------------------------------------------------------------------------
    | Public function / forget password submit 
    |--------------------------------------------------------------------------
    */ 
    public function forgetPasswordSubmit(Request $request){
        // api_v3
        try {

            $validation_array = [
                'email'         => 'required|string|email|max:100',
            ];
    
            $validator = Validator::make($request->all(), $validation_array);
    
            if($validator->fails()){
                return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
            }

            $user_mail = $request->email;

            $user = User::where('email',$user_mail)->first();

            if(!$user){
                return redirect()->back()->with('error',"Opps!. Your email not found.");   
            }    

            $concatenate = Str::random(64).'?'.$user_mail.'?'. Carbon::now()->addHour(1)->format('Y-m-d H:i:s');       
            $token = Crypt::encryptString($concatenate);

            PasswordReset::where('email',$user_mail)->delete();

            $query =  PasswordReset::create([
                'email'      => $user_mail, 
                'token'      => $token,
            ]);
    
            Mail::send('email-forgot-password',
            array(
                'token'    => $token,// API token 
                'email'    => $user_mail,
                'base_url' => URL::to('/'),
                'name'     => $user->first_name,
            ), function($message) use ($user_mail)
            
            {
                $message->from(config('site-specific.site-mail-address'));
                $message->subject('password-reset');
                $message->to($user_mail);
            });

            $user = User::where('email',$user_mail)->first();

            if ($user->phone_number) {
                $this->sendSms("You have forgotten the login password of your www.mytrader.biz account by verifying this link you can generate a new password. Password Reset Link: https://mytrader.biz/password-reset/'.$token",$user->phone_number);
            }

            return redirect()->back()->with('success', 'Password reset link has send to '.$user_mail);
        
        } catch (\Throwable $e) { 
            return response()->json($e->getMessage());
            return redirect()->back()->with('error', 'Oops! Something went wrong please try again later');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Public function / password reset submit 
    |--------------------------------------------------------------------------
    */ 
    public function passwordResetSubmit(Request $request){
        // api_v3
        try {

            $validation_array = [
                'password'      => 'required|confirmed|min:6',
                'token'         => 'required'
            ];
    
            $validator = Validator::make($request->all(), $validation_array);
    
            if($validator->fails()){
                return redirect()->back()->with('error', implode(" / ",$validator->messages()->all()));
            }

            $decrypted = Crypt::decryptString($request->token);
            $explode   = explode("?",$decrypted);
            $query  = PasswordReset::where('email',$explode[1])->where('token',$request->token);
            $passwordreset  = $query->first();  

            if($passwordreset){
                $user = User::where('email',$explode[1])->update(['password' =>bcrypt($request->password)]);
                $query->delete(); 
                if($user){
                    return redirect('/login')->with('success', 'Password reset successfully.');
                }
            }else{
                return redirect()->back()->with('error', 'Oops! Data not found');
            }           
          
        } catch (\Throwable $e) {     
            return redirect()->back()->with('error', 'Oops! Something went wrong please try again later');
        }

    }



    /*
    |--------------------------------------------------------------------------
    | Client Migration functions
    |--------------------------------------------------------------------------
    */
    public function migrateClients(){
        DB::beginTransaction();
        try {
            //1000 client is the main head
            $users = User::where('id', '!=', 1000)->orderBy('created_at')->get();
            foreach ($users as $key => $user) {
                $parent = $this->updateGenealogy($user->sponsor,(int)$user->sponsor_side,$user->id);

                //updating other data in client table
                $user->parent = $parent;
                $user->save();
            }
            DB::commit();
            return 'Success';
        }catch (\Throwable $e) { 
            DB::rollback();    
            return $e->getMessage();
        }
    }

    public function migrateTeamCounts(){
        DB::beginTransaction();
        try {
            // $user = User::find(28236);
            // $this->updateTeamMap($user,$user->id);
            $users = User::orderBy('created_at','desc')->get();
            foreach ($users as $key => $user) {
                $this->updateTeamMap($user,$user->id);
            }
            DB::commit();
            return 'Success';
        }catch (\Throwable $e) { 
            DB::rollback();    
            return $e->getMessage();
        }
    }

}
