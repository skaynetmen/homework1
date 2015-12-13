window.APP.feedback = (function ($) {
    'use strict';
    var $form = $('#feedbackForm');

    var submit = function () {
        var fields = [
                {
                    name: 'name',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите Ваше имя.',
                        minLength: 'Имя не может состоять меньше чем из 2 букв.'
                    },
                    errorMsgSubClass: 'left'
                },
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
                    name: 'message',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите сообщение.',
                    }
                },
                {
                    name: 'code',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите код с картинки.',
                    },
                    errorAppend: '.form__input-section'
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

window.APP.feedback.init();