<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\View\Helper;

use Common\Filter\Slugify;
use Subject\Options\ModuleOptions;
use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\View\Helper\AbstractHelper;

class SubjectHelper extends AbstractHelper
{

    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var Slugify
     */
    protected $filter;

    public function __construct()
    {
        $this->filter = new Slugify();
    }

    /**
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param TaxonomyTermInterface $subject
     * @return \Subject\Options\SubjectOptions
     */
    public function getOptions(TaxonomyTermInterface $subject)
    {
        return $this->getModuleOptions()->getInstance($subject->getName(), $subject->getInstance()->getName());
    }

    /**
     * @return ModuleOptions
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * @param ModuleOptions $moduleOptions
     */
    public function setModuleOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @param TaxonomyTermInterface $term
     * @param string                $parent
     * @return string
     */
    public function slugify(TaxonomyTermInterface $term, $parent = 'subject')
    {
        return $this->filter->filter(substr($this->processSlugs($term, $parent), 0, -1));
    }

    /**
     * @param TaxonomyTermInterface $term
     * @param string                $parent
     * @return string
     */
    protected function processSlugs(TaxonomyTermInterface $term, $parent)
    {
        return ($term->getTaxonomy()->getName() != $parent) ? $this->processSlugs(
                $term->getParent(),
                $parent
            ) . $term->getName() . '/' : '';
    }
}
