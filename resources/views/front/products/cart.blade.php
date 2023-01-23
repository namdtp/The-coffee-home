<?php 
use App\Models\Product;
?>

@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Giỏ Hàng</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang Chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('cart') }}">Giỏ Hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Thành Công: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{ Session::forget('success_message') }}
                    @endif
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Lỗi: </strong> {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif  
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error: </strong><?php echo implode('', $errors->all('<div>:message</div>'));?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div id="appendCartItems">
                        @include('front.products.cart_items')
                    </div>
                    <!-- Coupon -->
                    <div class="coupon-continue-checkout u-s-m-b-60">
                        <div class="coupon-area">
                            <h6>Nhập mã phiếu giảm giá của bạn nếu bạn có.</h6>
                            <div class="coupon-field">
                                <form id="ApplyCoupon" method="post" action="javascript:void(0);" @if(Auth::check()) user="1" @endif>@csrf
                                    <label class="sr-only" for="coupon-code">Áp Dụng Phiếu Giảm Giá</label>
                                    <input id="code" name="code" type="text" class="text-field" placeholder="Nhập Phiếu Giảm Giá">
                                    <button type="submit" class="button">Áp Dụng</button>
                                </form>
                            </div>
                        </div>
                        <div class="button-area">
                            <a href="{{ url('/') }}" class="continue">Tiếp Tục Mua Sắm</a>
                            <a href="{{ url('/checkout') }}" class="checkout">Tiến Hành Thanh Toán</a>
                        </div>
                    </div>
                    <!-- Coupon /- -->
                </div>
            </div>
        </div>
    </div>
    <!-- Cart-Page /- -->
@endsection