<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Ui\View\Helper;

use Zend\View\Exception;
use Zend\View\Helper\Partial;
use Zend\View\Model\ModelInterface;
use ZfcTwig\View\TwigRenderer;

class TwigPartial extends Partial
{
    /**
     * @var TwigRenderer
     */
    protected $twigRenderer;

    /**
     * @param TwigRenderer $twigRenderer
     */
    function __construct(TwigRenderer $twigRenderer)
    {
        $this->twigRenderer = $twigRenderer;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke($name = null, $values = null)
    {
        if (0 == func_num_args()) {
            return $this;
        }

        // If we were passed only a view model, just render it.
        if ($name instanceof ModelInterface) {
            return $this->getView()->render($name);
        }

        if (is_scalar($values)) {
            $values = array();
        } elseif ($values instanceof ModelInterface) {
            $values = $values->getVariables();
        } elseif (is_object($values)) {
            if (null !== ($objectKey = $this->getObjectKey())) {
                $values = array($objectKey => $values);
            } elseif (method_exists($values, 'toArray')) {
                $values = $values->toArray();
            } else {
                $values = get_object_vars($values);
            }
        }

        return $this->twigRenderer->render($name, $values);
    }
}
