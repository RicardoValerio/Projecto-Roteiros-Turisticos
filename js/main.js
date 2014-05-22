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
    validarFormLogin();
    validarFormRegisto();

    $('#login').click(function() {
        $('#lightboxLogin').removeClass().addClass('lightboxAtivo');

        //qd se carrega fora do botao e da div de login fecha a div login
        $("body").mousedown(function(localClicked) {
            var containerForm = $('#lightboxLogin form');
            var containerH1 = $('#lightboxLogin h1');
            //caso o click seja feito fora dos elementos definidos na variavel container ou dos seus 'filhos', a div do login é fechada
            if (!containerForm.is(localClicked.target) && containerForm.has(localClicked.target).length === 0 && !containerH1.is(localClicked.target) && containerH1.has(localClicked.target).length === 0) {
                $('#lightboxLogin').removeClass().addClass('lightboxInativo');
            }
        });

        //qd se carrega no ESC fecha a div login
        $("body").keydown(function(key) {
            if (key.keyCode == 27) {
                $('#lightboxLogin').removeClass().addClass('lightboxInativo');
            }
        });

        return false;
    });
    $('#registo').click(function() {
        $('#lightboxRegisto').removeClass().addClass('lightboxAtivo');

        //qd se carrega fora do botao e da div de login fecha a div login
        $("body").mousedown(function(localClicked) {
            var containerForm = $('#lightboxRegisto form');
            var containerH1 = $('#lightboxRegisto h1');
            //caso o click seja feito fora dos elementos definidos na variavel container ou dos seus 'filhos', a div do login é fechada
            if (!containerForm.is(localClicked.target) && containerForm.has(localClicked.target).length === 0 && !containerH1.is(localClicked.target) && containerH1.has(localClicked.target).length === 0) {
                $('#lightboxRegisto').removeClass().addClass('lightboxInativo');
            }
        });

        //qd se carrega no ESC fecha a div login
        $("body").keydown(function(key) {
            if (key.keyCode == 27) {
                $('#lightboxRegisto').removeClass().addClass('lightboxInativo');
            }
        });

        return false;
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
        } else {
            $(this).val($(this).val());
        }
    });
}

function centraLoginRegisto(element) {
    var windowSize = $(window).outerHeight();
    var boxSize = $('.loginRegistoBox').outerHeight(true);
    var titleSize = $(element + ' h1').outerHeight(true);
    var formSize = $(element + ' h1').outerHeight(true);

    var margemTop = (windowSize - (boxSize + formSize + titleSize)) / 2;
    $('.loginRegistoBox').css('marginTop', margemTop);
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

function validarFormLogin() {
    $("#formLogin").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: "required"
        },
        messages: {
            email: "Por favor preencha o seu email.",
            password: "Por favor preencha a sua password."
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