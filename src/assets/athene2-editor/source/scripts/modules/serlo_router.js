/*global define, window*/
define(function () {
    "use strict";
    var Router;

    function navigate(url) {
        window.location.href = url;
    }

    function reload() {
        if (typeof window.location.reload === "function") {
            window.location.reload();
            return;
        }
        var href = window.location.href;
        window.location.href = href;
    }

    Router = {
        navigate: function (url) {
            navigate(url);
        },
        reload: function () {
            reload();
        }
    };

    return Router;
});