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
namespace Normalizer\Adapter;

use Normalizer\Entity\Normalized;
use DateTime;
use Normalizer\Exception\RuntimeException;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\I18n\Translator;

abstract class AbstractAdapter implements AdapterInterface
{
    protected $object;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function getObject()
    {
        return $this->object;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    public function normalize($object)
    {
        if (!$this->isValid($object)) {
            throw new RuntimeException(sprintf(
                'I don\'t know how to normalize "%s", maybe you used the wrong strategy?',
                get_class($object)
            ));
        }


        $this->setObject($object);

        $normalized = new Normalized([
            'title'       => $this->getTitle(),
            'content'     => $this->getContent(),
            'type'        => $this->getType(),
            'routeName'   => $this->getRouteName(),
            'routeParams' => $this->getRouteParams(),
            'id'          => $this->getId(),
            'metadata'    => [
                'title'        => $this->getHeadTitle(),
                'creationDate' => $this->getCreationDate() ? $this->getCreationDate() : new DateTime(),
                'description'  => $this->getDescription(),
                'keywords'     => $this->getKeywords(),
                'lastModified' => $this->getLastModified() ? $this->getLastModified() : new DateTime(),
                'robots'       => $this->isTrashed() ? 'noindex' : 'all',
            ],
        ]);

        return $normalized;
    }

    /**
     * @return string
     */
    abstract protected function getContent();

    /**
     * @return string
     */
    abstract protected function getCreationDate();

    /**
     * @return string
     */
    protected function getDescription()
    {
        return $this->getContent();
    }

    /**
     * @return DateTime
     */
    protected function getLastModified()
    {
        return new DateTime();
    }

    /**
     * @return int
     */
    abstract protected function getId();

    /**
     * @return string
     */
    abstract protected function getKeywords();

    /**
     * @return string
     */
    abstract protected function getPreview();

    /**
     * @return string
     */
    abstract protected function getRouteName();

    /**
     * @return string
     */
    abstract protected function getRouteParams();

    /**
     * @return string
     */
    abstract protected function getTitle();

    /**
     * @return string
     */
    abstract protected function getType();

    /**
     * @return boolean
     */
    abstract protected function isTrashed();

    /**
     * @return string
     */
    protected function getHeadTitle()
    {
        return $this->getTitle();
    }
}
