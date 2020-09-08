$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert").fadeTo(100, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);
});


$(window).on('load', function () {
    // make every select into selectize
    $('select').selectize({
        /*allowEmptyOption: true,
        placeholder: 'Select One',*/

        plugins: ['remove_button'],

    });
});

$(document).ready(function () {
    // Disable scroll when focused on a number input.
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel', function (e) {
            e.preventDefault();
        });
    });

    // Restore scroll on number inputs.
    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel');
    });

    // Disable up and down keys.
    $('form').on('keydown', 'input[type=number]', function (e) {
        if (e.which == 38 || e.which == 40)
            e.preventDefault();
    });

    const regex = /http:\/\/.*\//g;
    const match = regex.exec(window.location.href);

    // iterate over all and find match
    if (match) {
        $.each($('#sidebarmenu ul li'), function (index, item) {
            var elem = $(this);
            // console.log(elem.parent());
            var href = elem.children().attr('href');
            // console.log('i am input'+ match['input']);
            if (match['input'].indexOf(href) >= 0) {
                var selected = $(this).find('a');
                selected.addClass("active");
            }
        });
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
});