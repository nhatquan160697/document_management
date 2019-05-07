@extends('layouts.user.master')
@section('title')
    Sửa Lịch Tuần
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">Sửa Lịch Tuần</h6>
                </div>
                @include('common.errors')
                <div class="row" style="text-align: left;">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                {!! Form::open([
                                    'method'=>'PUT',
                                    'route'=>['schedule-admin.update', $schedule->id]
                                    ]) !!}
                                {!! Form::label('title', 'Tiêu đề') !!}
                                <div class="form-group">
                                    {!! Form::text('title', $schedule->title, [
                                        'class'=>'form-control',
                                        'placeholder'=>'Nhập Tiêu đề',
                                        'required']) !!}
                                </div>
                                {!! Form::label('start', 'Ngày bắt đầu') !!}
                                <div class="form-group">
                                    {!! Form::date('start', $schedule->start, [
                                    'class' => 'form-control',
                                    'max' => \Carbon\Carbon::now()->addYear(100)->format('Y-m-d'),
                                    'min' => \Carbon\Carbon::now()->format('Y-m-d'),
                                    'required']) !!}
                                </div>
                                <div class="form-group schedule">
                                    {!! Form::label('content', 'Lập lịch') !!}
                                    <table width="100%">
                                        <tr style="text-align: center">
                                            <th width="10%">Thứ, ngày</th>
                                            <th width="30%">Sáng</th>
                                            <th width="30%">Chiều</th>
                                            <th width="30%">Tối</th>
                                        </tr>
                                        <tr>
                                            <td class="day"> Thứ 2</td>
                                            <td>{!! Form::textarea('thu2S', $timeTable->thu2S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu2C', $timeTable->thu2C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu2T', $timeTable->thu2T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="day"> Thứ 3</td>
                                            <td>{!! Form::textarea('thu3S', $timeTable->thu3S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu3C', $timeTable->thu3C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu3T', $timeTable->thu3T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 4</td>
                                            <td>{!! Form::textarea('thu4S', $timeTable->thu4S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu4C', $timeTable->thu4C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu4T', $timeTable->thu4T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 5</td>
                                            <td>{!! Form::textarea('thu5S', $timeTable->thu5S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu5C', $timeTable->thu5C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu5T', $timeTable->thu5T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 6</td>
                                            <td>{!! Form::textarea('thu6S', $timeTable->thu6S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu6C', $timeTable->thu6C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu6T', $timeTable->thu6T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Thứ 7</td>
                                            <td>{!! Form::textarea('thu7S', $timeTable->thu7S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu7C', $timeTable->thu7C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu7T', $timeTable->thu7T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td> Chủ nhật</td>
                                            <td>{!! Form::textarea('thu8S', $timeTable->thu8S, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu8C', $timeTable->thu8C, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                            <td>{!! Form::textarea('thu8T', $timeTable->thu8T, ['class'=>'form-control field', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                {!! Form::label('note', 'Lưu ý:') !!}
                                <div class="form-group">
                                    {!! Form::textarea('note', $schedule->note, ['class'=>'form-control', 'placeholder'=>'Nhập nội dung', 'cols' => 50, 'rows' => 3]) !!}
                                </div>
                                {!! Form::submit('Sửa', [
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
