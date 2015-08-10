<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Manager;

interface SubjectManagerAwareInterface
{
    /**
     * Gets the SubjectManager
     *
     * @return SubjectManagerInterface
     */
    public function getSubjectManager();

    /**
     * Sets the SubjectManager
     *
     * @param SubjectManagerInterface $subject
     * @return self
     */
    public function setSubjectManager(SubjectManagerInterface $subject);
}
