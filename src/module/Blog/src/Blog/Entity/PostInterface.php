<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Blog\Entity;

use DateTime;
use Instance\Entity\InstanceAwareInterface;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Model\TaxonomyTermModelInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface PostInterface extends UuidInterface, TaxonomyTermAwareInterface, InstanceAwareInterface
{

    /**
     * Gets the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Gets the content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Gets the creation date.
     *
     * @return Datetime
     */
    public function getTimestamp();

    /**
     * Gets the publish date.
     *
     * @return DateTime
     */
    public function getPublish();

    /**
     * @return int
     */
    public function isPublished();

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets the title.
     *
     * @param string $title
     * @return self
     */
    public function setTitle($title);

    /**
     * Gets the author.
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Gets the category.
     *
     * @return TaxonomyTermModelInterface
     */
    public function getBlog();

    /**
     * Sets the category.
     *
     * @param TaxonomyTermInterface $category
     * @return self
     */
    public function setBlog(TaxonomyTermInterface $category);

    /**
     * Sets the creation date.
     *
     * @param Datetime $date
     * @return self
     */
    public function setTimestamp(Datetime $date);

    /**
     * Sets the content.
     *
     * @param string $content
     * @return self
     */
    public function setContent($content);

    /**
     * Sets the author.
     *
     * @param UserInterface $author
     * @return self
     */
    public function setAuthor(UserInterface $author);

    /**
     * Sets the publish date.
     *
     * @param Datetime $publish
     * @return self
     */
    public function setPublish(Datetime $publish = null);
}
