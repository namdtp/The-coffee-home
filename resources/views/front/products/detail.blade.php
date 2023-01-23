<?php 
   use App\Models\Product;
   use App\Models\ProductsFilter;
   $productFilters = ProductsFilter::productFilters();
   // dd($productFilters);
   ?> 
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
   <div class="container">
      <div class="page-intro">
         <h2>Chi Tiết Sản Phẩm</h2>
         <ul class="bread-crumb">
            <li class="has-separator">
               <i class="ion ion-md-home"></i>
               <a href="{{ url('/') }}">Trang Chủ</a>
            </li>
            <li class="is-marked">
               <a href="javascript:;">Chi Tiết Sản Phẩm</a>
            </li>
         </ul>
      </div>
   </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Single-Product-Full-Width-Page -->
<div class="page-detail u-s-p-t-80">
   <div class="container">
      <!-- Product-Detail -->
      <div class="row">
         <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- Product-zoom-area -->
            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
               <a href="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}">
               <img src="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" alt="" width="500" height="500" />
               </a>
            </div>
            <div class="thumbnails" style="margin-top:20px">
               <a href="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}" data-standard="{{ asset('front/images/product_images/large/'.$productDetails['product_image']) }}">
               <img  width="120" height="120" src="{{ asset('front/images/product_images/small/'.$productDetails['product_image']) }}" alt="" />
               </a>
               @foreach($productDetails['images'] as $image)
               <a href="{{ asset('front/images/product_images/large/'.$image['image']) }}" data-standard="{{ asset('front/images/product_images/large/'.$image['image']) }}">
               <img width="120" height="120" src="{{ asset('front/images/product_images/large/'.$image['image']) }}" alt="" />
               </a>
               @endforeach
            </div>
            <!-- Product-zoom-area /- -->
         </div>
         <div class="col-lg-6 col-md-6 col-sm-12">
            <!-- Product-details -->
            <div class="all-information-wrapper">
               @if(Session::has('error_message'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>Lỗi: </strong> {{ Session::get('error_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Thành Công: </strong> <?php echo Session::get('success_message') ?>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
               @endif
               <div class="section-1-title-breadcrumb-rating">
                  <div class="product-title">
                     <h1>
                        <a href="javascript:;">{{ $productDetails['product_name'] }}</a>
                     </h1>
                  </div>
                  <ul class="bread-crumb">
                     <li class="has-separator">
                        <a href="{{ url('/') }}">Trang Chủ</a>
                     </li>
                     <li class="has-separator">
                        <a href="javascript:;">{{ $productDetails['section']['name'] }}</a>
                     </li>
                     <?php echo $categoryDetails['breadcrumbs']; ?>
                  </ul>
                  <div class="product-rating">
                     <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                        <span style='width:67px'></span>
                     </div>
                     <span>(23)</span>
                  </div>
               </div>
               <div class="section-2-short-description u-s-p-y-14">
                  <h6 class="information-heading u-s-m-b-8">Mô tả:</h6>
                  <p>
                     {{ $productDetails['description'] }}
                  </p>
               </div>
               <div class="section-3-price-original-discount u-s-p-y-14">
                  <?php $getDiscountPrice = Product::getDiscountPrice($productDetails['id']); ?>
                  <span class="getAttributePrice">
                     @if($getDiscountPrice>0)
                     <div class="price">
                        <h4>{{ $getDiscountPrice }} VNĐ</h4>
                     </div>
                     <div class="original-price">
                        <span>Original Price:</span>
                        <span>{{ number_format($productDetails['product_price'],0,'','.') }} VNĐ</span>
                     </div>
                     @else
                     <div class="price">
                        <h4>{{ number_format($productDetails['product_price'],0,'','.') }} VNĐ</h4>
                     </div>
                     @endif
                  </span>
                  <!-- <div class="discount-price">
                     <span>Discount:</span>
                     <span>15%</span>
                     </div>
                     <div class="total-save">
                     <span>Save:</span>
                     <span>$20</span>
                     </div> -->
               </div>
               <div class="section-4-sku-information u-s-p-y-14">
                  <h6 class="information-heading u-s-m-b-8">Thông tin đơn vị:</h6>
                  <div class="left">
                     <span>Mã sản phẩm:</span>
                     <span>{{ $productDetails['product_code'] }}</span>
                  </div>
                  <div class="left">
                     <span>Màu sắc:</span>
                     <span>{{ $productDetails['product_color'] }}</span>
                  </div>
                  <div class="availability">
                     <span>Khả dụng:</span>
                     @if($totalStock>0)
                     <span>Còn hàng</span>
                     @else
                     <span style="color:red">Hết hàng</span>
                     @endif
                  </div>
                  @if($totalStock>0)
                  <div class="left">
                     <span>Chỉ còn:</span>
                     <span>{{ $totalStock }}</span>
                  </div>
                  @endif
               </div>
               @if(isset($productDetails['vendor']))
               <div>
                  Bán bởi cửa hàng: <a href="/products/{{ $productDetails['vendor']['id'] }}">{{ $productDetails['vendor']['vendorbusinessdetails']['shop_name'] }} </a>                    
               </div>
               @endif
               <form action="{{ url('cart/add') }}" class="post-form" method="post">@csrf
                  <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}" />
                  <div class="section-5-product-variants u-s-p-y-14">             
                     @if(count($groupProducts)>0)
                     <div>
                        <div><strong>Màu sắc:</strong></div>
                        <div>
                           @foreach($groupProducts as $product)
                           <a href="{{ url('product/'.$product['id']) }}">
                           <img style="width:80px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}"/>
                           </a>
                           @endforeach
                        </div>
                     </div>
                     @endif
                     <div class="sizes u-s-m-b-11" style="margin-top:15px">
                        <span>Kích cỡ:</span>
                        <div class="size-variant select-box-wrapper">
                           <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" class="select-box product-size" required="">
                              <option value="">Chọn kích cỡ</option>
                              @foreach ($productDetails['attributes'] as $attribute)
                              <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                              @endforeach                          
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                     <?php /* <div class="quick-social-media-wrapper u-s-m-b-22">
                        <span>Share:</span>
                        <ul class="social-media-list">
                           <li>
                              <a href="#">
                              <i class="fab fa-facebook-f"></i>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fab fa-twitter"></i>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fab fa-google-plus-g"></i>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fas fa-rss"></i>
                              </a>
                           </li>
                           <li>
                              <a href="#">
                              <i class="fab fa-pinterest"></i>
                              </a>
                           </li>
                        </ul>
                     </div> */ ?>
                     <div class="quantity-wrapper u-s-m-b-22">
                        <span>Số lượng:</span>
                        <div class="quantity">
                           <input type="number" name="quantity" class="quantity-text-field" value="1" min="1" max="100"/>
                        </div>
                     </div>
                     <div>
                        <button class="button button-outline-secondary" type="submit">Thêm vào giỏ hàng</button>
                        <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                        <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- Product-details /- -->
         </div>
      </div>
      <!-- Product-Detail /- -->
      <!-- Detail-Tabs -->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="detail-tabs-wrapper u-s-p-t-80">
               <div class="detail-nav-wrapper u-s-m-b-30">
                  <ul class="nav single-product-nav justify-content-center">
                     <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#video">Video Sản Phẩm</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detail">Chi Tiết Sản Phẩm</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#review">Đánh Giá</a>
                     </li>
                  </ul>
               </div>
               <div class="tab-content">
                  <!-- Details-Tab -->
                  <div class="tab-pane fade active show" id="video">
                     <div class="description-whole-container">
                        @if($productDetails['product_video'])
                        <video controls>
                           <source src="{{ url('front/videos/product_videos/'.$productDetails['product_video']) }}" type="video/mp4" />
                        </video>
                        @else
                        Video Sản Phẩm Không Tồn Tại
                        @endif
                     </div>
                  </div>
                  <!-- Description-Tab /- -->
                  <!-- Specifications-Tab -->
                  <div class="tab-pane fade" id="detail">
                     <div class="specification-whole-container">
                        <div class="spec-table u-s-m-b-50">
                           <h4 class="spec-heading">Thông tin chi tiết sản phẩm</h4>
                           <table>
                              @foreach ($productFilters as $filter)
                              @if(isset($productDetails['category_id']))
                              <?php 
                                 $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$productDetails['category_id']);
                                 ?>
                              @if($filterAvailable=="Yes")
                              <tr>
                                 <td>{{ $filter['filter_name'] }}</td>
                                 <td>
                                    @foreach ($filter['filter_values'] as $value)
                                    @if(!empty($productDetails[$filter['filter_column']]) &&
                                    $value['filter_value']==$productDetails[$filter['filter_column']]){{ ucwords($value['filter_value'])}}
                                    @endif
                                    @endforeach
                                 </td>
                              </tr>
                              @endif
                              @endif
                              @endforeach
                           </table>
                        </div>
                     </div>
                  </div>
                  <!-- Specifications-Tab /- -->
                  <!-- Reviews-Tab -->
                  {{-- <div class="tab-pane fade" id="review">
                     <div class="review-whole-container">
                        <div class="row r-1 u-s-m-b-26 u-s-p-b-22">
                           <div class="col-lg-6 col-md-6">
                              <div class="total-score-wrapper">
                                 <h6 class="review-h6">Đánh Giá Trung Bình</h6>
                                 <div class="circle-wrapper">
                                    <h1>4.5</h1>
                                 </div>
                                 <h6 class="review-h6">Dựa Trên 23 Nhận Xét</h6>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="total-star-meter">
                                 <div class="star-wrapper">
                                    <span>5 Stars</span>
                                    <div class="star">
                                       <span style='width:0'></span>
                                    </div>
                                    <span>(0)</span>
                                 </div>
                                 <div class="star-wrapper">
                                    <span>4 Stars</span>
                                    <div class="star">
                                       <span style='width:67px'></span>
                                    </div>
                                    <span>(23)</span>
                                 </div>
                                 <div class="star-wrapper">
                                    <span>3 Stars</span>
                                    <div class="star">
                                       <span style='width:0'></span>
                                    </div>
                                    <span>(0)</span>
                                 </div>
                                 <div class="star-wrapper">
                                    <span>2 Stars</span>
                                    <div class="star">
                                       <span style='width:0'></span>
                                    </div>
                                    <span>(0)</span>
                                 </div>
                                 <div class="star-wrapper">
                                    <span>1 Star</span>
                                    <div class="star">
                                       <span style='width:0'></span>
                                    </div>
                                    <span>(0)</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row r-2 u-s-m-b-26 u-s-p-b-22">
                           <div class="col-lg-12">
                              <div class="your-rating-wrapper">
                                 <h6 class="review-h6">Your Review is matter.</h6>
                                 <h6 class="review-h6">Have you used this product before?</h6>
                                 <div class="star-wrapper u-s-m-b-8">
                                    <div class="star">
                                       <span id="your-stars" style='width:0'></span>
                                    </div>
                                    <label for="your-rating-value"></label>
                                    <input id="your-rating-value" type="text" class="text-field" placeholder="0.0">
                                    <span id="star-comment"></span>
                                 </div>
                                 <form>
                                    <label for="your-name">Name
                                    <span class="astk"> *</span>
                                    </label>
                                    <input id="your-name" type="text" class="text-field" placeholder="Your Name">
                                    <label for="your-email">Email
                                    <span class="astk"> *</span>
                                    </label>
                                    <input id="your-email" type="text" class="text-field" placeholder="Your Email">
                                    <label for="review-title">Review Title
                                    <span class="astk"> *</span>
                                    </label>
                                    <input id="review-title" type="text" class="text-field" placeholder="Review Title">
                                    <label for="review-text-area">Review
                                    <span class="astk"> *</span>
                                    </label>
                                    <textarea class="text-area u-s-m-b-8" id="review-text-area" placeholder="Review"></textarea>
                                    <button class="button button-outline-secondary">Submit Review</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <!-- Get-Reviews -->
                        <div class="get-reviews u-s-p-b-22">
                           <!-- Review-Options -->
                           <div class="review-options u-s-m-b-16">
                              <div class="review-option-heading">
                                 <h6>Reviews
                                    <span> (15) </span>
                                 </h6>
                              </div>
                              <div class="review-option-box">
                                 <div class="select-box-wrapper">
                                    <label class="sr-only" for="review-sort">Review Sorter</label>
                                    <select class="select-box" id="review-sort">
                                       <option value="">Sort by: Best Rating</option>
                                       <option value="">Sort by: Worst Rating</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!-- Review-Options /- -->
                           <!-- All-Reviews -->
                           <div class="reviewers">
                              <div class="review-data">
                                 <div class="reviewer-name-and-date">
                                    <h6 class="reviewer-name">John</h6>
                                    <h6 class="review-posted-date">10 May 2018</h6>
                                 </div>
                                 <div class="reviewer-stars-title-body">
                                    <div class="reviewer-stars">
                                       <div class="star">
                                          <span style='width:67px'></span>
                                       </div>
                                       <span class="review-title">Good!</span>
                                    </div>
                                    <p class="review-body">
                                       Good Quality...!
                                    </p>
                                 </div>
                              </div>
                              <div class="review-data">
                                 <div class="reviewer-name-and-date">
                                    <h6 class="reviewer-name">Doe</h6>
                                    <h6 class="review-posted-date">10 June 2018</h6>
                                 </div>
                                 <div class="reviewer-stars-title-body">
                                    <div class="reviewer-stars">
                                       <div class="star">
                                          <span style='width:67px'></span>
                                       </div>
                                       <span class="review-title">Well done!</span>
                                    </div>
                                    <p class="review-body">
                                       Cotton is good.
                                    </p>
                                 </div>
                              </div>
                              <div class="review-data">
                                 <div class="reviewer-name-and-date">
                                    <h6 class="reviewer-name">Tim</h6>
                                    <h6 class="review-posted-date">10 July 2018</h6>
                                 </div>
                                 <div class="reviewer-stars-title-body">
                                    <div class="reviewer-stars">
                                       <div class="star">
                                          <span style='width:67px'></span>
                                       </div>
                                       <span class="review-title">Well done!</span>
                                    </div>
                                    <p class="review-body">
                                       Excellent condition
                                    </p>
                                 </div>
                              </div>
                              <div class="review-data">
                                 <div class="reviewer-name-and-date">
                                    <h6 class="reviewer-name">Johnny</h6>
                                    <h6 class="review-posted-date">10 March 2018</h6>
                                 </div>
                                 <div class="reviewer-stars-title-body">
                                    <div class="reviewer-stars">
                                       <div class="star">
                                          <span style='width:67px'></span>
                                       </div>
                                       <span class="review-title">Bright!</span>
                                    </div>
                                    <p class="review-body">
                                       Cotton
                                    </p>
                                 </div>
                              </div>
                              <div class="review-data">
                                 <div class="reviewer-name-and-date">
                                    <h6 class="reviewer-name">Alexia C. Marshall</h6>
                                    <h6 class="review-posted-date">12 May 2018</h6>
                                 </div>
                                 <div class="reviewer-stars-title-body">
                                    <div class="reviewer-stars">
                                       <div class="star">
                                          <span style='width:67px'></span>
                                       </div>
                                       <span class="review-title">Well done!</span>
                                    </div>
                                    <p class="review-body">
                                       Good polyester Cotton
                                    </p>
                                 </div>
                              </div>
                           </div>
                           <!-- All-Reviews /- -->
                           <!-- Pagination-Review -->
                           <div class="pagination-review-area">
                              <div class="pagination-review-number">
                                 <ul>
                                    <li style="display: none">
                                       <a href="single-product.html" title="Previous">
                                       <i class="fas fa-angle-left"></i>
                                       </a>
                                    </li>
                                    <li class="active">
                                       <a href="single-product.html">1</a>
                                    </li>
                                    <li>
                                       <a href="single-product.html">2</a>
                                    </li>
                                    <li>
                                       <a href="single-product.html">3</a>
                                    </li>
                                    <li>
                                       <a href="single-product.html">...</a>
                                    </li>
                                    <li>
                                       <a href="single-product.html">10</a>
                                    </li>
                                    <li>
                                       <a href="single-product.html" title="Next">
                                       <i class="fas fa-angle-right"></i>
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <!-- Pagination-Review /- -->
                        </div>
                        <!-- Get-Reviews /- -->
                     </div>
                  </div> --}}
                  <!-- Reviews-Tab /- -->
               </div>
            </div>
         </div>
      </div>
      <!-- Detail-Tabs /- -->
      <!-- Different-Product-Section -->
      <div class="detail-different-product-section u-s-p-t-80">
         <!-- Similar-Products -->
         <section class="section-maker">
            <div class="container">
               <div class="sec-maker-header text-center">
                  <h3 class="sec-maker-h3">Sản Phẩm Tương Tự</h3>
               </div>
               <div class="slider-fouc">
                  <div class="products-slider owl-carousel" data-item="4">
                     @foreach($similarProducts as $product)
                     <div class="item">
                        <div class="image-container">
                           <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                           <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                           @if(!empty($product['product_image']) && file_exists($product_image_path))
                           <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                           @else
                           <img class="img-fluid" src="{{ asset('front/images/product/product_images/small/no-image.png') }}" alt="Product">
                           @endif
                           </a>
                           <div class="item-action-behaviors">
                              <a class="item-quick-look" data-toggle="modal" href="javascript:void(0)">Quick Look</a>
                              <a class="item-mail" href="javascript:void(0)">Mail</a>
                              <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                              <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                           </div>
                        </div>
                        <div class="item-content">
                           <div class="what-product-is">
                              <ul class="bread-crumb">
                                 <li class="has-separator">
                                    <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                 </li>
                                 <li class="has-separator">
                                    <a href="listing.html">{{ $product['product_color'] }}</a>
                                 </li>
                                 <li>
                                    <a href="listing.html">{{ $product['brand']['name'] }}</a>
                                 </li>
                              </ul>
                              <h6 class="item-title">
                                 <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                              </h6>
                              <!-- <div class="item-stars">
                                 <div class='star' title="0 out of 5 - based on 0 Reviews">
                                    <span style='width:0'></span>
                                 </div>
                                 <span>(0)</span>
                                 </div> -->
                           </div>
                           <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                           @if($getDiscountPrice>0)
                           <div class="price-template">
                              <div class="item-new-price">
                                 {{ $getDiscountPrice}} VNĐ
                              </div>
                              <div class="item-old-price">
                                 {{ number_format($product['product_price'],0,'',',') }} VNĐ
                              </div>
                           </div>
                           @else
                           <div class="price-template">
                              <div class="item-new-price">
                                 {{ number_format($product['product_price'],0,'',',') }} VNĐ
                              </div>
                           </div>
                           @endif
                        </div>
                        <div class="tag new">
                           <span>NEW</span>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </section>
         <!-- Similar-Products /- -->
         <!-- Recently-View-Products  -->
         <section class="section-maker">
            <div class="container">
               <div class="sec-maker-header text-center">
                  <h3 class="sec-maker-h3">Sản Phẩm Xem Gần Đây</h3>
               </div>
               <div class="slider-fouc">
                  <div class="products-slider owl-carousel" data-item="4">
                     @foreach($recentlyViewedProducts as $product)
                     <div class="item">
                        <div class="image-container">
                           <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                           <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                           @if(!empty($product['product_image']) && file_exists($product_image_path))
                           <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                           @else
                           <img class="img-fluid" src="{{ asset('front/images/product/product_images/small/no-image.png') }}" alt="Product">
                           @endif
                           </a>
                           <div class="item-action-behaviors">
                              <a class="item-quick-look" data-toggle="modal" href="javascript:void(0)">Quick Look</a>
                              <a class="item-mail" href="javascript:void(0)">Mail</a>
                              <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                              <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                           </div>
                        </div>
                        <div class="item-content">
                           <div class="what-product-is">
                              <ul class="bread-crumb">
                                 <li class="has-separator">
                                    <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                 </li>
                                 <li class="has-separator">
                                    <a href="listing.html">{{ $product['product_color'] }}</a>
                                 </li>
                                 <li>
                                    <a href="listing.html">{{ $product['brand']['name'] }}</a>
                                 </li>
                              </ul>
                              <h6 class="item-title">
                                 <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                              </h6>
                              <!-- <div class="item-stars">
                                 <div class='star' title="0 out of 5 - based on 0 Reviews">
                                    <span style='width:0'></span>
                                 </div>
                                 <span>(0)</span>
                                 </div> -->
                           </div>
                           <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                           @if($getDiscountPrice>0)
                           <div class="price-template">
                              <div class="item-new-price">
                                 {{ $getDiscountPrice}} VNĐ
                              </div>
                              <div class="item-old-price">
                                 {{ number_format($product['product_price'],0,'',',') }} VNĐ
                              </div>
                           </div>
                           @else
                           <div class="price-template">
                              <div class="item-new-price">
                                 {{ number_format($product['product_price'],0,'',',') }} VNĐ
                              </div>
                           </div>
                           @endif
                        </div>
                        <div class="tag new">
                           <span>NEW</span>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </section>
         <!-- Recently-View-Products /- -->
      </div>
      <!-- Different-Product-Section /- -->
   </div>
</div>
<!-- Single-Product-Full-Width-Page /- -->
@endsection