<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($img = 1; $img <= 100; $img++)
        {
            $image = new Image();
            $image->setName($faker->image(null, 640, 480));
            $product = $this->getReference('product-'. rand(1, 10));
            $image->setProduct(($product));
            $manager->persist($image);
        }

        $manager->flush();
    }
    
    /**
     * GetDepencies() permet de changer l'ordre alphabétique de la création des fixtures et créé les ProductFixtures avant ImageFixtures 
     * @return array
     */
    public function getDependencies():array
    {
        return [
            ProductsFixtures::class
        ];
    }
}
