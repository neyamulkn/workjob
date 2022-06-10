 @extends('layouts.frontend')
@section('title', 'Ads Post' )
@section('css')
  <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets')}}/node_modules/wizard/steps.css" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/ad-post.css">
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<style type="text/css">
    
    .labelBox{border: 1px solid #95918f; border-radius: 16px;padding: 3px 10px;margin-bottom: 5px; color: #000;}
   
    .labelArea input[type="checkbox"]:checked + label { border-color: #079b20; }
    .labelArea input[type="checkbox"]:checked + label {background-color: #00fb082e;color: #035a06;}
    .labelArea input[type="checkbox"]{display: none;}

    .labelArea input[type="radio"]:checked + label { border-color: #079b20; }
    .labelArea input[type="radio"]:checked + label {background-color: #00fb082e;color: #035a06;}
    .labelArea input[type="radio"]{display: none;}
    .removeStep{ padding: 3px;font-size: 16px; text-align: center;}


    .dropify_image{ position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;}

</style>
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
 <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Post job</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Post</a></li>
                                <li class="breadcrumb-item active">job</li>
                            </ol>
                            <a href="{{route('myJobs')}}" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Post list</a>
                        </div>
                    </div>
                </div>
            
                <div class="row" id="validation" style="position:relative;">

                    <div class="col-12" >
                         <div id="allpageLoading"></div>
                        <div class="card wizard-content">
                            <div class="card-body">
                                <h4 class="card-title">Step wizard with validation</h4>
                                <h6 class="card-subtitle">You can us the validation like what we did</h6>
                                <form action="{{ route('post.store') }}" id="formSubmit" method="post" enctype="multipart/form-data" class="validation-wizard wizard-circle">
                                    @csrf
                                    <!-- Step 1 -->
                                    <h6>Select Location</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-12 ">

                                                <div class="form-group">
                                                    
                                                <div class="labelArea form-group">
                                                    @foreach($locations as $location)
                                                    <input type="checkbox" class="form-control "  name="location[]" value="{{$location->id}}" id="location{{$location->id}}">
                                                    <label for="location{{$location->id}}" class="labelBox">{{$location->name}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </section>
                                    <!-- Step 2 -->
                                    <h6>Select Category</h6>
                                    <section class="labelArea">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    @foreach($categories as $index => $category)
                                                    <input @if($index == 0) checked @endif onclick ="get_subcategory(this.value)" type="radio"  name="category" value="{{$category->id}}" id="category{{$category->id}}">
                                                    <label  for="category{{$category->id}}" class="labelBox">{{$category->name}}</label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <h4>Select the subcategory</h4>
                                                <div class="form-group" id="subcategory">
                                                    @foreach($subcategories as $subcategory)
                                                    <input type="radio" name="subcategory" value="{{$subcategory->id}}" id="subcategory{{$subcategory->id}}">
                                                    <label for="subcategory{{$subcategory->id}}" class="labelBox">{{$subcategory->name}}</label>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </section>
                                    <!-- Step 3 -->
                                    <h6>Job Information</h6>
                                    <section id="jobInformation">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="required" for="title">Write an accurate job Title</label>
                                                    <input type="text" name="title" required placeholder="Enter your job title" class="form-control required" id="title"> 
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="workstep">What specific tasks need to be Completed</label>
                                                    <textarea name="workstep[]" rows="3" placeholder="Write tasks description" class="form-control workstep" id="workstep"></textarea> 
                                                </div>
                                                <span id="moreStep"></span>
                                                <a onclick="moreStep()" class="btn btn-info btn-sm" href="javascript:void(0)">Add More Step</a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="completed">Required proof the job was completed</label>
                                                    <textarea type="text" name="workProve" rows="3" class="form-control" placeholder="Write description" id="completed"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="wint1">Thumbnail Image(optional)</label>
                                                    <input type="file" data-allowed-file-extensions="jpg jpeg png gif" data-max-file-size="5M" class="dropify" accept="image/*" name="thumb_image">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </section>
                                    <!-- Step 4 -->
                                    <h6>Budget & Setting</h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="behName1">Worker Need</label>
                                                    <input type="number" min="1" name="job_workers_need" class="form-control required" id="behName1">
                                                </div>
                                                <div class="form-group">
                                                    <label for="per_workers_earn">Each worker Earn</label>
                                                    <input type="number" name="per_workers_earn" class="form-control required" id="per_workers_earn">
                                                </div>

                                                <div class="form-group">
                                                    <label for="screenshots">Require Screenshots</label>
                                                    <input type="number" min="0" name="work_screenshots" class="form-control required" id="screenshots">
                                                </div>

                                                <div class="form-group">
                                                    <label for="participants1">Estimated Day</label>
                                                    <input type="text" name="estimated_time" class="form-control required" id="participants1">
                                                </div>
                                              
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" >
                                                <div style="padding: 30px;border: 1px solid #d50707;border-radius: 5px;" >
                                                    <label for="decisions1">Estimated Job Cost</label>
                                                    <input type="number" class="form-control required" id="decisions1">
                                                </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#allpageLoading').hide();
        // Basic
        $('.dropify').dropify();

    });
</script>
<script src="{{ asset('js/parsley.min.js') }}"></script>
<script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".select2").select2();
</script>
<script type="text/javascript">
    
    function get_subcategory(id){
       var  url = '{{route("post.getSubCategory", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#subcategory").html(data);
                }else{
                    $("#subcategory").html('Sub category not found.');
                }
                
            }
        });
    }   

    function moreStep(number=null){
        var steps = document.querySelectorAll('.workstep').length;

        $('#moreStep').append(`
        <div id="step`+steps+`" style="margin-bottom: 8px;">
        <a class="removeStep" href="javascript:void(0)" onclick="removeStep(`+steps+`)" title="Remove work step">Step `+steps+` ✕</a>
        <textarea name="workstep[]" rows="3" class="form-control workstep" placeholder="Write step `+steps+` description"></textarea> 
        
        </div>
        </div>
        </div>`);
    }

    function removeStep(number) {
       $('#step'+number).remove();
      
    }
    // Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });

    $('[href="#finish"]').click(function() {
    $('#formSubmit').submit();
})
</script>

    <!-- This Page JS -->
    <script src="{{asset('assets')}}/node_modules/wizard/jquery.steps.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/wizard/jquery.validate.min.js"></script>
   <script>
    
            //Custom design form example
        $(".tab-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: "Submit"
            },
            onFinished: function (event, currentIndex) {
               alert('adfd');

            }
        });

        var form = $(".validation-wizard").show();

        $(".validation-wizard").steps({
            headerTag: "h6",
            bodyTag: "section",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            
            onStepChanging: function (event, currentIndex, newIndex) {
                return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
            },
            onFinishing: function (event, currentIndex) {
                return form.validate().settings.ignore = ":disabled", form.valid()
            },
            onFinished: function (event, currentIndex) {
                var form = $(this);
                // Submit form input
                form.submit();
            }
        }), 

        $(".validation-wizard").validate({
            
            errorClass: "text-danger",
            successClass: "text-success",
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass)
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass)
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element)
            },
            rules: {
                email: {
                    email: !0
                }
            }
        })
    </script>
@endsection