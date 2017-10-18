<?php

namespace AppBundle\Model\Animal\Manager;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Species;
use AppBundle\Model\ModelManagerAwareInterface;
use AppBundle\Model\ModelManagerAwareTrait;

/**
 * Class AnimalManager.
 */
class AnimalManager implements ModelManagerAwareInterface
{
    use ModelManagerAwareTrait;

    /**
     * @param Species|null $species
     *
     * @return Animal
     */
    public function createAnimal(Species $species = null): Animal
    {
        $animal = new Animal();
        $animal->setSpecies($species);
        $species->addAnimal($animal);

        return $animal;
    }

    /**
     * @param Animal $animal
     *
     * @return bool
     */
    public function delete(Animal $animal)
    {
        $species = $animal->getSpecies();
        $species->removeAnimal($animal);

        return $this->modelManager->delete($animal);
    }
}
