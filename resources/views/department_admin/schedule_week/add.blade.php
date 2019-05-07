@extends('layouts.user.master')
@section('title')
    Thêm Lịch Tuần
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm Lịch Tuần</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open([
                                         'method'=>'POST',
                                         'route'=>'schedule-admin.store'
                                         ]) !!}
                                {!! Form::label('title', 'Tiêu đề') !!}
                                <div class="form-group">
                                    {!! Form::text('title', '', [
                                        'class'=>'form-control',
                                        'placeholder'=>'Nhập Tiêu đề',
                                        'required']) !!}
                                </div>
                                {!! Form::label('start', 'Ngày bắt đầu') !!}
                                <div class="form-group">
                                    {!! Form::date('start', \Carbon\Carbon::now(), [
                                    'class' => 'form-control',
                                    'max' => \Carbon\Carbon::now()->addYear(100)->format('Y-m-d'),
                                    'min' => \Carbon\Carbon::now()->format('Y-m-d'),
                                    'required']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('content', 'Lập lịch') !!}
                                    <table width="100%" class="schedule">
                                        <tr style="text-align: center">
                                            <th width="15%">Thứ, ngày</th>
                                            <th width="30%">Sáng</th>
                                            <th width="30%">Chiều</th>
                                            <th width="30%">Tối</th>
                                        </tr>
                                        <tr>
                                            <td> Thứ 2</td>
                                            <td>{!! Form::textarea('thu2S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu2C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu2T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 3</td>
                                            <td>{!! Form::textarea('thu3S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu3C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu3T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 4</td>
                                            <td>{!! Form::textarea('thu4S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu4C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu4T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 5</td>
                                            <td>{!! Form::textarea('thu5S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu5C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu5T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 6</td>
                                            <td>{!! Form::textarea('thu6S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu6C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu6T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 7</td>
                                            <td>{!! Form::textarea('thu7S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu7C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu7T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Chủ nhật</td>
                                            <td>{!! Form::textarea('thu8S', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu8C', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu8T', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                {!! Form::label('note', 'Lưu ý:') !!}
                                <div class="form-group">
                                    {!! Form::textarea('note', '', ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}
                                </div>
                                {!! Form::submit('Thêm', [
                                    'class'=>'btn btn-primary mt-4 pr-4 pl-4',
                                    'id' => 'btnAddSchedule']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
