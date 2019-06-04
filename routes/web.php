<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::resource('login', 'LoginController');

Route::get('/test-crawl', function () {
    return view('crawl');
});
Route::post('/search', [
    'as' => 'search-document',
    'uses' => 'SearchDocumentController@search'
]);

Route::get('schedule-weekly', [
    'as' => 'schedule-week.nologin',
    'uses' => 'ScheduleWeekController@indexNoLogin',
]);

Route::post('/update-avatar', [
    'as' => 'update.avatar',
    'uses' => 'Information@changeAvatar'
]);

Route::post('/information', [
    'as' => 'profile.update.pass',
    'uses' => 'Information@changePass'
]);

Route::post('/department-changepassword', [
    'as' => 'department-changepass',
    'uses' => 'Information@changePassDepartment'
]);

Route::get('/ajax-infor', [
    'as' => 'ajax.information',
    'uses' => 'Information@ajaxFormEdit'
]);

Route::post('/Update-Infor', [
    'as' => 'update.information',
    'uses' => 'Information@updateInfo'
]);

Route::resource('forgot-password', 'ForgotPasswordController');

Route::get('404', [
    'as' => 'not-found',
    'uses' => 'ErrorController@notFound',
]);

Route::resource('schedule', 'ScheduleWeekController');

Route::namespace ('Document')->group(function () {
    Route::post('/document/{id}', [
        'as' => 'reply.document',
        'uses' => 'DocumentController@reply',
    ]);
});

Route::group(['middleware' => 'checkSysAdmin'], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', [
            'as' => 'admin-index',
            'uses' => 'HomeAdminController@index',
        ]);

        Route::get('/information', [
            'as' => 'profile.index-admin',
            'uses' => 'Information@indexAdmin'
        ]);

        Route::namespace ('SystemAdmin')->group(function () {

            //department
            Route::resource('department', 'DepartmentController');

            Route::get('/deparment-archived', [
                'as' => 'department-archived',
                'uses' => 'DepartmentController@archive',
            ]);

            Route::put('/department-restore/{id}', [
                'as' => 'department-restore',
                'uses' => 'DepartmentController@restore',
            ]);

            //department admin
            Route::resource('create-department-admin', 'CreateAnAdmin');

            Route::resource('department-admin', 'DepartmentAdminController');

            Route::get('/deparment-admin-archived', [
                'as' => 'department-admin-archived',
                'uses' => 'DepartmentAdminController@archive',
            ]);

            Route::put('/department-admin-restore/{id}', [
                'as' => 'department-admin-restore',
                'uses' => 'DepartmentAdminController@restore',
            ]);

            //department user
            Route::resource('department-user', 'DepartmentUserController');

            //document-type
            Route::resource('document-type', 'DocumentTypeController');

            Route::get('/document-type-archived', [
                'as' => 'document-type-archived',
                'uses' => 'DocumentTypeController@archive',
            ]);

            Route::put('/document-type-restore/{id}', [
                'as' => 'document-type-restore',
                'uses' => 'DocumentTypeController@restore',
            ]);
        });
    });
});

