<?php

namespace App\DataFixtures;

use App\Entity\Types;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['fire', 'electric', 'water', 'grass', 'dragon', 'normal', 'flying', 'ice'];
        
        foreach($types as $typeName) {
            $types = new Types();
            $types->setNom($typeName);
            $manager->persist($types);
        }
        $manager->flush();
    }
}
