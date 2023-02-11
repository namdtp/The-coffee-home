<?php
use App\Models\Section;
$sections = Section::sections();
// echo "<pre>"; print_r($sections); die;
$totalCartItems = totalCartItems();
?>
<!-- Header -->
<header>
   <!-- Top-Header -->
   <div class="full-layer-outer-header">
      <div class="container clearfix">
         <nav>
            <ul class="primary-nav g-nav">
               <li>
                  <a >
                  <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                  +84 942 074 779</a>
               </li>
               <li>
                  <a>
                  <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                  E-mail: dotranphuongnam.com
                  </a>
               </li>
            </ul>
         </nav>
         <nav>
            <ul class="secondary-nav g-nav">
               <li>
                  <a>@if(Auth::check())Tài khoản của tôi @else Đăng ký / Đăng nhập @endif
                  <i class="fas fa-chevron-down u-s-m-l-9"></i>
                  </a>
                  <ul class="g-dropdown" style="width:200px">
                     <li>
                        <a href="{{ url('orders') }}">
                           <i class="fas fa-file-alt"></i> Đơn hàng
                        </a>
                     </li>
                     <!-- <li>
                        <a href="checkout.html">
                        <i class="far fa-check-circle u-s-m-r-9"></i>
                        Checkout</a>
                     </li> -->
                     @if(Auth::check())
                        <li>
                           <a href="{{ url('user/account') }}">
                           <i class="fas fa-sign-in-alt u-s-m-r-9"></i>Tài khoản</a>
                        </li>
                        <li>
                           <a href="{{ url('user/logout') }}">
                           <i class="fas fa-sign-in-alt u-s-m-r-9"></i>Đăng xuất</a>
                        </li>
                     @else
                        <li>
                           <a href="{{ url('user/login-register') }}">
                           <i class="fas fa-sign-in-alt u-s-m-r-9"></i>Đăng nhập</a>
                        </li>
                     @endif
                  </ul>
               </li>
               <li>
                  <a>VI
                  <i class="fas fa-chevron-down u-s-m-l-9"></i>
                  </a>
                  <ul class="g-dropdown" style="width:70px">
                     <li>
                        <a href="#" class="u-c-brand">VI</a>
                     </li>
                  </ul>
            </ul>
         </nav>
      </div>
   </div>
   <!-- Top-Header /- -->
   <header class="site-navbar js-sticky-header site-navbar-target" role="banner">

      <div class="container">
        <div class="row align-items-center position-relative">


         <div class="site-logo">
            <a href="{{ url('/')}}">
            <img src="{{ asset('front/images/main-logo/logoTCH.png') }}" alt="TheCoffeeHome" class="app-brand-logo">
            </a>
         </div>

          <div class="col-12">
            <nav class="site-navigation text-right ml-auto " role="navigation">

              <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">

                @foreach($sections as $section)
                @if(count($section['categories'])>0)
                <li class="has-children">
                  <a href="#about-section">{{ $section['name'] }}</a>
                  <i class="fas fa-angle-down"></i>
                  <ul class="dropdown arrow-top">
                     @foreach($section['categories'] as $category)
                    <li>
                     <a href="{{ url($category['url']) }}">{{ $category['category_name'] }}</a>
                     <ul>
                        @foreach($category['subcategories'] as $subcategory)
                        <li>
                           <a href="{{ url($subcategory['url']) }}">{{ $subcategory['category_name'] }}</a>
                        </li>
                        @endforeach                                           
                     </ul>

                     </li>
                    @endforeach
                  </ul>
                </li>
                @endif
               @endforeach
                
                <li><a href="javascript:;" class="nav-link">Câu chuyện</a></li>
                <li><a href="javascript:;" class="nav-link">Cửa hàng</a></li>
                <li><a href="javascript:;" class="nav-link">Khuyến mãi</a></li>
                <li>
                <li>
                  <div class="col-lg-1 col-md-3 col-sm-6">
                  <nav>
                     <ul class="mid-nav g-nav">
                        <li>
                           <a id="mini-cart-trigger">
                           <i class="ion ion-md-basket"></i>
                           <span class="item-counter totalCartItems">{{ $totalCartItems }}</span>
                           <!-- <span class="item-price">0 đ</span> -->
                           </a>
                        </li>
                     </ul>
                  </nav>
                  </div>
                </li>
              </ul>
            </nav>

          </div>
         
         <div class="col-lg-1">
            
               <ul class="mid-nav g-nav">
         
            </div>

          <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>

        </div>
      </div>

    </header>
   <!-- Mid-Header -->
   {{-- <div class="full-layer-mid-header">
      <div class="container">
         <div class="row clearfix align-items-center">
            <div class="col-lg-2 col-md-9 col-sm-6">
               <div class="brand-logo text-lg-center">
                  <a href="{{ url('/')}}">
                  <img src="{{ asset('front/images/main-logo/logoTCH.png') }}" alt="TheCoffeeHome" class="app-brand-logo">
                  </a>
               </div>
            </div>
            <div class="col-lg-9 u-d-none-lg">
               
            </div>
            <div class="col-lg-1 col-md-3 col-sm-6">
               <nav>
                  <ul class="mid-nav g-nav">
                     <li>
                        <a id="mini-cart-trigger">
                        <i class="ion ion-md-basket"></i>
                        <span class="item-counter totalCartItems">{{ $totalCartItems }}</span>
                        <!-- <span class="item-price">0 đ</span> -->
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
      </div>
   </div> --}}
   <!-- Mid-Header /- -->
   <!-- Responsive-Buttons -->
   <div class="fixed-responsive-container">
      <div class="fixed-responsive-wrapper">
         <button type="button" class="button fas fa-search" id="responsive-search"></button>
      </div>
      <div class="fixed-responsive-wrapper">
         <a href="javascript:void(0)">
         <i class="far fa-heart"></i>
         {{-- <span class="fixed-item-counter">4</span> --}}
         </a>
      </div>
   </div>
   <!-- Responsive-Buttons /- -->
   <!-- Mini Cart -->
   <div id="appendHeaderCartItems">
      @include('front.layout.header_cart_items')
   </div>
   <!-- Mini Cart /- -->
   <!-- Bottom-Header -->
   <div class="full-layer-bottom-header">
      <div class="container">
         <div class="row align-items-center">
            <div class="col-lg-3">
               <div class="v-menu v-close">
                  <span class="v-title">
                  DANH MỤC
                  <i class="fas fa-angle-down"></i>
                  </span>
                  <nav>
                     <div class="v-wrapper">
                        <ul class="v-list animated fadeIn">
                           @foreach($sections as $section)
                           @if(count($section['categories'])>0)
                           <li class="js-backdrop">
                              <a>
                              {{ $section['name'] }}
                              <i class="ion ion-ios-arrow-forward"></i>
                              </a>
                              <button class="v-button ion ion-md-add"></button>
                              <div class="v-drop-right" style="width: 700px;">
                                 <div class="row">
                                    @foreach($section['categories'] as $category)
                                    <div class="col-lg-4">
                                       <ul class="v-level-2">
                                          <li>
                                             <a href="{{ url($category['url']) }}">{{ $category['category_name'] }}</a>
                                             <ul>
                                                @foreach($category['subcategories'] as $subcategory)
                                                <li>
                                                   <a href="{{ url($subcategory['url']) }}">{{ $subcategory['category_name'] }}</a>
                                                </li>
                                                @endforeach                                           
                                             </ul>
                                          </li>
                                       </ul>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </li>
                           @endif
                           @endforeach
                           <li><a href="#blog-section" class="nav-link">Câu chuyện</a></li>
                <li><a href="#contact-section" class="nav-link">Cửa hàng</a></li>
                <li><a href="#contact-section" class="nav-link">Khuyến mãi</a></li>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>
            <div class="col-lg-9">
               <ul class="bottom-nav g-nav u-d-none-lg">
                  <li>
                     <a href="{{  url('about')}}">Về Chúng Tôi
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('term') }}">Điều Khoản
                     </a>
                  </li>
                  <li>
                     <a href="{{ url('contact') }}">Liên Hệ
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <!-- Bottom-Header /- -->
</header>
<!-- Header /- -->