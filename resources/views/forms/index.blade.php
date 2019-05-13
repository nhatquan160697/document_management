@extends('layouts.user.master')
@section('title')
    Danh Sách Biễu Mẫu
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
                @if($form->count() == 0)
                    <div>
                        <span>Không có thông tin biểu mẫu.</span>
                    </div>
                @endif
                @foreach($form as $value)
                    <div class="list-group-item" >
                        <a href="{{ route('users-forms.show',$value->id) }}" title="{{ $value->name }}" >
                            <span style="text-align: left;float: left;color: black;width: 80%">{{ $value->name }}</span>
                            <span class="badge">{{ date('d-m-Y', strtotime($value->sent_date)) }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
