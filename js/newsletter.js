$(document).ready(function() {
    $("#newsletterForm").validate({
        rules: {
            subscrever: {
                required: true,
                email: true
            }
        },
        messages: {
            subscrever: "Insira um email válido."
        },
        submitHandler: function(form) {
            $.ajax({
                type: form.method,
                url: form.action,
                data: $(form).serialize(),
                success: function(response) {
                    dialogMessageNormal('#dialog_mensage', 'Newsletter');
                    $('#dialog_text').html(response);
                    formPlaceholder('input[name="subscrever"]', "Subscrever");
                }
            });
            return false;
        }
    });
});