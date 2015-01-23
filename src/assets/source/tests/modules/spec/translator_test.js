define(['translator'], function (t) {
    describe('Translator', function () {
        it('can change its current language', function () {
            var previousLanguage = t.getLanguage();
            t.config({
                language: 'js'
            });
            expect(t.getLanguage()).not.toBe(previousLanguage);
        });

        it('returns untranslated string if no translation is available', function () {
            var str = 'Halgkfomm ajnk jbauuuhekjf fa';

            expect(t(str)).toBe(str);
        });

        it('translates strings', function () {
            t.config({
                language: 'de'
            });

            expect(t('Close')).toBe('Schließen');
        });

        it('handles string replacements', function () {
            expect(t('Visit %s overview', 'Jasmine')).toBe('Zur Jasmine Übersicht');
        });

        it('even if there is no translation', function () {
            expect(t('Hello %s, I am from the future', 'Jasmine')).toBe('Hello Jasmine, I am from the future');
        });
    });
});