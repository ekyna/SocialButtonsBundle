(function(root, factory) {
    "use strict";

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = factory(require('jquery'));
    }
    else if (typeof define === 'function' && define.amd) {
        define('ekyna-social-buttons/share', ['jquery'], function($) {
            return factory($);
        });
    } else {
        root.EkynaSocialButtonsShare = factory(root.jQuery);
    }

}(this, function($) {
    "use strict";

    var popupCenter = function(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 3) - (h / 3)) + dualScreenTop;

        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    };

    var init = function() {
        $('.social-buttons').on('click', 'a.social-button', {}, function popUp(e) {
            e.preventDefault();
            e.stopPropagation();

            var self = $(this);
            popupCenter(self.attr('href'), self.attr('title'), 580, 470);

            return false;
        });
    };

    $(document).ready(function(){
        init();
    });

    var exports = {};
    exports.init = init;
    return exports;
}));