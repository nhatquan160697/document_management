<header class="header text-center">
    <div class="container">
        <div class="tagline" style="margin-top: 20px;font-size: 26px;">
            <p>Phân hiệu Trường Đại Học Nội Vụ Hà Nội</p>
        </div>
        <div class="branding">
            <h1 class="logo">
                <span aria-hidden="true" class="fa fa-file-text head-icon" style="font-size: 45px;margin-right: 10px;"></span>
                <span class="text-highlight" style="font-size: 42px">Hệ thống lưu trữ tài liệu</span>
            </h1>
        </div>
    </div>
</header>
<div>
    <span style="margin-left: 37%;">Bạn chưa đăng nhập ?</span>
    <a class="btn btn-primary btn-user" style="margin: 2% auto;width: 13%;margin-left: 10px;" href="{{ route('login.index') }}">
        Đăng Nhập
    </a>
</div>
@if(isset($schedule))
    <div style="text-align: center;margin-bottom: 2%">
        <h4>LỊCH CÔNG TÁC</h4>
        <span>{{ $schedule->title }}</span>
    </div>
    <div class="schedule-show">
        <table class="table table-striped table-bordered" style="width:100%">
            <tr >
                <th width="10%">Thứ, ngày</th>
                <th width="30%">Sáng</th>
                <th width="30%">Chiều</th>
                <th width="30%">Tối</th>
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
            <p style="font-weight: bold;color: red">
                Lưu ý : {{ $schedule->note }}
            </p>
        @endif
    </div>
@else
    <div style="text-align: center;margin-bottom: 2%">
        <h4>LỊCH CÔNG TÁC</h4>
        <span>Hiện tại ,Tuần này không có thời khóa biểu.</span>
    </div>
    <div class="schedule-show">
        <div class="schedule-show">
            @php
                $getMondayThisWeek = date('d-m-Y', strtotime('last monday', strtotime('next monday')));
            @endphp
            <table class="table table-striped table-bordered" style="width:100%">
                <tr >
                    <th width="10%">Thứ, ngày</th>
                    <th width="30%">Sáng</th>
                    <th width="30%">Chiều</th>
                    <th width="30%">Tối</th>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 2 <br />{{ $getMondayThisWeek }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 3 <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +1 day')) }} </td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 4 <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +2 day')) }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 5 <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +3 day')) }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 6 <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +4 day')) }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Thứ 7 <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +5 day')) }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
                <tr>
                    <td width="10%" class="style-col-schedule">Chủ nhật <br />{{ date('d-m-Y', strtotime($getMondayThisWeek . ' +6 day')) }}</td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                    <td width="30%" class="style-col-content"></td>
                </tr>
            </table>
    </div>
@endif
{{ Html::style(asset('/templates/user/css/font-awesome.min.css')) }}
{{ Html::style(asset('/templates/user/css/bootstrap.min.css')) }}
{{ Html::style(asset('/templates/user/css/style.css')) }}
{{ Html::style(asset('/templates/user/css/styles.css')) }}
{{ Html::style(asset('/templates/user/css/datepicker.css')) }}
{{ Html::script(asset('/templates/user/js/jquery-3.2.1.slim.min.js')) }}
{{ Html::script(asset('/templates/user/js/popper.min.js')) }}
{{ Html::style(asset('/css/all.css')) }}
{{ Html::style(asset('templates/admin/vendor/fontawesome-free/css/all.min.css')) }}
{{ Html::style(asset('/templates/user/css/bootstrap.css')) }}
{{ Html::style(asset('/templates/user/css/dataTables.bootstrap4.min.css')) }}
{{ Html::script(asset('/templates/user/js/jquery-3.3.1.min.js')) }}
{{ Html::script(asset('/templates/user/js/bootstrap.min.js')) }}
{{ Html::script(asset('/templates/user/js/stickyfill.min.js')) }}
{{ Html::script(asset('/templates/user/js/main.js')) }}
{{ Html::script(asset('/templates/user/js/myStyle.js')) }}
{{ Html::script(asset('/templates/user/js/bootstrapdatepick.min.js')) }}
{{ Html::script(asset('/templates/user/js/bootstrap-datepicker.js')) }}
{{ Html::script(asset('/js/all.js')) }}
{{ Html::script(asset('/js/app.js')) }}
{{ Html::style(asset('/templates/user/css/bootstrap-select.min.css')) }}
{{ Html::script(asset('/templates/user/js/jquery.dataTables.min.js')) }}
{{ Html::script(asset('/templates/user/js/dataTables.bootstrap4.min.js')) }}
{{ Html::script(asset('/templates/user/js/bootstrap-select.min.js')) }}