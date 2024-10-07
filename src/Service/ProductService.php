<?php

namespace App\Service;

use App\DTO\Contract\ProductDTO;
use App\Entity\Product;
use App\Repository\IProductRepository;

class ProductService implements IProductService
{
    public function __construct(readonly private IProductRepository $repository)
    {

    }

    /**
     * @param ProductDTO $dto
     * @return Product|null
     */
    public function addProduct(ProductDTO $dto): ?Product
    {
        /**
         * @var $product Product
         */
        $product = $dto->mapToEntity(Product::class);
        $this->repository->addProduct($product);

        return $product;
    }

    /**
     * @param Product $product
     * @param ProductDTO $dto
     * @return Product|null
     */
    public function updateProduct(Product $product, ProductDTO $dto): ?Product
    {
        /**
         * @var $product Product
         */
        $product = $dto->mapToEntity($product);
        $this->repository->updateProduct($product);

        return $product;

    }

    /**
     * @param Product $product
     * @return void
     */
    public function removeProduct(Product $product): void
    {
        $this->repository->removeProduct($product);
    }

    /**
     * @return array|null
     */
    public function getProducts(): ?array
    {
        return $this->repository->getAllProducts();
    }


}