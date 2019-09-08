@extends('layouts.admin.master')
@section('title')
    Thêm Mới Admin Đơn Vị
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                @include('common.errors')
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open(['method'=>'POST', 'route'=>'create-department-admin.store', 'files' => true]) !!}
                                {!! Form::label('name', "Tên Thành Viên") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => "Nhập  Tên Thành Viên", 'id' => 'name', 'required' => 'required', 'pattern' => config('setting.patter_fullname'),  'title' => 'Họ tên chỉ bao gồm chữ cái và phải tối thiểu 6 kí tự']) !!}
                                    </div>
                                </div>
                                {!! Form::label('name', "Tên Đăng Nhập") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('usernameF', old('usernameF'), ['id' => 'usernameF', 'class' => 'form-control', 'disabled' => true]) !!}
                                        {!! Form::text('username', old('username'), ['id' => 'username', 'class' => 'form-control', 'hidden' => true]) !!}
                                    </div>
                                </div>
                                {!! Form::label('email', "Email") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => "Nhập Email", 'id' => 'email', 'required' => 'required', 'pattern' => config('setting.patter_email'),  'title' => 'Phía trước dấu @ phải có ít nhất một kí tự và phía sau dấu @ là tối đa 2 đuôi tên miền.']) !!}
                                    </div>
                                </div>
                                {!! Form::label('password', "Mật Khẩu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => "Nhập Mật Khẩu", 'id' => 'password', 'required' => 'required', 'pattern' => '(?=.*\d)(?=.*[a-z]).{6,}',  'title' => 'Mật khẩu ít nhất có 6 kí tự bao gồm chữ và số']) !!}
                                    </div>
                                </div>
                                {!! Form::label('department_id', "Chọn phòng ban muốn ủy quyền Trưởng đơn vị") !!}
                                <div class="form-group">
                                    {!! Form::select('department_id', $searchDepartment, null,
                                            ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true']) !!}
                                </div>
                                {!! Form::label('avatar', "Ảnh Đại Diện") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <img class="img-preview" id="img-preview"/>
                                        {!! Form::file('avatar',['class' => 'form-control-file', 'id' => 'avatar'])  !!}
                                    </div>
                                </div>
                                {!! Form::submit("Thêm", ['class' => 'btn btn-primary mt-4 pr-4 pl-4', 'id' => 'btnAddUser']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
