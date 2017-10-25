@extends('layout.app')
@if(count($errors)>0)
    @foreach($errors->all() as $value)
        {{$value}}
    @endforeach
@endif

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Create</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{route('merchants.store')}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="col-md-4 control-label">name</label>

                        <div class="col-md-6">
                            <input class="form-control" name="name" value="" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">phone</label>

                        <div class="col-md-6">
                            <input class="form-control" name="phone" value="" type="phone">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">address</label>

                        <div class="col-md-6">
                            <select class="form-control" name="province" id="province">
                                <option></option>
                            </select>
                            <select class="form-control" name="city" id="city">
                                <option></option>
                            </select>
                            <select class="form-control" name="county" id="county">
                                <option></option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">street</label>
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input class="form-control" name="street" value="" type="text">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i>Commit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script src="/js/geo.js"></script>
@endsection