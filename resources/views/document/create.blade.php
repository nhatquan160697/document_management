@extends("layouts.user.master")
@section("title")
Tạo mới văn bản
@endsection
@section("content")
<div class="container">
    <div id="cards-wrapper" class="cards-wrapper row">
        <div class="create-doc">
            {!! Form::open(["method"=>"POST", "route"=>"document.store", "enctype"=>"multipart/form-data"]) !!}
            @include("common.errors")
                <div class="form-group" style="width: 45%;float: left;margin-right: 5%;margin-left: 2%">
                    {!! Form::label("document_number", "Số công văn", []) !!}
                    {!! Form::text("document_number", old("document_number"), ["class"=>"form-control", "id"=>"document_number", "placeholder"=>"Nhập số công văn..."]) !!}
                </div>
                <div class="form-group" style="width: 45%;float:left">
                    {!! Form::label("document_type_id", "Loại văn bản", []) !!}
                    {!! Form::select("document_type_id", $documentTypes, old("document_type_id"), ["class"=>"form-control", "id"=>"document_type_id"]) !!}
                </div>
                <div class="form-group" style="width: 45%;float: left;margin-right: 5%;margin-left: 2%">
                    {!! Form::label("department_id", "Đơn vị ban hành", []) !!}
                    {!! Form::select("department_id", $departments, old("department_id"), ["class"=>"form-control", "id"=>"department"]) !!}
                </div>
                <div class="form-group" style="width: 45%;float:left">
                    {!! Form::label("title", "Tiêu đề", []) !!}
                    {!! Form::text("title", old("title"), ["class"=>"form-control"]) !!}
                </div>
                <div class="form-group" style="width: 45%;float:left">
                    {!! Form::label("is_emergency", "Văn bản khẩn?", []) !!}
                    {!! Form::checkbox("is_emergency", old("is_emergency"), ["class"=>"form-control"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("content", "Trích yếu nội dung", []) !!}
                    {!! Form::textarea("content", old("content"), ["class"=>"form-control", "id"=>"content", "rows"=>"3", "placeholder"=>"Nhập trích yếu nội dung..."]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label("attachedFiles", "File đính kèm", []) !!}
                    {!! Form::file("attachedFiles[]", ["class"=>"form-control-file", "multiple", "id"=>"attachedFiles", "style"=>"width: 50%;margin-left: 33%"]) !!}
                </div>
                <div class="form-group" style="width: 35%;margin-left: 2%">
                    {!! Form::text("search", "", ["class"=>"form-control live-search-box", "placeholder"=>" Tìm kiếm đơn vị... "]) !!}
                </div>
                <div class="col-lg-5 col-sm-5 col-xs-12 float-left">
                    {!! Form::select("", $receivedDepartments, "1", ["id"=>"multiselect", "class"=>"form-control", "size"=>"8", "multiple"=>"multiple"]) !!}
                </div>

                <div class="multiselect-controls col-lg-2 col-sm-2 col-xs-12 float-left">
                    {!! Form::button("<i class='fa fa-forward'></i>", ["id"=>"multiselect_rightAll", "class"=>"btn btn-block"]) !!}
                    {!! Form::button("<i class='fa fa-chevron-right'></i>", ["id"=>"multiselect_rightSelected", "class"=>"btn btn-block"]) !!}
                    {!! Form::button("<i class='fa fa-chevron-left'></i>", ["id"=>"multiselect_leftSelected", "class"=>"btn btn-block"]) !!}
                    {!! Form::button("<i class='fa fa-backward'></i>", ["id"=>"multiselect_leftAll", "class"=>"btn btn-block"]) !!}
                </div>

                <div class="col-lg-5 col-sm-5 col-xs-12 float-left">
                    {!! Form::select("departments", [], old("departments"), ["id"=>"multiselect_to", "class"=>"form-control", "size"=>"8", "multiple"=>"multiple"]) !!}
                </div>
                <div class="clear"></div><br>
                <div class="form-group row">
                    {!! Form::submit("Gửi", ["class"=>"btn btn-primary"]) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
