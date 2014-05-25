var estrelas;

$(document).ready(function() {

    estrelas = $('#estrelas li');
    preencheEstrelasConformeVotacao();

    for (var i = 0; i < estrelas.length; i++) {
        $(estrelas[i]).attr({
            "id": i + 1
        });

        $(estrelas[i]).mouseover(function() {
            manipulaEstrelasVotacao($(this).attr("id"));
        });

    }
    $('#estrelas ul').mouseleave(function() {
        preencheEstrelasConformeVotacao();
    });

    $(estrelas).on('click', function() {
        var classificacao = $(this).attr("id");
        $.ajax({
            type: 'post',
            url: 'votacao.php',
            dataType: "json",
            data: {
                classificacao: classificacao
            },
            success: function(response) {
                dialogMessageNormal('#dialog_mensage', 'Votação');
                $('#dialog_text').html(response.mensagem);

                if (!response.erro) {
                    $('#classificacaoEstrelas').html(response.classificacao);
                    $('#classificacaoTexto').html(response.texto);
                    $('#numVotos').html(response.votos);

                    preencheEstrelasConformeVotacao();
                }

            }
        });
    });

});

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

function preencheEstrelasConformeVotacao() {
    var classificacaoMedia = parseFloat($("#classificacaoEstrelas").text().replace(",", "."));
    manipulaEstrelasVotacao(classificacaoMedia);
}