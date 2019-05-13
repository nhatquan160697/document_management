@extends('layouts.user.personal_document')
@section('title')
Văn bản đang chờ duyệt
@endsection
@section('content')
 <div class="container">
    <div id="cards-wrapper" class="cards-wrapper row">
        <div class="list-document-detail">
            <div id="sec1">
                <h4 class="h4-first">Văn bản đang chờ duyệt</h4>
                @include('layouts.user.search', ['currentPage'=>'pendingDocument'])
                <div class="all-document list-group" style="position: relative">
                    @if($documents->count() == 0)
                        <div class="list-group-item">
                            <span>Không có văn bản nào đang chờ duyệt.</span>
                        </div>
                    @endif
                    @foreach($documents as $document)
                    <div class="list-group-item" style="width: 95%;" onclick="showDocumentPending('{{$document->id}}')">
                        <a href="{{ route('document-pending.show',$document->id) }}" title = "{{$document->content}}" >
                        <span class="name" style="max-width: 135px !important;color: black;">{{$document->document_number}}</span>
                            <span class="float-left" style="width: 60%;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: left !important;">
                                <span class="" style="color: black;">{{$document->title}}</span><br/>
                                <span class="text-muted"><span style="color: black;">Trích yếu nội dung:&nbsp;{{$document->content}}</span></span>
                            </span>
                            <span class="badge">{{ date('H:m:i ( d-m-Y )', strtotime($document->created_at)) }}</span>
                        </a>
                        <span class="name userchinh">Người gửi</span>
                        <span class ="name userchinh1"><a href="" style="color:#f7f7f7;">{{$document->name}}</a></span>
                    </div>
                        <a href="javascript:void(0)" onclick="acceptApproval('acceptApproval'+{{$document->id }}, 'văn bản')" style="position: absolute;top:15px;right: 0px;"><i class="fas fa-check-circle" style="font-size: 20px;color: green" ></i></a>
                        {!! Form::open(['method'=>'PATCH', 'route'=>['document-pending.update',$document->id], 'id' => 'acceptApproval'.$document->id]) !!}
                        {!! Form::close() !!}
                        <a href="javascript:void(0)" onclick="cancelApproval('cancelApproval'+{{ $document->id }}, 'văn bản')" style="position: absolute;bottom:15px;right: 0px;"><i class="fas fa-ban" style="font-size: 20px;color:red" ></i></a>
                        {!! Form::open(['method'=>'DELETE', 'route'=>['document-pending.destroy',$document->id], 'id' => 'cancelApproval'.$document->id]) !!}
                        {!! Form::close() !!}
                    @endforeach
                    <div>
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
