$(document).ready(function() {
    $("#formRegisto").validate({
        rules: {
            nome: "required",
            email: {
                required: true,
                email: true
            },
            password: "required"
        },
        messages: {
            nome: "Por favor preencha o seu nome.",
            email: "Por favor preencha o seu email.",
            password: "Por favor preencha a sua password."
        },
        submitHandler: function(form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                success: function(response) {
                    dialogMessageNormal('#dialog_mensage', 'Registo');
                    $('#dialog_text').html(response);
                }
            });
            return false;
        }
    });
});