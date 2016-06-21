/*global define, Howl*/
define(['howlerjs'], function () {
    'use strict';

    var soundPath = '/assets/sounds/',
        sounds = {
            correct: new Howl({ urls: [soundPath + 'correct.ogg', soundPath + 'correct.mp3'] }),
            wrong: new Howl({ urls: [soundPath + 'wrong.ogg', soundPath + 'wrong.mp3'] })
        };

    return function (key) {
        sounds[key].stop().play();
    };
});
