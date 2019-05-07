@extends('layouts.user.master')
@section('title')
    Sửa Thời Khóa Biểu
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Sửa Thời Khóa Biểu</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'PUT', 'files' => true, 'route'=>['timetable.update',$timeTable->id]]) !!}
                                {!! Form::label('name', "Tiêu Đề") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', $timeTable->name, ['class' => 'form-control', 'placeholder' => "Nhập Tiêu Đề", 'id' => 'name', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::label('file_attachment', "File") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        @php
                                            $arrayFileDecode = array();
                                            if(isset($timeTable->file_attachment)){
                                                $arrayFileDecode = json_decode($timeTable->file_attachment);
                                            }
                                        @endphp
                                        <ul style=" padding: 0;">
                                            @foreach($arrayFileDecode as $value)
                                                <li>
                                                    <a href="/upload/files/schedule/{{ $value }}" download title="{{ $value }}">{{ $value}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        {!! Form::file('file_attachment[]', ['class' => 'form-control-file', "multiple", 'id' => 'file_attachment'])  !!}
                                    </div>
                                </div>
                                {!! Form::label('description', "Mô Tả") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('description', $timeTable->description, ['class' => 'form-control', 'placeholder' => "Nhập Mô Tả", 'id' => 'description', 'required' => 'required']) !!}
                                    </div>
                                </div>
                                {!! Form::submit("Sửa", ['class' => 'btn btn-primary mt-4 pr-4 pl-4' , 'id' => 'btnTimeTable']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
