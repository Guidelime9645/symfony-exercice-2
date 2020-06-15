<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'fantastique',
        'Horreur',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categorie){
            $category = new Category();
            $category->setName($categorie);
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);

        }

        $manager->flush();
    }
}
