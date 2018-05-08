<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\View\Helper;

use Common\Filter\PreviewFilter;
use Markdown\View\Helper\MarkdownHelper;
use Normalizer\NormalizerAwareTrait;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HeadMeta;
use Zend\View\Helper\HeadTitle;

class Normalize extends AbstractHelper
{
    use NormalizerAwareTrait;

    public function __invoke($object = null)
    {
        if ($object === null) {
            return $this;
        }
        return $this->normalize($object);
    }

    public function headMeta($object)
    {
        /* @var $meta HeadMeta */
        $meta       = $this->getView()->plugin('headMeta');
        $normalized = $this->normalize($object);
        $title      = $normalized->getTitle();
        $metadata   = $normalized->getMetadata();
        $keywords   = $metadata->getKeywords();
        $robots     = $metadata->getRobots();
        $preview    = $this->toPreview($object);
        $image      = $this->getMetaImage($object);
        $site_name  = $this->getView()->brand()->getBrand(true);
        $link       = $this->getCanonicalLink($object);

        $this->getView()->headLink(['rel' => 'canonical', 'href' => $link ]);
        $meta->appendName('description', $preview);
        $meta->appendName('keywords', implode(', ', $keywords));
        $meta->appendName('robots', $robots);
        $meta->setProperty('og:title', $title);
        $meta->setProperty('og:type', 'website');
        $meta->setProperty('og:image', $image);
        $meta->setProperty('og:description', $preview);
        $meta->setProperty('og:site_name', $site_name);
        $meta->setProperty('fb:pages', '155020041197918');
        $meta->setProperty('fb:profile_id', '155020041197918');
        $meta->setProperty('og:url', $link);
        $this->getView()->headLink(['rel' => 'search', 'href' => '/opensearch.xml', 'title' => 'Serlo (de)','type' => 'application/opensearchdescription+xml']);

        return $this;
    }


    public function getCanonicalLink($object){
        //TODO: use IDs to create short canonical links
        $link = $this->toUrl($object, true);
        return $link;
    }

    public function getMetaImage($object)
    {
        $subject = '';
        $fileName = 'meta_serlo.jpg';

        $subject = trim(strtolower(strip_tags( $this->getView()->navigation('default_navigation')->menu()->setPartial('layout/navigation/partial/active-subject')->setOnlyActiveBranch(true)->setMinDepth(0)->setMaxDepth(0)->render())));

        switch ($subject) {
            case 'mathematik':
            case 'math':
                $fileName = 'meta_serlo_mathe.png';
                break;

            case 'angewandte nachhaltigkeit':
            case 'applied sustainability':
                $fileName = 'meta_serlo_nachhaltigkeit.png';
                break;

            case 'biologie':
            case 'biology':
                $fileName = 'meta_serlo_bio.png';
                break;

            default:
                break;
        }
        return 'https://de.serlo.org/assets/images/'.$fileName;
    }

    public function headTitle($object)
    {
        /* @var $headTitle HeadTitle */

        // TODO: topic folder -> keine Klammer (weil der Titel eh immer Aufgaben zu xyz heißen muss)

        /*
        old version of topic folder {% do headTitle(term.getName() ~ ' - ' ~ (taxonomy().getAncestorName(term, 'subject')) ~ ' ' ~ (term.getTaxonomy.getName() | trans)) %}

        old version of topic {% do headTitle(term.getName() ~ ' - ' ~ (taxonomy().getAncestorName(term, 'subject')) ~ ' ' ~ ( term.getTaxonomy.getName() | trans)) %} #} */
        // "Page revision" can cause problems?

        $headTitle  = $this->getView()->plugin('headTitle');
        $brand  = $this->getView()->brand();

        if($object == NULL) {
            $title = $brand->getBrand(true) . " – " . $brand->getSlogan();
            $headTitle($title);
            return $this;
        }

        if(is_string($object)){
            $title = $object;
            $type = 'string';
            $typeName = $this->getView()->translate( 'curriculum' );
        }

        else {
            $normalized = $this->normalize($object);

            $type = $normalized->getType();
            $typeName = $this->getView()->translate( $normalized->getType() );

            $title = '';
            $titleFallback = $normalized->getTitle();
        }

        $titlePostfix = ' – ' . $brand->getHeadTitle(true);

        $maxStringLen = 65;

        if ( in_array($type, array('article','course','course-page','video')) ) {
            $title = $object->getCurrentRevision()->get('meta_title');
        }

        if($title == '') {
            $title = $titleFallback;
        }

        switch ($type) {
            case 'course-page': // e.g. Verschieben und Stauchen | 1. Startseite
                $parent = $object->getParents('link')->first();
                $parentTitle = $parent->getCurrentRevision()->get('title');
                $normalizedParent = $this->normalize($parent);
                $parentTitleFallback = $normalizedParent->getTitle();
                if($parentTitle == '') {
                    $parentTitle = $parentTitleFallback;
                }
                $title = $parentTitle . " | " .$title;
                break;
            case 'curriculum':
            case 'curriculum-topic-folder':
            case 'curriculum-topic':
            case 'locale':
            case 'string':
            case 'topic':
            case 'article':
            case 'video':
            case 'course':
            break;

            default:
                $title = $titleFallback . ' – ' . $brand->getBrand(true); //eg. Mathe Community – Serlo.org
                break;
        }

         //add "(Kurs)"
        if ( in_array($type, array('course','course-page','video', 'topic', 'curriculum', 'curriculum-topic-folder', 'curriculum-topic', 'locale', 'string')) ) {
            if( strlen($title) < ($maxStringLen-strlen($typeName)) ){
                   $title .=  ' (' . $typeName . ')';
            }
        }

        //add "– lernen mit serlo"
        if ( in_array($type, array('article','course','course-page','video', 'topic', 'curriculum', 'curriculum-topic-folder', 'curriculum-topic', 'locale')) ) {
            if( strlen($title) < ($maxStringLen-strlen($titlePostfix)) ){
                $title .= ' ' . $titlePostfix;
            }
        }
        $headTitle($title);
        return $this;
    }

    public function possible($object)
    {
        try {
            $this->normalize($object);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function toAnchor($object, $forceCanonical = false)
    {
        $normalized = $this->normalize($object);
        return '<a href="' . $this->toUrl($object, $forceCanonical) . '">' . $normalized->getTitle() . '</a>';
    }

    public function toAuthor($object)
    {
        return $this->normalize($object)->getMetadata()->getAuthor();
    }

    public function toCreationDate($object)
    {
        return $this->normalize($object)->getMetadata()->getCreationDate();
    }

    public function toLastModified($object)
    {
        return $this->normalize($object)->getMetadata()->getLastModified();
    }

    public function toPreview($object)
    {
        /* @var $markdown MarkdownHelper */
        $markdown   = $this->getView()->plugin('markdown');
        $normalized = $this->normalize($object);
        $filter     = new PreviewFilter(152);
        $content    = $normalized->getContent();
        $content    = $markdown->toHtml($content);
        $preview    = $filter->filter($content);
        return $preview;
    }

    public function toTitle($object)
    {
        return $this->normalize($object)->getTitle();
    }

    public function toType($object)
    {
        return $this->normalize($object)->getType();
    }

    public function toUrl($object, $forceCanonical = false)
    {
        $normalized = $this->normalize($object);
        return $this->getView()->url(
            $normalized->getRouteName(),
            $normalized->getRouteParams(),
            ['force_canonical' => $forceCanonical]
        );
    }

    protected function normalize($object)
    {
        return $this->getNormalizer()->normalize($object);
    }
}
