@extends('layouts.user.master')
@section('title')
    Thêm Biễu Mẫu
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm Biễu Mẫu</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'POST', 'route'=>'forms.store', 'files' => true]) !!}
                                {!! Form::label('name', "Tên biễu mẫu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => "Nhập Tên Biểu Mẫu", 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::label('link', "File Biểu Mẫu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::file('link[]',['class' => 'form-control-file', "multiple", 'id' => 'link', 'required' => 'required'])  !!}                                    </div>
                                </div>
                                {!! Form::label('description', "Mô Tả") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('description', '', ['class' => 'form-control', 'placeholder' => "Nhập Mô Tả", 'id' => 'description', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::submit("Thêm", ['class' => 'btn btn-primary mt-4 pr-4 pl-4', 'id' => 'btnForm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
