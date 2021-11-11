<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i <=10 ; $i++) { 
            $product = new Product();
            $product->setLibelle("lib $i")
                    ->setPrix($i*10+5)
                    ->setDescription("description de l'article n° $i")
                    ->setImage("http://placehold.it/350*150");
            $manager->persist($product);
        } 
     

        $manager->flush();
    }
}
