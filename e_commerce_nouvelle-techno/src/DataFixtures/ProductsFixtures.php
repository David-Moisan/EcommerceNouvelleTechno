<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}
    
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_EN');

        for($prod = 1; $prod <= 10; $prod++) {
            $product = new Product();
            $product->setName($faker->text(5));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 50000));
            $product->setStock($faker->numberBetween(0, 10));
            //On va chercher une référence de catégorie 
            $category = $this->getReference('category-'. rand(1,11));
            $product->setCategory($category); 

            $this->setReference('product-'. $prod, $product);
            
            $manager->persist($product);
            $this->addReference('product'. $prod, $product);
        }

        $manager->flush();
    }
}
