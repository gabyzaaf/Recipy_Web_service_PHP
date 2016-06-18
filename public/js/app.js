jQuery(document).ready(function () {
    $('#modal-send').on('click', function () {
        var toto = $(this).parent().parent().find('.modal-body')[0];
        var forms = $(toto).find('form');

        $.each(forms, function (key, form) {
            var parent = $(form).parent()[0];
            if ($(parent).hasClass('tab-pane') && $(parent).hasClass('active')) {
                var attr = $(form).attr('ajax');
                if (typeof attr !== typeof undefined && attr !== false) {
                    ajaxSubmit(form);
                } else {
                    console.log($(form));
                    console.log("fail");
                }
            }
        });
    });

    $("span").tooltip();
});

function ajaxSubmit(form) {
    $.post($(form).attr('action'), $(form).serialize(), function (data) {
        console.log(data); // todo : has deleted
        data = $.parseJSON(data)
        console.log(data.body != undefined);
        console.log(data.error != undefined);
        if (data.location != undefined)
            window.location.replace(data.location);
        if (data.body != undefined)
            $(form).replaceWith(data.body);
        if (data.error != undefined) {
            errorId = 'error-' + $(form).attr('name');
            errorMessage = '<p id="' + errorId + '"class="col-md-12 alert alert-danger">' + data.error.message + '</p>';
            if ($('#'+errorId).length == 0) {
                $(form).prepend(errorMessage);
            } else {
                $('#'+errorId).replaceWith(errorMessage)
            }
        }
    })
}