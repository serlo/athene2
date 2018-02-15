/**
 * Created by benny on 08.06.15.
 */
var dnode = require('dnode');
var async = require('async');

var d = dnode.connect(7070);

var timestampsStart = [], timestampsEnd = [];
var i = 0;

d.on('remote', function (remote) {
    runTests(remote);
});

function runTests(remote, rcb) {
    timestampsStart[i] = new Date().getTime();
    var calls = Math.pow(i, 2) + 1,
        asyncTasks = [];
    console.log('Starting up %d requests', calls);
    for (var j = 0; j <= calls; j++
        ) {
        asyncTasks.push(function (acb) {
            remote.render(getNewJSON(), function (output, exception, message) {
                if (exception) {
                    console.log(exception, exception);
                }
                //console.log(output);
                acb();
            });
        });
    }
    async.parallel(asyncTasks, function () {
        timestampsEnd[i] = new Date().getTime();
        console.log('Time used for %d call(s): %d ms. Average time: %d ms. Loop: %d', calls,
            timestampsEnd[i] - timestampsStart[i], (timestampsEnd[i] - timestampsStart[i]) / calls, i);
        if (i <= 5) {
            i++;
            runTests(remote);
        } else {
            console.log('Exiting');
            d.end();
        }
    });
}

function getNewJSON2() {
    return '[['
        + '{&quot;col&quot;:24,&quot;content&quot;:&quot;$$\\frac{' + Math.floor(Math.random() * 10000) + '}{' + Math.floor(Math.random() * 10000) + '}$$&quot;}],['
        + '{&quot;col&quot;:24,&quot;content&quot;:&quot;$$\\frac{' + Math.floor(Math.random() * 10000) + '}{' + Math.floor(Math.random() * 10000) + '}$$&quot;}'
        + ']]';
}

function getNewJSON() {
    var r = '[[{&quot;col&quot;:12,&quot;content&quot;:&quot;|a|b|\\n|-|-|\\n|c|d|&quot;},{&quot;col&quot;:12,&quot;content&quot;:&quot;GAFE\\n\\n$$'
        + Math.floor(Math.random() * 30) + '\\\\cdot' + Math.floor(Math.random() * 1500) + '\\\\cdot\\\\frac '
        + Math.floor(Math.random() * 257) + 'x' + Math.floor(Math.random() * 100) + ' ' + ' '
        + Math.floor(Math.random() * 42) + 'y-' + Math.floor(Math.random() * 30)
        + ' \\\\frac12*a`*b`+34567$$ text \\n noch mehr text&quot;}],[';

    for (var i = 0; i <= 50; i++
        ) {
        r +=
           '{&quot;col&quot;:8,&quot;content&quot;:&quot;$$\\\\frac{' + Math.floor(Math.random() * 10000) + '}{' + Math.floor(Math.random() * 10000) + '}$$&quot;},{&quot;col&quot;:16,&quot;content&quot;:&quot;OK&quot;}],['
    }
    r +=
        '{&quot;col&quot;:8,&quot;content&quot;:&quot;$$\\\\frac{' + Math.floor(Math.random() * 10000) + '}{' + Math.floor(Math.random() * 10000) + '}$$&quot;},{&quot;col&quot;:16,&quot;content&quot;:&quot;OK&quot;}'
            + ']]';
    return r;
}