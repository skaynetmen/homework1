window.APP.admin = (function ($) {
    'use strict';

    var
        $workMsg = $('#workMsg'),
        $userMsg = $('#userMsg'),
        $formWork = $('#formWork'),
        $formUser = $('#formUser'),
        $formUser2 = $('#formUser2');

    var submitWork = function () {
        var fields = [
                {
                    name: 'name',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите название проекта.',
                        minLength: 'Название не может состоять меньше чем из 2 букв.'
                    }
                },
                {
                    name: 'img',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства загрузите изображение.'
                    },
                    errorAppend: '.form__input-section'
                },
                {
                    name: 'url',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите адрес проекта.'
                    }
                },
                {
                    name: 'desc',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите описание проекта.'
                    }
                }
            ],
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
                            $workMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();

                            setTimeout(function () {
                                window.location.replace('/admin');
                            }, 2000);

                        } else {
                            $workMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $workMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };

        $formWork.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var submitUser = function () {
        var fields = [
                {
                    name: 'name',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите имя пользователя.',
                        minLength: 'Имя не может состоять меньше чем из 2 букв.'
                    }
                },
                {
                    name: 'lastname',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите фамилию пользователя.',
                        minLength: 'Фамилия не может состоять меньше чем из 2 букв.'
                    }
                },
                {
                    name: 'email',
                    rules: {
                        required: true,
                        validEmail: true
                    },
                    messages: {
                        required: 'Пожалуйства введите email пользователя.',
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
                        required: 'Пожалуйства введите пароль пользователя.',
                        minLength: 'Пароль не может состоять меньше чем из 6 символов.'
                    }
                }
            ],
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
                            $userMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();

                            setTimeout(function () {
                                window.location.replace('/admin');
                            }, 2000);

                        } else {
                            $userMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $userMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };

        $formUser.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var submitUser2 = function () {
        var fields = [
                {
                    name: 'name',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите имя пользователя.',
                        minLength: 'Имя не может состоять меньше чем из 2 букв.'
                    }
                },
                {
                    name: 'lastname',
                    rules: {
                        required: true,
                        minLength: 2
                    },
                    messages: {
                        required: 'Пожалуйства введите фамилию пользователя.',
                        minLength: 'Фамилия не может состоять меньше чем из 2 букв.'
                    }
                },
                {
                    name: 'email',
                    rules: {
                        required: true,
                        validEmail: true
                    },
                    messages: {
                        required: 'Пожалуйства введите email пользователя.',
                        validEmail: 'Некорректный email.'
                    }
                }
            ],
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
                            $userMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();

                            setTimeout(function () {
                                window.location.replace('/admin');
                            }, 2000);

                        } else {
                            $userMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $userMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };

        $formUser2.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var submitDelete = function () {
        $('#formDelete').on('submit', function (e) {
            e.preventDefault ? e.preventDefault() : (e.returnValue = false);

            var $that = $(this),
                $deleteMsg = $('#deleteMsg');

            $.ajax({
                url: $that.attr('action'),
                method: $that.attr('method'),
                data: $that.serialize(),
                dataType: 'json',
                success: function (data) {
                    if (!data.error) {
                        $deleteMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                        $that[0].reset();

                        setTimeout(function () {
                            window.location.replace('/admin');
                        }, 2000);

                    } else {
                        $deleteMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                    }
                },
                error: function () {
                    $deleteMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                }
            });
        })
    };

    return {
        init: function () {
            submitWork();
            submitUser();
            submitUser2();
            submitDelete();
        }
    };
})(window.jQuery);

window.APP.admin.init();