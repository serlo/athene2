define(["common"], function (Common) {

    describe('Common', function () {
        it('has keycodes', function () {
            expect(Common.KeyCode).not.toBeUndefined();
        });

        it('trims strings properly', function () {
            expect(Common.trim("  hello you  ")).toBe("hello you");
        });

        describe('creates copies', function () {
            it('for objects', function () {
                var obj = {
                        my: 'object'
                    },
                    obj2 = Common.CarbonCopy(obj);

                expect(obj).not.toBe(obj2);
            });

            it('and arrays', function () {
                var ar = ['my', 'shiny', 'new', 'array'],
                    ar2 = Common.CarbonCopy(ar);

                expect(ar).not.toBe(ar2);
            });

            it('and objects in objects', function () {
                var obj = {
                        my: 'object',
                        obj: {
                            my: 'other object'
                        }
                    },
                    obj2 = Common.CarbonCopy(obj);

                expect(obj).not.toBe(obj2);
                expect(obj.obj).not.toBe(obj2.obj);
            });
        });

        it('sorts arrays by object keys', function () {
            // sortArrayByObjectKey = function (key, array, ascending)
            var o1 = { name: 'peter', age: 50 },
                o2 = { name: 'anton', age: 48 },
                o3 = { name: 'christina', age: 83};

            var ar = [o1, o2, o3],
                arManualSorted = [o2, o1, o3],
                arSorted = Common.sortArrayByObjectKey('age', ar, true);

            expect(arSorted).toEqual(arManualSorted);
        });

        it('finds objects from an array by key', function () {
            var o1 = { name: 'peter', age: 50 },
                o2 = { name: 'anton', age: 48 },
                o3 = { name: 'christina', age: 83};

            var ar = [o1, o2, o3],
                result1 = Common.findObjectByKey('name', 'peter', ar),
                result2 = Common.findObjectByKey('age', 48, ar),
                noResult = Common.findObjectByKey('age', 120, ar);

            expect(result1).toBe(o1);
            expect(result2).toBe(o2);
            expect(noResult).toBeUndefined();
        });

        it('can memoize functions', function () {
            this.addMatchers({
                toBeGreaterThanOrEqual: function(expected) {
                    return this.actual >= expected;
                }
            });

            var t1,
                t2,
                diff1,
                diff2,
                num,
                fibonacci = Common.memoize(function (n) {
                    return (n < 2) ? n : fibonacci(n - 1) + fibonacci(n - 2);
                });
            t1 = +new Date;
            num = fibonacci(200);
            diff1 = (+new Date) - t1;
            t2 = +new Date;
            num = fibonacci(200);
            diff2 = (+new Date) - t2;

            expect(diff1).toBeGreaterThanOrEqual(diff2);
        });

        it('provides setInterval polyfill with requestAnimationFrame', function () {
            var num = 0,
                expected,
                interval;
            runs(function () {
                interval = Common.setInterval(function () {
                    num++;
                }, 10);
            });

            waits(150);

            runs(function () {
                Common.clearInterval(interval);
                // we cant check for a specific number
                // since requestAnimationFrame doesnt
                // behave like native setTimeout
                expect(num).toBeGreaterThan(0);
                expected = num;
            });

            waits(10);

            runs(function () {
                expect(num).toBe(expected);
            });
        });

        it('handles events', function () {
            var sentData = {name: 'jasmine'},
                recievedData;

            expect(Common.addEventListener).not.toBeUndefined();
            Common.addEventListener('jasmine', function (data) {
                recievedData = data;
            });

            Common.trigger('jasmine', sentData);
            expect(recievedData).toBe(sentData);
        });
    });
});