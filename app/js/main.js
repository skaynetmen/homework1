var APP = (function ($) {
    'use strict';

    var options = {
        fixedMenu: false
    };

    var mobileMenu = function () {
        (function () {
            $('<div/>', {'id': 'menuOverlay', 'class': 'menuOverlay'})
                .appendTo('body');
        })();

        var
            menu = $('#menu'),
            mobileMenuBtn = $('#mobileMenu'),
            menuOverlay = $('#menuOverlay');

        if (options.fixedMenu) {
            $("<style>.showMenu {position: fixed;}</style>")
                .appendTo("head");
        }

        mobileMenuBtn.on('click', function () {
            menu.toggleClass('showMenu');

            if (menu.hasClass('showMenu')) {
                menuOverlay.fadeIn();
            } else {
                menuOverlay.fadeOut();
            }
        });

        menuOverlay.on('click', function () {
            menu.removeClass('showMenu');
            menuOverlay.fadeOut();
        })
    };

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

    var changeOptions = function (param) {
        if (typeof param == 'object') {
            if (param.fixedMenu === true) {
                options.fixedMenu = true;
            }
        }
    };

    return {
        init: function (param) {
            if (param) {
                changeOptions(param);
            }

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