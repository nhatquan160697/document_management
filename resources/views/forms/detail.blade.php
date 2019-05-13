@extends('layouts.user.master')
@section('title')
    Show
@endsection
@section('content')
    <div class="container">
        <div id="cards-wrapper" class="cards-wrapper row detail-document-body">
            <div style="margin: 10px;width: 100%;;text-align: left">
                <div class="detail-head">
                    <h4 style="color:black;display: inline-block;">{{ $form->name }}</h4>
                    <div style="float: right"><span>Ngày ban hành: {{ date('d-m-Y', strtotime($form->sent_date)) }}</span></div>
                    <br>
                    <div class="content-document" style="margin-top: 15px;">
                        <p>{{ $form->description }}</p>
                    </div><br><div class="line"></div>
                    <div >
                        <div class="upload__files">
                            @foreach($arrayFileDecode as $value)
                                <div class="preview">
                                    <a href="/upload/files/form/{{ $value }}" download style="color:black;">
                                        @php
                                            $path = pathinfo($value,PATHINFO_EXTENSION);
                                        @endphp
                                        @if($path == 'docx' || $path == 'doc')
                                            <span class="preview__name files" title="{{ $value }}"><i class="fas fa-file-word"></i> {{ $value }}</span>
                                        @else
                                            <span class="preview__name files" title="{{ $value }}"><i class="fas fa-file-pdf"></i> {{ $value }}</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

    </div>
    {{ Html::script(asset('/templates/user/js/attach-file.js')) }}
@endsection
