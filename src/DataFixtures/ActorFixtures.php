<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {

        $faker  =  Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }
        $manager->flush();
    }
}
