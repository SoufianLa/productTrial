<?php

namespace App\Tests\Unit\Service;

use App\DTO\Contract\ProductDTO;
use App\Entity\Product;
use App\Repository\IProductRepository;
use App\Service\ProductService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    private MockObject $repository;
    private ProductService $productService;

    public function setUp(): void
    {
        $this->repository = $this->createMock(IProductRepository::class);
        $this->productService = new ProductService($this->repository);
    }

    public function testAddProduct(): void
    {
        $dto = $this->createMock(ProductDTO::class);
        $product = $this->createMock(Product::class);

        $dto->expects($this->once())->method('mapToEntity')
            ->with(Product::class)->willReturn($product);
        $this->repository->expects($this->once())->method('addProduct')->with($product);

        $result = $this->productService->addProduct($dto);
        $this->assertSame($result, $product);
    }

    public function testUpdateProduct(): void
    {
        $dto = $this->createMock(ProductDTO::class);
        $product = $this->createMock(Product::class);

        $dto->expects($this->once())->method('mapToEntity')
            ->with($product)->willReturn($product);
        $this->repository->expects($this->once())->method('UpdateProduct')->with($product);
        $result = $this->productService->updateProduct($product, $dto);
        $this->assertSame($result, $product);

    }

    public function testRemoveProduct(): void
    {
        $product = $this->createMock(Product::class);
        $this->repository->expects($this->once())->method('removeProduct')->with($product);
        $this->productService->removeProduct($product);
        $this->assertTrue(true); // Dummy assert to confirm no exceptions thrown

    }

    public function testGetProducts(): void
    {
        $products = [$this->createMock(Product::class)];
        $this->repository->expects($this->once())->method('getAllProducts')->willReturn($products);

        $result = $this->productService->getProducts();

        self::assertSame($result, $products);

    }
}
