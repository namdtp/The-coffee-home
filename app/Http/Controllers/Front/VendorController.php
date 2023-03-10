<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin;
use App\Models\Vendor;
use Validator;
use DB;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }
    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die();
            // Validator Vendor registration
            $rules = [
                "name" => "required",
                "email" => "required|email|unique:admins|unique:vendors",
                "mobile" => "required|min:10|numeric|unique:admins|unique:vendors",
                "accept" => "required"
            ];
            $customMessages = [
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "email.unique" => "Email already exists",
                "mobile.required" => "Mobile is required",
                "mobile.unique" => "Mobile already exists",
                "accept.required" => "Please accept T&C"
            ];
            $validator = Validator::make($data, $rules, $customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Create vendor account
            // Insert the vendor details in vendors table            
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;

            //Set default timezone to VietNam
            date_default_timezone_set('Asia/Bangkok');
            $vendor->created_at = date('Y-m-d H:i:s');
            $vendor->updated_at = date('Y-m-d H:i:s');

            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            // Insert the vendor details in vendors table
            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;

            //Set default timezone to VietNam
            date_default_timezone_set('Asia/Bangkok');
            $admin->created_at = date('Y-m-d H:i:s');
            $admin->updated_at = date('Y-m-d H:i:s');
            $admin->save();

             // Send Confirmation Email
             $email = $data['email'];
             $messageData = [
                 'email' => $data['email'],
                 'name' => $data['name'],
                 'code' => base64_encode($data['email'])
             ];
 
             Mail::send('emails.vendor_confirmation', $messageData,function($message)use($email){
                 $message->to($email)->subject('X??c nh???n T??i Kho???n Nh?? cung c???p c???a b???n');
             });

            DB::commit();


            // Redirect back Vendor with Success Message
            $message = "C???m ??n b???n ???? ????ng k?? l??m Nh?? cung c???p. Vui l??ng x??c nh???n Email c???a b???n ????? k??ch ho???t t??i kho???n c???a b???n.";
            return redirect()->back()->with('success_message', $message);


        }

    }

    public function confirmVendor($email){
        //Decode vendor email
        echo $email = base64_decode($email);
        // die;
        // Check vendor email exists
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount > 0){
            // vendor email is already activated or not
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails->confirm == "Yes"){
                $message = "T??i kho???n Nh?? cung c???p c???a b???n ???? ???????c k??ch ho???t.Bb???n c?? th??? ????ng nh???p ngay l??c n??y!";
                return redirect('vendor/login-register')->with('error_message',$message);
            }else{
                // update cofirm column to Yes in both admins / vendors table to activate account
                Admin::where('email', $email)->update(['confirm' => 'Yes']);
                Vendor::where('email', $email)->update(['confirm' => 'Yes']);

                // Send register email
                $messageData = [
                'email' => $email,
                'name' => $vendorDetails->name,
                'mobile' => $vendorDetails->mobile
                ];
                Mail::send('emails.vendor_confirmed', $messageData,function($message)use($email){
                    $message->to($email)->subject('T??i kho???n Nh?? cung c???p c???a b???n ???? ???????c x??c nh???n');
                });


                // Redirect to vendor login/register page with success message
                $message = "T??i kho???n Email Nh?? cung c???p c???a b???n ???? ???????c x??c nh???n. B???n c?? th??? ????ng nh???p 
                v?? th??m th??ng tin c?? nh??n, doanh nghi???p v?? ng??n h??ng c???a m??nh ????? k??ch ho???t T??i kho???n Nh?? cung c???p v?? th??m s???n ph???m";
                
                return redirect('vendor/login-register')->with('success_message',$message);
            }
        }else{
            abort(404);
        }

    }
}
