<?php

namespace App\Service;

use App\DTO\Contract\ProductDTO;
use App\Entity\Product;

interface IProductService
{
    public function addProduct(ProductDTO $dto): ?Product;

    public function updateProduct(Product $product, ProductDTO $dto): ?Product;

    public function removeProduct(Product $product): void;

    public function getProducts(): ?array;

}