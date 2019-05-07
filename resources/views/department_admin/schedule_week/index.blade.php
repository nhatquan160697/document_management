@extends('layouts.user.master')
@section('title')
    Quản Lý Lịch Tuần Của Trường
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Lịch Tuần Của Trường</h6>
                </div>
                <a href="{{ route('schedule-admin.create') }}" class="btn btn-primary" style="float:left;}">Thêm</a>
                @include('common.errors')
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($schedule as $schedule)
                            <tr>
                                <td>{{ $schedule->title }}</td>
                                <td class="frm-align">{{ $dateConvert = date('d-m-Y', strtotime($schedule->start)) }}</td>
                                <td class="frm-align">{{ $dateConvert = date('d-m-Y', strtotime($schedule->end)) }}</td>
                                <td class="frm-align"><span class="badge badge-pill badge-success">Khả dụng</span></td>
                                <td class="frm-align">
                                    <a href="{{ route('schedule-admin.show', $schedule->id) }}" class="text-warning frm-margin-right-8">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {!!Form::open(['method'=>'DELETE', 'id'=>'delete-department'.$schedule->id, 'route'=>['schedule-admin.destroy', $schedule->id], 'style'=>'display:inline'])!!}
                                    <a href="javascript:void(0)" class="text-danger data-delete frm-margin-left-8" onclick='submitForm("delete-department" + {{$schedule->id}});'>
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ route('schedule-archived') }}" class="btn btn-warning" style="float: right;margin-top: 10px;margin-right: 16px"><i class="fa fa-trash" style="color:white"></i></a>
    </div>
@endsection
