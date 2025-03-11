<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

#[AllowDynamicProperties]
class ProductFixtures extends Fixture
{
    public function __construct(
        EntityManagerInterface $em,
    )
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 20; $i++) {
            $p = new Product();
            $p->setName($faker->country());
            $p->setPrice($faker->randomFloat(2, 10));
            $p->setType($faker->name());
            $manager->persist($p);
        }

        $manager->flush();
    }
}
