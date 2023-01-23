<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
  <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Chi tiết đơn hàng: #{{ $orderDetails['id'] }}</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('/orders') }}">Đơn Đặt Hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Orders-Page -->
    <div class="container">
        <div class="table-responsive pt-3" style="display: flex;">
            <table class="table table-bordered" style="color:black; margin-right: 10px;">
                <!-- <thead> -->
                    <tr>
                        <td colspan="2">
                            <strong>Chi Tiết Đơn Hàng</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ngày Đặt Hàng
                        </td>
                        <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                    </tr>
                    <tr>
                        <td>
                            Trạng Thái Đơn Hàng
                        </td>
                        <td>{{ $orderDetails['order_status'] }}</td>
                    </tr>
                    @if(!empty($orderDetails['courier_name']))
                    <tr>
                        <td>
                            Dịch Vụ Chuyển Phát
                        </td>
                        <td>{{ $orderDetails['courier_name'] }}</td>
                    </tr>
                    @endif
                    @if(!empty($orderDetails['tracking_number']))
                    <tr>
                        <td>
                            Dịch Vụ Chuyển Phát
                        </td>
                        <td>{{ $orderDetails['tracking_number'] }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            Tổng Tiền Đơn Hàng
                        </td>
                        <td>{{ number_format($orderDetails['grand_total']),0,'',',' }}đ</td>
                    </tr>
                    <tr>
                        <td>
                            Phí Vận Chuyển
                        </td>
                        <td>{{ number_format($orderDetails['shipping_charges']),0,'',',' }} đ</td>
                    </tr>
                    <tr>
                        <td>
                            Mã Giảm Giá
                        </td>
                        <td>{{ $orderDetails['coupon_code'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Số Tiền Phiếu Giảm Giá
                        </td>
                        <td>{{ number_format($orderDetails['coupon_amount']),0,'','.' }} đ</td>
                    </tr>
                    <tr>
                        <td>
                            Phương Thức Thanh Toán
                        </td>
                        <td>{{ $orderDetails['payment_method'] }}</td>
                    </tr>
            </table>
            <table class="table table-bordered" style="color:black;margin-left: 10px;">
                    <tr>
                        <td colspan="2">
                            <strong>Địa Chỉ Giao Hàng</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tên
                        </td>
                        <td>{{ $orderDetails['name'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Địa chỉ
                        </td>
                        <td>{{ $orderDetails['address'] }}</td>
                    </tr>
                    <tr>
                        <td>
                           Thành Phố
                        </td>
                        <td>{{ $orderDetails['city'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Quận
                        </td>
                        <td>{{ $orderDetails['state'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Quốc Gia
                        </td>
                        <td>{{ $orderDetails['country'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Pincode
                        </td>
                        <td>{{ $orderDetails['pincode'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            Số Điện Thoại
                        </td>
                        <td>{{ $orderDetails['mobile'] }}</td>
                    </tr>
            </table>        
        </div>
    </div>
    <div class="container">
        <div class="table-responsive pt-3">
            <table id="orderProducts" class="table table-bordered" style="color:black">
                <thead>
                    <tr>
                        <th>
                                Hình Ảnh Sản Phẩm
                        </th>
                        <th>
                                Mã Sản Phẩm
                        </th>
                        <th>
                                Tên Sản Phẩm
                        </th>
                        <th>
                                Kích thước
                        </th>
                        <th>
                                Màu sắc
                        </th>
                        <th>
                                Số lượng
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails['orders_products'] as $product)
                    <tr>
                        <td style="text-align:center">
                            <?php
                                $getProductImage = Product::getProductImage($product['product_id']);
                            ?>
                            <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                                <img style="width:60%" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Product">          
                            </a>
                        </td>
                        <td>
                            {{ $product['product_code'] }}
                        </td>
                        <td>
                            {{ $product['product_name'] }}
                        </td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<!-- Orders-Page /- -->
@endsection