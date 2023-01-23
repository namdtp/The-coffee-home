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
                        <a href="{{ url('/') }}">Trang Chủ</a>
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
                        <strong>Lỗi: </strong><?php echo implode('', $errors->all('<div>:message</div>'));?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                @endif  
            <div class="row">
                <!-- Forgot password -->
                <div class="col-lg-6">
                    <div class="forgot-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Quên Mật Khẩu ?</h2>
                        <h6 class="account-h6 u-s-m-b-30">Nhập địa chỉ email của bạn bên dưới và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn.</h6>
                        <p id="forgot-error"></p>
                        <p id="forgot-success"></p>
                        <form id="forgotForm" action="javascript:;" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" name="email" id="users-email" class="text-field" placeholder="Email">
                                <p id="forgot-email"></p>
                            </div>
                            <div class="group-inline u-s-m-b-30">
                                <div class="group-2 text-right">
                                    <div class="page-anchor">
                                        <a href="{{ url('user/login-register') }}">
                                            <i class="fas fa-long-arrow-alt-left u-s-m-r-9"></i>Quay lại Đăng Nhập</a>
                                    </div>
                                </div>
                            </div>
                            <div class="m-b-45">
                                <button type="submit" class="button button-outline-secondary w-100">Gửi Liên Kết Đặt Lại</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Forgot password /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Đăng Ký</h2>
                        <h6 class="account-h6 u-s-m-b-30">Đăng ký cho trang web này cho phép bạn truy cập trạng thái và lịch sử đặt hàng của bạn.</h6>
                        <p id="register-success"></p>
                        <form id="registerForm" action="javascript:;" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="username">Tên
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-name" name="name" class="text-field" placeholder="Tên Người Dùng">
                                <p id="register-name"><p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="usermobile">Số Điện Thoại
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="user-mobile" name="mobile" class="text-field" placeholder="Số Điện Thoại">
                                <p id="register-mobile"><p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="useremail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="user-email" name="email" class="text-field" placeholder="Email">
                                <p id="register-email"><p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userpassword">Mật Khẩu
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="user-password" name="password" class="text-field" placeholder="Mật Khẩu">
                                <p id="register-password"><p>
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">Tôi đã đọc và chấp nhận
                                    <a href="terms-and-conditions.html" class="u-c-brand">diều khoản & điều kiện</a>
                                </label>
                                <p id="register-accept"><p>
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