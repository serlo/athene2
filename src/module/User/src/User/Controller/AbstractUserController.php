<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractUserController extends AbstractActionController
{
    use \User\Manager\UserManagerAwareTrait;
}
