<?php
return [
    'str_default' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    'patter_email' => '^[\w]{1,}[\w.+-]{0,}@[\w-]{2,}([.][a-zA-Z]{2,}|[.][\w-]{2,}[.][a-zA-Z]{2,})$',
    'patter_fullname' => '^[a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\\s]{6,}$',
    'patter_address' => '^[a-zA-Z0-9_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ] /@#$%&]+',
    'roles' => [
        'system_admin' => 1,
        'admin_department' => 2,
        'user' => 3,
    ],
    'active' => [
        'is_active' => 1,
        'no_active' => 0,
    ],
    'status' => [
        'no_lock' => 1,
        'lock' => 0,
    ],
    'position' => [
        'admin_department' => 1,
        'sub_admin' => 2,
        'secretary' => 3,
        'instructor' => 4,
    ],
    'department' => [
        'no_department' => 0,
        'active' => 1,
    ],
    'department_name' => [
        'training_department' => 1,
    ],
    'department_user' => [
        'active' => 1,
        'no_approved' => 0,
    ],
    'gender' => [
        'male' =>  1,
        'female' => 2,
    ],
    'delegacy' => [
        'no_delegacy' => null,
        'department_admin' => 1,
    ],
    'document' => [
        'approved' => 1,
        'pending' => 0,
        'file_location' => 'files/file_attachment',
    ],
    'document_user' => [
        'is_unseen' => 0,
        'is_seen' => 1,
    ],
    'reply' => [
        'is_reply_personal_document' => 1,
        'no_reply_personal_document' => 0,
    ],
    'approval' => [
        'is_approved' => 1,
        'no_approved' => 0,
        'cancel_approved' => 2,
    ],
    'seen' => [
        'is_seen' => 1,
        'not_seen' => 0,
    ],
    'parent_id_of_message' => 0,
];
