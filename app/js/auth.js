window.APP.auth = (function ($) {
    'use strict';

    var $form = $('#authForm'),
        $authMsg = $('#authMsg');

    /**
     * Отправка формы авторизации
     */
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
                    }
                }
            ],
            /**
             * Отправка формы через ajax
             * @param e
             */
            success = function (e) {
                e.preventDefault ? e.preventDefault() : (e.returnValue = false);

                var $that = $(this);

                $.ajax({
                    url: $that.attr('action'),
                    method: $that.attr('method'),
                    data: $that.serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (!data.error) {
                            $authMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();

                            setTimeout(function () {
                                window.location.href = '/';
                            }, 1000);
                        } else {
                            $authMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $authMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };

        //вешаем на форму валидатор
        $form.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    /**
     * Для ишака активируем плагин placeholder
     */
    var placeholder = function () {
        //Modernizr.input.placeholder
        if ($('html').hasClass('lt-ie9')) {
            $form.find('input, textarea').placeholder();
        }
    };

    //публичные методы
    return {
        init: function () {
            placeholder();
            submit();
        }
    };
})(window.jQuery);

window.APP.auth.init();