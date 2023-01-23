<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Session;
use Validator;

class UserController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6',
                'accept' => 'required'

            ],
            [
                'accept.required' => 'Please accept our Terms & Conditions'
            ]);

            if($validator->passes()){
                 // Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];  
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                /* Activate the user only when user confirms his email account*/
                $email = $data['email'];
                $messageData = ['name' => $data['name'],'email' => $data['email'],
                'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Xác nhận Tài khoản Azalea Clothing của bạn');
                });
                
                // redirect back user with success message
                $redirectTo = url('user/login-register');
                return response()->json(['type' => 'success', 'url' => $redirectTo, 'message' =>'Vui lòng kiểm tra hòm thư mail để kích hoạt tài khoản qua link bên trong mail!']);

                /* Activate the user straight way without sending any confirmation email */

                //Send Register Email
                /* $email = $data['email'];
                $messageData = ['name' => $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email']];
                Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Welcome to Azalea Clothing');
                }); */
                //Send Register Sms
                /* $message = "Dear Customer, you have been Successfully registered with AzaleaCloting.";
                $mobile = $data['mobile'];
                Sms::sendSms($message, $mobile); */

                /* if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart');
                    // Update User cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }
                    return response()->json(['type'=>'success','url' => $redirectTo]);
                } */

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }
    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>";print_r($data);die; */
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|max:150|exists:users'
                ],[
                'email.exists' => 'Email does not exists!'
            ]);
    
            if($validator->passes()){
                // Generate New Password
                $new_password = Str::random(16);

                // Update New Password
                User::where('email', $data['email'])->update(['password' => bcrypt($new_password)]);

                // Get User Details
                $userDetails = User::where('email', $data['email'])->first()->toArray();
                
                // Send Email to User
                $email = $data['email'];
                $messageData = ['name' => $userDetails['name'],'email' => $email,'password'=>$new_password ];
                Mail::send('emails.user_forgot_password', $messageData,function($message)use($email){
                    $message->to($email)->subject('Mật Khẩu Mới - Azalea Clothing');
                });

                // Show succes message
                return response()->json(['type' => 'success', 'message' => 'Mật khẩu mới được gửi đến email đăng ký của bạn.']);
            }else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
    
        }else{
            return view('front.users.forgot_password');
        }
        
    }
    public function userLogin(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6',

            ]);
            if ($validator->passes()) {
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type' => 'inactive', 'message' => 'Your account is inactive. Please check your mail to activate your account via the link inside the mail!']);
                    }
                    
                    // Update User cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url' => $redirectTo]);
                }else{
                    return response()->json(['type' => 'incorrect', 'message' => 'Incorrect Email or Password!']);
                }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'address' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:10',
                'pincode' => 'required|digits:6',
            ]);

            if($validator->passes()){

                // Update User Details
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'], 'city'=>$data['city'], 'state'=>$data['state'],
                'country'=>$data['country'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                // Redirect back user with success message
                return response()->json(['type' => 'success','message'=>'Your contact/billing details successfully updated!']);

            }else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status', 1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
        
    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(),[
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:new_password',
            ]);

            if($validator->passes()){
                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){

                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    // Redirect back user with success message
                    return response()->json(['type' => 'success','message'=>'Account password successfully updated!']);
                }else{
                    // Redirect back user with error message
                    return response()->json(['type' => 'incorrect','message'=>'Your current password is incorrect!']);
                }

                // // Redirect back user with success message
                // return response()->json(['type' => 'success','message'=>'Your contact/billing details successfully updated!']);

            }else{
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status', 1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
        
    }

    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                return redirect('user/login-register')->with('error_message', 'Tài khoản của bạn đã được kích hoạt. Bạn có thể đăng nhập ngay bây giờ.');
            }else{
                User::where('email', $email)->update(['status' => 1]);
                //Send Welcome Email
                $messageData = ['name' => $userDetails->name, 'mobile'=>$userDetails->mobile, 'email' => $email];
                Mail::send('emails.register', $messageData, function($message)use($email) {
                    $message->to($email)->subject('Chào mừng đến với Website Azalea Clothing');
                });
                return redirect('user/login-register')->with('success_message', 'Tài khoản của bạn được kích hoạt. Bạn có thể đăng nhập ngay bây giờ.');
            }   
        }else{
            abort(404);
        } 
    }
}
   
