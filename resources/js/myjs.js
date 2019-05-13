function submitForm(id) {
    const flag = confirm("Bạn có chắc chắc chắn muốn xóa không? \nCác dữ liệu liên quan sẽ không bị ảnh hưởng.");
    if (flag === true) {
        document.getElementById(id).submit();
    }
}
function submitFormDeleteHard(id) {
    const flag = confirm("Bạn có chắc chắc chắn muốn xóa vĩnh viễn nhân viên này không? \n Dữ liệu sẽ bị mất vĩnh viễn.");
    if (flag === true) {
        document.getElementById(id).submit();
    }
}
function restoreArchivedData(id) {
    const flag = confirm("Bạn có muốn khôi phục dữ liệu này?");
    if (flag === true) {
        document.getElementById(id).submit();
    }
}

function acceptApproval(id , type) {
    const flag = confirm("bạn có chắc chắc muốn duyệt "+type+" này không ?");
    if (flag === true) {
        document.getElementById(id).submit();
    }
}

function cancelApproval(id, type) {
    const flag = confirm("bạn có chắc chắc muốn hủy duyệt "+type+" này không ?");
    if (flag === true) {
        document.getElementById(id).submit();
    }
}

function changeDepartment(id) {
    const flag = confirm("Bạn có muốn thay đổi phòng ban của id: " + id + " này không ?");
    if (flag === true) {
        $("#changeDepartment" + id).submit();
    }
}

function changePosition(id) {
    const flag = confirm("Bạn có muốn thay đổi chức vụ của id " + id + " này không ?");
    if (flag === true) {
        $("#changePosition" + id).submit();
    }
}

$(document).ready(function() {
    //set initial state.
    $('#no_end_date').click(function() {
        if (!$(this).is(':checked')) {
            document.getElementById("end_date_div").style.display = "inherit";
            document.getElementById("end_date").disabled = false;
            $('#no_end_date').val(0);
        }
        else{
            document.getElementById("end_date_div").style.display = "none";
            document.getElementById("end_date").disabled = true;
            $('#no_end_date').val(1);
        }
    });
});

function share() {
    const flag = confirm("Bạn có muốn chuyển tiếp văn bản này đến toàn nhân viên trong đơn vị không ?");
    if (flag === true) {
        $("#share").submit();
    }
}

function departmentRedirect() {
    window.location.href = '/admin/department';
}
function UsersRedirect() {
    window.location.href = '/admin/department-user';
}
function departmentAdminRedirect() {
    window.location.href = '/admin/department-admin';
}
function infrastructureRedirect() {
    window.location.href = '/admin/infrastructure';
}

$(document).on('click', '#btnAddUser', function () {
    $.ajax({
        method: "GET",
        async: false,
        url: "/ajax-email",
    }).done(function (data) {
        var count = Object.keys(data).length;
        function validateEmail() {
            var email = document.getElementById("email");
            for (var i = 0; i < count; i++) {
                var obj = data[i];
                if (obj.email == email.value) {
                    return true;
                }
            }
            return false;
        }
        if (validateEmail() == true) {
            email.onchange = validateEmail;
            email.onkeyup = validateEmail;
            email.setCustomValidity("Tài Khoản Email " + email.value + " Đã Tồn Tại Trong Hệ Thống");
            $('#email').focus();
        }
        else {
            email.setCustomValidity("");
        }

        var new_password = document.getElementById("newpassword");
        var password_confirmation = document.getElementById("confirmpassword");
        if(new_password.value != password_confirmation.value)
        {
            password_confirmation.setCustomValidity('Vui lòng nhập giống với mật khẩu mới');
            $('#confirmpassword').focus();
        }
        else
        {
            password_confirmation.setCustomValidity("");
        }

        var sizef = document.getElementById("avatar");
        var fileUpload = sizef.files;
        for (var i = 0; i < fileUpload.length; i++){
            if (fileUpload[i].size/1024/1024 > 10){
                sizef.setCustomValidity('giới hạn upload file là 10 MB, file: '+fileUpload[i].name+' vượt quá 10mb');
            }
            else
            {
                sizef.setCustomValidity("");
            }
        }
    });
});

