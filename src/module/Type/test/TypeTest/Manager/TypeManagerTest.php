<?php
namespace module\Blog\test\BlogTest\Manager;

use AtheneTest\TestCase\AbstractManagerTestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Type\Entity\Type;
use Type\Entity\TypeInterface;
use Type\TypeManager;
use Type\TypeManagerInterface;

class TypeManagerTest extends AbstractManagerTestCase
{
    /**
     * @var TypeManagerInterface
     */
    private $typeManager;

    public function setUp()
    {
        parent::setUp();
        $this->classResolver = $this->mockClassResolver();
        $this->objectManager = $this->mockObjectManager();
        $this->typeManager = new TypeManager($this->classResolver, $this->objectManager);
    }

    public function testFindTypeByNames_OK()
    {
        $names = ["name1","name2"];
        $className = "Type\Entity\Type";
        $types = new ArrayCollection([new Type(),new Type()]);

        $this->prepareResolveClass($this->classResolver, TypeInterface::class, $className);
        $this->prepareFindBy($this->objectManager, $className, ['name' => $names], $types->toArray());

        $this->assertEquals($types, $this->typeManager->findTypesByNames($names));
    }

    public function testFindTypeByName_OK()
    {
        $name = "name";
        $className = "Type\Entity\Type";
        $type = new Type();

        $this->prepareResolveClass($this->classResolver, TypeInterface::class, $className);
        $this->prepareFindOneBy($this->objectManager, $className, ['name' => $name], $type);

        $this->assertEquals($type, $this->typeManager->findTypeByName($name));
    }
}
