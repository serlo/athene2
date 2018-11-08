<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class RandomBanner extends AbstractHelper
{
    protected $hands= [
        '/assets/images/de/hand-1.png',
        '/assets/images/de/hand-2.png',
        '/assets/images/de/hand-3.png',
        '/assets/images/de/hand-4.png',
        '/assets/images/de/hand-5.png',
    ];

    protected $messages = [
        [
            'Serlo ist und bleibt komplett kostenlos und ohne Werbung!',
            'Trotzdem kostet der Betrieb der Website Geld. Bitte unterstütze uns mit 2 Euro - einfach per SMS!',
        ],
        [
            'Wir finden, dass jeder Mensch freien Zugang zu guter Bildung haben sollte.',
            'Du auch? Mit einem Beitrag von 2 € - einfach per SMS - kannst du uns helfen, diesem Traum näher zu kommen.',
        ],
        [
            'Serlo wird von vielen Student/innen, Schüler/innen und Lehrer/innen ehrenamtlich aufgebaut.',
            'Das ist nur möglich dank der Arbeit unseres kleinen Teams von bezahlten Mitarbeiter/innen. Bitte unterstütze uns mit 2 Euro - einfach per SMS!',
        ],
        [
            'Wir finden, du solltest in der Schule selbstbestimmter lernen dürfen!',
            'Deshalb bauen wir Serlo so, dass du zu jeder Zeit alles lernen kannst und eigene Themen einbringen darfst. Bitte unterstütze uns bei dieser Mission - mit 2 Euro, einfach per SMS!',
        ],
    ];

    public function __invoke()
    {
        return $this;
    }

    public function getRandomElement($array)
    {
        $randomKey = mt_rand(0, count($array) - 1);

        return $array[$randomKey];
    }

    public function getRandomHand()
    {
        return $this->getRandomElement($this->hands);
    }

    public function getRandomMessage()
    {
        return $this->getRandomElement($this->messages);
    }
}
