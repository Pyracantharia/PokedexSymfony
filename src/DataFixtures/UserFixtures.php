<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
      
        $faker = Faker\Factory::create('fr_FR');

        for($nbUsers = 1; $nbUsers <= 10; $nbUsers++) {
            $user = new User();
            $user->setEmail($faker->email);
            if($nbUsers === 1){
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            $user->setPassword($this->encoder->encodePassword($user, 'test'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
