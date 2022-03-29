<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{   
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void    
    {
        $parent = $this->createCategory(name: 'Computer Science', manager: $manager);
        $this->createCategory(name: 'Desktop', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Screen', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Accessories', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Components', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Networks', parent: $parent, manager: $manager);

        $parent = $this->createCategory(name: 'High-Tech', manager: $manager);
        $this->createCategory(name: 'Connected Object', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Audio', parent: $parent, manager: $manager);
        $this->createCategory(name: 'Phone', parent: $parent, manager: $manager);
        $this->createCategory(name: 'TV', parent: $parent, manager: $manager);

        $manager->flush();
    }

    public function createCategory(string $name, Category $parent = null, ObjectManager $manager) 
    {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('category-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
