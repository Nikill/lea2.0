var FormsGeneral = function() {

    return {
        init: function() {
            /* Toggle .form-bordered class on block's form */
            $('.toggle-bordered').click(function() {
                $(this)
                    .parents('.block')
                    .find('form')
                    .toggleClass('form-bordered');
            });
        }
    };
}();