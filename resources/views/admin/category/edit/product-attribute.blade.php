<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="subcategory">Product Attribute Name</label>
        <input name="name" id="subcategory" value="{{$data->name}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">                           
    <div class="form-group">
        <label for="category">Select Category</label>
        <select name="category_id" id="category_id" class="form-control custom-select">
                <option @if($data->category_id == 'all') selected @endif value="all">All Category</option>
            @foreach($get_category as $category)
                <option value="{{$category->id}}" {{($category->id == $data->category_id) ?  'selected' : ''}}>{{$category->name}}</option>
                @if($category->get_subcategory)
                    @foreach($category->get_subcategory as $subcategory)
                        <option value="{{$subcategory->id}}" {{($subcategory->id == $data->category_id) ?  'selected' : ''}}>--{{$subcategory->name}}</option>
                         <!-- get sub childcategory -->
                        @if($subcategory->get_subcategory)
                        
                            @foreach($subcategory->get_subcategory as $subchildcategory)
                           
                                <option {{($subchildcategory->id == $data->category_id) ?  'selected' : ''}} value="{{$subchildcategory->id}}"> &nbsp;---{{$subchildcategory->name}}</option>
                            
                            @endforeach
                        
                        @endif
                        <!-- end sub childcatgory -->
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>



<div class="col-md-6" >
    <span>Select display type</span>
    <div class="row form-group">
        <div class="custom-control custom-radio">
            <input value="1" type="radio" @if($data->display_type == 1) checked @endif id="editflat" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editflat">Checkbox</label>
        </div>
        <div class="custom-control custom-radio">
            <input value="2" type="radio" @if($data->display_type == 2) checked @endif id="editselect" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editselect">Select</label>
        </div>
        <div class="custom-control custom-radio">
            <input value="3" @if($data->display_type == 3) checked @endif type="radio" id="editradio" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editradio">Radio</label>
        </div>

        <div class="custom-control custom-radio">
            <input value="4" @if($data->display_type == 4) checked @endif type="radio" id="editdropdown" name="display_type" class="custom-control-input">
            <label class="custom-control-label" for="editdropdown">Dropdown</label>
        </div>
    </div>
</div>
<div class="col-md-3">
    <span>Field is requird</span>
    <div class="form-group">
        <input  name="is_required"  @if($data->is_required) checked @endif id="eeditis_required" type="checkbox" > <label for="eeditis_required"> Yes/No</label>
    </div>
</div>
<div class="col-md-3">
    <span>Show in filter</span>
    <div class="form-group">
        <input  name="is_filter"  @if($data->is_filter) checked @endif id="editfilter" type="checkbox"> <label for="editfilter"> Yes/No </label>
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
