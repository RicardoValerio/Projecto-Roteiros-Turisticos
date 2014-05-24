$(document).ready(function() {
    $("#formLogin").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: "Por favor preencha o seu email.",
            password: "Por favor preencha a sua password."
        },
        submitHandler: function(form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                success: function(response) {
                    dialogMessageNormal('#dialog_mensage', 'Login');
                    $('#dialog_text').html(response);
                }
            });
            return false;
        }
    });
});