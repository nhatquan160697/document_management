<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="favicon.ico" />
        {{ Html::style(asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')) }}
        {{ Html::style(asset('/templates/user/css/bootstrap.min.css')) }}
        {{ Html::style(asset('/templates/user/css/style.css')) }}
        {{ Html::style(asset('/templates/user/css/styles.css')) }}
        {{ Html::style(asset('/templates/user/css/datepicker.css')) }}
        {{ Html::script(asset('/templates/user/js/jquery-3.2.1.slim.min.js')) }}
        {{ Html::script(asset('/templates/user/js/popper.min.js')) }}
        {{ Html::style(asset('/css/all.css')) }}
        {{ Html::style(asset('/templates/admin/vendor/fontawesome-free/css/all.min.css')) }}
    </head>
    <body class="landing-page">
        <div class="page-wrapper">
            @include('layouts.user.header')
            <section class="cards-section text-center">
				 <div class="item item-green col-lg-4 col-6" id="left-bar">

                    <div class="leftbar-pending-document">
                        <ul>
                            @if (auth()->user()->role == config('setting.roles.admin_department'))
                                @php
                                    $currentDepartmentId = DB::table('department_users')->where([
                                        'user_id' => Auth::user()->id,
                                       ])->first()->department_id;
                                    //count number document not yet be approved
                                    $pendingDocumentsQuantity = count(DB::table('documents')
                                        ->join('users', 'users.id', '=', 'documents.user_id')
                                        ->where([
                                            'documents.department_id' => $currentDepartmentId,
                                            'is_approved' => config('setting.department_user.no_approved')])
                                        ->select('documents.*')->get()
                                    );
                                    //count number document not yet seen
                                    $departmentID = \App\Models\DepartmentUser::where([
                                        'user_id' => Auth::user()->id
                                    ])->first();
                                    $arrDocumentID = \App\Models\Document::join('document_department', 'document_department.document_id', '=', 'documents.id')
                                        ->where('document_department.department_id', $departmentID->department_id)
                                        ->where('documents.is_approved', config('setting.document.approved'))
                                        ->get();
                                    if($arrDocumentID->count() > 0){
                                        foreach($arrDocumentID as $arrID){
                                              $listIdDoc = array();
                                              if(isset($arrID->document_id)){
                                                array_push($listIdDoc, $arrID->document_id);
                                              }
                                        }

                                        $documentDepartment = \App\Models\DocumentDepartment::whereIn('document_id', $listIdDoc)->where('department_id', $departmentID->department_id)->get();
                                        $count = 0;

                                        foreach($documentDepartment as $value){
                                            if(isset($value->array_user_seen) && $value->array_user_seen != ""){
                                                $check = true;
                                                $arrayUserSeenDecode = json_decode($value->array_user_seen);
                                                foreach($arrayUserSeenDecode as $ar){
                                                    if(Auth::user()->id == $ar){
                                                        $check = false;
                                                        break;
                                                    }
                                                }
                                                if($check == true){
                                                    $count = $count + 1;
                                                }
                                            }
                                            else {
                                               $count = $count + 1;
                                            }
                                        }
                                    }
                                    else {
                                        $count = 0;
                                    }
                                @endphp
                                <a href="{{route('document-department.index')}}">
                                    <li>
                                        <i class="icon-leftbar fa fa-download"></i>&nbsp;
                                        Văn bản đến đơn vị
                                        @if($count > 0)
                                            <span class="count-new-document">{{ $count }}</span>
                                        @endif
                                    </li>
                                </a>
                                <a href="{{route('document-sent.index')}}">
                                    <li>
                                        <i class="icon-leftbar fa fa-upload"></i>&nbsp;
                                        Văn bản đã gửi
                                    </li>
                                </a>
                                <a href="{{route('document-pending.index')}}">
                                    <li>
                                        <i class="icon-leftbar fa fa-download"></i>&nbsp;
                                        Văn bản đang chờ duyệt
                                        @if($pendingDocumentsQuantity > 0)
                                            <span class="count-new-document">
                                                {{$pendingDocumentsQuantity}}
                                            </span>
                                        @endif
                                    </li>
                                </a>
                            @else
                                @php
                                    $departmentID = \App\Models\DepartmentUser::where([
                                        'user_id' => Auth::user()->id,
                                    ])->first()->department_id;
                                    $documentUser = \App\Models\DocumentUser::where('department_id', $departmentID)->get();
                                    $arrayDocumentId = array();
                                    $countPersonalUnSeenDocumentsQuantity = 0;
                                    if($documentUser->count()>0){
                                        foreach($documentUser as $value){
                                            if(isset($value->array_user_id)){
                                                $jsonUserId = json_decode($value->array_user_id);
                                                foreach($jsonUserId as $key){
                                                    if($key == Auth::user()->id){
                                                        array_push($arrayDocumentId, $value->document_id);
                                                    }
                                                }
                                            }
                                        }
                                        $getDocumentPerson =
                                        \App\Models\DocumentUser::join('documents', 'documents.id', '=', 'document_user.document_id')
                                        ->whereIn('document_id', $arrayDocumentId)
                                        ->where('documents.is_approved', config('setting.document.approved'))
                                        ->get();
                                        if($getDocumentPerson->count()>0){
                                            $check = true;
                                            foreach($getDocumentPerson as $value){
                                                if(isset($value->array_user_seen)){
                                                    $jsonUserSeen = json_decode($value->array_user_seen);
                                                    foreach($jsonUserSeen as $key){
                                                        if($key == Auth::user()->id)
                                                        {
                                                            $check = false;
                                                            break;
                                                        }

                                                    }
                                                    if($check == true){
                                                        $countPersonalUnSeenDocumentsQuantity = $countPersonalUnSeenDocumentsQuantity + 1;
                                                    }
                                                }
                                                else
                                                {
                                                    $countPersonalUnSeenDocumentsQuantity = $countPersonalUnSeenDocumentsQuantity + 1;
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <a href="{{route('document-personal.index')}}">
                                    <li>
                                        <i class="icon-leftbar fa fa-download"></i>&nbsp;
                                        Văn bản đến cá nhân
                                        @if($countPersonalUnSeenDocumentsQuantity > 0)
                                            <span class="count-new-document">
                                                {{$countPersonalUnSeenDocumentsQuantity}}
                                            </span>
                                        @endif
                                    </li>
                                </a>
                            @endif
                            @if(auth()->user()->role == config('setting.roles.user') && auth()->user()->delegacy == config('setting.delegacy.department_admin'))
                                    @php
                                        //count number document not yet seen
                                        $departmentID = \App\Models\DepartmentUser::where([
                                            'user_id' => Auth::user()->id
                                        ])->first();
                                        $arrDocumentID = \App\Models\Document::join('document_department', 'document_department.document_id', '=', 'documents.id')
                                            ->where('document_department.department_id', $departmentID->department_id)
                                            ->where('documents.is_approved', config('setting.document.approved'))
                                            ->get();
                                        if($arrDocumentID->count() > 0){
                                            foreach($arrDocumentID as $arrID){
                                                  $listIdDoc = array();
                                                  if(isset($arrID->document_id)){
                                                    array_push($listIdDoc, $arrID->document_id);
                                                  }
                                            }

                                            $documentDepartment = \App\Models\DocumentDepartment::whereIn('document_id', $listIdDoc)->where('department_id', $departmentID->department_id)->get();
                                            $count = 0;

                                            foreach($documentDepartment as $value){
                                                if(isset($value->array_user_seen) && $value->array_user_seen != ""){
                                                    $check = false;
                                                    $arrayUserSeenDecode = json_decode($value->array_user_seen);
                                                    foreach($arrayUserSeenDecode as $ar){
                                                        if(Auth::user()->id == $ar){
                                                            $check = false;
                                                        }
                                                        else {
                                                            $check = true;
                                                        }
                                                    }
                                                    if($check == true){
                                                        $count = $count + 1;
                                                    }
                                                }
                                                else {
                                                   $count = $count + 1;
                                                }
                                            }
                                        }
                                        else {
                                            $count = 0;
                                        }
                                    @endphp
                                    <a href="{{route('document-department.index')}}">
                                        <li>
                                            <i class="icon-leftbar fa fa-download"></i>&nbsp;
                                            Văn bản đến đơn vị
                                            @if($count > 0)
                                                <span class="count-new-document">{{ $count }}</span>
                                            @endif
                                        </li>
                                    </a>
                            @endif
                        </ul>
                    </div>
                </div>
                @yield('content')
            </section>
        </div>
        @include('layouts.user.footer')
    {{ Html::script(asset('/templates/user/js/jquery-3.3.1.min.js')) }}
    {{ Html::script(asset('/templates/user/js/bootstrap.min.js')) }}
    {{ Html::script(asset('/templates/user/js/stickyfill.min.js')) }}
    {{ Html::script(asset('/templates/user/js/main.js')) }}
    {{ Html::script(asset('/templates/user/js/myStyle.js')) }}
    {{ Html::script(asset('/templates/user/js/bootstrapdatepick.min.js')) }}
    {{ Html::script(asset('/templates/user/js/bootstrap-datepicker.js')) }}
        {{ Html::script(asset('/js/all.js')) }}
        {{ Html::script(asset('/js/app.js')) }}
    </body>
</html>


