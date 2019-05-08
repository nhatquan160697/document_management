@extends('layouts.admin.master')
@section('title')
    Trang quản lý - ĐH Nội Vụ
@endsection
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" onclick="departmentRedirect()">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Phòng Ban</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sumOfDepartments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="far fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" onclick="UsersRedirect()">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nhân Sự</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sumOfUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4" onclick="departmentAdminRedirect()">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Trưởng Đơn Vị</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sumOfAdminDepartments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @if(isset($schedule))
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
        @endif
    </div>
</div>

{{ Html::script(asset('/templates/admin/vendor/chart.js/Chart.min.js')) }}
{{ Html::script(asset('/templates/admin/js/demo/chart-area-demo.js')) }}
{{ Html::script(asset('/templates/admin/js/demo/chart-pie-demo.js')) }}
@endsection
