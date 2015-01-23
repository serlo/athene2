<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Manager;

trait SubjectManagerAwareTrait
{

    /**
     * @var SubjectManagerInterface
     */
    protected $subjectManager;

    /**
     * @param SubjectManagerInterface $subjectManager
     * @return self
     */
    public function setSubjectManager(SubjectManagerInterface $subjectManager)
    {
        $this->subjectManager = $subjectManager;
        return $this;
    }

    /**
     * @return SubjectManagerInterface
     */
    public function getSubjectManager()
    {
        return $this->subjectManager;
    }
}
