<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Normalizer\Controller;

use Blog\Entity\PostInterface;
use Entity\Entity\EntityInterface;
use Instance\Manager\InstanceManagerInterface;
use Page\Entity\PageRepositoryInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Uuid\Entity\UuidInterface;
use Uuid\Manager\UuidManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SitemapController extends AbstractActionController
{
    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @var UuidManagerInterface
     */
    protected $uuidManager;

    public function __construct(InstanceManagerInterface $instanceManager, UuidManagerInterface $uuidManager)
    {
        $this->instanceManager = $instanceManager;
        $this->uuidManager     = $uuidManager;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $this->getResponse()->getHeaders()->addHeaders(
            [
                'Content-Type' => 'text/html'
            ]
        );
        $view->setTemplate('normalizer/sitemap');
        $view->setTerminal(true);
        return $view;
    }

    public function uuidAction()
    {
        // Todo unhack
        $objects  = $this->uuidManager->findAll();
        $objects  = $objects->filter(
            function (UuidInterface $object) {
                $isGood = $object instanceof TaxonomyTermInterface || $object instanceof PageRepositoryInterface;
                $isGood = $isGood || $object instanceof EntityInterface || $object instanceof PostInterface;
                if ($object instanceof EntityInterface) {
                    $name = $object->getType()->getName();
                    $isGood = $isGood && $object->hasCurrentRevision()
                        && (in_array(
                            $name,
                            ['article', 'course', 'video']
                        ));
                }
                return !$object->isTrashed() && $isGood;
            }
        );
        $view = new ViewModel(['objects' => $objects]);
        $this->getResponse()->getHeaders()->addHeaders(
            [
                'Content-Type' => 'text/html'
            ]
        );
        $view->setTemplate('normalizer/sitemap-uuid');
        $view->setTerminal(true);
        return $view;
    }
}
