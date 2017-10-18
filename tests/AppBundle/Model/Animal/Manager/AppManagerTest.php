<?php

namespace Tests\AppBundle\Model\Animal\Manager;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Species;
use AppBundle\Model\Animal\Manager\AnimalManager;
use AppBundle\Model\ModelManager;
use PHPUnit\Framework\TestCase;

/**
 * Class AppManagerTest.
 */
class AppManagerTest extends TestCase
{
    private $modelManager;
    private $animalManager;

    public function setUp()
    {
        $this->modelManager = $this->createMock(ModelManager::class);
        $this->animalManager = new AnimalManager();
        $this->animalManager->setModelManager($this->modelManager);
    }

    public function testCreateAnimal()
    {
        $animal = $this->animalManager->createAnimal();
        $this->assertNull($animal->getSpecies());

        $species = new Species();
        $animal = $this->animalManager->createAnimal($species);
        $this->assertSame($species, $animal->getSpecies());
    }

    public function testDelete()
    {
        $animal = new Animal();
        $animal2 = new Animal();
        $this->modelManager->expects($this->exactly(2))
            ->method('delete')
            ->withConsecutive($animal, $animal2)
            ->willReturn(true);

        $species = new Species();
        $animal2->setSpecies($species);
        $species->addAnimal($animal2);

        $result = $this->animalManager->delete($animal);
        $this->assertTrue($result);

        $result = $this->animalManager->delete($animal2);
        $this->assertTrue($result);
    }
}
