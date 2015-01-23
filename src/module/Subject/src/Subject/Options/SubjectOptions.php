<?php
/**
 * 
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	    LGPL-3.0
 * @license	    http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Subject\Options;

use Zend\Stdlib\AbstractOptions;

class SubjectOptions extends AbstractOptions
{

    protected $allowedTaxonomies = [];

    protected $allowedEntities = [];

    /**
     *
     * @return array
     */
    public function getAllowedTaxonomies()
    {
        return $this->allowedTaxonomies;
    }

    /**
     *
     * @return array
     */
    public function getAllowedEntities()
    {
        return $this->allowedEntities;
    }

    /**
     *
     * @param array $allowedTaxonomies            
     * @return self
     */
    public function setAllowedTaxonomies(array $allowedTaxonomies)
    {
        $this->allowedTaxonomies = $allowedTaxonomies;
        return $this;
    }

    /**
     *
     * @param array $allowedEntities            
     * @return self
     */
    public function setAllowedEntities(array $allowedEntities)
    {
        $this->allowedEntities = $allowedEntities;
        return $this;
    }

    /**
     * 
     * @param string $taxonomy
     * @return boolean
     */
    public function isTaxonomyAllowed($taxonomy)
    {
        return in_array($taxonomy, $this->getAllowedTaxonomies());
    }

    /**
     * 
     * @param string $entity
     * @return boolean
     */
    public function isEntityAllowed($entity)
    {
        return in_array($entity, $this->getAllowedEntities());
    }
}
