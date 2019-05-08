@extends('layouts.user.personal_document')
@section('title')
Văn bản đi
@endsection
@section('content')
@include("common.errors")
 <div class="container">
    <div id="cards-wrapper" class="cards-wrapper row">
        <div class="list-document-detail">
            <div id="sec1">
                <h4 class="h4-first">Văn bản đã gửi</h4>
                <div class="all-document list-group">
                    @foreach($documents as $document)
                        <div class="list-group-item ">
                            <a href="#" title="{{$document->content}}" >
                            <span class="name" style="max-width: 135px !important;color: black;">Đơn vị nhận: {{$document->name}}</span>
                                <span class="float-left" style="width: 60%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: left !important;">
                                    <span class="" style="color: black;">{{$document->title}}</span><br/>
                                    <span class="text-muted"><span style="color: black;">Trích yếu nội dung:&nbsp;{{$document->content}}</span></span>
                                </span>
                                <span class="badge">{{Carbon\Carbon::createFromTimeStamp(strtotime($document->sending_date))->diffForHumans()}}</span>
                            </a>
                            @if($document->is_approved == config('setting.document.approved'))
                                <span class="approved">Đã phê duyệt</span>
                            @else
                                <span class="userchinh3">Đang chờ</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
