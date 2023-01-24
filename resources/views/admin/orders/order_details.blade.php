<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">    
         <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{ Session::forget('success_message') }}
                    @endif
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error: </strong> {{ Session::get('error_message') }}
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
                  <h3 class="font-weight-bold">Order #{{ $orderDetails['id'] }} Details</h3>
                  <!-- <p class="card-description">
                     Add class <code>.table-bordered</code>
                  </p> -->
                  <div class="row">
                    <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Order Details</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            Order Date
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Order Status
                                        </td>
                                        <td>{{ $orderDetails['order_status'] }}</td>
                                    </tr>
                                    @if(!empty($orderDetails['courier_name']))
                                    <tr>
                                        <td>
                                            Courier Name
                                        </td>
                                        <td>{{ $orderDetails['courier_name'] }}</td>
                                    </tr>
                                    @endif
                                    @if(!empty($orderDetails['tracking_number']))
                                    <tr>
                                        <td>
                                            Tracking Number
                                        </td>
                                        <td>{{ $orderDetails['tracking_number'] }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            Order Total
                                        </td>
                                        <td>{{ number_format($orderDetails['grand_total']),0,'',',' }}đ</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Shipping Charges
                                        </td>
                                        <td>{{ number_format($orderDetails['shipping_charges']),0,'',',' }}đ</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Coupon Code
                                        </td>
                                        <td>{{ $orderDetails['coupon_code'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Order Amount
                                        </td>
                                        <td>{{ $orderDetails['coupon_amount'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Payment Method
                                        </td>
                                        <td>{{ $orderDetails['payment_method'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Payment Gateway
                                        </td>
                                        <td>{{ $orderDetails['payment_gateway'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Delivey Address</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            Name
                                        </td>
                                        <td>{{ $orderDetails['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Address
                                        </td>
                                        <td>{{ $orderDetails['address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                        City
                                        </td>
                                        <td>{{ $orderDetails['city'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            State
                                        </td>
                                        <td>{{ $orderDetails['state'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Country
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
                                            Mobile
                                        </td>
                                        <td>{{ $orderDetails['mobile'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Customer Details</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            Name
                                        </td>
                                        <td>{{ $userDetails['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Email   
                                        </td>
                                        <td>{{ $userDetails['email'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Billing Address</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>
                                            Name
                                        </td>
                                        <td>{{ $userDetails['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Address
                                        </td>
                                        <td>{{ $userDetails['address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            City
                                        </td>
                                        <td>{{ $userDetails['city'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            State
                                        </td>
                                        <td>{{ $userDetails['state'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Country
                                        </td>
                                        <td>{{ $userDetails['country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Pincode
                                        </td>
                                        <td>{{ $userDetails['pincode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mobile
                                        </td>
                                        <td>{{ $userDetails['mobile'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Update Order Status</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2">
                                            <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                                            <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                                            <select class="form-control" name="order_status" id="order_status" required="" style="color:black">
                                                <option>Select</option>
                                                @foreach($orderStatuses as $status)
                                                    <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) 
                                                    selected="" @endif>
                                                        {{ $status['name'] }}</option>
                                                @endforeach                                      
                                            </select>
                                            <br />
                                            <input class="form-control" type="text" name="courier_name" @if(empty($orderDetails['courier_name'])) id="courier_name" @endif placeholder="Courier Name" value="{{ $orderDetails['courier_name'] }}"><br />
                                            <input class="form-control" type="text" name="tracking_number" @if(empty($orderDetails['tracking_number'])) id="tracking_number" @endif placeholder="Tracking Number" value="{{ $orderDetails['tracking_number'] }}"><br />
                                            <button class="btn btn-info" type="submit">Update</button>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td colspan="2">
                                            @foreach($orderLog as $log)
                                                <label>TimeLine: <strong>{{ $log['order_status'] }}</strong></label> |
                                                <label> {{ date('j F, Y, g:i a', strtotime($log['created_at'])) }} </label><hr />
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </div>  
                        </div>
                        </div>
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <h4 class="card-title">Ordered Products</h4>
                                <div class="table-responsive pt-3">
                                    <table id="orderedProducts" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                Product Image
                                            </th>
                                            <th>
                                                Product Code
                                            </th>
                                            <th>
                                                Product Name
                                            </th>
                                            <th>
                                                Product Size
                                            </th>
                                            <th>
                                                Product Type
                                            </th>
                                            <th>
                                                Product Quantity
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
                                                <img style="width:90px;height: auto;" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Product">          
                                            </a>
                                        </td>
                                        <td>
                                            {{ $product['product_code'] }}
                                        </td>
                                        <td>
                                            {{ $product['product_name'] }}
                                        </td>
                                        <td>{{ $product['product_size'] }}</td>
                                        <td>{{ $product['product_type'] }}</td>
                                        <td>{{ $product['product_qty'] }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                  </div>                  
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- content-wrapper ends -->
   <!-- partial:../../partials/_footer.html -->
   <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
         <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
         <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
      </div>
   </footer>
   <!-- partial -->
</div>
@endsection