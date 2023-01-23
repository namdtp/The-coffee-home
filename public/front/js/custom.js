$(document).ready(function() {

	$('#orders').DataTable();
    $('#orderDetails').DataTable();
    $('#orderProducts').DataTable();
    $('#orderDeliveryAddress').DataTable();
	
    $('#getPrice').change(function() {
        var size = $(this).val();
        var product_id = $(this).attr('product-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data: {size: size, product_id: product_id},
            type: 'POST',
            success: function(resp) {
                // alert(resp['final_price']);
                if(resp['discount']>0){
                    $('.getAttributePrice').html("<div class='price'><h4>"+ Intl.NumberFormat('vi-VN').format(resp['final_price'])+" VNĐ</h4></div><div class='original-price'><span>Original Price: </span><span>"+Intl.NumberFormat('vi-VN').format(resp['product_price'])+" VNĐ</span></div>");
                }else{
                    $('.getAttributePrice').html("<div class='price'><h4>"+Intl.NumberFormat('vi-VN').format(resp['final_price'])+" VNĐ</h4></div>");
                }
            },error: function(){
                alert("Error");
            }
        })
    })
    // Update Cart Items Qty
	$(document).on('click','.updateCartItem',function(){
		if($(this).hasClass('plus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// increase the qty by 1
			new_qty = parseInt(quantity) + 1;
			// alert(new_qty);
		}
		if($(this).hasClass('minus-a')){
			// Get Qty
			var quantity = $(this).data('qty');
			// Check Qty is atleast 1
			if(quantity<=1){
				alert("Số lương sản phẩm phải bằng hoặc lớn hơn 1!");
				return false;
			}
			// increase the qty by 1
			new_qty = parseInt(quantity) - 1;
			/*alert(new_qty);*/
		}
		var cartid = $(this).data('cartid');
		$.ajax({
			headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		},
			data:{cartid:cartid,qty:new_qty},
			url:'/cart/update',
			type:'post',    
			success:function(resp){
				$(".totalCartItems").html(resp.totalCartItems);
				if(resp.status==false){
					alert(resp.message);
				}
				$("#appendCartItems").html(resp.view);
				$("#appendHeaderCartItems").html(resp.headerview);
				
			},error:function(){
				alert("Error");
			}
		});
	});

	// Delete Cart Items
	$(document).on('click','.deleteCartItem',function(){
		var cartid = $(this).data('cartid');
		var result = confirm('Bạn có chắc chắn xóa mặt hàng này trong giỏ hàng không ?');
		if(result){
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {cartid :cartid},
				url:'/cart/delete',
				type: 'post',
				success:function(resp){
					$(".totalCartItems").html(resp.totalCartItems);
					$("#appendCartItems").html(resp.view);
					$("#appendHeaderCartItems").html(resp.headerview);
				},error:function(){
					alert("Error");
				}
			});
		}

	});

	// Register Form Validation
	$("#registerForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/register",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors, function(i,error){
						$("#register-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#register-"+i).html(error);
						setTimeout(function(){
							$("#register-"+i).css({display: 'none'})
						},3000)
					});
				}else if(resp.type=="success"){
					// alert(resp.message);	
					$(".loader").hide();
					$("#register-success").attr('style','color:green;font-size:15px;margin-top:5px');
					$("#register-success").html(resp.message);
				}				
			},error:function(){
				alert("Error");
			}
		})
	});

	// Account Form Validation
	$("#accountForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/account",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors, function(i,error){
						$("#account-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#account-"+i).html(error);
						setTimeout(function(){
							$("#account-"+i).css({display: 'none'})
						},3000)
					});
				}else if(resp.type=="success"){
					// alert(resp.message);	
					$(".loader").hide();
					$("#account-success").attr('style','color:green;font-size:15px;margin-top:5px');
					$("#account-success").html(resp.message);
					setTimeout(function(){
						$("#account-success").css({display: 'none'})
					},3000)
				}				
			},error:function(){
				alert("Error");
			}
		})
	});

	// Update Password Form Validation
	$("#passwordForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/update-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors, function(i,error){
						$("#password-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#password-"+i).html(error);
						setTimeout(function(){
							$("#password-"+i).css({display: 'none'})
						},3000)
					});
				}
				else if(resp.type=="incorrect"){
					$(".loader").hide();
					$("#password-error").attr('style','color:red;font-size:15px;margin-top:5px');
					$("#password-error").html(resp.message);
					setTimeout(function(){
						$("#password-error").css({display: 'none'})
					},3000)
				}else if(resp.type=="success"){
					// alert(resp.message);	
					$(".loader").hide();
					$("#password-success").attr('style','color:green;font-size:15px;margin-top:5px');
					$("#password-success").html(resp.message);
					setTimeout(function(){
						$("#password-success").css({display: 'none'})
					},3000)
				}				
			},error:function(){
				alert("Error");
			}
		})
	});

	// Forgot Password Form Validation
	$("#forgotForm").submit(function(){
		$(".loader").show();
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/forgot-password",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$(".loader").hide();
					$.each(resp.errors, function(i,error){
						$("#forgot-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#forgot-"+i).html(error);
						setTimeout(function(){
							$("#forgot-"+i).css({display: 'none'})
						},3000)
					});
				}else if(resp.type=="success"){
					// alert(resp.message);	
					$(".loader").hide();
					$("#forgot-success").attr('style','color:green;font-size:15px;margin-top:5px');
					$("#forgot-success").html(resp.message);
				}				
			},error:function(){
				alert("Error");
			}
		})
	});

	// Login Form Validation
	$("#loginForm").submit(function(){
		var formdata = $(this).serialize();
		$.ajax({
			url:"/user/login",
			type:"POST",
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors, function(i,error){
						$("#login-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#login-"+i).html(error);
						setTimeout(function(){
							$("#login-"+i).css({display: 'none'})
						},3000)
					});
				}else if(resp.type=="incorrect"){
					// alert(resp.message);
					$("#login-error").attr('style','color:red;font-size:15px;margin-top:5px');
					$("#login-error").html(resp.message);
				}else if(resp.type=="inactive"){
					// alert(resp.message);
					$("#login-error").attr('style','color:red;font-size:15px;margin-top:5px');
					$("#login-error").html(resp.message);
				}else if(resp.type=="success"){
					window.location.href = resp.url;
				}									
			},error:function(){
				alert("Error");
			}
		})
	});

	//Apply Coupon
    $('#ApplyCoupon').submit(function(){
        var user = $(this).attr('user');
        if (user==1){
        }else{
            alert('Vui lòng Đăng nhập để áp dụng Phiếu giảm giá!');
            return false;
        }
        var code = $('#code').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            data:{code:code},
            url:'/apply-coupon',
            success:function(resp){
                if(resp.message!=""){
                    alert(resp.message);
                }
                $('.totalCartItems').html(resp.totalCartItems);
                $('#appendCartItems').html(resp.view);
                $('#appendHeaderCartItems').html(resp.headerview);
				if(resp.couponAmount){
					$(".couponAmount").text(Intl.NumberFormat('vi-VN').format(resp.couponAmount)+" đ");
				}else{
					$(".couponAmount").text("0đ")
				}
				if(resp.grand_total){
					$(".grand_total").text(Intl.NumberFormat('vi-VN').format(resp.grand_total)+" đ")
				}
            },error:function(){
                alert("Error");
            }
        })
    });

	$(document).on('click','.editAddress',function(){
		var addressid = $(this).data("addressid");
		$.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			data: {addressid:addressid},
			url:'/get-delivery-address',
			type:'post',
			success: function(resp){
				$('#showdifferent').removeClass('collapse');
				$('.newAddress').hide();
				$('.deliveryText').text('Edit Delivery Address');
				$('[name=delivery_id]').val(resp.address['id']);
				$('[name=delivery_name]').val(resp.address['name']);
				$('[name=delivery_address]').val(resp.address['address']);
				$('[name=delivery_city]').val(resp.address['city']);
				$('[name=delivery_state]').val(resp.address['state']);
				$('[name=delivery_country]').val(resp.address['country']);
				$('[name=delivery_pincode]').val(resp.address['pincode']);
				$('[name=delivery_mobile]').val(resp.address['mobile']);			
			},error: function(){
				alert('Error');
			}
		});
	});
	
	// Save Delivery Address
	$(document).on('submit','#addressAddEditForm',function(){
		var formdata = $('#addressAddEditForm').serialize();
		$.ajax({
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			url:'/save-delivery-address',
			type:'post',
			data:formdata,
			success:function(resp){
				if(resp.type=="error"){
					$.each(resp.errors, function(i,error){
						$("#delivery-"+i).attr('style','color:red;font-size:15px;margin-top:5px');
						$("#delivery-"+i).html(error);
						setTimeout(function(){
							$("#delivery-"+i).css({display: 'none'})
						},3000)
					});
				}else{
					$('#deliveryAddresses').html(resp.view);
					$("#editDelivery-success").html("Cập nhật địa chỉ giao hàng thành công!"); 
					setTimeout(() => {
						$("#editDelivery-success").hide();
				}, 	3000);
				}	
			},error:function(){
				alert('Error');
			}
		})
	});

	$(document).on('submit','#checkoutForm',function(){
		var addressid = $('[name=address_id]:checked').val();
		$('#address_id').val(addressid);
	});

	$(document).on('click','.deleteAddress',function(){
		var result = confirm('Are you sure want to delete')
		if(!result) {
			return false;
		}else{
			$("#editDelivery-success").html("Đã xóa địa chỉ giao hàng thành công!"); 
				setTimeout(() => {
					$("#editDelivery-success").hide();
			}, 3000)
		}
	});
});

function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}




