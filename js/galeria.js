var lightboxStatus = false;

$(document).ready(function() {
    $('#miniFotos img').click(function() {
        toggleLightbox();
        updateLightBox(this);
    });
    $("#lightbox").click(toggleLightbox);
});


function toggleLightbox() {
    if (lightboxStatus === true) {
        lightboxStatus = false;
        $("#lightbox").css({
            display: "none"
        });
        $(".lightboxImage").remove();
    } else {
        lightboxStatus = true;
        $("#lightbox").css({
            display: "block",
            zIndex: "1500"
        });
    }
}
function updateLightBox(elem) {
    $('#borda span').html();
    var newSrc = elem.src.replace("mini_", "");
    var newTitle = elem.title;
    var newAlt = elem.alt;
    
    var lightboxImage = $("<img>");
    lightboxImage.css({display: 'none'});
    lightboxImage.attr({
        class: "lightboxImage",
        src: newSrc,
        title: newTitle,
        alt: newAlt
    });
    $("#lightbox").append(lightboxImage);
    lightboxImage.load(function() {
        lightboxImage.css({display: 'block'});
        lightboxImageRealWidth = $(this).outerWidth();
        lightboxImageRealHeight = $(this).outerHeight();
        centerResizeImage();
    });
}
function centerResizeImage() {
    var windowWidth = $(window).width() * 0.7;
    var windowHeight = $(window).height() * 0.7;
    var newWidth;
    var newHeight;
    if (lightboxImageRealWidth <= windowWidth && lightboxImageRealHeight <= windowHeight) {
        newWidth = lightboxImageRealWidth;
        newHeight = lightboxImageRealHeight;
        changeLightboxImage(newWidth, newHeight);
    } else {
        if ((lightboxImageRealWidth / $(window).width()) >= (lightboxImageRealHeight / $(window).height())) {
            newWidth = windowWidth;
            newHeight = windowWidth / lightboxImageRealWidth * lightboxImageRealHeight;
            changeLightboxImage(newWidth, newHeight);
        } else {
            newWidth = windowHeight / lightboxImageRealHeight * lightboxImageRealWidth;
            newHeight = windowHeight;
            changeLightboxImage(newWidth, newHeight);
        }
    }
    $(".lightboxImage").css({
        left: ($(window).width() - $(".lightboxImage").outerWidth()) / 2 + "px"
    });
    $(".lightboxImage").css({
        top: ($(window).height() - $(".lightboxImage").outerHeight()) / 2 + "px"
    });
    ajustaBorda();
}
function ajustaBorda() {
    var texto = $("#lightbox img").attr('alt');
    $('#borda span').html(texto);
    var largura = (parseInt($("#lightbox img").width()) + 20);
    $("#borda").css({
        width: largura + "px",
        height: (parseInt($("#lightbox img").height()) + 50) + "px",
        left: (parseInt($("#lightbox img").css('left').replace("px", "")) - 10) + "px",
        top: (parseInt($("#lightbox img").css('top').replace("px", "")) - 10) + "px",
    });
    $('#borda p').css({
        left: ((largura - parseInt($('#borda span').width())) / 2) + "px"
    });
}
function changeLightboxImage(newWidth, newHeight) {
    $(".lightboxImage").css({
        width: newWidth,
        height: newHeight,
        left: ($(window).width() - newWidth) / 2 + "px",
        top: ($(window).height() - newHeight) / 2 + "px"
    });
}