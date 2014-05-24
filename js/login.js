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
                dataType: "json",
                success: function(response) {
                    
                    if (response.Erro) {
                        dialogMessageNormal('#dialog_mensage', 'Login');
                        $('#dialog_text').html(response.Mensagem);
                    } else {
                        window.location.href = response.Mensagem;
                    }

                }
            });
            //return false;
            return true;
        }
    });
});