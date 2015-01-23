/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license LGPL-3.0
 * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */

/*global define, require, window, Modernizr*/
define(['jquery', 'common', 'translator', 'content'], function ($, Common, t) {
    "use strict";
    var Injections,
        cache = {},
        ggbApplets = {},
        ggbAppletsCount = 0,
        geogebraScriptSource = 'https://www.geogebra.org/web/4.4/web/web.nocache.js',
        $geogebraTemplate = $('<article class="geogebraweb" data-param-width="700" data-param-height="525" data-param-usebrowserforjs="true" data-param-enableRightClick="false"></article>');

    // terrible geogebra oninit handler..
    // that doesnt work.....
    window.ggbOnInit = function (id) {
        if (ggbApplets[id]) {
            ggbApplets[id]();
        }
    };

    Injections = function () {
        var totalInjectionsCount = $(this).length;

        return $(this).each(function () {
            var $that = $(this),
                $a = $('> a', $that),
                title = $a.text(),
                href = $a.attr('href');

            if (!href) {
                return true;
            }

            function initGeogebraApplet(xml) {
                // disable geogebra applets for
                // touch devices..
                if (Modernizr.touch) {
                    $that.html('<div class="alert alert-warning">' + t('Sadly this geogebra plugin cannot be shown on your device. We work on that ;-)') + '</div>');
                } else {
                    var ggbAppletID = 'ggbApplet' + ggbAppletsCount,
                        $clone = $geogebraTemplate.clone();

                    ggbAppletsCount += 1;

                    $clone.attr('data-param-id', ggbAppletID);
                    // initialize geogebra applet with an empty dummy document
                    // otherwise it wont initialize and we will never be able
                    // to call the setXML method..
                    $clone.attr("data-param-ggbbase64", "UEsDBBQACAgIAD10R0QAAAAAAAAAAAAAAAAWAAAAZ2VvZ2VicmFfamF2YXNjcmlwdC5qc0srzUsuyczPU0hPT/LP88zLLNHQVKiuBQBQSwcI1je9uRkAAAAXAAAAUEsDBBQACAgIAD10R0QAAAAAAAAAAAAAAAAMAAAAZ2VvZ2VicmEueG1srVZtb9s2EP6c/oqDPqc2qTfbgZyiLVCgQBYUSzcU/UZJtMxZFgWRsp2iP353pGQ7Lx2WZXFk6njPvfLu6OzdYVvDTnZG6WYZ8AkLQDaFLlVTLYPert7Og3fXb7JK6krmnYCV7rbCLoN4EgcnOaQmnJEwHIy6avSt2ErTikLeFWu5FTe6ENYh19a2V9Ppfr+fjDonuqumVZVPDqYMAP1pzDIYXq5Q3QOhfeTgIWN8+u23G6/+rWqMFU0hAyBfe3X95iLbq6bUe9ir0q6XQZKmAaylqtbk/GIewJRALUbQysKqnTQoekaCKpeB3baBg4mG+Bf+DepjOAGUaqdK2S2DW3EbgO6UbOzA5IOR6Sie7ZTcez305kzEbDHDTCqj8loug5WoDYahmlWHKUQPuh5JY+9rmYtupE8O8Ev8IED9kKQLT8DHjRzGLumZ4ZMkzPtybjgAq3XttLJ/8GCgTy4MGw98GD2InvMgxce59siD+ZkHiOPwE3AJ/RIB/HQviafjgUw9OXMLZ37hA3NOXwsi0ldGFP2niPiZVX9SLzF6PMbFC0yGrzF5jPIZg2HyixhfmdpnE4u23L97npiMwpeYfNIi/9ZiNh37MxvqEsyasENerdziZHIlBwmWazqDS0iAL3CZUdmGwBOIEyT5HFJaZxBRpcYQwRwIxyOIYxKb41fsqjiFBHXR5syXM0QxJBFgVV9CGAOEDMKQ3jmEESKSBBIUIuuczEYpxCkS0RziBXpGmqiZIpRDGo2HEHGISJbPIEwhDWEWkXhMXieQEjxmEHOInSVEzSGiCPC0W22UTyWjGVq3x6S7rKmm7e2QqWG/2JZj1qx+BC91sflwTO3AkcLYcxjOzNMo9jP0waS+yGqRyxpvqTs6d4CdqKmcnYWVbiwMZ85Dv1d1ol2rwtxJa1HKwF9iJ26ElYdPiDajbWfaXSCZ7ItalUo0f2JRkApSCON94nr0eJ/wwXKhdVfe3RusFDh8l53G/uTJhJ3+4gSn3r1nRQ9ZKd4DphBU4wk7Z3BGl9f9r3nOttwdYxMHacb8Vx110JBZIj6bD7o+bbVaNfajaG3fuTsfR0JHUb1vqlq65LoOwnu22OT6cOeyGqZe19f71g0P50BefdS17gBbMEwSBAxr7leHIc+OKOYwzCHYeEyqPPL5InQIt+Z+dSg8d+/aECkfw+RsNKOMmxyo/LyFXdHQrd03yt6MhFXF5hQp4W/7bY71Nog9VMn/J5XZ9FGFZRvZNbL2ddTgSfa6N76wj8V5kfVGfhF2/b4pf5cVNuUXQWPQomoPPXlcykJtUdDvD6kTdKx/oKt+t5RVJ8cIa/dzzCfWcdl5VT/Zdqo+dXr7udl9xZp55Go2HePJTNGplkoTchzLG3mqvlIZgVO9PJfD4A1GUdDIwURaSmIAordr3blfXNi1uJKFc6jr3OEn5fXfUEsHCAggsi84BAAA2AoAAFBLAQIUABQACAgIAD10R0TWN725GQAAABcAAAAWAAAAAAAAAAAAAAAAAAAAAABnZW9nZWJyYV9qYXZhc2NyaXB0LmpzUEsBAhQAFAAICAgAPXRHRAggsi84BAAA2AoAAAwAAAAAAAAAAAAAAAAAXQAAAGdlb2dlYnJhLnhtbFBLBQYAAAAAAgACAH4AAADPBAAAAAA=");

                    // the following doesnt work.
                    ggbApplets[ggbAppletID] = function () {
                        var applet = window[ggbAppletID];
                        applet.setXML(xml);
                    };

                    $that.html($clone);

                    // web();
                }
            }

            function notSupportedYet($context) {
                Common.log('Illegal injection found: ' + href);
                $context.html('<div class="alert alert-info">' + t('Illegal injection found') + '</div>');
            }

            function handleResponse(data, contentType) {
                cache[href] = {
                    data: data,
                    contentType: contentType
                };

                // check if it is geogebra xml
                if (data.documentElement && data.documentElement.nodeName === 'geogebra') {
                    initGeogebraApplet(data.documentElement.outerHTML);
                } else if (contentType === 'image/jpeg' || contentType === 'image/png') {
                    $that.html('<img src="' + href + '" title="' + title + '" />');
                } else {
                    try {
                        data = JSON.parse(data);
                        if (data.response) {
                            $that.html(data.response);
                            Common.trigger('new context', $that);
                        } else {
                            notSupportedYet($that);
                        }
                    } catch (e) {
                        notSupportedYet($that);
                    }
                }
            }

            if (cache[href]) {
                handleResponse(cache[href].data, cache[href].contentType);
            }

            $.ajax(href)
                .success(function () {
                    handleResponse(arguments[0], arguments[2].getResponseHeader('Content-Type'));
                })
                .always(function () {
                    totalInjectionsCount -= 1;
                    if (totalInjectionsCount === 0 && ggbAppletsCount > 0) {
                        // if all injections have been loaded,
                        // load the geogebra script and there
                        // have been some gegeogebra injections
                        // load the geogegebra script
                        require([geogebraScriptSource]);
                    }
                })
                .error(function () {
                    Common.log('Could not load injection');
                });
        });
    };

    $.fn.Injections = Injections;
});