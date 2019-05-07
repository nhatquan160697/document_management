@extends('layouts.user.master')
@section('title')
    Sửa Biểu Mẫu
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Sửa Biễu Mẫu</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'PUT', 'files' => true, 'route'=>['forms.update',$forms->id]]) !!}
                                {!! Form::label('name', "Biểu Mẫu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', $forms->name, ['class' => 'form-control', 'placeholder' => "Nhập Tên Biểu Mẫu", 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::label('link', "File Biểu Mẫu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        @php
                                            $arrayFileDecode = array();
                                            if(isset($forms->link)){
                                                $arrayFileDecode = json_decode($forms->link);
                                            }
                                        @endphp
                                        <ul style=" padding: 0;">
                                            @foreach($arrayFileDecode as $value)
                                                <li>
                                                    <a href="/upload/files/form/{{ $value }}" download title="{{ $value }}">{{ $value}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        {!! Form::file('link[]', ['class' => 'form-control-file', "multiple", 'id' => 'link'])  !!}
                                    </div>
                                </div>
                                {!! Form::label('description', "Mô Tả") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('description', $forms->description, ['class' => 'form-control', 'placeholder' => "Nhập Mô Tả", 'id' => 'description', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::submit("Sửa", ['class' => 'btn btn-primary mt-4 pr-4 pl-4', 'id' => 'btnForm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
