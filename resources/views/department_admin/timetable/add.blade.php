@extends('layouts.user.master')
@section('title')
    Thêm Thời Khóa Biểu
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm Thời Khóa Biểu</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'POST', 'route'=>'timetable.store', 'files' => true]) !!}
                                {!! Form::label('name', "Tiêu Đề") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => "Nhập Tiêu Đề", 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::label('file_attachment', "File") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::file('file_attachment[]',['class' => 'form-control-file', "multiple", 'id' => 'file_attachment', 'required' => 'required'])  !!}
                                    </div>
                                </div>
                                {!! Form::label('description', "Mô Tả") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('description', '', ['class' => 'form-control', 'placeholder' => "Nhập Mô Tả", 'id' => 'description', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::submit("Thêm", ['class' => 'btn btn-primary mt-4 pr-4 pl-4', 'id' => 'btnTimeTable']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
