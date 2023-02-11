@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
      <div class="container">
          <div class="page-intro">
              <h2>Điều Khoản</h2>
              <ul class="bread-crumb">
                  <li class="has-separator">
                      <i class="ion ion-md-home"></i>
                      <a href="{{ url('/') }}">Trang Chủ</a>
                  </li>
                  <li class="is-marked">
                      <a href="{{ url('terms') }}">Điều Khoản & Điều Kiện</a>
                  </li>
              </ul>
          </div>
      </div>
  </div>
  <!-- Page Introduction Wrapper /- -->
  <!-- Terms-&-Conditions-Page -->
  <div class="page-term u-s-p-t-80">
      <div class="container">
          <div class="term u-s-m-b-50">
              <h1>Điều Khoản & Điều Kiện</h1>
              <h1>Vui lòng đọc kỹ “Điều khoản & Điều kiện” của chúng tôi và tìm hiểu tất cả các quy tắc của chúng tôi.</h1>
              <p>Các quy tắc này đã được sửa đổi vào ngày 10 tháng 12 năm 2022.</p>
          </div>
          
      </div>
  </div>
  <!-- Terms-&-Conditions-Page /- -->
@endsection    