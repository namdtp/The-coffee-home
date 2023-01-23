<?php 
use App\Models\Product;
?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
   <table>
      <thead>
         <tr>
            <th>Sản pPhẩm</th>
            <th>Giá</th>
            <th>Số Lượng</th>
            <th>Tổng Tiền</th>
            <th>#</th>
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
               <div class="cart-anchor-image">
                  <a href="{{ url('product/'.$item['product_id']) }}" style="display:flex; align-items: center;">
                     <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" 
                        alt="Product">
                     <h6>
                        {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }}) <br />
                        Size: {{ $item['size'] }} |
                        Color: {{ $item['product']['product_color'] }}
                     </h6>
                  </a>
               </div>
            </td>
            <td>
               <div class="cart-price">
                  @if($getDiscountAttributePrice['discount']>0)
                  <div class="price-template">
                     <div class="item-new-price">
                        {{ number_format($getDiscountAttributePrice['final_price']),0,'',',' }} đ
                     </div>
                     <div class="item-old-price" style="margin-left:-20px">
                        {{ number_format($getDiscountAttributePrice['product_price']),0,'',',' }} đ
                     </div>
                  </div>
                  @else
                  <div class="price-template">
                     <div class="item-new-price">
                        {{ number_format($getDiscountAttributePrice['final_price']),0,'',',' }} đ
                     </div>
                  </div>
                  @endif
               </div>
            </td>
            <td>
               <div class="cart-quantity">
                  <div class="quantity">
                     <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                     <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-max="100">&#43;</a>
                     <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-min="1">&#45;</a>
                  </div>
               </div>
            </td>
            <td>
               <div class="cart-price">
                  {{ number_format(($getDiscountAttributePrice['final_price'] * $item['quantity']),0,'','.') }} đ
               </div>
            </td>
            <td>
               <div class="action-wrapper">
                 <!--  <button class="button button-outline-secondary fas fa-sync"></button> -->
                  <button class="button button-outline-secondary fas fa-trash deleteCartItem" data-cartid="{{ $item['id'] }}"></button>
               </div>
            </td>
         </tr>
         @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
         @endforeach
      </tbody>
   </table>
</div>
<!-- Products-List-Wrapper /- -->

<!-- Billing -->
<div class="calculation u-s-m-b-60">
   <div class="table-wrapper-2">
      <table>
         <thead>
            <tr>
               <th colspan="2">Tổng Đơn Giỏ Hàng</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>
                  <h3 class="calc-h3 u-s-m-b-0">Tổng Tiền</h3>
               </td>
               <td>
                  <span class="calc-text">{{ number_format($total_price),0,'',',' }} đ</span>
               </td>
            </tr>
            <tr>
               <td>
                  <h3 class="calc-h3 u-s-m-b-0">Phiếu Giảm Giá</h3>
               </td>
               <td>
                  <span class="calc-text couponAmount">
                     @if(Session::has('couponAmount'))
                        {{ Session::get('couponAmount') }} đ
                     @else
                        0 đ
                     @endif
                  </span>
               </td>
            </tr>
            <tr>
               <td>
                  <h3 class="calc-h3 u-s-m-b-0">Tổng Cộng</h3>
               </td>
               <td>
                  <span class="calc-text"><strong class="grand_total">{{ number_format($total_price - Session::get('couponAmount')),0,'',',' }} đ</strong></span>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
<!-- Billing /- -->