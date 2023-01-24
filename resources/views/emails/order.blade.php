<!DOCTYPE html>
<html>
	<head>
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>
	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="5">
						<table>
							<tr>
                                <td>
                                    Xin chào {{ $name }}! <br />
                                    Cảm ơn đã mua sản phẩm bên chúng tôi. Chi tiết đơn đặt hàng của bạn như sau:
                                </td>								
								<td>
									<strong>Đơn Hàng: #{{ $order_id }}</strong><br />								
								</td>                             
							</tr>
						</table>
					</td>
				</tr>
				<tr class="information">
					<td colspan="10">
						<table>
							<tr>
								<td>
									Địa Chỉ Giao Hàng:<br />
                                    <strong>{{ $orderDetails['name'] }}</strong><br />
                                    <strong>{{ $orderDetails['address'] }}, {{ $orderDetails['state'] }}</strong><br />
                                    <strong>{{ $orderDetails['city'] }}, {{ $orderDetails['country'] }}</strong><br />
                                    <strong>{{ $orderDetails['pincode'] }}</strong><br /> 
                                    <strong>{{ $orderDetails['mobile'] }} </strong>                             
								</td>
                                <td></td>
                                <td>
									Phương Thức Thanh Thoán: <br />
                                    <strong>{{ $orderDetails['payment_method'] }}</strong>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="heading">
					<td>Tên Sản Phẩm</td>
					<td>Mã Sản Phẩm</td>
                    <td>Kích Thước</td>
                    <td>Số Lượng</td>
                    <td>Giá</td>
				</tr>
                @foreach($orderDetails['orders_products'] as $order)
				<tr class="item last">
					<td>{{ $order['product_name'] }}</td>
                    <td>{{ $order['product_code'] }}</td>
                    <td>{{ $order['product_size'] }}</td>
                    <td>{{ $order['product_qty'] }}</td>
                    <td>{{ number_format($order['product_price'] * $order['product_qty']),0,'',',' }} đ</td>
				</tr>
                @endforeach
                <tr class="total">
                    <td></td>
                    <td></td>
                    <td></td>
					<td>Phí Vận Chuyển: {{ $orderDetails['shipping_charges'] }} đ</td>
                    <td>Phiếu Giảm Giá:  
                        @if($orderDetails['coupon_amount']>0)
                            {{ number_format($orderDetails['coupon_amount']),0,'',',' }} đ
                        @else
                            0 đ
                        @endif
                    </td>
                    <td>Tổng Tiền: {{ number_format($orderDetails['grand_total']),0,'',',' }} đ</td>
				</tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td colspan="10" style="font-size: 14px">Đối với bất kỳ câu hỏi nào về sản phẩm, bạn có thể liên hệ với chúng tôi qua địa chỉ email sau: <br /><a style="color:black;" href="mailto:dotranphuongnam@gmail.com"> dotranphuongnam@gmail.com </a></td></tr>
                <tr><td>Trân Trọng,<br />Team TheCoffeeHome Customer</td></tr>
			</table>
		</div>
	</body>
</html>