<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Filter;

use Zend\Filter\FilterInterface;

class Shortify implements FilterInterface
{
    /*
     * Stop words can be found for example on
     * https://code.google.com/p/stop-words/
     *
     * Please use the smallest possible bundle for a language
     */
    static $stopWords = [
        'en' => [
            'I' => true, 'a' => true, 'about' => true, 'an',
            'are' => true, 'as' => true, 'at' => true, 'be',
            'by' => true, 'com' => true, 'for' => true, 'from',
            'how' => true, 'in' => true, 'is' => true, 'it',
            'of' => true, 'on' => true, 'or' => true, 'that',
            'the' => true, 'this' => true, 'to' => true, 'was',
            'what' => true, 'when' => true, 'where' => true, 'who',
            'will' => true, 'with' => true, 'the' => true, 'www'
        ],
        'de' => [
            'aber' => true, 'als' => true, 'am' => true, 'an' => true, 'auch' => true, 'auf' => true, 'aus' => true, 'bei',
            'bin' => true, 'bis' => true, 'bist' => true, 'da' => true, 'dadurch' => true, 'daher' => true, 'darum' => true, 'das',
            'da' => true, 'dass' => true, 'dein' => true, 'deine' => true, 'dem' => true, 'den' => true, 'der' => true, 'des',
            'dessen' => true, 'deshalb' => true, 'die' => true, 'dies' => true, 'dieser' => true, 'dieses' => true, 'doch' => true, 'dort',
            'du' => true, 'durch' => true, 'ein' => true, 'eine' => true, 'einem' => true, 'einen' => true, 'einer' => true, 'eines' => true, 'er',
            'es' => true, 'euer' => true, 'eure' => true, 'für' => true, 'hatte' => true, 'hatten' => true, 'hattest' => true, 'hattet',
            'hier' => true, 'hinter' => true, 'ich' => true, 'ihr' => true, 'ihre' => true, 'im' => true, 'in' => true, 'ist',
            'ja' => true, 'jede' => true, 'jedem' => true, 'jeden' => true, 'jeder' => true, 'jedes' => true, 'jener' => true, 'jenes',
            'jetzt' => true, 'kann' => true, 'kannst' => true, 'können' => true, 'könnt' => true, 'machen' => true, 'mein' => true, 'meine',
            'mit' => true, 'muß' => true, 'mußt' => true, 'musst' => true, 'müssen' => true, 'müßt' => true, 'nach' => true, 'nachdem',
            'nein' => true, 'nicht' => true, 'nun' => true, 'oder' => true, 'seid' => true, 'sein' => true, 'seine' => true, 'sich',
            'sie' => true, 'sind' => true, 'soll' => true, 'sollen' => true, 'sollst' => true, 'sollt' => true, 'sonst' => true, 'soweit',
            'sowie' => true, 'und' => true, 'unser' => true, 'unsere' => true, 'unter' => true, 'vom' => true, 'von' => true, 'vor',
            'wann' => true, 'warum' => true, 'was' => true, 'weiter' => true, 'weitere' => true, 'wenn' => true, 'wer' => true, 'werde',
            'werden' => true, 'werdet' => true, 'weshalb' => true, 'wie' => true, 'wieder' => true, 'wieso' => true, 'wir',
            'wird' => true, 'wirst' => true, 'wo' => true, 'woher' => true, 'wohin' => true, 'zu' => true, 'zum' => true, 'zur' => true, 'über'
        ]
    ];

    /**
     * @param string $word
     * @return bool
     */
    static protected function isStopWord($word)
    {
        $lowerCased = strtolower($word);

        foreach (self::$stopWords as $lang) {
            if (array_key_exists($lowerCased, $lang)) return true;
        }
        return false;
    }

    /**
     * @param string $text
     * @return bool|mixed
     */
    static protected function shortify($text)
    {
        $words = preg_split('/[\W]+/u', $text);

        $filtered = [];

        foreach ($words as $word) {
            if (!self::isStopWord($word)) {
                $filtered[] = $word;
            }
        }

        if (empty($filtered)) {
            return false;
        }

        return implode(' ', $filtered);
    }

    /**
     * {@inheritDoc}
     */
    public function filter($value)
    {
        return self::shortify($value);
    }
}
