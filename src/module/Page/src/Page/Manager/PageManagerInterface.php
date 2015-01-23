<?php
namespace Page\Manager;

use Common\ObjectManager\Flushable;
use Page\Entity\PageRepositoryInterface;
use Page\Entity\PageRevisionInterface;
use User\Entity\UserInterface;
use Zend\Form\FormInterface;

interface PageManagerInterface extends Flushable
{
    /**
     * @param FormInterface $form
     * @return PageRepositoryInterface
     */
    public function createPageRepository(FormInterface $form);

    /**
     * @param PageRepositoryInterface $repository
     * @param array                   $data
     * @param UserInterface           $user
     * @return PageRepositoryInterface
     */
    public function createRevision(PageRepositoryInterface $repository, array $data, UserInterface $user);

    /**
     * @param FormInterface           $form
     * @return mixed
     */
    public function editPageRepository(FormInterface $form);

    /**
     * @param numeric $id
     * @return PageRepositoryInterface;
     */
    public function getPageRepository($id);

    /**
     * @param numeric $id
     * @return PageRevisionInterface;
     */
    public function getRevision($id);
}
