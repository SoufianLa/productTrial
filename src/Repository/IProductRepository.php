<?php

namespace App\Repository;

use App\Entity\Product;

interface IProductRepository
{
    public function addProduct(Product $product): void;
    public function updateProduct(Product $product): void;
    public function removeProduct(Product $product): void;
    public function getAllProducts(): ?array;

}