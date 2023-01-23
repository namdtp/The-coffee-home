@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->

<!-- Page Introduction Wrapper /- -->
<!-- Shop-Page -->
<div class="page-shop u-s-p-t-80">
    <div class="container">
        <!-- Shop-Intro -->
        <div class="shop-intro">
            <ul class="bread-crumb">
                <li class="has-separator">
                <a href="{{ url('/') }}">Trang Chủ</a>
                </li>
                <?php echo $categoryDetails['breadcrumbs']; ?>
            </ul>
        </div>
        <!-- Shop-Intro /- -->
        <div class="row">
            <!-- Shop-Left-Side-Bar-Wrapper -->
            @include('front.products.filters')
            <!-- Shop-Left-Side-Bar-Wrapper /- -->
            <!-- Shop-Right-Wrapper -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!-- Page-Bar -->
                <div class="page-bar clearfix">
                <!-- <div class="shop-settings">        
                    <a id="list-anchor">
                    <i class="fas fa-th-list"></i>
                    </a> 
                    <a id="grid-anchor" class="active">
                    <i class="fas fa-th"></i>
                    </a>                  
                </div> -->
                <!-- Toolbar Sorter 1  -->
                {{-- <form name="sortProducts" id="sortProducts">
                    <input type="hidden" name="url" id="url" value="{{ $url }}">
                    <div class="toolbar-sorter">
                        <div class="select-box-wrapper">
                            <label class="sr-only" for="sort-by">Sắp Theo Xếp:</label>
                            <select name="sort" id="sort" class="select-box">
                                <!-- <option selected="selected" value="">Sort By: Best Selling</option> -->
                                <option selected="" value="">Chọn Cách Sắp Xếp</option>
                                <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort'] == 'product_latest') selected="" @endif>
                                    Sắp Theo: Mới Nhất</option>
                                <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort'] == 'price_lowest') selected="" @endif>
                                    Sắp Theo: Giá Thấp đến Cao</option>
                                <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort'] == 'price_highest') selected="" @endif>
                                    Sắp Theo: Giá Cao đến Thấp</option>
                                <option value="name_a_z" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_a_z') selected="" @endif>
                                    Sắp Theo: A - Z</option>
                                <option value="name_z_a" @if(isset($_GET['sort']) && $_GET['sort'] == 'name_z_a') selected="" @endif>
                                    Sắp Theo: Z - A</option>
                                <!-- <option value="">Sort By: Best Rating</option> -->
                            </select>
                        </div>
                    </div>
                </form> --}}
                <!-- //end Toolbar Sorter 1  -->
                <!-- Toolbar Sorter 2  -->
                <!-- <div class="toolbar-sorter-2">
                    <div class="select-box-wrapper">
                        <label class="sr-only" for="show-records">Show Records Per Page</label>
                        <select class="select-box" id="show-records">
                            <option selected="selected" value="">Show: 8</option>
                            <option value="">Show: 16</option>
                            <option value="">Show: 28</option>
                        </select>
                    </div>
                </div> -->
                {{-- <div class="toolbar-sorter-2">
                    <div class="select-box-wrapper">
                        <label class="sr-only" for="show-records">Show Records Per Page</label>
                        <select class="select-box" id="show-records">
                            <option selected="selected" value="">Đang hiển thị: {{ count($categoryProducts) }}</option>
                            <option value="">Hiển thị: Tất Cả</option>
                        </select>
                    </div>
                </div> --}}
                <!-- //end Toolbar Sorter 2  -->
                </div>
                <!-- Page-Bar /- -->
                <!-- Row-of-Product-Container -->
                <div class="filter_products">
                    @include('front.products.ajax_products_listing')
                </div>
                <!-- Row-of-Product-Container /- -->
                @if(isset($_GET['sort']))
                <div class="mb-3">{{ $categoryProducts->appends(['sort'=>$_GET['sort']])->links() }}</div>
                @else
                <div class="mb-3">{{ $categoryProducts->links() }}</div>
                @endif
                <div>{{ $categoryDetails['categoryDetails']['description'] }}</div>
            </div>
            <!-- Shop-Right-Wrapper /- -->
            <!-- Shop-Pagination -->
            <?php /* <div class="pagination-area">
                <div class="pagination-number">
                <ul>
                    <li style="display: none">
                        <a href="shop-v1-root-category.html" title="Previous">
                        <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="active">
                        <a href="shop-v1-root-category.html">1</a>
                    </li>
                    <li>
                        <a href="shop-v1-root-category.html">2</a>
                    </li>
                    <li>
                        <a href="shop-v1-root-category.html">3</a>
                    </li>
                    <li>
                        <a href="shop-v1-root-category.html">...</a>
                    </li>
                    <li>
                        <a href="shop-v1-root-category.html">10</a>
                    </li>
                    <li>
                        <a href="shop-v1-root-category.html" title="Next">
                        <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
                </div>
            </div> */ ?>
            <!-- Shop-Pagination /- -->
        </div>
    </div>
</div>
<!-- Shop-Page /- -->
@endsection