Route::group(['middleware' => 'checkIsNotSysAdmin'], function () {

    Route::get('/', [
        'as' => 'home-page',
        'uses' => 'HomeController@index',
    ]);
    // tin nhắn cho cả 2 role
    Route::resource('chat', 'ChatController');
    //load tin nhắn
    Route::get('/chats/{id}', [
        'as' => 'load-message',
        'uses' => 'ChatController@loadMessage',
    ]);
    //lấy thông tin room chat của user đang đăng nhập
    Route::get('/get-room-of-current-user', [
        'as' => 'get-room-of-current-user',
        'uses' => 'ChatController@getRoomOfCurrentUser',
    ]);
    //lấy danh sách room
    Route::get('/list-room', [
        'as' => 'load-room',
        'uses' => 'ChatController@listRoom',
    ]);
    //lấy user đang login
    Route::get('/getUserLogin', function() {
        return Auth::user();
    });
    //kiểm tra tin nhắn mới
    Route::get('/check-is-new-chat/{id}', [
        'as' => 'check-is-new-chat',
        'uses' => 'ChatController@checkNewChat',
    ]);
    //lấy danh sách liên hệ
    Route::get('/list-user-in-chat', [
        'as' => 'list-user-in-chat',
        'uses' => 'ChatController@listUserInChat',
    ]);
    //lấy tên người dùng đang chát vs mình
    Route::get('/get-current-user-in-chat/{id}', [
        'as' => 'get-current-user-in-chat',
        'uses' => 'ChatController@getNameOfCurrentUserChat',
    ]);
    Route::get('/search-users-in-chat/{keyWord}', [
        'as' => 'search-user-chat',
        'uses' => 'ChatController@searchUser',
    ]);
    Route::post('/chats/{id}/{receiverId}', [
        'as' => 'send-message',
        'uses' => 'ChatController@sendMessage',
    ]);


    Route::resource('message', 'MessageController');

    Route::get('/message/create/{id}', [
        'as' => 'reply-message-user',
        'uses' => 'MessageController@createHaveUsers'
    ]);
    Route::post('/reply-message/{id}', [
        'as' => 'reply-message',
        'uses' => 'MessageController@reply'
    ]);

    Route::get('/del-multi-message/', [
        'as' => 'detele.message',
        'uses' => 'MessageController@deleteMulti'
    ]);
    Route::get('/information', [
        'as' => 'profile',
        'uses' => 'Information@index'
    ]);
    Route::resource('collaboration', 'CollaborationController');

    Route::group(['middleware' => 'checkDelegacy'], function () {
        // Phần chỉ dành cho Department admin, không dành cho ủy quyền
        Route::group(['middleware' => 'CheckIsTrainningDepartment'], function () {
            Route::namespace ('DepartmentAdmin')->group(function () {
                Route::resource('schedule-admin',
                    'ScheduleManagementController');
                Route::get('/schedule-archived', [
                    'as'   => 'schedule-archived',
                    'uses' => 'ScheduleManagementController@archive',
                ]);
                Route::put('/schedule-restore/{id}', [
                    'as'   => 'schedule-restore',
                    'uses' => 'ScheduleManagementController@restore',
                ]);
            });
        });
        Route::group(['middleware' => 'checkDepAdmin'], function () {
            Route::namespace ('Document')->group(function () {
                //dep-admin
                Route::resource('document-pending', 'PendingDocumentController');
            });
            Route::namespace ('DepartmentAdmin')->group(function () {
                // ủy quyền
                Route::resource('delegacy', 'DelegacyController');

                // users
                Route::resource('users', 'UserManagementController');
                Route::post('/delete-user/{id}', [
                    'uses' => 'UserManagementController@delete',
                    'as' => 'users.delete',
                ]);
                Route::get('/ajax-email', [
                    'uses' => 'UserManagementController@ajaxEmail',
                    'as' => 'ajax.email',
                ]);
                Route::get('/archive', [
                    'uses' => 'UserManagementController@archiveIndex',
                    'as' => 'users.archive',
                ]);
                Route::put('/archive-restore/{id}', [
                    'uses' => 'UserManagementController@restore',
                    'as' => 'users.archive.restore',
                ]);
                Route::get('/add-user-exists', [
                    'uses' => 'UserManagementController@indexOfAdd',
                    'as' => 'add.user.exists',
                ]);
                Route::post('/add-user-exists', [
                    'uses' => 'UserManagementController@addUserExist',
                    'as' => 'users.exists',
                ]);
            });
        });

        // Phần dành cho admin department và người được ủy quyền
        Route::namespace ('Document')->group(function () {
            // tạo mới và lưu văn bản
            Route::resource('document', 'DocumentController');
            Route::get('ajax/department/{id}', 'DocumentController@handleSelectDepartment');
            // văn bản đơn vị
            Route::resource('document-department', 'DocumentDepartmentController');
            Route::post('/share-document/{id}', [
                'uses' => 'DocumentDepartmentController@share',
                'as' => 'share.document',
            ]);
            Route::post('/document-department/{id}', [
                'as' => 'reply.document-department',
                'uses' => 'DocumentDepartmentController@reply',
            ]);
            //dep-admin
            Route::resource('document-sent', 'SentDocumentController');
            //văn bản các nhân
            Route::resource('document-personal', 'PersonalDocumentController', [
                'only' => ['store', 'create', 'edit', 'update']
            ]);
        });

        Route::namespace ('DepartmentAdmin')->group(function () {
            //infrastructure - depadmin
            Route::resource('infrastructure', 'InfrastructureManagementController');
            Route::get('/infrastructure-archive', [
                'uses' => 'InfrastructureManagementController@archiveIndex',
                'as' => 'infrastructure.archive',
            ]);
            Route::put('/infrastructure-archive-restore/{id}', [
                'uses' => 'InfrastructureManagementController@restore',
                'as' => 'infrastructure.archive.restore',
            ]);

            //TimeTable
            Route::resource('timetable', 'TimeTableController');
            Route::get('/timetable-archive', [
                'uses' => 'TimeTableController@archiveIndex',
                'as' => 'timetable.archive',
            ]);
            Route::put('/timetable-restore/{id}', [
                'uses' => 'TimeTableController@restore',
                'as' => 'timetable.archive.restore',
            ]);

            // form
            Route::resource('forms', 'FormManagementController');
            Route::get('/form-archive', [
                'uses' => 'FormManagementController@archiveIndex',
                'as' => 'forms.archive',
            ]);
            Route::put('/form-restore/{id}', [
                'uses' => 'FormManagementController@restore',
                'as' => 'forms.archive.restore',
            ]);
            Route::get('/approval', [
                'uses' => 'FormManagementController@approval',
                'as' => 'forms.approval',
            ]);
            Route::get('/approval/{id}', [
                'uses' => 'FormManagementController@detailApproval',
                'as' => 'forms.approval.detail',
            ]);
            Route::put('/cancel-approval{id}', [
                'uses' => 'FormManagementController@cancelApproval',
                'as' => 'forms.approval.cancel',
            ]);
            Route::put('/accept-approval/{id}', [
                'uses' => 'FormManagementController@acceptApproval',
                'as' => 'forms.approval.accept',
            ]);

            //collaboration-unit
            Route::resource('collaboration-unit', 'CollaborationUnitController');
            Route::get('/collaboration-unit-archived', [
                'as' => 'collaboration-unit-archived',
                'uses' => 'CollaborationUnitController@archive',
            ]);
            Route::put('/collaboration-unit-restore/{id}', [
                'as' => 'collaboration-unit-restore',
                'uses' => 'CollaborationUnitController@restore',
            ]);
        });
    });

    Route::group(['middleware' => 'checkUser'], function () {
        // thời khóa biểu của user - chỉ xem
        Route::resource('timetable-users', 'TimeTableController');
        Route::resource('infrastructure-user', 'InfrastructureController');
        // biểu mẫu của user - chỉ xem
        Route::resource('users-forms', 'FormsController');
        // chỉ xem danh sách user của đơn vị
        Route::resource('list-users', 'MemberController');
        // chỉ xem danh sách đơn vị liên kết của đơn vị
        Route::resource('collaboration', 'CollaborationController');
        
        Route::namespace ('Document')->group(function () {
            //user
            Route::resource('document-personal', 'PersonalDocumentController', [
                'only' => ['index', 'show']
            ]);
            Route::post('/document-personal/{id}', [
                'as' => 'reply.document-personal',
                'uses' => 'PersonalDocumentController@reply',
            ]);
        });

    });
});
