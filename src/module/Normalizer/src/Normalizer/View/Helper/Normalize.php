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
namespace Normalizer\View\Helper;

use Common\Filter\PreviewFilter;
use Markdown\View\Helper\MarkdownHelper;
use Normalizer\NormalizerAwareTrait;
use Ui\View\Helper\Brand;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\HeadMeta;
use Zend\View\Helper\HeadTitle;

class Normalize extends AbstractHelper
{
    use NormalizerAwareTrait;

    private static $maxStringLen = 65;

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
        $type       = $normalized->getType();
        $metadata   = $normalized->getMetadata();
        $keywords   = $metadata->getKeywords();
        $robots     = $metadata->getRobots();
        $preview    = $this->toPreview($object);
        $image      = $this->getMetaImage($object);
        $site_name  = $this->getView()->brand()->getBrand(true);

        $meta->appendName('content_type', $type);
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
        $this->getView()->headLink(['rel' => 'search', 'href' => '/opensearch.xml', 'title' => 'Serlo (de)','type' => 'application/opensearchdescription+xml']);

        return $this;
    }


    public function getMetaImage($object)
    {
        $fileName = 'meta_serlo.jpg';

        $subject = trim(strtolower(strip_tags(
            $this->getView()->navigation('default_navigation')
                ->menu()
                ->setPartial('layout/navigation/partial/active-subject')
                ->setOnlyActiveBranch(true)
                ->setMinDepth(0)
                ->setMaxDepth(0)
                ->render()
        )));

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

    public function headTitle($object = null)
    {
        /* @var $headTitle HeadTitle */
        $headTitle  = $this->getView()->plugin('headTitle');

        $title='';
        if($object == null) {
            /** @var Brand $brand */
            $brand  = $this->getView()->brand();
            $title = $brand->getBrand(true) . " – " . $brand->getSlogan();
        } else if(is_string($object)){
            $title = $this->appendBrand($object);
        } else {
            $normalized = $this->normalize($object);
            $title = $this->appendBrand($normalized->getMetadata()->getTitle());
        }
        $headTitle($title);
        return $this;
    }

    private function appendBrand($title) {
        /** @var Brand $brand */
        $brand  = $this->getView()->brand();
        $maxStringLen = 65;

        //add "– lernen mit Serlo"
        $titlePostfix = ' – ' . $brand->getHeadTitle(true);
        if( strlen($title) < ($maxStringLen-strlen($titlePostfix)) ){
            return $title . $titlePostfix;
        }

        $titlePostfixFallback = ' – ' . $brand->getBrand(true);
        if( strlen($title) < ($maxStringLen-strlen($titlePostfixFallback))) {
            return $title . $titlePostfixFallback;
        }

        return $title;
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
