@extends('layouts.user.master')
@section('title')
    Thêm ủy quyền
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thêm người muốn ủy quyền</h6>
                <p>Những người được ủy quyền sẽ được tạo và quản lý các văn bản, công văn</p>
            </div>
            @include('common.errors')
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open([
                                        'method'=>'POST',
                                        'route'=>'delegacy.store'
                                        ]) !!}
                                {!! Form::label('name', 'Chọn nhân viên') !!}
                                <div class="form-group">
                                    {!! Form::select('user_id', $searchAdmin, null,
                                            ['class' => 'selectpicker form-control',
                                            'data-live-search' => 'true']) !!}
                                </div>

                                {!! Form::submit('Thêm', [
                                    'class'=>'btn btn-primary mt-4 pr-4 pl-4']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Html::script(asset('/templates/user/js/handleDate.js')) }}
@endsection
