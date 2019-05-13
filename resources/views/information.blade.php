@extends('layouts.user.master')
@section('title')
    Thông Tin Cá Nhân
@endsection
@section('content')
    <div class="container">
        <div id="cards-wrapper" class="cards-wrapper" style="margin-left: 30%;width: 70%;">
            @include('common.errors')
            <div class="css-profile" style="height: 270px">
                <div style="margin-bottom: 2%;margin-top: 2%;position: relative">
                    <div class="left-profile">
                        {!! Form::open(['method'=>'POST', 'route'=>['update.avatar'], 'id' => 'changeAvatar', 'files' => true]) !!}
                        <div class="profile-img" id="avatar">
                            @if(Auth::user()->avatar == 'user-default.png')
                                <a href="/templates/user/images/{{Auth::user()->avatar}}"><img src="/templates/user/images/{{Auth::user()->avatar}}" style="width: 150px;height: 200px;" alt="" class="img-rounded img-responsive" /></a>
                            @else
                                <a href="/upload/images/{{Auth::user()->avatar}}"><img src="/upload/images/{{Auth::user()->avatar}}" style="width: 150px;height: 200px;" alt="" class="img-rounded img-responsive" /></a>
                            @endif
                            <div class="file btn btn-lg btn-primary">Thay Đổi
                                {!! Form::file('avatar',['id' => 'picture']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="right-profile" id="ajaxform">
                        @php
                            $id = \App\Models\DepartmentUser::where('user_id', Auth::user()->id)->first();
                            $department = \App\Models\Department::where('id', $id->department_id)->first();
                            $position = \App\Models\Position::where('id', $id->position_id)->first();
                        @endphp
                        <h4>{{ Auth::user()->name }}</h4>
                        <span> {{ $position->name }} - {{ $department->name }}</span>
                        <br/>
                        <br/>
                        <p>
                            <i class="fa fa-envelope-open icon-margin-right"></i>{{ Auth::user()->email }}
                            <br />
                            @php
                                $phpdate = strtotime( Auth::user()->birth_date);
                                $mysqldate = date( 'd-m-Y', $phpdate );
                            @endphp
                            <i class="fa fa-birthday-cake icon-margin-right"></i>{{ $mysqldate }}
                            <br />
                            <i class="fa fa-venus-mars icon-margin-right"></i>{{(Auth::user()->gender == config('setting.gender.male'))?"Nam":"Nữ"}}
                            <br />
                            <i class="fa fa-map-marker icon-margin-right" style="width: 15px;"></i>{{ Auth::user()->address }}
                            <br />
                            <i class="fa fa-phone icon-margin-right" style="width: 15px;"></i>{{ Auth::user()->phone }}
                            <br />
                        </p>
                        <div class="button-profile">
                            <button class="btn btn-primary" id="editInfor">Chỉnh Sửa</button>
                            <a class="btn btn-primary" data-toggle="modal" data-target="#password_modal">Đổi Mật Khẩu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    modal change password --}}
    <div id="password_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Đổi Mật Khẩu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                {!! Form::open(['method'=>'POST', 'route'=>['profile.update.pass']]) !!}
                <div class="modal-body" style="text-align: left;">
                    {!! Form::label('oldpassword', "Mật khẩu Cũ ") !!}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            {!! Form::password('oldpassword', ['class' => 'form-control', 'placeholder' => "Nhập Mật Khẩu", 'id' => 'password', 'required' => 'required']) !!}
                        </div>
                    </div>
                    {!! Form::label('newpassword', "Mật khẩu Mới") !!}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            {!! Form::password('newpassword', ['class' => 'form-control', 'placeholder' => "Nhập Mật Khẩu Mới", 'id' => 'password', 'required' => 'required', 'pattern' => '(?=.*\d)(?=.*[a-z]).{6,}',  'title' => 'Mật khẩu ít nhất có 6 kí tự bao gồm chữ và số']) !!}
                        </div>
                    </div>
                    {!! Form::label('renewpassword', "Nhập Lại Mật Khẩu Mới") !!}
                    <div class="form-group row">
                        <div class="col-sm-12">
                            {!! Form::password('confirmpassword', ['class' => 'form-control', 'placeholder' => "Nhập Lại Mật Khẩu Mới", 'id' => 'password', 'required' => 'required', 'pattern' => '(?=.*\d)(?=.*[a-z]).{6,}',  'title' => 'Mật khẩu ít nhất có 6 kí tự bao gồm chữ và số']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::submit("Lưu Thay Đổi", ['class' => 'btn btn-primary']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@endsection
