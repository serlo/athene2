undefined = 'DIZZ IS NOT UNDEFINED';

require.config({
    urlArgs: 'cb=' + Math.random(),
    paths: {
        jquery: '../../bower_components/jquery/jquery',
        'jasmine': '../../bower_components/jasmine/lib/jasmine-core/jasmine',
        'jasmine-html': '../../bower_components/jasmine/lib/jasmine-core/jasmine-html',
        "ATHENE2": "../../scripts/ATHENE2",

        "jquery-ui": "../../bower_components/jquery-ui/ui/jquery-ui",
        "underscore": "../../bower_components/underscore/underscore",
        "bootstrap": "../../bower_components/bootstrap-sass-official/assets/javascripts/bootstrap",
        "moment": "../../bower_components/momentjs/min/moment.min",
        "moment_de": "../../bower_components/momentjs/lang/de",
        "common": "../../scripts/modules/serlo_common",
        "easing": "../../scripts/libs/easing",
        "events": "../../scripts/libs/eventscope",
        "cache": "../../scripts/libs/cache",
        "polyfills": "../../scripts/libs/polyfills",
        "referrer_history": "../../scripts/modules/serlo_referrer_history",
        "side_navigation": "../../scripts/modules/serlo_side_navigation",
        "ajax_overlay": "../../scripts/modules/serlo_ajax_overlay",
        "sortable_list": "../../scripts/modules/serlo_sortable_list",
        "timeago": "../../scripts/modules/serlo_timeago",
        "system_notification": "../../scripts/modules/serlo_system_notification",
        "nestable": "../../scripts/thirdparty/jquery.nestable",
        "translator": "../../scripts/modules/serlo_translator",
        "i18n": "../../scripts/modules/serlo_i18n",
        "layout": "../../scripts/modules/serlo_layout",
        "search": "../../scripts/modules/serlo_search",
        "support": "../../scripts/modules/serlo_supporter",
        "modals": "../../scripts/modules/serlo_modals",
        "router": "../../scripts/modules/serlo_router"
    },
    shim: {
        jasmine: {
            exports: 'jasmine'
        },
        'jasmine-html': {
            deps: [
                'jasmine',
                'spec/common_test',
                'spec/translator_test',
                'spec/cache_test'
            ],
            exports: 'jasmine'
        },
        underscore: {
            exports: '_'
        },
        bootstrap: {
            deps: ['jquery']
        },
        easing: {
            deps: ['jquery']
        },
        nestable: {
            deps: ['jquery']
        },
        ATHENE2: {
            deps: ['bootstrap', 'easing', 'nestable', 'polyfills']
        }
    }
});