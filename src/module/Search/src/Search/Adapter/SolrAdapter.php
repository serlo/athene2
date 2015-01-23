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
namespace Search\Adapter;

use Common\Filter\PreviewFilter;
use Common\Guard\StringGuardTrait;
use Instance\Manager\InstanceManagerInterface;
use Normalizer\NormalizerInterface;
use Search\Entity;
use Search\Exception;
use Search\Paginator\SolrPaginator;
use Solarium\Client;
use Solarium\QueryType\Update\Query\Query;
use Uuid\Manager\UuidManagerInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Paginator\Paginator;

class SolrAdapter implements AdapterInterface
{
    use StringGuardTrait;

    const KEYWORD_DELIMITER = ';';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * @var UuidManagerInterface
     */
    protected $uuidManager;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var Query
     */
    protected $update;

    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @param Client                   $client
     * @param InstanceManagerInterface $instanceManager
     * @param NormalizerInterface      $normalizer
     * @param TranslatorInterface      $translator
     * @param UuidManagerInterface     $uuidManager
     */
    public function __construct(
        Client $client,
        InstanceManagerInterface $instanceManager,
        NormalizerInterface $normalizer,
        TranslatorInterface $translator,
        UuidManagerInterface $uuidManager
    ) {
        $this->instanceManager = $instanceManager;
        $this->client          = $client;
        $this->normalizer      = $normalizer;
        $this->uuidManager     = $uuidManager;
        $this->translator      = $translator;
        $this->filter          = new PreviewFilter(200);
    }

    /**
     * {@inheritDoc}
     */
    public function add(Entity\DocumentInterface $document)
    {
        $id       = $document->getId();
        $title    = $document->getTitle();
        $content  = $document->getContent();
        $type     = $document->getType();
        $link     = $document->getLink();
        $keywords = $document->getKeywords();
        $instance = $document->getInstance();

        $keywords = implode(self::KEYWORD_DELIMITER, $keywords);
        $update   = $this->update = $this->client->createUpdate();

        $solrDocument               = $update->createDocument();
        $solrDocument->id           = (string)$id;
        $solrDocument->title        = (string)$title;
        $solrDocument->content      = (string)$content;
        $solrDocument->content_type = (string)$type;
        $solrDocument->keywords     = (string)$keywords;
        $solrDocument->link         = (string)$link;
        $solrDocument->instance     = (string)$instance;

        $update->addDeleteById($id);
        $update->addDocument($solrDocument);
        $update->addCommit();
        $this->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        $update = $this->update = $this->client->createUpdate();
        $update->addDeleteById($id);
        $update->addCommit();
    }

    /**
     * {@inheritDoc}
     */
    public function erase()
    {
        $update = $this->update = $this->client->createUpdate();
        $update->addDeleteQuery('*:*');
        $update->addCommit();
        $this->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function flush()
    {
        if (!is_object($this->update)) {
            return;
        }
        $this->client->update($this->update);
        $this->update = null;
    }

    /**
     * {@inheritDoc}
     */
    public function search($query)
    {
        $query      = $result = preg_replace('@([\+\-\&\|\!\(\)\{\}\[\]\^\"\~\*\?\:])@is', '\\\1', $query);
        $queryClass = $this->client->createSelect();
        $instance   = $this->instanceManager->getInstanceFromRequest();
        $queryClass->createFilterQuery('ínstanceFilter')->setQuery('instance:(' . $instance->getId() . ')');
        $hl = $queryClass->getHighlighting();
        $hl->setFields('content');
        $hl->setSimplePrefix('<strong>');
        $hl->setSimplePostfix('</strong>');
        $queryClass->setFields(['*', 'score']);
        $disMax = $queryClass->getDisMax();
        $disMax->setQueryFields('title^4 content keywords^2 type^3');
        $queryClass->setQuery($query);
        $queryClass->addSort('score', $queryClass::SORT_DESC);
        $queryClass->setQueryDefaultOperator($queryClass::QUERY_OPERATOR_AND);

        $adapter = new SolrPaginator($this->client, $queryClass);
        $adapter->setTranslator($this->translator);
        $paginator = new Paginator($adapter);

        return $paginator;
    }
}
