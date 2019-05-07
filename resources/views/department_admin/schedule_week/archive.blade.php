@extends('layouts.user.master')
@section('title')
    Lịch Tuần Đã Bị Xóa
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Lịch Tuần Đã Bị Xóa</h6>
                </div>
                <a href="{{ route('schedule-admin.index') }}" class="btn btn-primary" style="float:left;}">Quay Lại</a>
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
                                <td class="frm-align"><span class="badge badge-pill badge-success">Không khả dụng</span></td>
                                <td class="frm-align">
                                    {!!Form::open(['method' => 'PUT', 'route' => ['schedule-restore', $schedule->id ], 'id' => 'schedule-restore'.$schedule->id])!!}
                                    <a href="javascript:void(0)" class="text-success data-delete frm-margin-left-8" onclick="restoreArchivedData('schedule-restore' + {{$schedule->id}})" title="Khôi phục">
                                        <i class="fa fa-trash-restore"></i>
                                    </a>
                                    {!!Form::close()!!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
