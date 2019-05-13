@extends('layouts.user.master')
@section('title')
    Danh Sách Thành Viên
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            @include('common.errors')
            <div class="card-header py-3" style="margin-bottom: 5px;">
                <h6 class="m-0 font-weight-bold text-primary">Danh Sách Thành Viên</h6>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary" style="float:left;">Thêm</a>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th width="20%">Tên đầy đủ</th>
                    <th width="20%">Email</th>
                    <th width="20%">Địa chỉ</th>
                    <th width="10%">Điện thoại</th>
                    <th width="10%">Chức vụ</th>
                    <th width="10%">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departmentUser as $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->position_name }}</td>
                        <td class="frm-align">
                            <a href="{{ route('users.show',$value->user_id) }}" class="text-warning" style="margin-right: 8px;">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if($value->position_id != config('setting.position.admin_department'))
                                <a href="javascript:void(0)" class="text-danger data-delete frm-margin-left-8"  onclick='submitForm("delete-department" + {{$value->user_id}});'><i class="fa fa-trash"></i></a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy',$value->user_id], 'id'=>'delete-department'.$value->user_id]) !!}
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('users.archive') }}" class="btn btn-warning" style="float: right;margin-top: 10px;margin-right: 16px"><i class="fa fa-trash" style="color:white"></i></a>
</div>
@endsection
