<input type="hidden" value="{{$data->id}}" name="id">


    <div class="col-md-12">
        <div class="form-group">
            <label for="name" class="required">Categroy</label>
            <select  required name="category_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                <option value="">Select Category</option>
                @foreach($get_category as $category)

                    <option disabled @if($data->category_id  == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    <!-- get subcategory -->
                    @if(count($category->get_subcategory)>0)
                   
                        @foreach($category->get_subcategory as $subcategory)

                            <option @if($data->category_id  == $subcategory->id) selected @endif value="{{$subcategory->id}}">-- {{$subcategory->name}}</option>

                            <!-- get sub childcategory -->
                            @if(count($subcategory->get_subcategory)>0)
                             
                                @foreach($subcategory->get_subcategory as $subchildcategory)

                                    <option @if($data->category_id == $subchildcategory->id) selected @endif value="{{$subchildcategory->id}}"> &nbsp;---{{$subchildcategory->name}}</option>

                                @endforeach
                            
                            @endif
                            <!-- end sub childcatgory -->
                        @endforeach
                      
                    @endif
                    <!-- end subcategory -->
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="required">Number of ads</label>
            <input name="ads" required placeholder="Example: 50 ads" value="{{$data->ads}}" class="form-control" type="number">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="required">Ads duration</label>
            <input name="duration" required placeholder="Example: 7 Days" value="{{$data->duration}}" class="form-control" type="number">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="required">Price</label>
            <input name="price" required placeholder="Example: {{ config('siteSetting.currency_symble') }}50 " value="{{$data->price}}" class="form-control" type="number">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Discount</label>
            <input name="discount" value="{{$data->discount}}" placeholder="Example: 10%" class="form-control" type="number">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="name">Package Details</label>
            <input name="details" id="name" value="{{$data->details}}"  placeholder="Write details" type="text" class="form-control">
        </div>
    </div>
</div>                               
<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
       
            <div  class="status-btn" >
                <div class="custom-control custom-switch">
                    <input name="status" {{($data->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                    <label class="custom-control-label" for="status-edit">Publish/UnPublish</label>
                </div>
            </div>
      
    </div>
</div>

