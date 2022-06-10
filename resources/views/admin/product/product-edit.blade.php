@extends('layouts.admin-master')
@section('title', 'Edit Post')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
  
@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/ad-post.css">
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .packageBox{cursor: pointer;  border: 2px solid #bdbdbd;border-radius: 16px;padding: 10px;margin-bottom: 10px !important;width: 100%;}
    .packageValue{border: 1px solid #a3dca2; border-radius: 16px;padding: 3px 10px;margin-bottom: 5px; color: #279625;}
    .form-check-list li{display: inline-flex;margin-left: 10px;}
    .adjust-field{border: none;border-radius:0;position: absolute;top: 0;right: 0;background: #e9ecef;padding: 7px;}

    .adpost-plan-list input[type="radio"]:checked + label { border-color: #3db83a; }

    .packageValueList input[type="radio"]:checked + label {background-color: #a3dca2;color: #279625;}
    .adpost-plan-list input[type="radio"]{display: none;}
.dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }

.image .col-md-2{width: 20% !important;}
.dropify-wrapper{height: 125px;padding: 5px;}
  .fa-check-square{color: green;}
  .addNumber{position: relative;margin-right: 10px;width: 320px;border-bottom: 1px solid #e5e5e5;padding: 5px;}
  .removeNumber{color:red;padding: 3px 5px

</style>

@endsection

@section('content')

    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Edit post</h4>
                </div>
                
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div id="pageLoading"></div>
                <div class="card-body">
                     @if($product->status == 'reject')
                    <div class="alert alert-danger alert-dismissible">{{ $product->reject_reason }}</div>
                    @endif
                    <form action="{{ route('post.update',$product->id) }}" data-parsley-validate method="post" enctype="multipart/form-data" class="adpost-form">
                        @csrf
                        <div class="adpost-card">
                            <div class="adpost-title">
                                <h3>Ad Information</h3>
                            </div>

                            <div id="pageLoading"></div>
                           
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="required">Product Title</label>
                                        <input name="title" required value="{{$product->title}}" type="text" class="form-control" placeholder="Type your product title here">
                                    </div>
                                </div>


                                
                                @if(count($chilcategories)>0)
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class=" required">Type</label>
                                        <select name="childcategory_id" class="form-control">
                                            <option value="">Select Type</option>
                                            @foreach($chilcategories as $childcategory)
                                            <option @if($product->childcategory_id == $childcategory->id) selected @endif value="{{$childcategory->id}}">{{$childcategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                @foreach($attributes as $attribute)
                                <input type="hidden" name="attribute[{{$attribute->id}}]" value="{{$attribute->name}}">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label class="@if($attribute->is_required == 1) required @endif">{{$attribute->name}}</label>
                                        @if($attribute->display_type == 1)
                                            @if(count($attribute->get_attrValues)>0)
                                            <ul class="form-check-list">
                                                @foreach($attribute->get_attrValues as $value)
                                                <li>
                                                    <input name="attributeValue[{{$attribute->id}}][]" @if($attribute->is_required == 1) required @endif @if($value->get_productVariant) checked @endif value="{{$value->id}}" type="checkbox" class="form-check" id="attributeValue{{$value->id}}">
                                                    <label for="attributeValue{{$value->id}}" class="form-check-text">{{$value->name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        @elseif($attribute->display_type == 3)
                                        @if(count($attribute->get_attrValues)>0)
                                            <ul class="form-check-list">
                                                @foreach($attribute->get_attrValues as $value)
                                                <li>
                                                    <input name="attributeValue[{{$attribute->id}}][]" @if($value->get_productVariant) checked @endif @if($attribute->is_required == 1) required @endif value="{{$value->id}}" type="radio" class="form-check" id="attributeValue{{$value->id}}">
                                                    <label for="attributeValue{{$value->id}}" class="form-check-text">{{$value->name}}</label>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif

                                        @else
                                        <select class="form-control" @if($attribute->is_required == 1) required @endif name="attributeValue[{{$attribute->id}}][]">
                                            @if($attribute->get_attrValues)
                                                @if(count($attribute->get_attrValues)>0)
                                                    <option value="">Select one</option>
                                                    @foreach($attribute->get_attrValues as $value)
                                                        <option @if($value->get_productVariant) selected @endif value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Value Not Found</option>
                                                @endif
                                            @endif
                                        </select>
                                        @endif

                                    </div>
                                </div>
                                @endforeach
                                
                                <div class="col-md-12" @if(count($features) <= 0) style="display:none" @endif>
                                    <!-- Allow attribute checkbox button -->
                                    <label class="form-label">Product Features</label>
                                   

                                    <div class="row">
                                        @foreach($features as $feature)
                                        <div style="margin-bottom:10px;" class="col-4 @if($feature->is_required) required @endif col-sm-2 text-right col-form-label">{{$feature->name}}
                                        <input type="hidden" value="{{$feature->name}}" class="form-control" name="features[{{$feature->id}}]"></div>
                                        <div class="col-8 col-sm-4">
                                            <input @if($feature->is_required) required @endif type="text" name="featureValue[{{$feature->id}}]" value="{{ ($feature->featureValue) ? $feature->featureValue->value : null}}" class="form-control" placeholder="Input value here">
                                        </div>
                                        @endforeach
                                    </div>

                                    <div id="PredefinedFeatureBycategory"></div>
                                    <div id="PredefinedFeatureBySubcategory"></div>
                                   
                                </div>

                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="">Product image</label>
                                        <div class="row image" style="padding: 0 10px">

                                            <div class="col-6 col-md-2" style="padding: 5px;">
                                                <input type="file" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" name="feature_image" class="dropify" data-default-file="{{asset('upload/images/product/thumb/'.$product->feature_image)}}" @if(!$product->feature_image) required @endif  accept="image/*" >
                                            </div>

                                            @foreach($product->get_galleryImages as $galleryImage)

                                            <div class="col-6 col-md-2" style="padding: 5px;">
                                               <input type="file" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M"  name="gallery_image[{{$galleryImage->id}}]" class="dropify" data-default-file="{{asset('upload/images/product/gallery/'.$galleryImage->image_path)}}" accept="image/*" >
                                            </div>

                                            @endforeach
                                            @for($i=count($product->get_galleryImages); $i<5; $i++)
                                            <div class="col-6 col-md-2" style="padding: 5px;">
                                               <input type="file" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" name="gallery_image[]" class="dropify" data-default-file="{{asset('upload/images/product/default.jpg')}}" accept="image/*" >
                                            </div>
                                           
                                            @endfor
                                        </div>
                                         <div class="form-group"><i style="color:red;font-size: 11px">Supported formats are jpg,gif,png (Max picture size 5 Mb)</i></div>
                                    </div>
                                   
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="required">ad description</label>
                                        <textarea name="description" required class=" form-control" rows="4" maxlength="5000" placeholder="Describe your message">{!! $product->description !!}</textarea>
                                        <p>Max 5000 character</p>
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="required">Division</label>
                                        <select required name="state_id" onchange="get_city(this.value)" class="form-control custom-select">
                                            <option selected>Select Location</option>
                                            @foreach($regions as $region)
                                            <option @if($product->state_id == $region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="required">City</label>
                                        <select required name="city_id" id="city_id" class="form-control custom-select">
                                            <option selected>Select City</option>
                                            @foreach($cities as $city)
                                            <option @if($product->city_id == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class=" required">Price</label>
                                    <div class="form-group" style="position: relative;">
                                        <input name="price" value="{{$product->price}}" required type="number" class="form-control" placeholder="Enter your pricing amount">

                                        <span class="adjust-field">
                                            <input id="negotiable" @if($product->negotiable == 1) checked @endif name="negotiable" type="checkbox" value="1">&nbsp;
                                            <label for="negotiable"><small>Negotiable</small></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="required">Search Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</label>

                                         <div class="tags-default">
                                            <input  type="text" name="meta_keywords[]" value="{{ $product->meta_keywords }}" data-role="tagsinput" placeholder="Enter search keywords" />
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="adpost-card">
                            <div class="adpost-title">
                                <h3>Author Information</h3>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="required">Name</label>
                                        <input type="text" required name="contact_name" value="{{($product->contact_name ? $product->contact_name : Auth::user()->name )}}" class="form-control" placeholder="Your Name">
                                    </div>
                                </div>
                               
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        @foreach(json_decode($product->contact_mobile) as $number)
                                        <div id="mobileNumber">
                                            <div id="{{ $number }}" class="addNumber">
                                            <input type="hidden" name="contact_mobile[]" value="{{ $number }}">
                                            <i class="fa fa-check-square"></i> <strong>{{ $number }} </strong><a class="removeNumber" href="javascript:void(0)" onclick="removeNumber('{{ $number }}')" title="Remove phone number">✕
                                            </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        <span id="moreMobile"><a onclick="moreMobile()" href="javascript:void(0)">Add another mobile number</a></span>
                                    </div>
                                    
                                    <label><input id="contact_hidden" @if($product->contact_hidden == 1) checked @endif name="contact_hidden" type="checkbox" value="1"> Hide mobile number(s)</label>
                                </div>
                            </div>
                            <div class="row offset-md-2">
                                <div class="col-md-8">
                                <div class="form-group text-right">
                                    <button style="width: 100%;" class="btn btn-success">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Update Your Ad</span>
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>
                       
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection
@section('js')
<script src="{{ asset('js/parsley.min.js') }}"></script>
<script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });
</script>
<script type="text/javascript">

    function get_city(id){
       
        var  url = '{{route("get_city", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#city_id").html(data);
                }else{
                    $("#city_id").html('<option>City not found</option>');
                }
            }
        });
    } 
    // Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });

</script>

<script type="text/javascript">
    function packageBox(id, price){
        $("#packagePrice"+id).html(price);
        $(".package").prop("checked", false);
        $('#package'+id).prop('checked', true);
    }
</script>

</script>
<script>
 
    var number = 1;
    do {
      function showPreview(event, number){
        if(event.target.files.length > 0){
        if((event.target.files[0].size/1000) <= 5120 ){
          let src = URL.createObjectURL(event.target.files[0]);
          let preview = document.getElementById("file-ip-"+number+"-preview");
          preview.src = src;
          preview.style.display = "block";
            $('#'+number).html('');
        }else{
            $('#'+number).html('<span style="font-size:12px;color:red"> Image size max 5MB</span>');
        }
        }
      }
      function myImgRemove(number) {
          document.getElementById("file-ip-"+number+"-preview").src = "{{asset('upload/images/product/default.jpg')}}";
          document.getElementById("file-ip-"+number).value = null;
        }
      number++;
    }
    while (number < 5);


    function moreMobile(number=null){
       
        $('#moreMobile').html(`
        <div style="display:flex; margin-bottom: 10px;">
        <div>
        Add mobile number
        <div style="position: relative;margin-right: 10px;width: 300px;">
        <input type="number" id="number" value="`+number+`" required name="contact_mobile" class="form-control" placeholder="Enter your number">
        <span class="adjust-field" onclick="addNumber()"> Add</span>
        </div>
        </div>
        </div>`);
    }
    function addNumber(){
       var number = $('#number').val();
        if(number){
        $.ajax({
            url:"{{route('addNumber')}}",
            method:'get',
            data:{number:number},
            success:function(data){
                $('#moreMobile').html(data);
            }
        });
        }
    }

    function verifyNumber(number){

       var otp = $('#otp').val();
        if(otp){
        $.ajax({
            url:"{{route('verifyNumber')}}",
            method:'get',
            data:{otp:otp,number:number},
            success:function(data){
                if(data.status){
                    $('#mobileNumber').append(data.number);
                    $('#moreMobile').html('<a onclick="moreMobile()" href="javascript:void(0)">Add another mobile number</a>')
                }else{
                    $('#optmsg').html('<span style="color:red">Invalid otp code.</span>')
                }
            }
        });
        }else{
            $('#optmsg').html('<span style="color:red">Please enter otp</span>')
        }
    }


    function removeNumber(number) {
       $('#'+number).remove();
    }
    </script>
@endsection