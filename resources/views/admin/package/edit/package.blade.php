<input type="hidden" value="{{$data->id}}" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name required">Package Name</label>
            <input name="name" placeholder="Write package name" id="name" value="{{$data->name}}" required="" type="text" class="form-control">
        </div>
    </div>

    <div class="col-xs-6 col-md-6">
        <div class="form-group">
            <label for="name">Ribbon Image</label>
            <input name="ribbon" id="name" type="file" class="form-control">
        </div>
    </div>
    <div class="col-xs-6 col-md-6">
        <div class="form-group">
            <label for="name">Ribbon Position</label>
            <select name="ribbon_position" class="form-control">
                <option @if($data->ribbon_position == 'top-left') selected @endif value="top-left">Top left</option>
                <option @if($data->ribbon_position == 'top-right') selected @endif value="top-right">Top right</option>
                <option @if($data->ribbon_position == 'bottom-left') selected @endif value="bottom-left">Bottom left</option>
                <option  @if($data->ribbon_position == 'bottom-right') selected @endif value="bottom-right">Bottom right</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Bacground Color</label>
            <input name="background_color" type="text" value="{{$data->background_color}}" class="gradient-colorpicker form-control ">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Text Color</label>
            <input name="text_color" value="{{$data->text_color}}" class="gradient-colorpicker form-control" type="text">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Border Color</label>
            <input name="border_color" value="{{$data->border_color}}" class="gradient-colorpicker form-control" type="text">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Package Details</label>
            <textarea name="details" rows="1" id="name" value="{{old('details')}}" placeholder="Write package details" class="form-control">{{$data->details}}</textarea>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="promote_demo">Promote Demo</label>
            <input name="promote_demo" id="promote_demo" type="file" class="form-control">
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
