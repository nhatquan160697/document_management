<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trang đăng nhập - ĐH Nội Vụ Hà Nội</title>

    {{ Html::style(asset('/templates/admin/vendor/fontawesome-free/css/all.min.css')) }}
    {{ Html::style(asset('/templates/admin/vendor/fontawesome-free/css/css.css')) }}
    {{ Html::style(asset('/templates/admin/css/sb-admin-2.css')) }}

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6" style="margin:auto">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    {!! Form::open(['method'=>'POST', 'route'=>'login.store', 'class'=>'user']) !!}
                                        @include('common.errors')
                                        <div class="form-group">
                                            {!! Form::text('email', '',
                                                    ['id'=>'exampleInputEmail',
                                                    'class'=>'form-control form-control-user',
                                                    'aria-describedby'=>'emailHelp',
                                                    'placeholder'=>'Địa chỉ email...'
                                                    ]) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::password('password',
                                                    ['id'=>'exampleInputPassword',
                                                    'class'=>'form-control form-control-user',
                                                    'aria-describedby'=>'emailHelp',
                                                    'placeholder'=>'Mật khẩu'
                                                    ]) !!}
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        {!! Form::submit('Login', ['class'=>'btn btn-primary btn-user btn-block']) !!}
                                        {{-- <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> --}}
                                    {!! Form::close() !!}
                                    <hr />
                                    <div class="text-center">
                                        <a class="small" href="{{ route('forgot-password.index') }}">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Html::script(asset('/templates/admin/vendor/jquery/jquery.min.js')) }}
    {{ Html::script(asset('/templates/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')) }}
    {{ Html::script(asset('/templates/admin/vendor/jquery-easing/jquery.easing.min.js')) }}
    {{ Html::script(asset('/templates/admin/js/sb-admin-2.min.js')) }}

</body>

</html>
