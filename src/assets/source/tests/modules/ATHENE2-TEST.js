define("ATHENE2-TEST", ['ATHENE2', 'jquery', 'jasmine-html', 'underscore'], function (APP, $, jasmine) {

    return function () {
        var jasmineEnv = jasmine.getEnv();
        jasmineEnv.updateInterval = 1000;

        var htmlReporter = new jasmine.HtmlReporter();

        jasmineEnv.addReporter(htmlReporter);

        jasmineEnv.specFilter = function (spec) {
            return htmlReporter.specFilter(spec);
        };

        var specs = [];

        specs.push('spec/common_test');
        specs.push('spec/translator_test');
        specs.push('spec/cache_test');



        $(function () {
            require(specs, function (spec) {
                jasmineEnv.execute();
            });
        });
    };
});

require(['ATHENE2-TEST'], function (TEST) {
    TEST();
});