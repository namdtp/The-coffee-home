<link rel="stylesheet" href="{{ url('front/css/bootstrap.min.css') }}">
<!-- jQuery -->
<script type="text/javascript" src="{{ url('front/js/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script type="text/javascript" src="{{ url('front/js/bootstrap.min.js') }}"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<style>
    body{
    margin-top:20px;
    background:#eee;
    }

    .invoice {
        background: #fff;
        padding: 20px
    }

    .invoice-company {
        font-size: 20px
    }

    .invoice-header {
        margin: 0 -20px;
        background: #f0f3f4;
        padding: 20px
    }

    .invoice-date,
    .invoice-from,
    .invoice-to {
        display: table-cell;
        width: 1%
    }

    .invoice-from,
    .invoice-to {
        padding-right: 20px
    }

    .invoice-date .date,
    .invoice-from strong,
    .invoice-to strong {
        font-size: 16px;
        font-weight: 600
    }

    .invoice-date {
        text-align: right;
        padding-left: 20px
    }

    .invoice-price {
        background: #f0f3f4;
        display: table;
        width: 100%
    }

    .invoice-price .invoice-price-left,
    .invoice-price .invoice-price-right {
        display: table-cell;
        padding: 20px;
        font-size: 20px;
        font-weight: 600;
        width: 75%;
        position: relative;
        vertical-align: middle
    }

    .invoice-price .invoice-price-left .sub-price {
        display: table-cell;
        vertical-align: middle;
        padding: 0 20px
    }

    .invoice-price small {
        font-size: 12px;
        font-weight: 400;
        display: block
    }

    .invoice-price .invoice-price-row {
        display: table;
        float: left
    }

    .invoice-price .invoice-price-right {
        width: 25%;
        background: #2d353c;
        color: #fff;
        font-size: 28px;
        text-align: right;
        vertical-align: bottom;
        font-weight: 300
    }

    .invoice-price .invoice-price-right small {
        display: block;
        opacity: .6;
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 12px
    }

    .invoice-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        font-size: 10px
    }

    .invoice-note {
        color: #999;
        margin-top: 80px;
        font-size: 85%
    }

    .invoice>div:not(.invoice-footer) {
        margin-bottom: 20px
    }

    .btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
        color: #2d353c;
        background: #fff;
        border-color: #d9dfe3;
    }
</style>

<?php use App\Models\Product; ?>

<div class="container">
   <div class="col-md-12">
      <div class="invoice">
         <!-- begin invoice-company -->
         <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
            <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
            <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
            </span>
           <img style="margin-left:30px" src="{{ asset('front/images/main-logo/logoTCH.png') }}">
         </div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header">
            <div class="invoice-from">
               <small>Billed To:</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">{{ $userDetails['name'] }}</strong><br>
                  @if(!empty($userDetails['address']))
                  {{ $userDetails['address'] }}<br>
                  @endif
                  @if(!empty($userDetails['state']))
                  {{ $userDetails['state'] }}<br>
                  @endif
                  @if(!empty($userDetails['city']))
                  {{ $userDetails['city'] }}<br>
                  @endif
                  @if(!empty($userDetails['country']))
                  {{ $userDetails['country'] }}<br>
                  @endif
                  @if(!empty($userDetails['pincode']))
                  {{ $userDetails['pincode'] }}<br>
                  @endif
                  {{ $userDetails['mobile'] }}<br>
               </address>
            </div>
            <div class="invoice-to">
               <small>Shipped To:</small>
               <address class="m-t-5 m-b-5">
                <strong class="text-inverse">{{ $orderDetails['name'] }}</strong><br>
                {{ $orderDetails['address'] }}, {{ $orderDetails['state'] }}<br>
                {{ $orderDetails['city'] }}, {{ $orderDetails['country'] }}<br>
                {{ $orderDetails['pincode'] }}<br>
                {{ $orderDetails['mobile'] }}<br>
               </address>
            </div>
            <div class="invoice-date">
               <div class="invoice-detail">
                <small>Payment Method:</small><br/>
                    <strong>{{ $orderDetails['payment_method'] }}</strong>
               </div>
            </div>
            <div class="invoice-date">
                <div class="invoice-detail"> 
                     <strong>Invoice Order # {{ $orderDetails['id'] }}</strong><br>
                     {{ date('j F, Y, g:i a', strtotime($orderDetails['created_at'])) }}<br />
                     <small style="float: right"><?php echo DNS1D::getBarcodeHTML($orderDetails['id'], 'C39')?></small>
                     
                </div>
             </div>
         </div>
         <!-- end invoice-header -->
         <!-- begin invoice-content -->
         <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th>ORDER SUMMARY</th>
                        <th class="text-center" width="10%">PRICE</th>
                        <th class="text-center" width="10%">QUANTITY</th>
                        <th class="text-right" width="20%">TOTALS</th>
                     </tr>
                  </thead>
                  <tbody>
                    @php $total_price = 0 @endphp                    
                    @foreach($orderDetails['orders_products'] as $product) 
                     <tr>
                        <td>
                           <span class="text-inverse">{{ $product['product_name'] }}</span><br>
                           <small>{{ $product['product_code'] }} | {{ $product['product_size'] }} | {{ $product['product_type'] }}</small><br/>
                           <small style="float:left">&nbsp;<?php echo DNS1D::getBarcodeHTML($product['product_code'], 'C39')?></small>
                        </td>
                        <td class="text-center">{{ number_format(($product['product_price']),0,'','.') }} đ</td>
                        <td class="text-center">{{ $product['product_qty'] }}</td>
                        <td class="text-right">{{ number_format(($product['product_price'] * $product['product_qty'] ),0,'','.') }} đ</td>
                     </tr>
                     @php $total_price = $total_price + ($product['product_price'] * $product['product_qty']) @endphp
                    @endforeach
                  </tbody>
               </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
               <div class="invoice-price-left">
                  <div class="invoice-price-row">
                     <div class="sub-price">
                        <small>SUBTOTAL</small>
                        <span class="text-inverse">{{ number_format($total_price),0,'',',' }} đ</span>
                     </div>
                     <div class="sub-price">
                        <i class="fa fa-plus text-muted"></i>
                     </div>
                     <div class="sub-price">
                        <small>Shipping Charges</small>
                        <span class="text-inverse">0 đ</span>
                     </div>
                     <div class="sub-price">
                        <i class="fa fa-minus text-muted"></i>
                     </div>
                     <div class="sub-price">
                        <small>Coupon Discount</small>
                        @if($orderDetails['coupon_amount']>0)
                        <span class="text-inverse">{{ number_format($orderDetails['coupon_amount']),0,'','.' }} đ</span>
                        @else 
                        <span class="text-inverse">0 đ</span>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="invoice-price-right">
                  <small>GRAND TOTAL</small> <span class="f-w-600">{{ number_format($orderDetails['grand_total']),0,'',',' }} đ</span>
               </div>
            </div>
            <!-- end invoice-price -->
         </div>
         <!-- end invoice-content -->
         <!-- begin invoice-footer -->
         <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
               THANK YOU FOR YOUR BUY
            </p>
            <p class="text-center">
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> #</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i>#</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> Mail: dotranphuongnam@gmail.com</span>
            </p>
         </div>
         <!-- end invoice-footer -->
      </div>
   </div>
</div>