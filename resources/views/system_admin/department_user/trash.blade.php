@extends('layouts.admin.master')
@section('title')
    Danh sách nhân sự đã bị xóa.
@endsection
@section('content')
    <div class="container-fluid">
        @include('common.errors')
        <br />
        <br />
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách nhân sự</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="frm-align">
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Phòng ban</th>
                            <th>Vị trí</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tfoot class="frm-align">
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Phòng ban</th>
                            <th>Vị trí</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($depUsers as $depUser)
                            <tr>
                                <td class="frm-align">{{ $depUser->department_user_id }}</td>
                                <td class="frm-align">{{ $depUser->username }}</td>
                                <td class="frm-align">{{ $depUser->depname }}</td>
                                <td class="frm-align">{{ $depUser->posname }}</td>
                                <td class="frm-align"><span class="badge badge-pill badge-warning">Không Khả dụng</span></td>
                                <td class="frm-align">
                                    {!!Form::open(['method'=>'Patch', 'id'=>'restore-User'.$depUser->department_user_id, 'route'=>['department-user.restore', $depUser->department_user_id], 'style'=>'display:inline'])!!}
                                    <a href="javascript:void(0)" class="text-danger data-delete frm-margin-left-8" onclick='restoreArchivedData("restore-User" + {{$depUser->department_user_id}});'>
                                        <i class="fa fa-trash-restore-alt"></i>
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
    </div>
@endsection
