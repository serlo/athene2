<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui\View\Helper;

use Common\Traits\ConfigAwareTrait;
use Ui\Options\PageHeaderHelperOptions;
use Zend\Filter\StripTags;
use Zend\View\Helper\AbstractHelper;

class PageHeader extends AbstractHelper
{
    /**
     * @var string
     */
    protected $text = '';

    /**
     * @var string
     */
    protected $subtext = '';

    /**
     * @var string|null
     */
    protected $backLink = '';

    /**
     * @var PageHeaderHelperOptions
     */
    protected $options;

    /**
     * @var string
     */
    protected $append = '';

    /**
     * @var string
     */
    protected $prepend = '';

    /**
     * @param PageHeaderHelperOptions $pageHeaderHelperOptions
     */
    public function __construct(PageHeaderHelperOptions $pageHeaderHelperOptions)
    {
        $this->options = $pageHeaderHelperOptions;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function __invoke($text)
    {
        $this->text = $this->getView()->translate((string)$text);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param string $string
     * @return $this
     */
    public function append($string)
    {
        $this->append .= $string;
        return $this;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function prepend($string)
    {
        $this->prepend .= $string;
        return $this;
    }

    /**
     * @param bool $setHeadTitle
     * @return string
     */
    public function render($setHeadTitle = true)
    {
        if ($setHeadTitle) {
            $filter = new StripTags();
            $this->getView()->headTitle($filter->filter($this->text));
            if (!empty($this->subtext)) {
                $this->getView()->headTitle($filter->filter($this->subtext));
            }
        }

        return $this->getView()->partial(
            $this->options->getTemplate(),
            [
                'text'     => $this->text,
                'subtext'  => $this->subtext,
                'backLink' => $this->backLink,
                'append'   => $this->append,
                'prepend'  => $this->prepend
            ]
        );
    }

    /**
     * @param string $backLink
     * @return $this
     */
    public function setBackLink($backLink)
    {
        $this->backLink = $backLink;
        return $this;
    }

    /**
     * @param string $subtext
     * @return $this
     */
    public function setSubtitle($subtext)
    {
        $this->subtext = $this->getView()->translate((string)$subtext);
        return $this;
    }
}
