@extends('layouts.user.master')
@section('title')
    Quản Lý Tài Sản Đã Bị Xóa
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Tài Sản Đã Bị Xóa</h6>
                </div>
                <a href="{{ route('infrastructure.index') }}" class="btn btn-primary" style="float:left;}">Quay Lại</a>
                @include('common.errors')
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Tên tài sản</th>
                        <th>Ảnh</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($infrastructure as $key)
                        <tr>
                            <td>{{ $key->name }}</td>
                            <td><img src="/upload/images/{{ $key->picture }}" class="img-preview2"></td>
                            <td style="text-align: center">{{ $key->amount }}</td>
                            <td class="frm-align"><span class="badge badge-pill badge-success">Không khả dụng</span></td>
                            <td class="frm-align">
                                {!!Form::open(['method' => 'PUT', 'route' => ['infrastructure.archive.restore', $key->id ], 'id' => 'infrastructure-restore'.$key->id])!!}
                                <a href="javascript:void(0)" class="text-success data-delete frm-margin-left-8" onclick="restoreArchivedData('infrastructure-restore' + {{$key->id}})" title="Khôi phục">
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
