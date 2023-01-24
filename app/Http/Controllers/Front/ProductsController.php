<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\OrdersProduct;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Models\Vendor;
use Illuminate\Support\Facades\View;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use DB;


class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //  echo "<pre>";
            //  print_r($data);
            //  die;
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){ 
                // Get Category details
                $categoryDetails = Category::categoryDetails($url);    
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                ->where('status',1);

                // Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach ($productFilters as $key => $filter) {
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) 
                    && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }
                
                //checking for sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderBy('products.id','Desc');
                    }else if ($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderBy('products.product_price','Asc');
                    }else if ($_GET['sort']=="price_highest"){
                        $categoryProducts->orderBy('products.product_price','Desc');
                    }else if ($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderBy('products.product_name','Desc');
                    }else if ($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderBy('products.product_name','Asc');
                    }
                }

                //Checking for size of product
                if(isset($data['size']) && !empty($data['size'])){
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //Checking for color of product
                if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_type',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //Checking for price of product
                $productIds = array();
                if(isset($data['price']) && !empty($data['price'])){
                    foreach($data['price'] as $key => $price){
                        $priceArr = explode(' - ',$price);    
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('product_price',[$priceArr[0],$priceArr[1]])
                        ->pluck('id')->toArray();
                        }                  
                    }
                    $productIds = array_unique(array_flatten($productIds));
                    $categoryProducts->whereIn('products.id', $productIds);
                }

                //Checking for brand of product
                if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }


                
                $categoryProducts = $categoryProducts->paginate(6);
                // dd($categoryDetails);
                // echo "Category exists"; die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }  
        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){ 
                // Get Category details
                $categoryDetails = Category::categoryDetails($url);    
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])
                ->where('status',1);

                //checking for sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderBy('products.id','Desc');
                    }else if ($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderBy('products.product_price','Asc');
                    }else if ($_GET['sort']=="price_highest"){
                        $categoryProducts->orderBy('products.product_price','Desc');
                    }else if ($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderBy('products.product_name','Desc');
                    }else if ($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderBy('products.product_name','Asc');
                    }
                }


                $categoryProducts = $categoryProducts->paginate(6);
                // dd($categoryDetails);
                // echo "Category exists"; die;
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }   
        }  
    }

    public function vendorListing($vendorid){
        // Get Vendor Shop Name
        $getVendorShop = Vendor::getVendorShop($vendorid);

        // Get vendor products
        $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);

        $vendorProducts = $vendorProducts->paginate(6);
        return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
        // dd($vendorProducts);
    }

    public function detail($id){
        $productDetails = Product::with(['section', 'category', 'brand',
            'attributes' => function ($query) {
                $query->where('stock', '>', '0')->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        // dd($productDetails);
        
        // Get similar products
        $similarProducts = Product::with('brand')->where('category_id', $productDetails['category']['id'])->
        where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($similarProducts);

        // Set Session for Recently Viewed Products
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id', $session_id);

        // Insert Product in table if not already exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        // Get Recently Viewed Products Ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)
        ->inRandomOrder()->get()->take(4)->pluck('product_id');
        // dd($recentProductsIds); 

        // Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();
        /* dd($recentlyViewedProducts); */

        // Get Group products
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)->where(['group_code' =>$productDetails['group_code'],'status'=>1])->get()->toArray();
            // dd($groupProducts);
        }

        $totalStock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'], $data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            
            // Check Product Stock is Available or not
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'], $data['size']);
            if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','Required Quantity is not available');
            }

            // Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            // Check Product if already exists in the user cart
            if(Auth::check()){
                // User is logged in
                $user_id = Auth::user()->id; 
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();
            }else{
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
            }

            if($countProducts>0){
                return redirect()->back()->with('error_message', 'Product already exists in Cart!');
            }

            // Save Product in carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            return redirect()->back()->with('success_message', 'Sản phẩm đã được thêm vào giỏ hàng thành công! <a style="font-weight:bold !important; text-decoration-line:underline;" href="/cart">Xem Giỏ Hàng</a>');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        // dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;

            // Get cart details
            $cartDetails = Cart::find($data['cartid']);

            // Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id' => $cartDetails['product_id'],
            'size'=>$cartDetails['size']])->first()->toArray();

            // Check if desired stock from user is available
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                'status'=>false,
                'message'=>'Product Stock is no available',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
            }

            // Check if product size is available
            $availableSize = ProductsAttribute::where(['product_id' => $cartDetails['product_id'],
            'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                'status'=>false,
                'message'=>'Product Size is no available. Please remove this Product and choose another one!',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
            }

            // Update the quantity
            Cart::where('id', $data['cartid'])->update(['quantity'=> $data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);   
        }
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            //  echo "<pre>";
            //  print_r($data);
            //  die;
            Cart::where('id', $data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);

        }
    }

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            /* echo "<pre>";print_r($data);die; */
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            $couponCount = Coupon::where('coupon_code',$data['code'])->count();
            if($couponCount==0){
                return response()->json([
                    'status' => 'false',
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'The coupon is not valid!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }
            else{
                // Check for other coupon conditions
                // Get Coupon Details
                $couponDetails = Coupon::where('coupon_code',$data['code'])->first();

                // Check if the coupon is active
                if($couponDetails->status==0){
                    $message = 'Phiếu giảm giá không hoạt động!';
                }

                // Check if the coupon is expired
                $expiry_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expiry_date < $current_date){
                    $message = 'Phiếu giảm giá đã hết hạn!';
                }

                // Check if coupon is from selected categories
                // Get all selected categories from coupon and convert to array
                $catArr = explode(",", $couponDetails->categories);           
                

                // Check if any cart item not belong to coupon category
                $total_amount = 0;
                foreach ($getCartItems as $key => $item) {
                    if(!in_array($item['product']['category_id'],$catArr)){
                        $message = 'Mã phiếu giảm giá này không dành cho một trong những sản phẩm đã chọn!';
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);                
                    $total_amount = $total_amount + ($attrPrice['final_price'] * $item['quantity']);
                }

                // Check if coupon is from selected users
                // Get all selected users from coupon and convert to array
                if(isset($couponDetails->users) && !empty($couponDetails->users)){
                    $usersArr = explode(",",$couponDetails->users);
                    if(count($usersArr)){
                        // Get User Id's of all selected users
                        foreach ($usersArr as $key => $user) {
                            $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                            $usersId[] = $getUserId['id'];
                        }
                        // Check if any cart item not belong to coupon user
                        foreach ($getCartItems as $item) {
                            if(!in_array($item['user_id'],$usersId)){
                                $message = 'Mã phiếu giảm giá này không dành cho bạn. Hãy thử với mã phiếu giảm giá hợp lệ!';
                            }  
                        }
                    }
                }
                if($couponDetails->vendor_id>0){
                    $productIds = Product::select('id')->where('vendor_id',$couponDetails->vendor_id)->pluck('id')->toArray();
                    // Check if coupon belongs to Vendor products
                    foreach ($getCartItems as $item) {
                        if(!in_array($item['product']['id'],$productIds)){
                            $message = 'Mã phiếu giảm giá này không dành cho bạn. Hãy thử với mã phiếu giảm giá hợp lệ!';
                        }
                    }
                }    
                // If error message is there
                if(isset($message)){
                    return response()->json([
                        'status' => false,
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }else{
                    // Coupon code is correct

                    // Check if Coupon Amount type is Fixed or Percentage
                    if($couponDetails->amount_type=="Fixed"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount / 100);
                    }
                    $grand_total = $total_amount - $couponAmount;

                    // Add Coupon code & amount in session variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "Mã phiếu giảm giá được áp dụng thành công. Bạn đang được giảm giá!";

                    return response()->json([
                        'status' => true,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }
                
            }
        }
    }

    public function checkout(Request $request){
        if($request->isMethod('POST')){
            $data = $request->all();
                // echo "<pre>";
                // print_r($data);
                // die; 
            
            if(empty($data['address_id'])){
                $message = "Vui lòng chọn địa chỉ giao hàng";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if(empty($data['payment_gateway'])){
                $message = "Vui lòng chọn cổng thanh toán";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if(empty($data['accept'])){
                $message = "Vui lòng kiểm tra điều khoản và điều kiện";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
            if($data['payment_gateway']=='COD'){
                $payment_method = "COD";
            }else{
                echo "Coming Soon";
                die;
                // $payment_method = "Prepaid";
            }

            // Get Delivery Address from address_id
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            // dd($deliveryAddress);

            DB::beginTransaction();

            // Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = 0;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            // Get last Insert Order Id
            $order_id = DB::getPdo()->lastInsertId();

            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach ($cartItems as $key => $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name', 'product_type')
                ->where('id',$item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_type = $getProductDetails['product_type'];
                $cartItem->product_size = $item['size'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountAttributePrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            // Insert Order id in Session Variable
            Session::put('order_id', $order_id);

            DB::commit();

            if ($data['payment_gateway'] == 'COD') {

                $orderDetails = Order::with('orders_products')->where('id', $order_id)->first()->toArray();
                // Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Đã Đặt Hàng Thành Công - Azalea-Clothing.store');
                });

                return redirect('/thanks');
            }else{
                echo "Prepaid Method Coming Soon";
                die;
            }
        }

        $getCartItems = Cart::getCartItems();

        if(count($getCartItems)==0){
            $message = "Giỏ Hàng Của Bạn Đang Rỗng! Vui Lòng Thêm Sản Phẩm Để Tiến Hành Thanh Toán.";
            Session::put('error_message',$message);
            return redirect('cart');
        }

        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $countries = Country::where('status', 1)->get()->toArray();
        /* dd($deliveryAddresses); */
        return view('front.products.checkout')->with(compact('deliveryAddresses','countries','getCartItems'));
    }

    public function thanksUser(){
        if(Session::has('order_id')){
            //Empty the User Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('/cart');
        }
    }

}
