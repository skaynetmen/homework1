var APP = (function ($) {
    'use strict';

    var options = {
        fixedMenu: false
    };

    /**
     * Показ меню сайта для планшетов и мобильников
     */
    var mobileMenu = function () {
        //добавляем подложку на страницу
        (function () {
            $('<div/>', {'id': 'menuOverlay', 'class': 'menuOverlay'})
                .appendTo('body');
        })();

        var
            menu = $('#menu'),
            mobileMenuBtn = $('#mobileMenu'),
            menuOverlay = $('#menuOverlay');

        //наверное лучше это вынести в цсс стили и убрать отсюда
        if (options.fixedMenu) {
            $("<style/>", {
                'text': '.showMenu {position: fixed;}'
            })
                .appendTo("head");
        }

        //вешаем события на кнопку вызова меню
        mobileMenuBtn.on('click', function () {
            menu.toggleClass('showMenu');

            if (menu.hasClass('showMenu')) {
                menuOverlay.fadeIn();
            } else {
                menuOverlay.fadeOut();
            }
        });

        //по клику за областью меню, скрываем его
        menuOverlay.on('click', function () {
            menu.removeClass('showMenu');
            menuOverlay.fadeOut();
        })
    };

    /**
     * Фиксируем хедер при прокрутке,
     * по-умолчанию эта опция отключена
     */
    var fixedMenu = function () {
        var
            win = $(window),
            header = $('#header'),
            headerTop = header.offset().top;

        win.scroll(function () {
            if (headerTop < win.scrollTop()) {
                header.addClass('affix');
            }
            else {
                header.removeClass('affix');
            }
        });
    };

    //публичные методы
    return {
        init: function (param) {
            options = $.extend(options, param);

            mobileMenu();

            if (options.fixedMenu) {
                fixedMenu();
            }
        }
    };
})(window.jQuery);

APP.init({
    fixedMenu: false
});