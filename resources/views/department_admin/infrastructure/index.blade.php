@extends('layouts.user.master')
@section('title')
    Quản Lý Tài Sản
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Danh Sách Tài Sản</h6>
                </div>
                <a href="{{ route('infrastructure.create') }}" class="btn btn-primary" style="float:left;}">Thêm</a>
                @include('common.errors')
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Tên tài sản</th>
                        <th>Ảnh</th>
                        <th>Thuộc đơn vị</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($infrastructure as $key)
                        <tr>
                            <td>{{ $key->name }}</td>
                            <td><img src="/upload/images/{{ $key->picture }}" class="img-preview2"></td>
                            <td>
                                {!! Form::select('department_id', $department, $key->department_id, ['class' => 'form-control', 'disabled' => true]) !!}
                            </td>
                            <td style="text-align: center">{{ $key->amount }}</td>
                            <td class="frm-align">
                                <a href="{{ route('infrastructure.show',$key->id) }}" class="text-warning frm-margin-right-8">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {!!Form::open(['method'=>'DELETE', 'id'=>'delete-infrastructure'.$key->id, 'route'=>['infrastructure.destroy',$key->id], 'style'=>'display:inline'])!!}
                                <a href="javascript:void(0)" class="text-danger data-delete frm-margin-left-8" onclick='submitForm("delete-infrastructure" + {{$key->id}});'>
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
        <a href="{{ route('infrastructure.archive') }}" class="btn btn-warning" style="float: right;margin-top: 10px;margin-right: 16px"><i class="fa fa-trash" style="color:white"></i></a>
    </div>
@endsection
