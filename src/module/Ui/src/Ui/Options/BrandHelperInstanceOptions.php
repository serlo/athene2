<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui\Options;

use Zend\Stdlib\AbstractOptions;

class BrandHelperInstanceOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $name = 'Athene2';

    /**
     * @var string
     */
    protected $slogan = 'The Learning Resources Management System';

    /**
     * @var string
     */
    protected $description = 'Manage your learning resources, easy, fast and reliable.';

    /**
     * @var string
     */
    protected $logo = 'Logo html here';


    /**
     * @var string
     */
    protected $headTitle = 'Athene2';

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;
    }

    /**
     * @return string
     */
    public function getHeadTitle()
    {
        return $this->headTitle;
    }

    /**
     * @param string $headTitle
     */
    public function setHeadTitle($headTitle)
    {
        $this->headTitle = $headTitle;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * @param string $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }
}
