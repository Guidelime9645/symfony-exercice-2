<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $faker  =  Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $season = new Season();
            $season->setProgramId($this->getReference('program_' . $faker->numberBetween(0, 5)));
            $season->setNumber($faker->numberBetween(1, 10));
            $season->setYear($faker->numberBetween(2000, 2020));
            $season->setDescription($faker->text(200));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
        }
        $manager->flush();
    }
    public function getDependencies()

    {

        return [ProgramFixtures::class];
    }
}
