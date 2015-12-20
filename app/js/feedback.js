window.APP.feedback = (function ($) {
    'use strict';

    var $form = $('#feedbackForm'),
        $feedbackMsg = $('#feedbackMsg'),
        errorMsgClass = 'tooltip';

    /**
     * Отправка формы обратной связи
     */
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
                        required: 'Пожалуйства введите сообщение.'
                    }
                }/*,
                {
                    name: 'code',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите код с картинки.'
                    },
                    errorAppend: '.form__input-section'
                 }*/
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
                            $feedbackMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();
                        } else {
                            $feedbackMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $feedbackMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };

        //вешаем на форму валидатор
        $form.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: errorMsgClass
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

    /**
     * По нажатию на крестик в алертах, закрываем его
     */
    var closeAlert = function () {
        $feedbackMsg.on('click', '.alert__close', function () {
            $(this)
                .closest('.alert')
                .remove();
        });
    };

    /**
     * Удаление тултипов и состояния ошибки у полей,
     * при очистке формы
     */
    var clearForm = function () {
        $('#clearFeedbackForm').on('click', function () {
            $form.find('.form__input').each(function () {
                var $that = $(this);

                $that.removeClass('error');

                $('.' + errorMsgClass).remove();
            });
        });
    };

    //публичные методы
    return {
        init: function () {
            placeholder();
            submit();
            closeAlert();
            clearForm();
        }
    };
})(window.jQuery);

window.APP.feedback.init();