@extends('layouts.user.personal_document')
@section('title')
    Văn bản đến đơn vị
@endsection
@section('content')
    <div class="container">
        <div id="cards-wrapper" class="cards-wrapper row detail-document-body">
            <div style="margin: 10px;width: 100%;text-align: left">
                <div class="detail-head">
                    <h4 style="color:black">{{ $document->title }}</h4>
                    <br>
                    <div>
                        <img src="/upload/images/{{$document->avatar}}" style="width: 35px;height: 35px;border-radius: 2em;">&nbsp;
                        <span style="color: black;font-weight: bold">{{ $document->name }}</span>
                        <div style="float: right"><span>{{ $document->publish_date }}</span></div>
                    </div>
                    <br>
                    <div class="content-document">
                        <p>{{ $document->content }}</p>
                    </div>
                    <br>
                    <div>
                        <div class="upload__files">
                            @foreach($attachedFiles as $file)
                            <a href="/files/file_attachment/{{$file->name}}" download class="preview"><span class="preview__name" title="{{$file->name}}">{{$file->name}}</span></a>

                            @endforeach
                        </div>
                    </div>
                    {!! Form::open(["method"=>"PATCH", "route"=>["document-pending.update",$document->id]]) !!}
                        {!! Form::button("<i class='fa fa-check'></i>&nbsp;Phê duyệt", ["class"=>"btn btn-primary rep-bot-button", "type" => "submit"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{ Html::script(asset('/templates/user/js/attach-file.js')) }}
@endsection
