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
namespace Search\Paginator;

use Common\Filter\PreviewFilter;
use EwgoSolarium\Paginator\Adapter\SolariumPaginator;
use Search\Adapter\SolrAdapter;
use Search\Entity\Document;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\I18n\Translator\TranslatorAwareTrait;

class SolrPaginator extends SolariumPaginator implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public function getItems($offset, $itemCountPerPage)
    {
        $resultSet    = parent::getItems($offset, $itemCountPerPage);
        $highlighting = $resultSet->getHighlighting();
        $items        = [];
        $filter       = new PreviewFilter();

        foreach ($resultSet as $document) {
            $highlightedDoc = $highlighting->getResult($document->id);
            $id             = $document['id'];
            $title          = $document['title'];
            $content        = implode(' ... ', $highlightedDoc->getField('content'));
            $type           = ucfirst($document['content_type']);
            $keywords       = explode(SolrAdapter::KEYWORD_DELIMITER, $document['keywords']);
            if ($type) {
                $type = $this->getTranslator()->translate($type);
            }
            if ($content) {
                $content = '... ' . $content . ' ...';
            } else {
                $content = $filter->filter($document['content']);
            }
            $item    = new Document($id, $title, $content, $type, $id, $keywords);
            $items[] = $item;
        }

        return $items;
    }
}
