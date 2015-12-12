window.APP.feedback = (function ($) {
    'use strict';

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

                console.log('yea', data);
            };


        $('#feedbackForm').skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    return {
        init: function () {
            submit();
        }
    };
})(window.jQuery);

window.APP.feedback.init();