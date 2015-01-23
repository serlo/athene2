define(['cache'], function (Cache) {
    describe('Cache', function () {
        var c = Cache('jasmine_cache_test');
        it('Stores Objects as JSON', function () {
            var o1 = {name: 'jasmine', language: 'js'};

            c.memorize(o1);

            expect(c.remember()).not.toBe(o1);
        });
    });
});