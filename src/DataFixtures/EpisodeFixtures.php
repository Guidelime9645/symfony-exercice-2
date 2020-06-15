<?php
namespace App\DataFixtures;

use App\Entity\Episode;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $faker  =  Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $episode = new Episode();
            $episode->setSeasonId($this->getReference('season_' . $faker->numberBetween(0, 19)));
            $episode->setTitle($faker->word);
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynopsis($faker->text(200));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }
        $manager->flush();
    }

    public function getDependencies()

    {

        return [SeasonFixtures::class];
    }
}
