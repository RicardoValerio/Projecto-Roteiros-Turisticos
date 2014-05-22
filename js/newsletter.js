/****************************************************************************
 *			NEWSLETTER FORM
 ****************************************************************************/

$(document).ready(function() {
    $(function() {
        $('#newsletterForm').bind('submit', function(event) {

            event.preventDefault();// using this page stop being refreshing

            $.ajax({
                type: 'POST',
                url: 'newsletterSubmitEmail.php',
                data: $('#newsletterForm').serialize(),
                success: function() {
                    $('#thanks').html("Obrigado por submeter o seu E-mail!");
                }
            });

        });
    });
});