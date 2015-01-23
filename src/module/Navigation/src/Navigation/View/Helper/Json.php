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
namespace Navigation\View\Helper;

use Zend\Json\Json as ZendJson;
use Zend\Navigation\Page\AbstractPage;
use Zend\View\Helper\Navigation\Menu;

class Json extends Menu
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function render($container = null)
    {
        $this->parseContainer($container);
        if (null === $container) {
            $container = $this->getContainer();
        }

        $data = $this->process($container);
        $json = new ZendJson;
        $json = $json->encode($data);
        return $json;
    }

    protected function isActive(AbstractPage $page, $recursive = true)
    {
        if ($page->get('identifier') != $this->identifier && $recursive) {
            foreach ($page->getPages() as $subPage) {
                if ($this->isActive($subPage, $recursive)) {
                    return true;
                }
            }
            return false;
        }

        return $page->get('identifier') == $this->identifier;
    }

    public function findActive($container, $minDepth = null, $maxDepth = -1)
    {
        $this->parseContainer($container);
        if (!is_int($minDepth)) {
            $minDepth = $this->getMinDepth();
        }
        if ((!is_int($maxDepth) || $maxDepth < 0) && null !== $maxDepth) {
            $maxDepth = $this->getMaxDepth();
        }

        $found  = null;
        $foundDepth = -1;
        $iterator = new \RecursiveIteratorIterator($container, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $page) {
            $currDepth = $iterator->getDepth();
            if ($currDepth < $minDepth || !$this->accept($page)) {
                // page is not accepted
                continue;
            }

            if ($this->isActive($page, false) && $currDepth > $foundDepth) {
                // found an active page at a deeper level than before
                $found = $page;
                $foundDepth = $currDepth;
            }
        }

        if (is_int($maxDepth) && $foundDepth > $maxDepth) {
            while ($foundDepth > $maxDepth) {
                if (--$foundDepth < $minDepth) {
                    $found = null;
                    break;
                }

                $found = $found->getParent();
                if (!$found instanceof AbstractPage) {
                    $found = null;
                    break;
                }
            }
        }

        if ($found) {
            return array('page' => $found, 'depth' => $foundDepth);
        }

        return array();
    }

    protected function process($container, $currentDepth = 0, $activeDepth = null, array &$pages = [])
    {
        if (!$activeDepth) {
            $foundActive = $this->findActive($container, 0, 9999);
            $activeDepth = 99999;
            if (!empty($foundActive)) {
                $activeDepth = $foundActive['depth'];
            }
        }

        $start         = $this->getMinDepth();
        $end           = $start + $this->getMaxDepth();
        $pagePrototype = [
            'identifier'    => null,
            'label'         => null,
            'class'         => null,
            'href'          => null,
            'elements'      => 0,
            'icon'          => null,
            'needsFetching' => false,
            'children'      => []
        ];

        /* @var $page AbstractPage */
        foreach ($container as $page) {
            if (!($page->isVisible() && $this->accept(
                    $page
                ) && $currentDepth < $end && ($currentDepth > $activeDepth || $this->isActive($page)))
            ) {
                continue;
            }
            if ($currentDepth >= $start) {
                if ($page->getLabel() == 'divider') {
                    $addPage          = $pagePrototype;
                    $addPage['class'] = 'divider';
                    $pages[]          = $addPage;
                } else {
                    $active                   = $this->isActive($page, false) ? ' active' : '';
                    $addPage                  = $pagePrototype;
                    $addPage['identifier']    = $page->get('identifier');
                    $addPage['label']         = $page->getLabel();
                    $addPage['elements']      = $page->get('elements') ? : 0;
                    $addPage['icon']          = $page->get('icon');
                    $addPage['class']         = $page->getClass() . $active;
                    $addPage['href']          = $page->getHref();
                    $addPage['needsFetching'] = $currentDepth >= $end - 2 && count($page->getPages());
                    if (count($page->getPages())) {
                        $addPage['children'] = $this->process($page->getPages(), $currentDepth + 1, $activeDepth);
                    }
                    $pages[] = $addPage;
                }
            } else {
                if (count($page->getPages())) {
                    $this->process($page->getPages(), $currentDepth + 1, $activeDepth, $pages);
                }
            }
        }

        return $pages;
    }

    protected function removeWrapping(array $data)
    {
        $first = $data[0];
        if (count($first) == 1 && count($data) == 1) {
            return $this->removeWrapping($data[0]);
        }
        return $data;
    }
}
