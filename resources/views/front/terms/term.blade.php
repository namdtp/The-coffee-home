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
          <ul class="term-list">
              <li>
                A. BẢO HÀNH.<br />
                - Đối với sản phẩm có Bảo hành chính hãng, khi bán hàng, Cửa hàng sẽ kèm theo phiếu bảo hành để khách hàng liên hệ trực tiếp Trạm bảo hành của nhà sản xuất để thực hiện quyền lợi của mình khi cần.<br />
                - Đối với những sản phẩm cửa hàng có ghi chú "Bảo hành tại cửa hàng", Quý khách vui lòng mang sản phẩm đến địa chỉ Cửa hàng để thực hiện quyền bảo hành sản phẩm.<br />
              </li>
              <li>
                B. ĐỔI HÀNG.<br />
                Khách hàng luôn kiểm tra kỹ hàng hóa về số lượng và chất lượng với nhân viên giao hàng ngay khi nhận. Kiểm tra kỹ size, màu sắc theo Danh sách giao hàng mà người giao hàng cầm trên tay.
              </li>
              <li>
                Cửa hàng chỉ đổi hàng trong 2 trường hợp:<br />
                1. Cửa hàng giao sản phẩm không đúng yêu cầu của khách đã đặt trong đơn hàng;<br />
                2. Quần áo người lớn và trẻ em mặc không vừa, đổi sang size to hơn hoặc nhỏ hơn để mặc cho vừa. Chỉ cho đổi size mà cửa hàng còn đăng trên web. Không cho đổi sang sản phẩm khác ( thực chất là trả hàng và mua hàng khác). Riêng quần lót  và áo lót, KHÔNG CHO ĐỔI HÀNG.<br />
                <br/ >Việc đổi hàng này chỉ thực hiện khi: Cửa hàng có giao 1 đơn hàng khác tại địa chỉ của khách thì mang hàng theo đổi và thu phí 7% giá trị món đổi hoặc ít nhất là 5 ngàn/món, trừ trường hợp việc đổi này là do lỗi của Cửa hàng thì không có phí; hoặc khách hàng mang đến/gửi người khác mang đến địa chỉ  Cửa hàng để đổi thì không có phí đổi hàng.
              </li>
              <li>
                C. TRẢ HÀNG và PHÍ TRẢ HÀNG:<br />

                1. Trả hàng:<br />
                Quý khách vui lòng kiểm tra hàng hóa với nhân viên ngay khi nhận hàng. LUÔN LUÔN KIỂM HÀNG TRƯỚC KHI THANH TOÁN.<br />
                Nếu sản phẩm giao đúng yêu cầu, chất lượng và hoạt động tốt như đã đăng trên web thì nhận, trái lại thì trả ngay cho nhân viên và trừ tiền sản phẩm đó ra khỏi Đơn hàng trước khi thanh toán.<br />
                
                <strong>Cửa hàng không bảo hành ,không nhận Đổi hay Trả hàng sau khi nhân viên đã giao hàng xong và rời khỏi địa chỉ giao hàng</strong><br />
                
                Cửa hàng KHÔNG mang hàng cho khách xem. Chỉ mang đi giao đúng những món hàng nào Quý khách Đặt hàng. Nếu sản phẩm nào khách hàng xem Chi Tiết Sản phẩm rồi mà vẫn không rõ thì có thể điện thoại, gửi mail  hoặc Chat qua YM với Cửa hàng để hỏi thêm trước khi đặt hàng.
              </li>
          </ul>
      </div>
  </div>
  <!-- Terms-&-Conditions-Page /- -->
@endsection    