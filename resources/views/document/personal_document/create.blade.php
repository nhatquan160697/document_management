@extends("layouts.user.master")
@section("title")
Tạo mới văn bản
@endsection
@section("content")
<div class="container">
    <div id="cards-wrapper" class="cards-wrapper row">
        <div class="create-doc">
            <h3>Gửi văn bản cho toàn đơn vị</h3>
            {!! Form::open(["method"=>"POST", "route"=>"document-personal.store", "enctype"=>"multipart/form-data"]) !!}
            @include("common.errors")
                <div class="form-group" style="width: 45%;float: left;margin-right: 5%;margin-left: 2%">
                    {!! Form::label("document_number", "Số công văn", []) !!}
                    {!! Form::text("document_number", old("document_number"), ["class"=>"form-control", "id"=>"document_number", "placeholder"=>"Nhập số công văn..."]) !!}
                </div>
                <div class="form-group" style="width: 45%;float:left">
                    {!! Form::label("document_type_id", "Loại văn bản", []) !!}
                    {!! Form::select("document_type_id", $documentTypes, old("document_type_id"), ["class"=>"form-control", "id"=>"document_type_id"]) !!}
                </div>
                <div class="form-group" style="width: 45%;float: left;margin-right: 5%;margin-left: 2%;">
                    <label for="publish_date">Ngày ban hành</label>
                    <div id="datepicker" class="input-group date" style="border: 1px solid #ced4da;">
                        {!! Form::text("publish_date",'', ['data-date-format'=>'dd/mm/yyyy', "class"=>"form-control", "readonly", "style" => "background: #fff;border:none;"]) !!}
                        <span style="background-color: #fff;width: 7%;display:none" class="input-group-addon"></span>
                    </div>
                </div>
                <div class="form-group" style="width: 45%;float:left">
                    {!! Form::label("title", "Tiêu đề", []) !!}
                    {!! Form::text("title", old("title"), ["class"=>"form-control"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("content", "Trích yếu nội dung", ['style' => 'margin-right: 75%;']) !!}
                    {!! Form::textarea("content", old("content"), ["class"=>"form-control", "id"=>"content", "rows"=>"3", "placeholder"=>"Nhập trích yếu nội dung..."]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("attachedFiles", "File đính kèm", []) !!}
                    {!! Form::file("attachedFiles[]", ["class"=>"form-control-file", "multiple", "id"=>"attachedFiles", "style"=>"width: 50%;margin-left: 33%", 'required']) !!}
                </div>
                <div class="form-group row">
                    {!! Form::submit("Gửi", ["class"=>"btn btn-primary", 'style' => 'width: 15%;']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
