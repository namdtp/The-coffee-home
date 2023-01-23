<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //Admin Login Route
    Route::match(['get','post'],'login','AdminController@login');

    Route::group(['middleware'=>['admin']],function(){

        //Admin Dashboard Route
        Route::get('dashboard','AdminController@dashboard');
        
        //Update Admin Password Route
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

        //Update Admin Password Route
        Route::post('check-admin-password','AdminController@checkAdminPassword');

        // Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        //Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');
        
        // View Admins / Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        // View Vendor Details
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

        // Update Admin Status
        Route::post('update-admin-status','AdminController@updateAdminStatus');
        
        //Admin Logout
        Route::get('logout','AdminController@logout');
        
        //Sections
        Route::get('sections','SectionController@sections');
        // Update Section Status
        Route::post('update-section-status','SectionController@updateSectionStatus');
        // Delete Section
        Route::get('delete-section/{id}','SectionController@deleteSection');
        // Add-Edit Section
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

          //Brands
        Route::get('brands','BrandController@brands');
        // Update Brands Status
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        // Delete Brands
        Route::get('delete-brand/{id}','BrandController@deleteBrand');
        // Add-Edit Brands
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        //Categories
        Route::get('categories','CategoryController@categories');
        // Update Categories Status
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        //Add-Edit-Category
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        // Level Category
        Route::get('append-categories-level','CategoryController@appendCategoriesLevel');
        // Delete category
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        //
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        
        // Products
        Route::get('products','ProductsController@products');
        // Update Categories Status
        Route::post('update-product-status','ProductsController@updateProductStatus');
        // Delete product
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        // Add-Edit
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        //
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        // Attributes
        Route::match(['get','post'],'add-edit-attributes/{id}','ProductsController@addAttributes');
        // Update Attributes Status
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        // Delete Attributes
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        // Filters
        Route::get('filters', 'FilterController@filters');
        Route::get('filters-values', 'FilterController@filtersValues');
        Route::post('update-filter-status','FilterController@updateFilterStatus');
        Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');
        Route::match (['get', 'post'], 'add-edit-filter/{id?}', 'FilterController@addEditFilter');
        Route::match (['get', 'post'], 'add-edit-filter-value/{id?}', 'FilterController@addEditFilterValue');
        Route::post('category-filters', 'FilterController@categoryFilters');

        // Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::post('update-image-status','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteImage');

        // Banners
        Route::get('banners','BannersController@banners');
        Route::post('update-banner-status','BannersController@updateBannerStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');     
         
        // Coupons
        Route::get('coupons','CouponsController@coupons');
        Route::post('update-coupon-status','CouponsController@updateCouponStatus');
        Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');
        Route::match(['get','post'],'add-edit-coupon/{id?}','CouponsController@addEditCoupon');

        // User
        Route::get('users','UserController@users');
        Route::post('update-user-status','UserController@updateUserStatus');

        // Orders
        Route::get('orders','OrdersController@orders');
        Route::get('orders/{id}','OrdersController@orderDetails');
        Route::post('update-order-status','OrdersController@updateOrderStatus');
        Route::get('view-order-invoice/{id}','OrdersController@viewOrderInvoice');
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');

    // Listing/Categories Routes
    $carUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach($carUrls as $key => $url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing'); 
    }

    // Vendor Products
    Route::get('/products/{vendorid}', 'ProductsController@vendorListing');

    // Product Details Page
    Route::get('/product/{id}', 'ProductsController@detail');

    // Get product attribute price
    Route::post('get-product-price', 'ProductsController@getProductPrice');
    
    // Vendor Login/Register
    Route::get('vendor/login-register', 'VendorController@loginRegister');

    //vendor register 
    Route::post('vendor/register','VendorController@vendorRegister');

    // Confirm Vendor Account
    Route::get('vendor/confirm/{code}', 'VendorController@confirmVendor');

    // Add to cart
    Route::post('cart/add', 'ProductsController@cartAdd');

    // Cart routes
    Route::get('cart','ProductsController@cart');

    // Update Cart
    Route::post('cart/update','ProductsController@cartUpdate');

    // Delete Cart
    Route::post('cart/delete','ProductsController@cartDelete');

    // User Login/Register
    Route::get('user/login-register',['as'=>'login','uses'=>'UserController@loginRegister']);

    // User Register
    Route::post('user/register', 'UserController@userRegister');

    Route::group(['middleware'=>['auth']],function(){
         // User Account
        Route::match(['get','post'],'user/account', 'UserController@userAccount');

        // Users Orders
        Route::get('/orders', 'OrdersController@orders');

        // User Order Details
        Route::get('/orders/{id}', 'OrdersController@orderDetails');

        // User Update Password
        Route::post('user/update-password', 'UserController@userUpdatePassword');

        // Appyly Coupon
        Route::post('/apply-coupon','ProductsController@applyCoupon');  

        // Checkout
        Route::match (['get', 'post'], '/checkout','ProductsController@checkout');

        // Get Delivery Address
        Route::post('get-delivery-address', 'AddressController@getDeliveryAddress');

        // Save Delivery Address
        Route::post('save-delivery-address', 'AddressController@saveDeliveryAddress');

        // Delete Delivery Address
        Route::get('delete-delivery-address/{id}', 'AddressController@deleteDeliveryAddress');

        // Thanks
        Route::get('thanks', 'ProductsController@thanksUser');
    }); 
    // User Login
    Route::post('user/login', 'UserController@userLogin');

    // User forgot password
    Route::match(['get','post'],'user/forgot-password', 'UserController@forgotPassword');

    // User Logout
    Route::get('user/logout','UserController@userLogout');

    // Confirm user account
    Route::get('user/confirm/{code}', 'UserController@confirmAccount');

    // About
    Route::get('about', 'AboutController@about');
    // Terms
    Route::get('term', 'TermController@term');
    // Contact
    Route::get('contact', 'ContactController@contact');
    // FAQ
    Route::get('faq', 'FaqController@faq');
    
});

