var dialogMessageStatus = false;

$(document).ready(function() {
    
});

function dialogMessageNormal(elem, title) {
    $(elem).dialog({
        modal: true,
        draggable: false,
        resizable: false,
        width: "460px",
        closeOnEscape: true,
        title: title,
        buttons: {
            Ok: function() {
                $(this).dialog("close");
            }
        },
        open: function() {
            dialogMessageStatus = true;
            $('#dialog_text').css({
                paddingTop: "20px",
                paddingBottom: "20px"
            });
        },
        close: function() {
            dialogMessageStatus = false;
            $('#dialog_text').css({
                paddingTop: "0px",
                paddingBottom: "0px"
            });
        }
    });

    $(window).scroll(function() {
        if (dialogMessageStatus) {
            $(elem).dialog({
                position: {my: "center", at: "center", of: window}
            });
        }
    });
}

function dialogMensageForm() {
    $('#dialog_mensage_form').dialog({
        modal: true,
        draggable: false,
        resizable: false,
        width: "460px",
        closeOnEscape: true,
        open: function() {
            dialogMessageStatus = true;
            $('.dialog').css({
                display: "block"
            });
        },
        close: function() {
            dialogMessageStatus = false;
            $('.dialog').css({
                display: "none"
            });
        }
    });

    $(".dialog_mensage_form_button").click(function() {
        dialog("close");
    });

    $(window).scroll(function() {
        if (dialogMessageStatus) {
            $('#dialog_mensage_form').dialog({
                position: {my: "center", at: "center", of: window}
            });
        }
    });
}