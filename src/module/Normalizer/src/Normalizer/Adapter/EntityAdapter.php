<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use DateTime;
use Entity\Entity\EntityInterface;

class EntityAdapter extends AbstractAdapter
{
    /**
     * @return EntityInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof EntityInterface;
    }

    protected function getContent()
    {
        return $this->getField('content');
    }

    protected function getCreationDate()
    {
        return $this->getObject()->getTimestamp();
    }

    /**
     * @return string
     */
    protected function getDescription()
    {
        return $this->getField(['summary', 'description', 'content']);
    }

    protected function getField($field, $default = '')
    {
        $entity = $this->getObject();
        $id     = $entity->getId();

        if (is_array($field)) {
            $fields = $field;
            $value  = '';
            foreach ($fields as $field) {
                $value = $this->getField((string)$field);
                if ($value && $value != $id) {
                    break;
                }
            }

            return $value ? : $id;
        }


        $revision = $entity->hasCurrentRevision() ? $entity->getCurrentRevision() : $entity->getHead();

        if (!$revision) {
            return $default;
        }

        $value = $revision->get($field);

        return $value ? : $id;
    }

    protected function getId()
    {
        return $this->getObject()->getId();
    }

    protected function getKeywords()
    {
        $entity   = $this->getObject();
        $keywords = [];
        foreach ($entity->getTaxonomyTerms() as $term) {
            while ($term->hasParent()) {
                $keywords[] = $term->getName();
                $term       = $term->getParent();
            }
        }
        return array_unique($keywords);
    }

    /**
     * @return DateTime
     */
    protected function getLastModified()
    {
        $head = $this->getObject()->getHead();
        if ($head) {
            return $head->getTimestamp();
        }
        return new DateTime();
    }

    protected function getPreview()
    {
        return $this->getField(['summary', 'description', 'content']);
    }

    protected function getRouteName()
    {
        return 'entity/page';
    }

    protected function getRouteParams()
    {
        return [
            'entity' => $this->getObject()->getId()
        ];
    }

    protected function getTitle()
    {
        return $this->getField(['title', 'id'], $this->getId());
    }

    protected function getType()
    {
        return $this->getObject()->getType()->getName();
    }
}
