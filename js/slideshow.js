var slideshowImages,
        slideshowNavegationButtons,
		slideshowNavegationList,
        slideshowInterval,
		slideshowSaberMaisLink;
var slideshowIntervalTime = 5000;
var effectInTime = 500;
var imageCount = 0;
var buttonStatusInactive = false;

$("document").ready(function() {
	preparaSlideshow();
	manipulaBotoes();
	initSlideshow();
});

function preparaSlideshow() {
	centraNavegationButtons();
	preparaNavegacaoSlideshow();

	slideshowImages = $("#slideshowImages img");
	preparaElementoSlideShow(slideshowImages);
	slideshowNavegationList = $("#slideshowList li");
	preparaElementoSlideShow(slideshowNavegationList);
	slideshowSaberMaisLink = $("#saberMais li");
	preparaElementoSlideShow("#saberMais li");


}

function preparaElementoSlideShow(elem) {
	var elemento = $(elem);

    for (var i = 0; i < elemento.length; i++) {

        //para que o primeiro elemento fique à frente
        if (i > 0) {
            $(elemento[i]).hide();
        }
    }
}

function centraNavegationButtons() {
	var larguraSlideShow = $('#slideshow').outerWidth();
	var larguraNavegationButtons = $('#navegationButtons').outerWidth();
	var leftMargin = (larguraSlideShow - larguraNavegationButtons) / 2;

	$('#navegationButtons').css('marginLeft',leftMargin);
}

function preparaNavegacaoSlideshow() {
	slideshowNavegationButtons = $("#navegationButtons li");

    for (i = 0; i < slideshowNavegationButtons.length; i++) {
        //para que o primeiro icon fique seleccionado
        if (i === 0) {
            $(slideshowNavegationButtons[i]).addClass("slide_ativo");
        }
    }
}

//manipulação do slideshow
function resetSlideshowInterval() {
	if (buttonStatusInactive) {
		clearInterval(slideshowInterval);
		slideshowInterval = setInterval(showImageSlideshow, slideshowIntervalTime);
	}
}

function initSlideshow() {
    slideshowInterval = setInterval(showImageSlideshow, slideshowIntervalTime);
}

//aceder aos botoes de navegacao e manipular o click
function manipulaBotoes() {
    for (var i = 0; i < slideshowNavegationButtons.length; i++) {
        $(slideshowNavegationButtons[i]).attr({
			"id": i
		});

        $(slideshowNavegationButtons[i]).click(function() {
            showImageNavegationButtonSelected($(this).attr("id"));
        });
    }

    var leftButton = $("#left_button");
    $(leftButton).click(function(){
		backwardImage();
	});

    var rightButton = $("#right_button");
    $(rightButton).click(function(){
		forwardImage();
	});
}

function showWorksListElem(elem) {
    for (var i = 0; i < $(slideshowNavegationList).length; i++) {

        if (i === elem) {
            effectOn(slideshowNavegationList[i]);
        } else {
            $(slideshowNavegationList[i]).fadeOut(0);
        }
    }
}

function showSaberMaisLinkElem(elem) {
	for (var i = 0; i < $(slideshowSaberMaisLink).length; i++) {

        if (i === elem) {
            effectOn(slideshowSaberMaisLink[i]);
        } else {
            $(slideshowSaberMaisLink[i]).fadeOut(0);
        }
    }
}

function backwardImage() {

	imageCount--;
	imgCountReset();

    chooseImage();
}

function forwardImage() {

	imageCount++;
	imgCountReset();

    chooseImage();
}

function showImageSlideshow() {
    imageCount++;
    imgCountReset();

    changeImageView();
}

function showImageNavegationButtonSelected(elem) {
    imageCount = elem;

    chooseImage();
}

function chooseImage() {
    if (!buttonStatusInactive) {
        toggleButtonStatus();

        resetSlideshowInterval();

        changeImageView();

        toggleButtonStatus();
    }
}

function changeImageView() {
    for (var i = 0; i < slideshowImages.length; i++) {

        if (i == imageCount) {
            activeImg(i);
        } else {
            inactiveImg(i);
        }
    }
}

function toggleButtonStatus() {
    if (buttonStatusInactive) {
        buttonStatusInactive = false;
    } else {
        buttonStatusInactive = true;
    };
}

function changeNavegationButtonsOut(elem) {
    $(slideshowNavegationButtons[elem]).removeClass("slide_ativo");
    changeNavegationButtonsSelected();
}

//mantem o botao de navegacao activo de acordo com a imagem que está no slideshow
function changeNavegationButtonsSelected() {
	$(slideshowNavegationButtons[imageCount]).addClass("slide_ativo");
}

function imgCountReset() {
    if (imageCount > slideshowImages.length - 1) {
        imageCount = 0;
    } else if (imageCount < 0) {
        imageCount = slideshowImages.length - 1;
    }
}

function effectOn(elem) {
    $(elem).fadeIn(effectInTime);
}

function effectOff(elem) {
    $(elem).fadeOut(300);
}

function activeImg(elem) {
    showWorksListElem(elem);
	showSaberMaisLinkElem(elem);
    effectOn(slideshowImages[elem]);
}

function inactiveImg(elem) {
    effectOff(slideshowImages[elem]);
    changeNavegationButtonsOut(elem);
}