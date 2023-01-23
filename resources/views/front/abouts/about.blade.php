@extends('front.layout.layout')
@section('content')    
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Về Chúng Tôi</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="is-marked">
                        <a href="about.html">Về Chúng Tôi</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- About-Page -->
    <div class="page-about u-s-p-t-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-me-info u-s-m-b-30">
                        <h1>Chào mừng bạn đến với
                            <span>Azalea</span>
                        </h1>
                        <p class="card-text">Azalea là một công ty Việt Nam đảm bảo cung cấp quần áo phổ biến cho mọi đối tượng.</p>
                        <div class="card">
                        <div class="card-body">
                            <p class="card-text">Kể từ Ngày 10 Tháng 12 Năm 2022<br/>
                            TheCoffeeHome VIETNAM CO., LTD</p>
                            <h5 class="card-title">TÊN CÔNG TY</h5>
                            <p class="card-text">TheCoffeeHome VIETNAM CO., LTD</p>
                            <h5 class="card-title">THÀNH LẬP</h5>
                            <p class="card-text">NGÀY 1 THÁNG 11 NĂM 2022</p>
                            <h5 class="card-title">ĐỊA ĐIỂM</h5>
                            <p class="card-text">Địa Chỉ Đăng Ký : 134/8a Đường Trần Bá Giao, Phường 5, Quận Gò Vấp, TP.HCM, Việt Nam</p>
                            <h5 class="card-title">NGÀNH KINH DOANH</h5>
                            <p class="card-text">Nhà bán lẻ quần áo phổ biến thương hiệu Azalea tại Việt Nam</p>
                            <h5 class="card-title">SỐ LƯỢNG CỬA HÀNG</h5>
                            <p class="card-text">1 cửa hàng (Tính từ 08 2022)</p>
                        </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
    <!-- About-Page /- -->
@endsection    