$(document).ready(function () {

    function readURLPicTure(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#avatar").change(function () {
        readURLPicTure(this);
    });

    $("#resetAdd").click(function () {
        this.form.reset();
        return false;
    })
});

jQuery(document).ready(function($){
    $('.live-search-list option').each(function(){
        $(this).attr('data-search-term', $(this).text().toLowerCase());
    });

    $('.live-search-box').on('keyup', function(){

        var searchTerm = $(this).val().toLowerCase();

        $('.live-search-list option').each(function(){

            if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
                $(this).show();
            } else {
                $(this).hide();
            }

        });

    });
});

$(document).on("click", "#editInfor", function(){
    $.ajax({
        url: '/ajax-infor',
        type: 'GET',
        cache: false,
        success: function(data){
            $('.css-profile').addClass('css-load-form');
            $('#ajaxform').html(data);
        },
        error: function (){
            alert("that bai");
        }
    });
    return false;
});

$(document).on("change", "#picture", function(){
    if(this.files[0].size/1024/1024  > 10){
        alert('giới hạn upload file là 10 MB, file: '+this.files[0].name+' vượt quá 10mb')
    }
    else {
        $('#changeAvatar').submit();
    }
});
//validate form schecule_week
$(document).on('click', '#btnAddSchedule', function () {
    var date = document.getElementById("start");
    var d = new Date(date.value);
    if( d.getDay() != 1) {
        date.setCustomValidity('Chỉ chọn được ngày bắt đầu từ thứ 2 của tuần');
            $('start').focus();
    }
    else
    {
        date.setCustomValidity("");
    }
});
//validate file upload timetable
$(document).on('click', '#btnTimeTable', function () {
    var sizef = document.getElementById("file_attachment");
    var fileUpload = sizef.files;
    for (var i = 0; i < fileUpload.length; i++){
        if (fileUpload[i].size/1024/1024 > 10){
            sizef.setCustomValidity('giới hạn upload file là 10 MB, file: '+fileUpload[i].name+' vượt quá 10mb');
        }
        else
        {
            sizef.setCustomValidity("");
        }
    }
});
//validate file upload form
$(document).on('click', '#btnForm', function () {
    var sizef = document.getElementById("link");
    var fileUpload = sizef.files;
    for (var i = 0; i < fileUpload.length; i++){
        if (fileUpload[i].size/1024/1024 > 10){
            sizef.setCustomValidity('giới hạn upload file là 10 MB, file: '+fileUpload[i].name+' vượt quá 10mb');
        }
        else
        {
            sizef.setCustomValidity("");
        }
    }
});
//validate file upload reply document
$(document).on('click', '#replyDocument', function () {
    var sizef = document.getElementById("file_attachment_reply");
    var fileUpload = sizef.files;
    for (var i = 0; i < fileUpload.length; i++){
        if (fileUpload[i].size/1024/1024 > 10){
            sizef.setCustomValidity('giới hạn upload file là 10 MB, file: '+fileUpload[i].name+' vượt quá 10mb');
        }
        else
        {
            sizef.setCustomValidity("");
        }
    }
});
//validate file upload infrastructure
$(document).on('click', '#btnInfrastructure', function () {
    var sizef = document.getElementById("avatar");
    var fileUpload = sizef.files;
    for (var i = 0; i < fileUpload.length; i++){
        if (fileUpload[i].size/1024/1024 > 10){
            sizef.setCustomValidity('giới hạn upload file là 10 MB, file: '+fileUpload[i].name+' vượt quá 10mb');
        }
        else
        {
            sizef.setCustomValidity("");
        }
    }
});

