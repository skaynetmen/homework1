window.APP.works = (function ($) {
    'use strict';
    var
        $form = $('#formAddWork'),
        $modalMsg = $('#modalMsg');

    var addWork = function () {
        $('#addWork').on('click', function (event) {
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);

            $('.modal').skModal({
                closeClass: 'modal__close',
                onOpen: function () {
                    placeholder();
                    fileUpload();
                },
                onClose: function () {
                    //не делаем ресет формы на ИЕ8, иначе слетают placeholder
                    //Modernizr.input.placeholder
                    if (!$('html').hasClass('lt-ie9')) {
                        $form[0].reset();
                    }
                }
            });
        });
    };

    var fakeFileInput = function () {
        var $projectImg = $('#projectImg'),
            $fakeInputFile = $('#fakeInputFile'),
            $fakeProjectImg = $('#fakeProjectImg');

        $fakeProjectImg.on('click', function () {
            $projectImg.trigger('click');
        });

        $fakeInputFile.on('click', function () {
            $projectImg.trigger('click');
        });

        $projectImg.on('change', function () {
            $fakeProjectImg.val($(this).val());
            $fakeProjectImg.trigger('keyup');
        });
    };

    var submit = function () {
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
                    },
                    errorMsgSubClass: 'left'
                },
                {
                    name: 'fakeImg',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства загрузите изображение.',
                    },
                    errorMsgSubClass: 'left',
                    errorAppend: '.form__input-section'
                },
                {
                    name: 'url',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите адрес проекта.',
                    },
                    errorMsgSubClass: 'left'
                },
                {
                    name: 'desc',
                    rules: {
                        required: true
                    },
                    messages: {
                        required: 'Пожалуйства введите описание проекта.',
                    },
                    errorMsgSubClass: 'left'
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
                            $modalMsg.html('<div class="alert success"><button class="alert__close">&times;</button><h4 class="alert__title">Выполнено!</h4><p>' + data.msg + '</p></div>');
                            $that[0].reset();
                        } else {
                            $modalMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>' + data.msg + '</p></div>');
                        }
                    },
                    error: function () {
                        $modalMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Не удалось подключиться к серверу.</p></div>');
                    }
                });
            };


        $form.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var closeAlert = function () {
        $modalMsg.on('click', '.alert__close', function () {
            $(this)
                .closest('.alert')
                .remove();
        });
    };

    var placeholder = function () {
        //Modernizr.input.placeholder
        if ($('html').hasClass('lt-ie9')) {
            $form.find('.form__input').placeholder();
        }
    };

    var fileUpload = function () {
        if (typeof $.fn.fileupload !== 'undefined') {
            $('#projectImg').fileupload({
                url: '/works/upload',
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        if (file.type == 'image/jpeg' || file.type == 'image/png') {
                            $('#imageFile')
                                .html($('<p/>')
                                    .html('<img src="' + file.thumbnailUrl + '" alt="" class="modal__img"/>' + file.name));
                            $('#hiddenField').val(file.name);
                        }
                        else {
                            $modalMsg.html('<div class="alert error"><button class="alert__close">&times;</button><h4 class="alert__title">Ошибка!</h4><p>Неверный формат файла!</p></div>');

                            $.ajax({
                                type: file.deleteType,
                                url: file.deleteUrl,
                                success: function () {
                                    //console.log(file.name + ' has deleted');
                                }
                            });
                        }
                    });
                },
                //acceptFileTypes: /(\.|\/)(jpe?g|png)$/i
            }).prop('disabled', !$.support.fileInput)
                .parent()
                .addClass($.support.fileInput ? undefined : 'disabled');
        }
    };

    return {
        init: function () {
            addWork();
            fakeFileInput();
            submit();
            closeAlert();
        }
    };
})(window.jQuery);

window.APP.works.init();
