@extends('front.layout.layout')
@section('content')
  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Đơn Đặt Hàng</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang Chủ</a>
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
   <div class="table-responsive pt-3">
      <table id="orders" class="table table-bordered" style="color:black">
         <thead>
            <tr>
               <th>
                    Mã Đơn Đặt Hàng
               </th>
               <th>
                    Mã Sản Phẩm
               </th>
               <th>
                    Phương Thức Thanh Toán
               </th>
               <th>
                    Tổng Tiền
               </th>
               <th>
                    Ngày Đặt
               </th>
               <th>
                    #
               </th>
            </tr>
         </thead>
         <tbody>
            @foreach($orders as $order)
            <tr>
                <td><a href="{{ url('orders/'.$order['id']) }}">#{{ $order['id'] }}</a></td>
                <td>
                    @foreach($order['orders_products'] as $pro)
                        {{ $pro['product_code'] }}<br/>
                    @endforeach
                </td>
                <td>{{ $order['payment_method'] }}</td>
                <td>{{ number_format($order['grand_total']),0,'',',' }} đ</td>
                <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
                <td><a href="{{ url('orders/'.$order['id']) }}"><i class="fas fa-eye"></i></a></td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>
<!-- Orders-Page /- -->
@endsection