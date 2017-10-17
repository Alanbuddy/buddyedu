@if(count($errors)>0)
    @foreach($errors->all() as $value)
        {{$value}}
    @endforeach
@endif


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{route('login')}}">
                    <input name="_token" value="v6I5WlFpFQPtjPwIfpDgthNyOQJ1i8wO6GxmnTJ2" type="hidden">

                    {{--<div class="form-group">--}}
                    {{--<label class="col-md-4 control-label">E-Mail Address</label>--}}

                    {{--<div class="col-md-6">--}}
                    {{--<input class="form-control" name="email" value="" type="email">--}}

                    {{--</div>--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <label class="col-md-4 control-label">phone</label>

                        <div class="col-md-6">
                            <input class="form-control" name="phone" value="" type="phone">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input class="form-control" name="password" type="password">

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>Login
                            </button>

                            <a class="btn btn-link" href="https://bitmyth.com/password/reset">Forgot Your Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>