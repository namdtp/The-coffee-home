@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Liên Hệ</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="contact.html">Liên Hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Contact-Page -->
    <div class="page-contact u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="touch-wrapper">
                        <h1 class="contact-h1">Liên Hệ Với Chúng Tôi</h1>
                        <form>
                            <div class="group-inline u-s-m-b-30">
                                <div class="group-1 u-s-p-r-16">
                                    <label for="contact-name">Tên Của Bạn
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="text" id="contact-name" class="text-field" placeholder="Name">
                                </div>
                                <div class="group-2">
                                    <label for="contact-email">Địa chỉ Email
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="text" id="contact-email" class="text-field" placeholder="Email">
                                </div>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="contact-subject">Vấn Đề
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="contact-subject" class="text-field" placeholder="Subject">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="contact-message">Nội Dung:</label>
                                <textarea class="text-area" id="contact-message"></textarea>
                            </div>
                            <div class="u-s-m-b-30">
                                <button type="submit" class="button button-outline-secondary">Gửi Tin Nhắn</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="information-about-wrapper">
                        <h1 class="contact-h1">Thông Tin Về Chúng Tôi</h1>
                        <p>
                            TheCoffeeHome là một công ty Việt Nam.
                        </p>
                    </div>
                    <div class="contact-us-wrapper">
                        <h1 class="contact-h1">Liên Hệ Chúng Tôi</h1>
                        <div class="contact-material u-s-m-b-16">
                            <h6>Địa Chỉ</h6>
                            <span>134, Đường Trần Bá Giao</span>
                            <span>Phường 5, Quận Gò Vấp, TP.HCM, VietNam</span>
                        </div>
                        <div class="contact-material u-s-m-b-16">
                            <h6>Email</h6>
                            <span>dotranphuongnam@gmail.com</span>
                        </div>
                        <div class="contact-material u-s-m-b-16">
                            <h6>Telephone</h6>
                            <span>+84 942 074 779</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="u-s-p-t-80">
            <div id="map"></div>
        </div>
    </div>
    <!-- Contact-Page /- -->
@endsection    