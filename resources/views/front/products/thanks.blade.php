@extends('front.layout.layout')
@section('content')
<!-- Checkout-Page -->
    <div class="page-checkout u-s-p-t-200" style="padding: 200px 0 200px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <div class="page-checkout-confirm">
                            <div class="vertical-center">
                                <div class="text-center">
                                    <h1>Cảm Ơn!</h1>
                                    <h4>ĐƠN HÀNG CỦA BẠN ĐÃ ĐƯỢC ĐẶT THÀNH CÔNG</h4>
                                    <h5>Mã số đơn đặt hàng của bạn là #{{ Session::get('order_id') }} và tổng tiền: {{ number_format(Session::get('grand_total')),0,'',',' }} đ</h5>
                                    <a href="{{ url('/')}}" class="thank-you-back">Quay về Trang Chủ</a>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Checkout-Page /- -->
@endsection
<?php 
    Session::forget('grand_total');
    Session::forget('order_id');
    Session::forget('couponAmonut');
    Session::forget('couponCode');
?>