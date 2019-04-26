@extends('layouts.user.master')
@section('title')
    Thêm ủy quyền
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thêm người muốn ủy quyền</h6>
            </div>
            @include('common.errors')
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open([
                                        'method'=>'POST',
                                        'route'=>'delegacy.store'
                                        ]) !!}
                                {!! Form::label('name', 'Chọn nhân viên') !!}
                                <div class="form-group">
                                    {!! Form::select('user_id', $searchAdmin, null,
                                            ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true']) !!}
                                </div>

                                {!! Form::label('namePosition', 'Ủy quyền cho') !!}
                                <div class="form-group">
                                    {!! Form::text('position_id', 'ahihi', [
                                        'class'=>'form-control',
                                        'readonly']) !!}
                                </div>
                                <div class="form-group" style="width: 50%;float:left">
                                    {!! Form::label("date-start", "Chọn ngày bắt đầu tiếp quản", []) !!}
                                    <div class="input-group date" data-date-format="dd-mm-yyyy">
                                        {!! Form::text("date-start", old("date-start"), ["class"=>"form-control", "readonly"]) !!}
                                        <span style="background-color: #fff;width: 15%;" class="input-group-addon"><i class="fa fa-calendar" style="font-size: 20px;margin-top: 9px;"></i></span>
                                    </div>
                                </div>
                                <div class="form-group" style="width: 50%;float:left">
                                    {!! Form::label("date-end", "Chọn ngày kết thúc", []) !!}
                                    <div class="input-group date" data-date-format="dd-mm-yyyy">
                                        {!! Form::text("date-end", old("date-end"), ["class"=>"form-control", "readonly"]) !!}
                                        <span style="background-color: #fff;width: 15%;" class="input-group-addon"><i class="fa fa-calendar" style="font-size: 20px;margin-top: 9px;"></i></span>
                                    </div>
                                </div>
                                {!! Form::submit('Thêm', [
                                    'class'=>'btn btn-primary mt-4 pr-4 pl-4']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Html::script(asset('/templates/user/js/handleDate.js')) }}
@endsection
