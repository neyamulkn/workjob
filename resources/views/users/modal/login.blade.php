<div class="modal fade" id="so_sociallogin" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="display: block;">
                    <div class="modal-body">
                        <button type="button" style="float:right;" class="close" data-dismiss="modal">&times;</button>
                    <div class="card-body" >
                   
                    <form action="{{route('userLogin')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12" style="text-align: center;font-size: 26px;margin-bottom: 15px;">Login</div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" required name="emailOrMobile" value="{{old('emailOrMobile')}}" class="form-control" placeholder="Email Or Mobile">
                                    @if ($errors->has('emailOrMobile'))
                                        <span class="error" role="alert">
                                            {{ $errors->first('emailOrMobile') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" name="password" required class="form-control" id="pass" placeholder="Password">
                                    <button  style="position: absolute;top: 8px;right: 25px;" type="button" class="form-icon"><i class="eye fas fa-eye"></i></button>
                                   
                                    @if ($errors->has('password'))
                                        <span class="error" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="signin-check">
                                        <label class="custom-control-label" for="signin-check">Remember me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group text-right">
                                    <a href="#" class="form-forgot">Forgot password?</a>
                                </div>
                            </div>
                            <div class="col-12" style="text-align: center;" >
                                <div class="form-group">
                                    <button type="submit" class="btn btn-inline">
                                        <i class="fas fa-unlock"></i>
                                        <span>Enter your account</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="user-form-direction" >
                        <p>Don't have an account? click on the <span>(<a href="{{route('register')}}"> sign up </a>)</span> button above.</p>
                    </div>
                </div>
            </div>
               
        </div>
    </div>
</div>
