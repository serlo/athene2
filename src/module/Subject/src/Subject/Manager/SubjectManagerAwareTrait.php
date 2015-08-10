<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
