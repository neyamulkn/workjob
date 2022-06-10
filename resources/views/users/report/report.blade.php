
<div class="row justify-content-md-center">
    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="reason">Report Reason</label>
            <select required name="reason" class="form-control">
                <option value="">Select reason</option>
            @foreach($reportReasons as $reason)
                <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label class="required" for="reason_details">Please describe your issue.</label>
            <textarea class="form-control" required minlength="6" rows="2" id="reason_details" placeholder="Write reason details" name="reason_details"></textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-danger"> Submit Report</button>
</div>