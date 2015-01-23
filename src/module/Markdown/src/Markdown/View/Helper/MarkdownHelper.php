<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Markdown\View\Helper;

use Exception;
use Markdown\Exception\RuntimeException;
use Markdown\Service\RenderServiceAwareTrait;
use Markdown\Service\RenderServiceInterface;
use Zend\View\Helper\AbstractHelper;

class MarkdownHelper extends AbstractHelper
{
    use RenderServiceAwareTrait;

    protected $storage;

    public function __construct(RenderServiceInterface $renderService)
    {
        $this->renderService = $renderService;
    }

    public function __invoke()
    {
        return $this;
    }

    /**
     * @param string $content
     * @param bool   $catch
     * @return string
     */
    public function toHtml($content, $catch = true)
    {
        if ($catch) {
            try {
                return $this->getRenderService()->render($content);
            } catch (RuntimeException $e) {
                return htmlspecialchars($content);
            }
        } else {
            return $this->getRenderService()->render($content);
        }
    }
}
