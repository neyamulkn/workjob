<input type="hidden" value="{{$faq->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="question">Question</label>
        <input placeholder="Write Question"  name="question" id="question" value="{{$faq->question}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label for="route">Answer</label>
        <textarea name="answer" rows="3" placeholder="Write Answer" class="form-control summernote">{{$faq->answer}}</textarea>
    </div>
</div>

<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($faq->status == 1 ) ?  'checked' : ''}} type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>

