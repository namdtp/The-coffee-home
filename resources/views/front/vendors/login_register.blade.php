@extends('front.layout.layout')
@section('content')
  <!-- Page Introduction Wrapper -->
  <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Tài Khoản</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('user/login-register') }}">Tài Khoản</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container">
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thành Công: </strong> {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
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
            <div class="row">
                <!-- Login -->
                
                <!-- Login /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Đăng Ký (Vendor)</h2>
                        <h6 class="account-h6 u-s-m-b-30">Đăng ký cho trang web này cho phép bạn truy cập trạng thái và lịch sử đặt hàng của bạn.</h6>
                        <form id="vendorForm" action="{{ url('/vendor/register') }}" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="vendorname">Tên
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorname" name="name" class="text-field" placeholder="Tên">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendormobile">Số Điện Thoại
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendormobile" name="mobile" class="text-field" placeholder="Số Điện Thoại">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendoremail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="vendoremail" name="email" class="text-field" placeholder="Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorpassword">Mật Khẩu
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="vendorpassword" name="password" class="text-field" placeholder="Mật Khẩu">
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">Tôi đã đọc và chấp thuận
                                    <a href="terms-and-conditions.html" class="u-c-brand">điều khoản & điều kiện</a>
                                </label>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Đăng Ký</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection