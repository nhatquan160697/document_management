@extends('layouts.user.personal_document')
@section('title')
    Văn bản đến đơn vị
@endsection
@section('content')
    <div class="container">
        <div class="cards-wrapper">
            @include('common.errors')
        </div>
        <div id="cards-wrapper" class="cards-wrapper row detail-document-body">
            <div style="margin: 10px;width: 100%;;text-align: left">
                <div class="detail-head">
                    <h4 style="color:black;margin-bottom: 10px">{{ $document->title }}</h4>
                    <h5 style="color:black;display:inline">Công văn số: {{ $document->document_number }}</h5>
                    <div style="float: right"><span>Ngày ban hành: {{ date('d-m-Y', strtotime($document->publish_date)) }}</span></div>
                    <br>
                    <div style="margin-top: 35px;">
                        @if($document->avatar == 'user-default.png')
                            <img src="/templates/user/images/{{$document->avatar}}" style="width: 35px;height: 35px;border-radius: 2em;">&nbsp;
                        @else
                            <img src="/upload/images/{{$document->avatar}}" style="width: 35px;height: 35px;border-radius: 2em;">&nbsp;
                        @endif
                        <span style="color: black;font-weight: bold">{{ $document->name }}</span>
                        <div style="float: right">
                            <button class="pulse-button" id="show" title="Phản hồi"><i class="fa fa-reply"></i></button>
                        </div>
                    </div>
                    <br>
                    <div class="content-document">
                        <p>{{ $document->content }}</p>
                    </div>
                    <br>
                    <div class="line"></div>
                    <div>
                        <div style="margin: 5px 10px;">
                            @foreach($arrayFileDecode as $value)
                                <div class="preview1">
                                    <a href="/upload/files/document/{{ $value->name }}" download style="color:black;">
                                        @php
                                            $path = pathinfo($value->name,PATHINFO_EXTENSION);
                                        @endphp
                                        @if($path == 'docx' || $path == 'doc')
                                            <span class="preview__name files filesfix" title="{{ $value->name }}"><i class="fas fa-file-word"></i> {{ $value->name }}</span>
                                        @else
                                            <span class="preview__name files filesfix" title="{{ $value->name }}"><i class="fas fa-file-pdf"></i> {{ $value->name }}</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="clear"></div>
                    @foreach($replyDocument as $value)
                        <div style="border: 3px solid #e5e7e9;max-width: 800px;margin-bottom: 10px;">
                            <div class="detail-head">
                                <div style="margin: 10px;">
                                    @if($document->avatar == 'user-default.png')
                                        <img src="/templates/user/images/{{$document->avatar}}" style="width: 35px;height: 35px;border-radius: 2em;">&nbsp;
                                    @else
                                        <img src="/upload/images/{{$document->avatar}}" style="width: 35px;height: 35px;border-radius: 2em;">&nbsp;
                                    @endif
                                    <span style="color: black;font-weight: bold">{{ $value->name }}</span>
                                    <div style="float: right"><span title="{{ date('H:m:i ( d-m-Y )', strtotime($value->created_at)) }}">
                                            {{Carbon\Carbon::createFromTimeStamp(strtotime($value->created_at))->diffForHumans()}}</span>&nbsp;
                                        <button class="pulse-button" title="Phản hồi"><i class="fa fa-reply"></i></button>
                                    </div>
                                </div>
                                <br>
                                <div class="content-document" style="margin: 10px;">
                                    <p>{{ $value->content_reply }}</p>
                                </div>
                                <br>
                                <div class="line" style="max-width: 98%;margin: 0 auto;"></div>
                                <div >
                                    <div style="margin: 5px 10px;">
                                        @php
                                            $arrayFileReplyDecode = array();
                                            if(isset($value->file_attachment_reply)){
                                            $arrayFileReplyDecode = json_decode($value->file_attachment_reply);
                                            }
                                        @endphp
                                        @foreach($arrayFileReplyDecode as $value)
                                            @php
                                                $path = pathinfo($value,PATHINFO_EXTENSION);
                                            @endphp
                                            <div class="preview1">
                                                <a href="/upload/files/document_reply/{{ $value }}" download style="color:black;">
                                                    @if($path == 'docx' || $path == 'doc')
                                                        <span class="preview__name files filesfix" title="{{ $value }}"><i class="fas fa-file-word"></i> {{ $value }}</span>
                                                    @else
                                                        <span class="preview__name files filesfix" title="{{ $value }}"><i class="fas fa-file-pdf"></i> {{ $value }}</span>
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" class="btn btn-light rep-bot-button"><i class="fa fa-reply"></i>&nbsp;Phản hồi</button>
                    <button type="button" class="btn btn-light color-btn-share" onclick="share()" title="Chuyển tiếp văn bản đến toàn bộ nhân viên trong đơn vị"><i class="fas fa-share-alt"></i>&nbsp;Chuyển tiếp </button>
                    {!! Form::open(['method'=>'POST', 'route'=> ['share.document', $document->documentID], 'id' => 'share']) !!}
                    {!! Form::close() !!}
                    <div class="reply display-none" id="rep-area">
                        <div>
                            <span class="badge"style="padding-left: 1em;float:none !important;">RE: {{ $document->document_number }}</span>
                        </div>
                        {!! Form::open(['method'=>'POST', 'route'=>['reply.document-department', $document->documentID], 'files' => true]) !!}
                        {!! Form::textarea('content_reply', null, ['id' => 'content_reply', 'rows' => 5, 'cols' => 90, 'style' => 'resize:none']) !!}
                        <div class="upload">
                            <div class="upload__files">
                            </div>
                        </div>
                        <div class="reply-foot">
                            {!! Form::submit("Gửi", ['class' => 'btn btn-primary btchinh', 'id' => 'replyDocument']) !!}
                            <div class="reply-attach-file">
                                <label for="file-input">
                                    <i class="fa fa-paperclip" ></i>
                                </label>
                                {!! Form::file('file_attachment_reply[]', ['class' => 'upload__input', 'id' => 'file-input', 'multiple' => true])  !!}
                            </div>
                            <button class="fa fa-trash close-rep-area"></button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script(asset('/templates/user/js/attach-file.js')) }}
@endsection
