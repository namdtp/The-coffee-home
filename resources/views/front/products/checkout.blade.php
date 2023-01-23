<?php 
use App\Models\Product;
use App\Models\DeliveryAddress;
?>
@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Thanh Toán</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('checkout') }}">Thanh Toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-80">
        <div class="container">
            <div class="row">
                <!-- Billing-&-Shipping-Details -->
                <div class="col-lg-6" id="deliveryAddresses">
                    @include('front.products.delivery_addresses')
                </div>
                <!-- Billing-&-Shipping-Details /- -->
                <!-- Checkout -->
                <div class="col-lg-6">
                    <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post" >@csrf 
                        <input type="hidden" name="address_id" id="address_id">
                        <h4 class="section-h4">Đơn Hàng Của Bạn</h4>
                        <div class="order-table">
                            <table class="u-s-m-b-13">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $total_price = 0 @endphp
                                @foreach ($getCartItems as $item)
                                <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                                    //echo "<pre>";print_r($getDiscountAttributePrice); die;
                                ?>                                  
                                    <tr>
                                        <td>
                                            <h6 class="order-h6">{{ $item['product']['product_name'] }} | {{ $item['size'] }} | {{ $item['product']['product_color'] }}</h6>
                                            <span class="order-span-quantity">x {{ $item['quantity'] }}</span>
                                        </td>
                                        <td>
                                        @if($getDiscountAttributePrice['discount']>0)
                                            <h6 class="order-h6">{{ number_format(($getDiscountAttributePrice['final_price'] * $item['quantity']),0,'',',') }} đ</h6>
                                        @else
                                            <h6 class="order-h6">{{ number_format(($getDiscountAttributePrice['final_price'] * $item['quantity']),0,'',',') }} đ</h6>
                                        @endif
                                        </td>
                                    </tr>
                                    @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
                                    @endforeach
                                    <tr>
                                        <td>
                                            <h3 class="order-h3">Tổng phụ</h3>
                                        </td>
                                        <td>
                                            <h3 class="order-h3">{{ number_format($total_price),0,'',',' }} đ</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 class="order-h3">Phí giao hàng</h3>
                                        </td>
                                        <td>                                              
                                            <h3 class="order-h3">0 đ</h3>              
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h3 class="order-h3">Phiếu mua hàng</h3>
                                        </td>
                                        <td>
                                            <h3 class="order-h3">
                                            @if(Session::has('couponAmount'))
                                                {{ number_format(Session::get('couponAmount')),0,'','.' }} đ
                                            @else
                                                0 đ
                                            @endif
                                            </h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>                                               
                                            <h3 class="order-h3">Tổng cộng</h3>
                                        </td>
                                        <td>
                                            <h3 class="order-h3">{{ number_format($grand_total = $total_price - Session::get('couponAmount')),0,'','.' }} đ</h3>
                                            <?php Session::put('grand_total',$grand_total); ?>
                                        </td>
                                    </tr>                           
                                </tbody>
                            </table>
                            <div class="u-s-m-b-13">
                                <input type="radio" class="radio-box" name="payment_gateway" id="COD" value="COD">
                                <label class="label-text" for="COD">Thanh Toán Khi Nhận Hàng</label>
                            </div>
                            <!-- <div class="u-s-m-b-13">
                                <input type="radio" class="radio-box" name="payment_gateway" id="CreditCard">
                                <label class="label-text" for="CreditCard">Credit Card (Stripe)</label>
                            </div> -->
                            <div class="u-s-m-b-13">
                                <input type="radio" class="radio-box" name="payment_gateway" id="Paypal" value="Paypal">
                                <label class="label-text" for="Paypal">Paypal</label>
                            </div>
                            <div class="u-s-m-b-13">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept" required="">Tôi đã đọc & chấp thuận
                                    <a href="javascript:;" class="u-c-brand">Điều khoản & điều kiện</a>
                                </label>
                            </div>
                            <button type="submit" class="button button-outline-secondary">Đặt Hàng</button>
                        </div>
                    </form>
                </div>  
                <!-- Checkout /- -->
            </div>
        </div>
    </div>
    <!-- Checkout-Page /- -->
@endsection