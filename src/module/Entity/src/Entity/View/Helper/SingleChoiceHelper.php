<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\View\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Entity\Exception;
use Entity\Options\ModuleOptionsAwareTrait;
use Zend\View\Helper\AbstractHelper;

class SingleChoiceHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function fetchSingleChoice(EntityInterface $entity) {
        $answers = [];
        foreach ($entity->getChildren('link', 'single-choice-right-answer') as $add) {
            $answers[] = [
                'right' => true,
                'entity' => $add
            ];
        }
        foreach ($entity->getChildren('link', 'single-choice-wrong-answer') as $add) {
            $answers[] = [
                'right' => false,
                'entity' => $add
            ];
        }
        shuffle($answers);
        return $answers;
    }

    /**
     * @param EntityInterface $entity
     * @return String
     */
    public function fetchPositiveFeedback(EntityInterface $entity) {
        foreach ($entity->getChildren('link', 'single-choice-right-answer') as $positive) {
            if ($positive->hasCurrentRevision()) {
                return $positive->getCurrentRevision()->get('feedback');
            } else {
                return '';
            }
        }
    }
}
