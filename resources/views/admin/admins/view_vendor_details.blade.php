@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-md-12 grid-margin">
            <div class="row">
               <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Vendor Details</h3>
                  <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendor') }}" >Back To Vendors</a></h6>
               </div>
               <div class="col-12 col-xl-4">
                  <div class="justify-content-end d-flex">
                     <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                           <a class="dropdown-item" href="#">January - March</a>
                           <a class="dropdown-item" href="#">March - June</a>
                           <a class="dropdown-item" href="#">June - August</a>
                           <a class="dropdown-item" href="#">August - November</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> 
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Personal Information</h4>                                             
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                    </div>           
                    <div class="form-group">    
                      <label for="vendor_name">Name</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['name'] }}" readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_address">Address</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['address'] }}"  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_city">City</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['city'] }}"  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_state">State</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['state'] }}" readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_country">Country</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['country'] }}" readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_pincode">Pincode</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['pincode'] }}" readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_mobile">Mobile</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['mobile'] }}" readonly="">
                    </div> 
                    @if(!empty($vendorDetails['image']))
                    <div class="form-group">    
                      <label for="vendor_image">Avatar</label>
                      <br /><img style="width: 200px;" src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}"/>  
                    </div>                          
                    @endif
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Business Information</h4>                                                     
                    {{-- <div class="form-group">    
                      <label for="vendor_name">Shop Name</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_name']))  value="{{ $vendorDetails['vendor_business']['shop_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_address">Shop Address</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_address'])) value="{{ $vendorDetails['vendor_business']['shop_address'] }}" @endif  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_city">Shop City</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_city'])) value="{{ $vendorDetails['vendor_business']['shop_city'] }}" @endif  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_state">Shop State</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_state'])) value="{{ $vendorDetails['vendor_business']['shop_state'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_country">Shop Country</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_country'])) value="{{ $vendorDetails['vendor_business']['shop_country'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_pincode">Shop Pincode</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_pincode'])) value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_mobile">Shop Mobile</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_mobile'])) value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}" @endif readonly="">
                    </div> 
                    <div class="form-group">    
                      <label for="vendor_mobile">Shop Website</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_website'])) value="{{ $vendorDetails['vendor_business']['shop_website'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_mobile">Shop Email</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['shop_email'])) value="{{ $vendorDetails['vendor_business']['shop_email'] }}" @endif readonly="">
                    </div>  
                    <div class="form-group">    
                      <label for="vendor_mobile">Address Proof</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['address_proof'])) value="{{ $vendorDetails['vendor_business']['address_proof'] }}" @endif readonly="">
                    </div>       
                    <div class="form-group">    
                      <label for="vendor_mobile">Business License Number</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['business_license_number'])) 
                      value="{{ $vendorDetails['vendor_business']['business_license_number'] }}" @endif readonly="">
                    </div> 
                    <div class="form-group">    
                      <label for="vendor_mobile">GST Number</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['gst_number'])) value="{{ $vendorDetails['vendor_business']['gst_number'] }}" @endif readonly="">
                    </div> 
                    <div class="form-group">    
                      <label for="vendor_mobile">PAN Number</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_business']['pan_number'])) value="{{ $vendorDetails['vendor_business']['pan_number'] }}" @endif readonly="">
                    </div>              
                    @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                    <div class="form-group">    
                      <label for="vendor_image">Address Proof Image</label>
                      <br /><img style="width: 200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}"/>                  
                    </div>                           --}}
                    @endif                   
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bank Information</h4>                                                     
                    <div class="form-group">    
                      <label for="vendor_name">Account Holder Name</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_bank']['account_holder_name'])) value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_address">Bank Name</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_bank']['bank_name'])) value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" @endif  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_city">Account Number</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_bank']['account_number'])) value="{{ $vendorDetails['vendor_bank']['account_number'] }}" @endif  readonly="">
                    </div>
                    <div class="form-group">    
                      <label for="vendor_state">IFSC Code</label>
                      <input type="text" class="form-control" 
                      @if(isset($vendorDetails['vendor_bank']['bank_ifsc_code'])) value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}" @endif readonly="">
                    </div>                           
                </div>
              </div>
            </div>
      </div>
   </div>
   <!-- content-wrapper ends -->
   <!-- partial:partials/_footer.html -->
   @include('admin.layout.footer')
   <!-- partial -->
</div>

@endsection