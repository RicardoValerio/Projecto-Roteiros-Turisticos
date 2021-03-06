$(document).ready(function() {
    formPlaceholder('input[name="subscrever"]', "Subscrever");
    formPlaceholder('input[name="procura"]', "Procura...");
    centraLoginRegisto('#lightboxLogin');
    centraLoginRegisto('#lightboxRegisto');

    $('#testemunhos li').click(function() {
        $('.testemunhoSelecionado').removeClass('testemunhoSelecionado');
        $(this).addClass('testemunhoSelecionado');
    });

    scrollCenter();

    validarFormRecuperarPassword();
    validarFormComentario();

    $('.loginRegistoBox').click(function(localClicked) {
        var button = $('input[type="submit"]');
        if (button.is(localClicked.target)) {
            return true;
        } else {
            return false;
        }
    });

    $('#recuperaPassword').click(function() {
        dialogMensageForm();
    });

});

function scrollCenter() {
    var windowSize = $(window).outerWidth();
    var contentSize = $('#all').outerWidth();
    var distancia = (contentSize - windowSize) / 2
    $(document).scrollLeft(distancia);
}

function formPlaceholder(selector, defaultText) {
    $(selector).val(defaultText).focus(function() {
        if ($(this).val() == defaultText) {
            $(this).val('');
        } else {
            $(this).val($(this).val());
        }
    }).blur(function() {
        if (($.trim($(this).val())) == "") {
            $(this).val(defaultText);
            if (selector == 'input[name="subscrever"]')
                $("#newsletterForm .error").html('');
        } else {
            $(this).val($(this).val());
        }
    });
}

function centraLoginRegisto(element) {
    var windowSize = $(window).outerHeight();
    var boxSize = $(element + ' .loginRegistoBox').outerHeight(true);

    var margemTop = (windowSize - boxSize) / 2;
    $(element + ' .loginRegistoBox').css('marginTop', margemTop);
}

function validarFormRecuperarPassword() {
    $("#recuperarPassword").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: "Por favor preencha o seu email."
        },
        submitHandler: function(form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.erro) {
                        $('#dialog_mensage_form .error').html(response.mensagem);
                        $('#dialog_mensage_form .error').css({
                            display: "block"
                        });
                    } else {
                        $('#dialog_mensage_form').dialog("close");
                        dialogMessageNormal('#dialog_mensage', 'Recuperar Password');
                        $('#dialog_text').html(response.mensagem);
                    }
                }
            });
            return false;
        }
    });
}

function validarFormComentario() {
    $("#formComentar").validate({
        rules: {
            comentar: {
                required: true,
                minlength: 5,
                maxlength: 50
            }
        },
        messages: {
            comentar: {
                required: "O seu comentário tem de ter pelo menos 5 caracteres.",
                minlength: "O seu comentário tem de ter pelo menos 5 caracteres.",
                maxlength: "O seu comentário não pode ter mais de 50 caracteres."
            }
        }
    });
}