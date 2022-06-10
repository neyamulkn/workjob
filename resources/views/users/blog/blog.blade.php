 @extends('layouts.frontend')
@section('title', 'Blog Post' )
@section('css')
<link rel="stylesheet" href="{{asset('frontend')}}/css/custom/ad-post.css">
<style type="text/css">
    .form-check-list li{display: inline-flex;}
    .adjust-field{border: none;border-radius:0;position: absolute;top: 0;right: 0;background: #e9ecef;padding: 5px;}
    
</style>
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
@endsection
@section('content')

    <!--=====================================
                ADPOST PART START
    =======================================-->
    <section class="user-area">
        <div class="container">
            <div class="row">
                <!--Right Part Start -->
                @include('users.inc.sidebar')
                <!--Middle Part Start-->
                <div class="col-md-9 sticky-conent">
                    <form action="{{ route('blog.store') }}" data-parsley-validate method="post" enctype="multipart/form-data" class="adpost-form">
                        @csrf
                        <div class="adpost-card">
                            <div class="adpost-title">
                                <h3>Write your blog</h3>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label required">Blog Title</label>
                                        <input name="title" required value="{{old('title')}}" type="text" class="form-control" placeholder="Type your product title here">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label required">Category</label>
                                        <select required name="category_id" class="form-control custom-select">
                                            <option selected>Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Image</label>
                                        <input style="padding-top: 0;" name="feature_image" type="file" class="form-control">
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label required">Blog description</label>
                                        <textarea name="description" required class="summernote form-control" placeholder="Describe your message">{{old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="required">Search Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</label>

                                         <div class="tags-default">
                                            <input  type="text" name="meta_keywords[]"  data-role="tagsinput" placeholder="Enter search keywords" />
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-lg-12 form-group text-right">
                                <button class="btn btn-inline">
                                    <i class="fas fa-check-circle"></i>
                                    <span>published your blog</span>
                                </button>
                            </div>
                            </div>

                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--=====================================
                ADPOST PART END
    =======================================-->

@endsection

@section('js')
<script src="{{ asset('js/parsley.min.js') }}"></script>

<script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 150, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>


<script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
    // Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });

</script>
@endsection