<?php use App\Models\Product; ?>
<div class="row product-container grid-style">
    @foreach($categoryProducts as $product)
    <div class="product-item col-lg-4 col-md-6 col-sm-6">
        <div class="item">
            <div class="image-container">
                <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                @if(!empty($product['product_image']) && file_exists($product_image_path))
                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                @else
                <img class="img-fluid" src="{{ asset('front/images/product/product_images/small/no-image.png') }}" alt="Product">
                @endif
                </a>
            </div>
            <div class="item-content">
                <div class="what-product-is">
                
                <h6 class="item-title">
                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                </h6>
                <div class="item-description">
                    <p>
                        {{ $product['description'] }}
                    </p>
                </div>
                <!-- <div class="item-stars">
                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                        <span style='width:67px'></span>
                    </div>
                    <span>(23)</span>
                    </div> -->
                </div>
                <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                @if($getDiscountPrice>0)
                <div class="price-template">
                <div class="item-new-price">
                    {{ $getDiscountPrice}} VNĐ
                </div>
                    <div class="item-old-price">
                        {{ number_format($product['product_price'],0,'',',') }} VNĐ
                    </div>
                </div>
                @else
                <div class="price-template">
                    <div class="item-new-price">
                        {{ number_format($product['product_price'],0,'',',') }} VNĐ
                    </div>
                </div>
                @endif
            </div>
            <?php $isProductNew = Product::isProductNew($product['id']); ?>
            @if($isProductNew=="Yes")
            <div class="tag new">
                <span>NEW</span>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>