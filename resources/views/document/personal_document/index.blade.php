@extends('layouts.user.personal_document')
@section('title')
Văn bản đến cá nhân
@endsection
@include("common.errors")
@section('content')
 <div class="container">
    <div id="cards-wrapper" class="cards-wrapper row">
        <div class="list-document-detail">
            <div id="sec1">
                <h4 class="h4-first">Văn bản đến cá nhân</h4>
                <div class="all-document list-group">
                    @foreach($document as $value)
                        @php
                            $id = \App\Models\DocumentUser::where('document_id', $value->documentID)->first();
                            $id_reply = \App\Models\ReplyDocument::where('document_id',$value->documentID)->first();
                            $arrId = json_decode($id->array_user_seen);
                            $checkNew = false;
                            if(isset($arrId)){
                                foreach($arrId as $arr){
                                    if(Auth::user()->id == $arr){
                                        $checkNew = true;
                                    }
                                }
                            }
                        @endphp
                        <div class="list-group-item {{ ($checkNew == true)? '':'newDoc'}} @if(isset($id_reply->user_id)) {{($id_reply->user_id == Auth::user()->id)?'replied':''}}@endif" >
                            <a href="{{ route('document-personal.show',$value->documentID) }}" title="{{ $value->content }}" >
                                <span class="name" style="max-width: 135px !important;color: black;">{{ $value->name_department }}</span>
                                <span class="float-left" style="width: 60%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: left !important;">
                                    <span class="" style="color: black;">{{ $value->title }}</span></br>
                                    <span class="text-muted"><span style="color: black;">Trích yếu nội dung: {{ $value->content }}</span></span>
                                </span>
                                <span class="badge" title="{{ date('H:m:i ( d-m-Y )', strtotime($value->sent_date)) }}">
                                    {{Carbon\Carbon::createFromTimeStamp(strtotime($value->sent_date))->diffForHumans()}}
                                </span>
                            </a>
                            <span class="name userchinh">Người gửi</span>
                            <span class ="name userchinh1"><a href="" style="color:#f7f7f7;">{{ $value->name }}</a></span>
                            <span class ="name type_document"><span href="" style="color:#f7f7f7;">{{ $value->name_type_document }}</span></span>
                        @if($checkNew == true)
                                <span class="userchinh2">đã xem</span>
                            @else
                                <span class="userchinh3">Mới</span>
                            @endif
                        </div>
                    @endforeach
                    <div>
                        {{ $document->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
