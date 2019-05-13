@extends('layouts.user.master')
@section('title')
    Danh Sách Thời Khóa Biểu
@endsection
@section('content')
    <div class="container">
        <div id="cards-wrapper" class="cards-wrapper row">
            <div class="document-topBody">
                <div class="dropdown show dropdown-search">
                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sắp xếp theo...
                    </a>

                    <div class="dropdown-menu dropdown-filter" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                    </div>
                </div>
                <div class="form-search-doc">
                    <form class="form-inline form-search">
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" class="form-control input-search" id="search" placeholder="Nhập nội dung tìm kiếm...">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
                    </form>
                </div>
            </div>
            <div class="list-group">
                @if($timeTable->count() == 0)
                    <div>
                        <span>Không có thông tin thời khóa biểu.</span>
                    </div>
                @endif
                <ul class="css-timetable-ul">
                    @foreach($timeTable as $value)
                        <li>
                            <a href="{{ route('timetable-users.show', $value->id) }}" class="css-timetable-a">{{ $value->name }}
                                <span class="css-timetable-span">
                               ( {{ date('d-m-Y', strtotime($value->created_at)) }} )
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
