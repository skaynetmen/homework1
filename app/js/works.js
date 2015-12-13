window.APP.works = (function ($) {
    'use strict';
    var
        $form = $('#formAddWork');

    var addWork = function () {
        $('#addWork').on('click', function (event) {
            event.preventDefault ? event.preventDefault() : (event.returnValue = false);

            $('.modal').skModal({
                closeClass: 'modal__close',
                onOpen: placeholder,
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

                var data = $(this).serialize();

                alert(data);
            };


        $form.skValidator({
            fields: fields,
            success: success,
            errorMsgClass: 'tooltip'
        });
    };

    var closeAlert = function () {
        $('#modalMsg').on('click', '.alert__close', function () {
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