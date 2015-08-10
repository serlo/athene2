<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Hydrator;

use Instance\Manager\InstanceManagerAwareTrait;
use Instance\Manager\InstanceManagerInterface;
use Navigation\Provider\ContainerProviderInterface;
use Subject\Manager\SubjectManagerAwareTrait;
use Subject\Manager\SubjectManagerInterface;
use Zend\Stdlib\ArrayUtils;

class Navigation implements ContainerProviderInterface
{
    use SubjectManagerAwareTrait, InstanceManagerAwareTrait;

    protected $path;

    public function __construct(InstanceManagerInterface $instanceManager, SubjectManagerInterface $subjectManager)
    {
        $this->subjectManager  = $subjectManager;
        $this->instanceManager = $instanceManager;
    }

    public function provide($container)
    {
        $config   = [];
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $subjects = $this->getSubjectManager()->findSubjectsByInstance($instance);
        foreach ($subjects as $subject) {
            $config = ArrayUtils::merge(
                $config,
                include $this->path . $instance->getName() . '/' . strtolower(
                        $subject->getName()
                    ) . '/navigation.config.php'
            );
        }

        return $config;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
}
