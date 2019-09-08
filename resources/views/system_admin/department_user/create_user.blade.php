@extends('layouts.admin.master')
@section('title')
    Tạo mới nhân sự
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
                                {!! Form::open(['method'=>'POST', 'route'=>'department-user.store', 'files' => true]) !!}
                                {!! Form::label('name', "Tên Thành Viên") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('name', old('name'), ['maxlength' => "20", 'class' => 'form-control', 'placeholder' => "Nhập  Tên Thành Viên", 'id' => 'name', 'required' => 'required', 'pattern' => config('setting.patter_fullname'),  'title' => 'Họ tên chỉ bao gồm chữ cái và phải tối thiểu 6 kí tự']) !!}
                                    </div>
                                </div>
                                {!! Form::label('name', "Tên Đăng Nhập") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('usernameF', old('username'), ['id' => 'usernameF', 'class' => 'form-control', 'disabled' => true]) !!}
                                        {!! Form::text('username', old('username'), ['id' => 'username', 'class' => 'form-control', 'hidden' => true]) !!}
                                    </div>
                                </div>
                                {!! Form::label('email', "Email") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => "Nhập Email", 'id' => 'email', 'required' => 'required', 'pattern' => config('setting.patter_email'),  'title' => 'Phía trước dấu @ phải có ít nhất một kí tự và phía sau dấu @ là tối đa 2 đuôi tên miền.', 'maxlenght' => 15]) !!}
                                    </div>
                                </div>
                                {!! Form::label('password', "Mật Khẩu") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => "Nhập Mật Khẩu", 'id' => 'password', 'required' => 'required', 'pattern' => '(?=.*\d)(?=.*[a-z]).{6,}',  'title' => 'Mật khẩu ít nhất có 6 kí tự bao gồm chữ và số']) !!}
                                    </div>
                                </div>
                                {!! Form::label('birth_date', "Ngày Sinh") !!}
                                <div class="input-group date">
                                    {!! Form::text('birth_date', old('birth_date'), ['data-date-format'=>'dd/mm/yyyy','readonly', 'class'=>'form-control birthday', 'style'=>'background:#fff']) !!}
                                </div>
                                {!! Form::label('gender', "Giới Tính") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::select('gender' , [config('setting.gender.male') => 'Nam', config('setting.gender.female') => 'Nữ'], null, ['class' => 'form-control', 'id' => 'gender']) !!}
                                    </div>
                                </div>
                                {!! Form::label('avatar', "Ảnh Đại Diện") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <img class="img-preview" id="img-preview"/>
                                        {!! Form::file('avatar',['class' => 'form-control-file', 'id' => 'avatar'])  !!}
                                    </div>
                                </div>
                                {!! Form::label('address', "Địa Chỉ") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => "Nhập Địa Chỉ", 'id' => 'address', 'required' => 'required', 'pattern' => config('setting.patter_address'),  'title' => 'địa chỉ bao gồm chữ và số']) !!}
                                    </div>
                                </div>
                                {!! Form::label('phone', "Số Điện Thoại") !!}
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        {!! Form::text('phone', '', ['class' => 'form-control', 'placeholder' => "Nhập Số Điện Thoại", 'id' => 'phone', 'pattern' => '[0][0-9]{9}',  'title' => 'số điện thoại chỉ gồm số và bắt đầu bằng số 0 , gồm 10 số.']) !!}
                                    </div>
                                </div>
                                {!! Form::label('department_id', 'Chọn phòng ban') !!}
                                <div class="form-group">
                                    {!! Form::select('department_id', $searchDepartment, old('department_id'),
                                            ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true']) !!}
                                </div>
                                {!! Form::label('position_id', 'Chọn chức vụ tiếp quản') !!}
                                <div class="form-group">
                                    {!! Form::select('position_id', $searchPosition, old('position_id'),
                                            ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true']) !!}
                                </div>
                                {!! Form::label('end_date', "Ngày Hết Hạn Tài Khoản") !!}
                                <div style="margin-bottom: 10px">
                                    {!! Form::checkbox('no_end_date', 1, true, ['id' => 'no_end_date']) !!}
                                    <span title="tích vào ô nếu không có ngày hết hạn">vô hạn</span>
                                </div>
                                <div class="form-group row" id="end_date_div" style="display:none">
                                    <div class="col-sm-12">
                                        {{ Form::text('end_date', \Carbon\Carbon::now()->addDays(60), ['class' => 'form-control end_date', 'id' => 'end_date']) }}
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
