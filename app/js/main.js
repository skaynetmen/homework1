var app = (function ($) {
    var mobileMenu = function () {
        (function () {
            $('<div/>', {'id': 'menuOverlay', 'class': 'menuOverlay'})
                .appendTo('body');
        })();

        var
            menu = $('#menu'),
            mobileMenuBtn = $('#mobileMenu'),
            menuOverlay = $('#menuOverlay');

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

    return {
        init: function () {
            mobileMenu();
        }
    };
})(window.jQuery);

app.init();