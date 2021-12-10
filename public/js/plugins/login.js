$(document).ready(function () {
    $("#post-email-forget").validate({
        rules: {
            forgetEmail: {
                required: true,
                email: true
            },
        }, messages: {
            forgetEmail: {
                required: 'Vui lòng nhập email',
                email: 'Vui lòng đúng định dạng email'
            }
        }
    })
    $("#form-login").validate({
        rules: {
            loginEmail: {
                required: true,
                email: true
            },
            loginPassword: {
                required: true,
                minlength: 6,
            },
        }, messages: {
            loginEmail: {
                required: 'Vui lòng nhập email',
                email: 'Vui lòng đúng định dạng email'
            },
            loginPassword: {
                required: 'Vui lòng nhập Mật khẩu',
                minlength: 'Ít nhất 6 kí tự '
            }
        }
    })
    $("#form-register").validate({
        rules: {
            name:{
              required: true,
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: "#password-register"
            }
        }, messages: {
            name: 'Vui lòng nhập họ và tên',
            email: {
                required: 'Vui lòng nhập email',
                email: 'Vui lòng đúng định dạng email'
            },
            password: {
                required: 'Vui lòng nhập Mật khẩu',
                minlength: 'Ít nhất 6 kí tự '
            },
            password_confirmation: {
                required: 'Chưa xác nhân Mật khẩu',
                minlength: 'Ít nhất 6 kí tự ',
                equalTo: 'Xác nhận mật khẩu không chính xác'
            }
        }
    })
    $('input[name="forgetEmail"]').keyup(function(){
        $('#err-email-forget').hide();
    })
    $('input[name="email"]').keyup(function(){
        $('#email-error').hide();
    })
    $('input[name="loginEmail"]').keyup(function(){
        $('#error-login-email').hide();
    })
})
