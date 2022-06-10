@extends('layouts.admin-master')
@section('title', 'Review list')
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
        #ratting .checked{color: #ff8d00}
    </style>
@endsection
@section('content')
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
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
                    <h4 class="text-themecolor">Review List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Review</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                class="fa fa-plus-circle"></i> Create New</button>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">

                    <div class="card ">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Product</th>
                                            <th>Customer</th>
                                            <th>Review</th>
                                            <th>Published</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody id="positionSorting">
                                        @foreach($reviews as $review)
                                        <tr id="item{{$review->id}}">
                                            <td>
                                                #{{ $review->order_id }} <br/>
                                                <i class="fas fa-calender"></i> {{ Carbon\Carbon::parse($review->created_at)->format(Config::get('siteSetting.date_format')) }}
                                                <i> {{ Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</i>
                                            </td>
                                            <td><a target="_blank" href="{{ route('product_details', $review->slug) }}"><img src="{{asset('upload/images/product/thumb/'. $review->feature_image)}}" width="50"> {{Str::limit($review->product_name, 30)}}</a></td>
                                            <td><a href="{{ route('customer.profile', $review->username) }}"> {{$review->customer_name}}</a></td>
                                            
                                            <td><p id="ratting" style="margin-bottom: 0"> 
                                                @for($r=1; $r<=5; $r++) <i title=" {{$r}} Start" class="fa fa-star {{ ($r <= $review->ratting) ? 'checked' : '' }}"></i> @endfor</p>

                                                {!! Str::limit($review->review, 120) !!}

                                                @foreach($review->review_image_video as $image_video)
                                                 
                                                    @if( $image_video->review_image)
                                                        <div class="col-md-2">
                                                          <a  style="display: inline-flex;" class="popup-gallery single-review" href="{{asset('upload/review/'.$image_video->review_image)}}">
                                                            <img  width="40" height="40" src="{{asset('upload/review/'.$image_video->review_image)}}" alt="">
                                                          </a>
                                                        </div>
                                                      @endif
                                                @endforeach
                                            </td>
                                           
                                            <td>
                                                <div class="bt-switch">
                                                    <input  onchange="satusActiveDeactive('reviews', '{{$review->id}}')" type="checkbox" {{($review->status == 1) ? 'checked' : ''}} data-on-color="success" data-off-color="danger" data-on-text="Publish" data-off-text="Unpublish"> 
                                                </div>
                                            </td>
                                          
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                       
                                                        <a class="dropdown-item" title="Review reply" href="{{ route('reviewReply', $review->id) }}"><i class="fa fa-reply"></i> view details</a>

                                                       <!--  <a class="dropdown-item" title="Edit profile" data-toggle="tooltip" href="{{ route('adminReviewEdit', $review->id) }}"><i class="ti-pencil-alt"></i> Edit</a>
                                                        -->
                                                      
                                                        <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{ route("adminReviewDelete", $review->id) }}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete review</button></span>
                                                    </div>
                                                </div>                                          
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                                   {{$reviews->appends(request()->query())->links()}}
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of total {{$reviews->total()}} entries ({{$reviews->lastPage()}} Pages)</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->

        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- update Modal -->
    <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">

              <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create review</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                        <form action="{{route('productReviewInsert')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">review Name</label>
                                            <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            <label class="dropify_image">Feature Image</label>
                                            <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
                                        </div>
                                        @if ($errors->has('phato'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('phato') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="notes">Details</label>
                                            <textarea name="notes" class="form-control" placeholder="Enter details" id="notes" rows="2">{{old('notes')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                    <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- update Modal -->
    <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('adminReviewUpdate')}}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update review</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row" id="edit_form"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
              </div>
            </form>
        </div>
      </div>

    <!-- delete Modal -->
    @include('admin.modal.delete-modal')

@endsection
@section('js')
  
    <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>


    <script type="text/javascript">
       
        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("adminReviewEdit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $('.dropify').dropify();
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });
        }
    </script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            // Basic
            $('.dropify').dropify();

        });
    </script>

@endsection
