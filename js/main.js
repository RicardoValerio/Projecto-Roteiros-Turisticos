var estrelas;

$(document).ready(function() {
    formPlaceholder('input[name="subscrever"]', "Subscrever");
    formPlaceholder('input[name="procura"]', "Procura...");
    centraLoginRegisto('#lightboxLogin');
    centraLoginRegisto('#lightboxRegisto');

    $('#testemunhos li').click(function() {
        $('.testemunhoSelecionado').removeClass('testemunhoSelecionado');
        $(this).addClass('testemunhoSelecionado');
    });

    estrelas = $('#estrelas li');
    for (var i = 0; i < estrelas.length; i++) {
        $(estrelas[i]).attr({
            "id": i + 1
        });

        $(estrelas[i]).mouseover(function() {
            manipulaEstrelasVotacao($(this).attr("id"));
        });

    }
    $('#estrelas ul').mouseleave(function() {
        var classificacaoMedia = parseFloat($("#classificacaoEstrelas").text().replace(",", "."));
        manipulaEstrelasVotacao(classificacaoMedia);
    });

    scrollCenter();

    validarFormInserirRoteiro();


    $('.loginRegistoBox').click(function(localClicked) {
            var button = $('input[type="submit"]');
            if (button.is(localClicked.target)) {
                return true;
            } else {
                return false;
            }
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

function manipulaEstrelasVotacao(elem) {
    var int_classificacao = Math.floor(elem);
    var metade_classificacao = elem - int_classificacao;

    for (var i = 0; i < estrelas.length; i++) {
        $(estrelas[i]).removeClass();
    }

    for (var i = 0; i < int_classificacao; i++) {
        $(estrelas[i]).addClass('estrelaCompleta');
    }

    var incremento = 0;
    if (metade_classificacao > 0) {
        incremento = 1;
        $(estrelas[int_classificacao]).addClass('estrelaMetade');
    }
    for (var i = int_classificacao + incremento; i < estrelas.length; i++) {
        $(estrelas[i]).addClass('estrelaVazia');
    }
}

function validarFormInserirRoteiro() {
    $("#formInserirRoteiro").validate({
        rules: {
            nome: "required",
            regiao: "required",
            tempo: "required",
            tipoPercurso: "required",
            descricao: "required"
        },
        messages: {
            nome: "Por favor preencha o nome do roteiro.",
            regiao: "Por favor selecione a regi&#227;o do roteiro.",
            tempo: "Por favor preencha o tempo do roteiro.",
            tipoPercurso: "Por favor escolha o tipo de percurso do roteiro.",
            descricao: "Por favor preencha a descri&#231;&#227;o do roteiro."
        }
    });
}

function validarFormRegisto() {
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
        }
    });
}