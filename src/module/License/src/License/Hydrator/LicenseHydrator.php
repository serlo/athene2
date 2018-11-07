<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Hydrator;

use License\Entity;
use License\Exception;
use Zend\Stdlib\Hydrator\HydratorInterface;

class LicenseHydrator implements HydratorInterface
{
    public function extract($object)
    {
        /* @var $object Entity\LicenseInterface */
        if (!$object instanceof Entity\LicenseInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected parameter 1 to be an instance of LicenseInterface but got `%s`',
                get_class($object)
            ));
        }

        return [
            'title'     => $object->getTitle(),
            'url'       => $object->getUrl(),
            'content'   => $object->getContent(),
            'iconHref'  => $object->getIconHref(),
            'agreement' => $object->getAgreement(),
            'default'   => $object->isDefault(),
        ];
    }

    public function hydrate(array $data, $object)
    {
        /* @var $object Entity\LicenseInterface */
        if (!$object instanceof Entity\LicenseInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected parameter 1 to be an instance of LicenseInterface but got `%s`',
                get_class($object)
            ));
        }

        $object->setContent($data['content']);
        $object->setTitle($data['title']);
        $object->setUrl($data['url']);
        $object->setIconHref($data['iconHref']);
        $object->setAgreement($data['agreement']);
        $object->setDefault($data['default']);

        return $object;
    }
}
