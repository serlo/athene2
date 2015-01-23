<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Mailman\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Mailman\MailmanAwareTrait;
use Mailman\MailmanInterface;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Renderer\RendererInterface;

abstract class AbstractListener extends AbstractSharedListenerAggregate
{
    use MailmanAwareTrait;
    use TranslatorAwareTrait;

    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * @param MailmanInterface  $mailman
     * @param RendererInterface $phpRenderer
     * @param Translator        $translator
     */
    public function __construct(MailmanInterface $mailman, RendererInterface $phpRenderer, Translator $translator)
    {
        $this->mailman    = $mailman;
        $this->translator = $translator;
        $this->renderer   = $phpRenderer;
    }

    /**
     * @return PhpRenderer $renderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}
