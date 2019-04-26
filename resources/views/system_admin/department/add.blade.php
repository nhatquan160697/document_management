@extends('layouts.admin.master')
@section('title')
    Thêm phòng ban
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
                            {!! Form::open([
                                        'method'=>'POST',
                                        'route'=>'department.store'
                                        ]) !!}
                                {!! Form::label('nameDepartment', 'Tên phòng ban') !!}
                                <div class="form-group">
                                        {!! Form::text('name', '', [
                                            'class'=>'form-control',
                                            'placeholder'=>'Nhập tên phòng ban',
                                            'required']) !!}
                                </div>
                                {!! Form::submit('Thêm', [
                                    'class'=>'btn btn-primary mt-4 pr-4 pl-4']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <br />
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách phòng ban đang hoạt</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="frm-align">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bộ phận</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tfoot class="frm-align">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bộ phận</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($departments as $department)
                                <tr>
                                    <td class="frm-align">{{ $department->id }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td class="frm-align">{{ $department->created_at }}</td>
                                    <td class="frm-align"><span class="badge badge-pill badge-success">Khả dụng</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
