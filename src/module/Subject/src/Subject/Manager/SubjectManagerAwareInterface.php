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
