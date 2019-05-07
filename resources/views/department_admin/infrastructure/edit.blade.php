@extends('layouts.user.master')
@section('title')
    Sửa Thông Tin Tài Sản
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Sửa Thông Tin Tài Sản</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'PUT', 'files' => true, 'route'=>['infrastructure.update', $infrastructure->id]]) !!}
                                    {!! Form::label('name', "Tên Tài Sản") !!}
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            {!! Form::text('name', $infrastructure->name, ['class' => 'form-control', 'placeholder' => "Nhập Tên Tài Sản", 'id' => 'name', 'required' => 'required', 'pattern' => config('setting.patter_fullname'),  'title' => 'Tên tài sản chỉ bao gồm chữ cái và phải tối thiểu 6 kí tự']) !!}
                                        </div>
                                    </div>
                                    {!! Form::label('picture', "Ảnh Đại Diện") !!}
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <img class="img-preview" src="/upload/images/{{ $infrastructure->picture }}" id="img-preview"/>
                                            {!! Form::file('picture',['class' => 'form-control-file', 'id' => 'avatar'])  !!}
                                        </div>
                                    </div>
                                    {!! Form::label('amount', "Số Lượng") !!}
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            {!! Form::number('amount', $infrastructure->amount, ['class' => 'form-control', 'placeholder' => "Nhập Số Lượng", 'id' => 'amount', 'min' => 0, 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                    {!! Form::submit("Sửa", ['class' => 'btn btn-primary mt-4 pr-4 pl-4', 'id' => 'btnInfrastructure']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
