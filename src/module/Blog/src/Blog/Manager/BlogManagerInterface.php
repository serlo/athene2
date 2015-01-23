<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog\Manager;

use Blog\Entity\PostInterface;
use ClassResolver\ClassResolverAwareTrait;
use Instance\Entity\InstanceInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\Form\FormInterface;

interface BlogManagerInterface
{

    /**
     * @param FormInterface $form
     * @return PostInterface|false
     */
    public function createPost(FormInterface $form);

    /**
     * @param InstanceInterface $instanceService
     * @return TaxonomyTermInterface[]
     */
    public function findAllBlogs(InstanceInterface $instanceService);

    /**
     * Make changes persistent
     *
     * @return self
     */
    public function flush();

    /**
     * @param int $id
     * @return TaxonomyTermInterface
     */
    public function getBlog($id);

    /**
     * @param int $id
     * @return PostInterface
     */
    public function getPost($id);

    /**
     * @param FormInterface $form
     * @return void
     */
    public function updatePost(FormInterface $form);
}
