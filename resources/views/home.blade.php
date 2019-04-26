@extends('layouts.user.master')
@section('title')
    Trang quản lý - ĐH Nội Vụ
@endsection
@section('content')
    <div class="container">
        <div id="cards-wrapper" class="cards-wrapper row">
            <div class="item item-green item-2 col-lg-4 col-6">
                <div class="item-inner">
                    <div class="icon-holder">
                        <i class="icon fa fa-calendar-plus-o"></i>
                    </div>
                    <h3 class="title">Hồ sơ văn bản</h3>
                    <p class="intro">
                        Xem hồ sơ văn bản
                    </p>
                    @if (auth()->user()->role == config('setting.roles.admin_department'))
                        <a class="link" href="{{ route("document-department.index") }}"><span></span></a>
                    @elseif(auth()->user()->role == config('setting.roles.user'))
                        <a class="link" href="{{ route("document-personal.index") }}"><span></span></a>
                    @endif
                </div>
            </div>
            @if (auth()->user()->role == config('setting.roles.admin_department'))
                <div class="item item-orange item-2 col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fab fa-wpforms"></i>
                        </div>
                        <h3 class="title">Biểu mẫu</h3>
                        <p class="intro">
                            Tạo mới biểu mẫu
                        </p>
                        <a class="link" href="{{route('forms.index')}}"><span></span></a>
                    </div>
                </div>
                <div class="item item-blue col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-edit"></i>
                        </div>
                        <h3 class="title">Tạo mới và lưu văn bản</h3>
                        <p class="intro">
                            Tạo mới các văn bản, công văn, quyết định
                        </p>
                        <a class="link" href="{{ route('document.create') }}"><span></span></a>
                    </div>
                </div>
                <div class="item item-orange item-2 col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-users"></i>
                        </div>
                        <h3 class="title">Danh sách cán bộ, nhân viên</h3>
                        <p class="intro">
                            Quản lý danh sách giảng viên, thành viên
                        </p>
                        <a class="link" href="{{ route('users.index') }}"><span></span></a>
                    </div>
                </div>
                <div class="item item-red col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-calendar-check-o"></i>
                        </div>
                        <h3 class="title">Ủy quyền</h3>
                        <p class="intro">
                            Ủy quyền cho cán bộ soạn thảo và lưu văn bản
                        </p>
                        <a class="link" href="{{ route('delegacy.index') }}"><span></span></a>
                    </div>
                </div>
                <div class="item item-purple col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-calendar-check-o"></i>
                        </div>
                        <h3 class="title">Thời khóa biểu</h3>
                        <p class="intro">
                            Xem thời khóa biểu của trường
                        </p>
                        <a class="link" href="{{ route('timetable.index') }}"><span></span></a>
                    </div>
                </div>
            @endif
            @if (auth()->user()->role == config('setting.roles.user'))
                <div class="item item-purple col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-calendar-check-o"></i>
                        </div>
                        <h3 class="title">Thời khóa biểu</h3>
                        <p class="intro">
                            Xem thời khóa biểu của trường
                        </p>
                        <a class="link" href="{{ route('timetable-users.index') }}"><span></span></a>
                    </div>
                </div>
                <div class="item item-orange item-2 col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fab fa-wpforms"></i>
                        </div>
                        <h3 class="title">Biểu mẫu</h3>
                        <p class="intro">
                            Xem biểu mẫu có sẵn
                        </p>
                        <a class="link" href="{{route('users-forms.index')}}"><span></span></a>
                    </div>
                </div>
            @endif
            <div class="item item-red col-lg-4 col-6">
                <div class="item-inner">
                    <div class="icon-holder">
                        <i class="icon fa fa-calendar"></i>
                    </div>
                    <h3 class="title">Lịch tuần trường</h3>
                    <p class="intro">
                        Xem thời khóa biểu của tuần
                    </p>
                    <a class="link" href="{{ route('schedule.index') }}"><span></span></a>
                </div>
            </div>
            <div class="item item-orange col-lg-4 col-6">
                <div class="item-inner">
                    <div class="icon-holder">
                        <i class="icon fa fa-calendar-plus-o"></i>
                    </div>
                 </div>
            @endif
            @if (auth()->user()->role == config('setting.roles.user'))
                <div class="item item-purple col-lg-4 col-6">
                    <div class="item-inner">
                        <div class="icon-holder">
                            <i class="icon fa fa-calendar-check-o"></i>
                        </div>
                        <h3 class="title">Thời khóa biểu</h3>
                        <p class="intro">
                            Xem thời khóa biểu của trường
                        </p>
                        <a class="link" href="{{ route('timetable-users.index') }}"><span></span></a>
            @endif

            <div class="item item-primary item-2 col-lg-4 col-6">
                <div class="item-inner">
                    <div class="icon-holder">
                        <i class="icon fa fa-address-book"></i>
                    </div>
                    <h3 class="title">Các đơn vị liên kết</h3>
                    <p class="intro">
                        Xem các địa chỉ/ đơn vị liên kết
                    </p>
                    <a class="link" href="{{ route('collaboration-unit.index') }}"><span></span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
