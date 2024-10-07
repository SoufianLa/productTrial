<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\InventoryStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setCode($faker->unique()->bothify('???-####'));
            $product->setName($faker->word);
            $product->setDescription($faker->sentence);
            $product->setImage($faker->imageUrl(400, 400, 'product', true));
            $product->setCategory($faker->randomElement(['Electronics', 'Books', 'Toys', 'Clothing']));
            $product->setPrice($faker->randomFloat(2, 10, 500));
            $product->setQuantity($faker->numberBetween(0, 100));
            $product->setInternalReference($faker->unique()->numerify('INT-####'));
            $product->setShellId($faker->numberBetween(1, 10));
            $product->setInventoryStatus($faker->randomElement([InventoryStatus::INSTOCK, InventoryStatus::LOWSTOCK, InventoryStatus::OUTOFSTOCK]));
            $product->setRating($faker->numberBetween(1, 5)); // Random rating between 1 and 5

            $manager->persist($product);
        }

        $manager->flush();
    }


}
