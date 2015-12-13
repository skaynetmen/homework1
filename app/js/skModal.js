/**
 * skModal - jQuery modal window plugin 1.0.0
 * Copyright (c) 2015 Alexandr Skrylev, http://alskr.ru
 * Is open source under the MIT license.
 */

(function ($) {
    'use strict';
    var
        id,
        $modal = {},
        $overlay = {},
        $document = $(document),
        $window = $(window),
        settings = {
            position: 'fixed',
            opacity: 0.6,
            verticalAlign: 'middle',
            closeClass: 'skModalClose',
            disableScrollBar: false,
            onOpen: {},
            onClose: {}
        };

    /**
     * Добавляем полупрозрачную подкложку
     * @returns {*|HTMLElement}
     */
    var createOverlay = function () {
        var $cache = $('#skModalOverlay');

        //проверяем, есть ли уже подложка на странице
        if ($cache && !$cache.length) {
            $modal.before(
                $('<div/>', {
                    'id': 'skModalOverlay',
                    'class': 'skModalOverlay',
                    'css': {
                        'display': 'none',
                        'position': 'fixed',
                        'top': 0,
                        'right': 0,
                        'bottom': 0,
                        'left': 0,
                        'opacity': settings.opacity,
                        //'-ms-filter': '"progid:DXImageTransform.Microsoft.Alpha(Opacity='+ (settings.opacity * 100) +')"',
                        'filter': 'alpha(opacity=' + (settings.opacity * 100) + ')',
                        'z-index': 9998,
                        'cursor': 'pointer',
                        'background-color': '#000000'
                    }
                })
            );

            return $('#skModalOverlay');
        }

        return $cache;
    };

    /**
     * Возвращает размеры окна
     * @returns {{width: *, height: *}}
     */
    var windowSize = function () {
        return {
            width: $window.width(),
            height: $window.height()
        };
    };

    /**
     * Возвращает размеры модального окна
     * @returns {{width: *, height: *}}
     */
    var modalSize = function () {
        return {
            width: $modal.outerWidth(true),
            height: $modal.outerHeight(true)
        };
    };

    /**
     * Вычисляет положение для модального окна
     * @param wSize
     * @param mSize
     * @returns {{x: number, y: number}}
     */
    var calcPosition = function (wSize, mSize) {
        var x = 0,
            y = 50;

        if (settings.verticalAlign === 'middle' && wSize.height >= mSize.height) {
            y = (wSize.height / 2) - (mSize.height / 2);
        }

        if (wSize.width >= mSize.width) {
            x = (wSize.width / 2) - (mSize.width / 2);
        }

        return {
            x: x,
            y: y
        };
    };

    /**
     * Добавляем события для нашего модального окна
     */
    var addEvents = function () {
        if (settings.disableScrollBar) {
            $('html').css('overflow', 'hidden');
        }

        $('#skModalOverlay.' + id).on('click', closeModal);
        $document.bind('keydown.' + id, function (e) {
            //esc
            if (e.which == 27) {
                closeModal();
            }
        });
        $modal.delegate('.' + settings.closeClass, 'click.' + id, closeModal);

        $window.on('resize.' + id, reposition);
    };

    /**
     * Удаляем события модального окна
     */
    var removeEvents = function () {
        if (settings.disableScrollBar) {
            $('html').css('overflow', 'auto');
        }

        $('#skModalOverlay.' + id).off('click');
        $document.off('keydown.' + id);
        $modal.undelegate('.' + settings.closeClass, 'click.' + id, closeModal);
        $window.off('resize.' + id);
    };

    /**
     * Закрывает модальное окна
     */
    var closeModal = function () {
        if (typeof settings.onClose == 'function') {
            settings.onClose.apply($modal);
        }

        removeEvents();

        $modal.fadeOut();
        $overlay
            .removeClass(id)
            .fadeOut();
    };

    /**
     * Пересчитываем координаты
     */
    var reposition = function () {
        var position = calcPosition(windowSize(), modalSize());

        $modal.css({
            'left': position.x,
            'top': position.y
        });
    };

    /**
     * Модальное окно
     * @param options
     * @returns {jQuery}
     */
    $.fn.skModal = function (options) {
        $modal = this;
        settings = $.extend(settings, options);
        id = 'skModal' + Math.floor((Math.random() * 100) + 1);

        var position = calcPosition(windowSize(), modalSize());

        //Показываем подложку
        $overlay = createOverlay();
        $overlay
            .addClass(id)
            .fadeIn();

        //Показываем окно
        $modal.css({
            'position': settings.position,
            'left': position.x,
            'top': position.y,
            'z-index': 9999,
            'transition': 'left, top 1s ease'
        })
            .fadeIn();

        //если в настройки передана callback функция при открытии окна, выполняем ее
        if (typeof settings.onOpen == 'function') {
            settings.onOpen.apply($modal);
        }

        //добавляем события
        addEvents();

        return this;
    };
})(jQuery);
