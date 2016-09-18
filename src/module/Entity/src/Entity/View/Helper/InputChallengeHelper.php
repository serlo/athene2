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
use Zend\View\Helper\AbstractHelper;

class InputChallengeHelper extends AbstractHelper
{
    public function __invoke() {
        return $this;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function fetchInput(EntityInterface $entity) {
        foreach ($entity->getValidChildren('link') as $child) {
            if (in_array($child->getType()->getName(), [
                'input-string-normalized-match-challenge',
                'input-number-exact-match-challenge',
                'input-expression-equal-match-challenge'
            ])) {
                return $child;
            }
        }

        return null;
    }

    /**
     * @param EntityInterface $entity
     * @return array
     */
    public function fetchWrongInputs(EntityInterface $entity) {
        $wrongInputs = [];

        foreach ($entity->getValidChildren('link') as $child) {
            $revision = $child->getCurrentRevision();

            if ($revision) {
                $wrongInputs[] = [
                    'entity' => $child,
                    'type' => $child->getType()->getName(),
                    'solution' => $revision->get('solution'),
                    'feedback' => $this->view->markdown()->toHtml($revision->get('feedback'))
                ];
            }
        }

        return $wrongInputs;
    }
}
