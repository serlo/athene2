<?php
namespace RelatedContent\Entity;

interface HolderInterface
{

    /**
     * @return ContainerInterface
     */
    public function getContainer();

    /**
     * @return InternalInterface ExternalInterface CategoryInterface
     */
    public function getSpecific();

    /**
     * @param ContainerInterface $container
     * @return self
     */
    public function setContainer(ContainerInterface $container);

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @param int $position
     * @return self
     */
    public function setPosition($position);
}
