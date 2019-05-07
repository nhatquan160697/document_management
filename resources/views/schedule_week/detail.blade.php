@extends('layouts.user.master')
@section('title')
    Lịch Tuần
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="card-header py-3" style="margin-bottom: 5px;">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $schedule->title }}</h6>
                </div>
                <table class="table table-striped table-bordered" style="width:100%">
                    <tr style="background-color: #1b4b72;color:white;">
                        <th width="13%">Thứ, ngày</th>
                        <th width="29%">Sáng</th>
                        <th width="29%">Chiều</th>
                        <th width="29%">Tối</th>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 2 <br /> {{ date('d-m-Y', strtotime($schedule->start)) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu2S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu2C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu2T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 3 <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +1 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu3S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu3C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu3T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 4 <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +2 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu4S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu4C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu4T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 5 <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +3 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu5S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu5C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu5T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 6 <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +4 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu6S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu6C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu6T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Thứ 7 <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +5 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu7S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu7C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu7T }}</td>
                    </tr>
                    <tr>
                        <td width="10%" class="style-col-schedule">Chủ nhật <br /> {{ date('d-m-Y', strtotime($schedule->start . ' +6 day')) }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu8S }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu8C }}</td>
                        <td width="30%" class="style-col-content">{{ $timeTable->thu8T }}</td>
                    </tr>
                </table>
                @if(isset($schedule->note))
                    <p style="font-weight: bold;color: red;text-align: left">
                        Lưu ý : {{ $schedule->note }}
                    </p>
                @endif
            </div>
            @if($countSchedule > 0)
                <div class="list-group" style="text-align: left;">
                    <span>
                        <i class="icon fa fa-calendar"></i>
                         Thông tin các lịch tuần khác
                    </span>
                    <ul class="css-timetable-ul">
                        @foreach($scheduleRandom as $scheduleRandom)
                            <li>
                                <a href="{{ route('timetable-users.show', $scheduleRandom->id) }}" class="css-timetable-a">{{ $scheduleRandom->title }}
                                    <span class="css-timetable-span">
                                   ( {{ date('d-m-Y', strtotime($scheduleRandom->created_at)) }} )
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
@endsection