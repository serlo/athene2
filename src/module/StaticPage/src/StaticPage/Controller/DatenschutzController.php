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

namespace StaticPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class Revision
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var bool
     */
    private $current;


    public function __construct(string $revision, bool $current)
    {
        $this->id = $revision;
        $this->current = $current;
    }

    public function isArchived()
    {
        return !$this->current;
    }

    public function getUrl()
    {
        return $this->current ? '/datenschutz' : '/datenschutz/archiv/' . $this->id;
    }

    public function getDate()
    {
        $formatter = new \IntlDateFormatter('de_DE', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);

        return $formatter->format(new \DateTime($this->id));
    }

    public function getLabel()
    {
        return $this->current ? 'Aktuelle Version' : $this->getDate();
    }
}

class DatenschutzController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/1-col');

        return $this->renderRevision($this->getCurrentRevision());
    }

    public function archiveIndexAction()
    {
        $view = new ViewModel([
            'revisions' => $this->getHydratedRevisions(),
        ]);

        $this->layout('layout/1-col');
        $view->setTemplate('static/de/datenschutz/archive');

        return $view;
    }

    public function archiveViewAction()
    {
        $revision = $this->params('revision');

        return $this->renderRevision($revision);
    }

    public function jsonAction()
    {
        return new JsonModel($this->getRevisions());
    }

    private function renderRevision(string $revision)
    {
        $view = new ViewModel([
            'revision' => $this->hydrateRevision($revision),
        ]);

        $view->setTemplate('static/de/datenschutz/revision-' . $revision);

        return $view;
    }

    /**
     * @return string[]
     */
    private function getRevisions()
    {
        $config = $this->getServiceLocator()->get('Config');
        return $config['datenschutz']['revisions'];
    }

    /**
     * @return string
     */
    private function getCurrentRevision()
    {
        return $this->getRevisions()[0];
    }

    /**
     * @return Revision[]
     */
    private function getHydratedRevisions()
    {
        return array_map(function ($revision) {
            return $this->hydrateRevision($revision);
        }, $this->getRevisions());
    }

    /**
     * @param string $revision
     * @return Revision
     */
    private function hydrateRevision(string $revision)
    {
        return new Revision($revision, $revision === $this->getCurrentRevision());
    }
}
