<?php
namespace Page\Entity;

use Instance\Entity\InstanceProviderInterface;
use Uuid\Entity\UuidInterface;
use Versioning\Entity\RevisionInterface;

interface PageRevisionInterface extends RevisionInterface, InstanceProviderInterface, UuidInterface
{
}
