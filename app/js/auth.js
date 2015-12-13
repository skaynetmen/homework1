window.APP.auth = (function ($) {
    'use strict';
    var $form = $('#authForm');

    var submit = function () {
        var fields = [
                {
                    name: 'email',
                    rules: {
                        required: true,
                        validEmail: true
                    },
                    messages: {
                        required: 'Пожалуйства введите Ваш email.',
                        validEmail: 'Некорректный email.'
                    }
                },
                {
                    name: 'password',
                    rules: {
                        required: true,
                        minLength: 6
                    },
                    messages: {
                        required: 'Пожалуйства введите Ваш пароль.',
                        minLength: 'Пароль не может состоять меньше чем из 6 символов.'
                    },
                }
            ],
            success = function (e) {
                e.preventDefault ? e.preventDefault() : (e.returnValue = false);

                var data = $(this).serialize();

                alert(data);
            };


        $form.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var placeholder = function () {
        //Modernizr.input.placeholder
        if ($('html').hasClass('lt-ie9')) {
            $form.find('input, textarea').placeholder();
        }
    };

    return {
        init: function () {
            placeholder();
            submit();
        }
    };
})(window.jQuery);

window.APP.auth.init();