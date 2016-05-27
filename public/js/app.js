jQuery(document).ready(function () {
    $('#modal-send').on('click', function () {
        var toto = $(this).parent().parent().find('.modal-body')[0];
        var forms = $(toto).find('form');
        $.each(forms, function (key, form) {
            var parent = $(form).parent()[0];
            if ($(parent).hasClass('tab-pane') && $(parent).hasClass('active')) {
                $(form).submit();
            }
        });
    });
        $("span").tooltip();
});
