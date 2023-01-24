<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductsFilter;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use Session;
use Auth;
use Image;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Tài khoản nhà cung cấp của bạn không được phê duyệt
                chưa. Vui lòng đảm bảo điền thông tin cá nhân, doanh nghiệp và ngân hàng hợp lệ của bạn');
            }
        }
        $products = Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        if($adminType=="vendor"){
            $products = $products->where('vendor_id', $vendor_id);
        }
        $products = $products->get()->toArray();
        // dd($products);
        return view('admin.products.products')->with(compact('products'));
    }
    // Update Status Product
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;                
            }else{
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }
    //Delete Product
    public function deleteProduct($id){
        // Delete Product
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully!";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product has been added successfully!";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product updated successfully!";
        }
        
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^\w+$/',      
                'product_price' => 'required|numeric',
                'product_type' => 'required',                 
            ];            

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Vaild Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Vaild Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.regex' => 'Vaild Product Price is required',
                'product_type.required' => 'Product Type is required',
            ];
            $this->validate($request,$rules,$customMessages);

               // Upload Product Photo Resize small: 250x250 medium 500x500 large 1000x1000              
               if($request->hasFile('product_image')){
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload Image
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    //Insert Img Name in product table
                    $product->product_image = $imageName;
                }
            }
            
            // Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()){
                    //Upload Video in folder
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111,99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    //Upload Video in table
                    $product->product_video = $videoName;
                }
            }

            $categoriesDetails = Category::find($data['category_id']);
            $product->section_id = $categoriesDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->group_code = $data['group_code'];

            $productFilters = ProductsFilter::productFilters();
            foreach ($productFilters as $filter) {
                // echo $data[$filter['filter_column']];
                // die;
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                if($filterAvailable=="Yes"){
                    if(isset($filter['filter_column']) && $data[$filter['filter_column']]){
                        $product->{$filter['filter_column']} = $data[$filter['filter_column']];
                    }
                }
            }

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if($adminType=="vendor"){
                $product->vendor_id = $vendor_id;               
            }else{
                $product->vendor_id = 0;
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }
            
            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_type = $data['product_type'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            if(!empty($data['is_bestseller'])){
                $product->is_bestseller = $data['is_bestseller'];
            }else{
                $product->is_bestseller = "No";
            }
            $product->status = 1;
            $product->save();

            return redirect('admin/products')->with('success_message', $message);


        }

        //Get sections with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        // Get all brands
        $brands = Brand::where('status',1)->get()->toArray();

        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }

    public function deleteProductImage($id){
        //Get product image
        $productImage = Product::select('product_image')->where('id',$id)->first();

        //Get product image path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //Delete product small image
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }
        //Delete product medium image
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }
        //Delete product large image
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }
        //Delete product image product table
        Product::where('id',$id)->update(['product_image'=>'']);

        $message = "Product IMG has been deleted successfully!";

        return redirect()->back()->with('success_message',$message);
    }

    public function deleteProductVideo($id){
        //Get product video
        $productVideo = Product::select('product_video')->where('id',$id)->first();
        
        // Get product video paths
        $product_video_path = 'front/videos/product_videos/';

        //Delete product video form folder
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }
        //Delete  product video form tables
        Product::where('id',$id)->update(['product_video' => ""]);    

        $message = "Product Video has been deleted successfully!";

        return redirect()->back()->with('success_message',$message);
    }

    public function addAttributes(Request $request, $id){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_type','product_price','product_image')->with('attributes')->find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            foreach ($data['sku'] as $key => $value) {
                if(!empty($value)){
                    
                    //SKU duplicated check
                    $skuCount = ProductsAttribute::where('sku',$value)->count();
                    if($skuCount>0){ 
                        return redirect()->back()->with('error_message','SKU already exists! Please add another SKU!');
                    }

                     //Size duplicated check
                     $sizeCount = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                     if($sizeCount>0){ 
                        return redirect()->back()->with('error_message','Size already exists! Please add another Size!');
                    }
                    $attributes = new ProductsAttribute;
                    $attributes->product_id = $id;
                    $attributes->sku = $value;
                    $attributes->size = $data['size'][$key];
                    $attributes->price = $data['price'][$key];
                    $attributes->stock = $data['stock'][$key];
                    $attributes->status = 1;
                    $attributes->save();
                }           
            }
            return redirect()->back()->with('success_message','Product Attributes has been added successfully');
        }
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;                
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function editAttributes(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach ($data['attributeId'] as $key => $attribute){
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=>$data['price'][$key],
                    'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Product Attributes has been updated successfully');
        }
    }

    public function addImages($id,Request $request){
        Session::put('page','products');
        $product = Product::select('id','product_name','product_code','product_type','product_price','product_image')->with('images')->find($id);
        
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "<pre>"; print_r($images); die;
                foreach ($images as $key => $image){      
                    //Generate temp image
                    $image_tmp = Image::make($image);
                    // Get Image name
                    $image_name = $image->getClientOriginalName();              
                    //Get Image Extension
                    $extension = $image->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = $image_name.rand(111,99999).'.'.$extension;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
                    // Upload Image
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    //Insert Img Name in product table
                    $image = new  ProductsImage;
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    $image->save();
                }
            }       
            return redirect()->back()->with('success_message','Product Images have been added successfully');      
        }

        return view('admin.images.add_images')->with(compact('product'));
    }
    // Update Status Attribute
    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;                
            }else{
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id){
        //Get product image
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        //Get product image path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //Delete product small image
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        //Delete product medium image
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        //Delete product large image
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }
        //Delete product image product table
        ProductsImage::where('id',$id)->delete();

        $message = "Product IMG has been deleted successfully!";

        return redirect()->back()->with('success_message',$message);
    }
    
}
