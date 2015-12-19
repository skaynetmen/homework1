/**
 * skValidator - jQuery validation plugin 1.0.0
 * Copyright (c) 2015 Alexandr Skrylev, http://alskr.ru
 * Is open source under the MIT license.
 */

(function ($) {
    'use strict';
    var
        id,
        form = {},
        settings = {
            fields: [],
            errorClass: 'error',
            errorMsgClass: 'error-msg',
            errorMsgSubClass: '',
            messages: {
                required: 'Поле обязательно для заполнения',
                minLength: 'Минимальное кол-во символов %s',
                maxLength: 'Максимальое кол-во символов %s',
                validEmail: 'Некорректный email',
                equalTo: 'Должно совпадать с полем %s'
            },
            success: {}
        },
        fields = [],
        errors = [];

    /**
     * Формирует имя селектора поля ошибки для jquery
     * @param errorClass
     * @param subClass
     * @param id
     * @returns {string}
     */
    var makeMsgSelector = function (errorClass, subClass, id) {
        var msgSelector = '.' + errorClass;

        if (subClass && $.trim(subClass) !== '') {
            msgSelector += '.' + subClass;
        }
        msgSelector += '.' + id;

        return msgSelector;
    };

    /**
     * Валидации указанного поля
     * @param field
     */
    var validateField = function (field) {
        //перед проверкой удалим поле из глобального массива
        var indexError = $.inArray(field.name, errors);
        if (indexError >= 0) {
            errors.splice(indexError, 1);
        }

        field.errors = [];
        //проверяем поле по всем правилам
        $.each(field.rules, function (rule, value) {
            if (typeof hooks[rule] === 'function') {
                if (!hooks[rule].apply(this, [field.that, value])) {
                    var msg = '';

                    //если у поля указанно сообщение ошибки, иначе ищем в базовых
                    if (field.messages[rule]) {
                        msg = field.messages[rule];
                    } else {
                        if (rule === 'minLength' || rule === 'minLength') {
                            msg = settings.messages[rule].replace('%s', value);
                        } else {
                            settings.messages[rule].replace('%s', field.name);
                        }
                    }

                    field.errors.push({
                        rule: rule,
                        message: msg
                    });
                }
            }
        });

        //если у нас есть ошибки
        if (field.errors && field.errors.length) {
            var event = (field.type === 'checkbox' || field.type === 'radio') ? 'change' : 'keyup',
                message = '';

            //помещаем имя поля в глобальный массив
            errors.push(field.name);

            //формируем список сообщений
            $.each(field.errors, function (key, value) {
                message += '<p>' + value.message + '</p>';
            });

            var appendChanged = field.errorAppend && field.that.closest(field.errorAppend).length > 0;

            //добавляем класс ошибки, навешиваем событие при котором будет произведена повторная проверка
            //и после поля, вставляем элемент с сообщением об ошибках
            field.that
                .addClass(settings.errorClass)
                .off(event + '.' + id)
                .on(event + '.' + id, function () {
                    field.that.removeClass(settings.errorClass);

                    if (!appendChanged) {
                        field.that
                            .next(makeMsgSelector(settings.errorMsgClass, field.errorMsgSubClass, id))
                            .remove();
                    } else {
                        field.that
                            .closest(field.errorAppend)
                            .find(makeMsgSelector(settings.errorMsgClass, field.errorMsgSubClass, id))
                            .remove();
                    }

                    validateField(field);
                });

            var $errorElement = $('<span/>', {
                'class': settings.errorMsgClass + ' ' + field.errorMsgSubClass + ' ' + id,
                'html': message
            });

            if (appendChanged) {
                field.that
                    .closest(field.errorAppend)
                    .append($errorElement)
            } else {
                field.that.after($errorElement);
            }
        }
    };

    /**
     * Объект хуков - Функций правил валидации
     * @type {{required: Function, minLength: Function, maxLength: Function, validEmail: Function, equalTo: Function}}
     */
    var hooks = {
        /**
         * Непустое поле
         * @param field
         * @returns {*}
         */
        required: function (field) {
            var value = field.val(),
                type = field.type;

            if (type === 'checkbox' || type === 'radio') {
                return field.prop('checked');
            }

            return ($.trim(value) !== '');
        },
        /**
         * Минимальная длинна строки
         * @param field
         * @param length
         * @returns {boolean}
         */
        minLength: function (field, length) {
            if (isNaN(length)) {
                return false;
            }

            return (field.val() && field.val().length >= parseInt(length, 10));
        },
        /**
         * Максимальная длинна строки
         * @param field
         * @param length
         * @returns {boolean}
         */
        maxLength: function (field, length) {
            if (isNaN(length)) {
                return false;
            }

            return (field.val() && field.val().length <= parseInt(length, 10));
        },
        /**
         * Корректный email адрес
         * @param field
         * @returns {boolean}
         */
        validEmail: function (field) {
            var reg, value;
            reg = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            value = field.val();
            return (value !== '') ? reg.test(value) : false;
        },
        /**
         * Эквивалентность полю
         * @param field
         * @param equalFieldName
         * @returns {boolean}
         */
        equalTo: function (field, equalFieldName) {
            //глупо сверять, если сверяемое поле пустое
            if (field.val() !== '') {
                var equalField = form.find('input[name="' + equalFieldName + '"]');

                if (equalField) {
                    return field.val() === equalField.val();
                }
            }

            return false;
        }
    };

    /**
     * Очищает состояние поля и удаляет сообщение ошибки
     * @param field
     */
    var clearField = function (field) {
        var event = (field.type === 'checkbox' || field.type === 'radio') ? 'change' : 'keyup',
            appendChanged = field.errorAppend && field.that.closest(field.errorAppend).length > 0;

        field.errors = [];

        field.that
            .removeClass(settings.errorClass)
            .off(event + '.' + id);

        if (!appendChanged) {
            field.that
                .next(makeMsgSelector(settings.errorMsgClass, field.errorMsgSubClass, id))
                .remove();
        } else {
            field.that
                .closest(field.errorAppend)
                .find(makeMsgSelector(settings.errorMsgClass, field.errorMsgSubClass, id))
                .remove();
        }

        return field;
    };

    /**
     * Валидация формы
     * @param that
     * @param options
     * @constructor
     */
    function Validator(that, options) {
        id = 'skValidator' + Math.floor((Math.random() * 100) + 1);
        form = $(that);
        settings = $.extend(settings, options);

        //добавляем в глобальный массив поля из переданных настроек
        $.each(settings.fields, function (key, value) {
            var selector = form.find('input[name="' + value.name + '"]'),
                type = selector.attr('type');

            //если input`a с таким именем не нашлось, ищем, может это textarea?
            if (selector && !selector.length) {
                selector = form.find('textarea[name="' + value.name + '"]');
                type = selector.length ? 'textarea' : '';
            }

            fields.push($.extend({
                    that: selector,
                    type: type,
                    errors: [],
                    errorMsgSubClass: settings.errorMsgSubClass
                }, value)
            );
        });

        //обрабатываем событие submit
        form.on('submit', function (event) {
            errors = [];

            //запускаем првоерку полей
            $.each(fields, function (key, value) {
                //если форма уже отправлялась, чистим состояние поля
                if (value.errors && value.errors.length) {
                    if (clearField(value)) {
                        validateField(value);
                    }
                } else {
                    validateField(value);
                }
            });

            //если были обнаружены ошибки, прерываем отправку формы
            if (errors && errors.length) {
                event.preventDefault ? event.preventDefault() : (event.returnValue = false);
            } else {
                //Если в настройки передана callback функция, вызываем ее
                if (typeof settings.success === 'function') {
                    //возможно здесь это не нужно, дадим пользователю возможность самому сделать выбор
                    //event.preventDefault();

                    settings.success.apply(this, [event]);
                }
            }
        });
    }

    /**
     * Инициализируем расширение для jquery
     * @param options
     * @returns {*}
     */
    $.fn.skValidator = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_skValidator')) {
                $.data(this, 'plugin_skValidator',
                    new Validator(this, options));
            }
        });
    };
})(jQuery);
