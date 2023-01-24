<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersLog;
use App\Models\OrderStatus;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    public function orders(){
        Session::put('page','orders');
        $orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.orders')->with(compact('orders'));
    }

    public function orderDetails($id){
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status', 1)->get()->toArray();
        $orderLog = OrdersLog::where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }

    public function updateOrderStatus(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $message = 'Order Status has been updated successfully!';
            Order::where('id', $data['order_id'])->update(['order_status' => $data['order_status']]);
            Session::put('success_message',$message);

            // Update Courier Name and Tracking Number
            if(!empty($data['courier_name']) && !empty($data['tracking_number'])){
                Order::where('id',$data['order_id'])->update(['courier_name'=>$data['courier_name'],'tracking_number'=>$data['tracking_number']]);
            }

            // Get Delivery Details
            $deliveryDetails = Order::select('mobile', 'email', 'name')->where('id', $data['order_id'])->first()->toArray();

            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            // Send Order Status Update Email
            $email =  $deliveryDetails['email'];
            $messageData = [
                'email' => $email,
                'name' =>  $deliveryDetails['name'],
                'order_id' => $data['order_id'],
                'order_status' => $data['order_status'],
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number'],
                'orderDetails' => $orderDetails
            ];
            Mail::send('emails.order_status', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Cập Nhật Trạng Thái Đơn Hàng - Azalea-Clothing.store');
            });

            // Update Order Log
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();
            

            return redirect()->back();
        }
    }
    public function viewOrderInvoice($id){
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails', 'userDetails'));
    }
}
