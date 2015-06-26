/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license LGPL-3.0
 * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
/*global require*/
require.config({
    name: 'ATHENE2',
    baseUrl: "/assets/build/scripts",
    paths: {
        "jquery": "../bower_components/jquery/jquery",
        "jquery-ui": "../bower_components/jquery-ui/ui/jquery-ui",
        "underscore": "../bower_components/underscore/underscore",
        "bootstrap": "../bower_components/bootstrap-sass-official/assets/javascripts/bootstrap",
        "moment": "../bower_components/momentjs/min/moment.min",
        "moment_de": "../bower_components/momentjs/lang/de",
        "jasny": "../bower_components/jasny-bootstrap/dist/js/jasny-bootstrap",
        "magnific_popup": "../bower_components/magnific-popup/dist/jquery.magnific-popup",
        "historyjs": "../bower_components/history.js/scripts/bundled/html4+html5/jquery.history",
        "common": "modules/serlo_common",
        "easing": "libs/easing",
        "events": "libs/eventscope",
        "cache": "libs/cache",
        "polyfills": "libs/polyfills",
        "event_extensions": "libs/event_extensions",
        "referrer_history": "modules/serlo_referrer_history",
        "side_navigation": "modules/serlo_side_navigation",
        "mobile_navigation": "modules/serlo_mobile_navigation",
        "breadcrumbs": "modules/serlo_breadcrumbs",
        "ajax_overlay": "modules/serlo_ajax_overlay",
        "sortable_list": "modules/serlo_sortable_list",
        "timeago": "modules/serlo_timeago",
        "trigger": "modules/serlo_trigger",
        "system_notification": "modules/serlo_system_notification",
        "nestable": "thirdparty/jquery.nestable",
        "datepicker": "../bower_components/bootstrap-datepicker/js/bootstrap-datepicker",
        "translator": "modules/serlo_translator",
        "i18n": "modules/serlo_i18n",
        "side_element": "modules/serlo_side_element",
        "content": "modules/serlo_content",
        "spoiler": "modules/serlo_spoiler",
        "deployggb": "thirdparty/deployggb",
        "injections": "modules/serlo_injections",
        "search": "modules/serlo_search",
        "slider": "modules/serlo_slider",
        "support": "modules/serlo_supporter",
        "modals": "modules/serlo_modals",
        "router": "modules/serlo_router",
        "forum_select": "modules/serlo_forum_select",
        "toggle_action": "modules/serlo_toggle",
        "tracking": "modules/serlo_tracking",
        "affix": "modules/serlo_affix"
    },
    shim: {
        underscore: {
            exports: '_'
        },
        bootstrap: {
            deps: ['jquery']
        },
        datepicker: {
            deps: ['jquery', 'bootstrap']
        },
        easing: {
            deps: ['jquery']
        },
        nestable: {
            deps: ['jquery']
        },
        historyjs: {
            deps: ['jquery']
        },
        injections: {
            deps: ['deployggb']
        }
    },
    waitSeconds: 2
});
