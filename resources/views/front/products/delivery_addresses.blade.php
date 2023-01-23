
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
<p id="editDelivery-success" style="color:green"></p>
@if(count($deliveryAddresses)>0)
<h4 class="section-h4">Địa Chỉ Giao Hàng</h4>
@foreach($deliveryAddresses as $address)
<div class="control-group" style="margin-right:5px;float:left;"><input type="radio" name="address_id" id="address{{ $address['id'] }}" 
   value="{{ $address['id'] }}"></div>
<div>
   <label class="control-label">{{ $address['name'] }}, {{ $address['address'] }}, {{ $address['city'] }},
   {{ $address['state'] }}, {{ $address['country'] }} ({{ $address['mobile'] }})
   </label>
   <a style="float: right;" href="{{ url('delete-delivery-address/'.$address['id']) }}" class="deleteAddress">Xóa</a>
   <span style="float: right;">|</span>
   <a style="float: right;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Sửa</a>  
</div>
@endforeach<br />
@endif
<!-- Form-Fields /- -->
<h4 class="section-h4 deliveryText">Thêm địa chỉ giao hàng mới</h4>
<div class="u-s-m-b-24">
   <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
   <label class="label-text newAddress" for="ship-to-different-address">Giao hàng đến một địa chỉ khác?</label>
</div>
<div class="collapse" id="showdifferent">
   <!-- Form-Fields -->
   <form id="addressAddEditForm" action="javascript:;" method="post">@csrf
        <input type="hidden" name="delivery_id">
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name-extra">Tên Người Nhận
                <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_name" name="delivery_name" class="text-field">
                <p id="delivery-delivery_name"></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Địa Chỉ
                <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_address" name="delivery_address" class="text-field">
                <p id="delivery-delivery_address"></p>
            </div>
        </div>
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name-extra">Thành Phố
                <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_city" name="delivery_city" class="text-field">
                <p id="delivery-delivery_city"></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Quận
                <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_state" name="delivery_state" class="text-field">
                <p id="delivery-delivery_state"></p>
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="select-country-extra">Quốc Gia
            <span class="astk">*</span>
            </label>
            <div class="select-box-wrapper"> 
                <select class="select-box" id="delivery_country" name="delivery_country">
                    <option value="">Vui lòng chọn Quốc Gia</option>
                    @foreach($countries as $country)
                    <option value="{{ $country['country_name'] }}" @if($country['country_name']==Auth::user()->country) selected @endif>
                        {{ $country['country_name'] }}
                    </option>
                    @endforeach
                </select>
                <p id="delivery-delivery_country"></p>
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="postcode-extra">Pincode
            <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_pincode" name="delivery_pincode" class="text-field">
            <p id="delivery-delivery_pincode"></p>
        </div>
        <div class="u-s-m-b-13">
            <label for="postcode-extra">Số điện thoại
            <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_mobile" name="delivery_mobile" class="text-field">
            <p id="delivery-delivery_mobile"></p>
        </div>
        <div class="u-s-m-b-13" >
            <button style="width:100%" type="submit" class="button button-outline-secondary">Cập nhật</button>
        </div>
    </form>
   <!-- Form-Fields /- -->
</div>
<div>
   <label for="order-notes">Ghi chú đơn hàng</label>
   <textarea class="text-area" id="order-notes" placeholder="Ghi chú về đơn đặt hàng của bạn, Ví dụ: ghi chú đặc biệt cho giao hàng."></textarea>
</div>
