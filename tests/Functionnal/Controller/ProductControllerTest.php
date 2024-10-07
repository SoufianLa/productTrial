<?php

namespace App\Tests\Functionnal\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    public function testCreateProduct(): void
    {
        $client = static::createClient();
        $payload = [
            'code' => 'P001',
            'name' => 'Test Product',
            'description' => 'A sample product description',
            'image' => "https://via.placeholder.com/400x400.png/0077cc?text=product+a",
            'category' => 'Electronics',
            'price' => 199.99,
            'quantity' => 100,
            'internalReference' => 'REF123',
            'shellId' => 1,
            'inventoryStatus' => 'INSTOCK',
            'rating' => 5,
        ];

        $client->request(
            'POST',
            '/api/products', [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        // Assert that the response contains the product details
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertSame('Test Product', $responseData['name']);
    }

    public function testGetProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/products');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertIsArray($responseData);
    }

    public function testGetProductDetails(): void
    {
        $client = static::createClient();
        $product = $this->createProduct();
        $client->request('GET', '/api/products/'.$product->getId());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->request('GET', '/api/products/999');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testUpdateProduct(): void
    {
        $client = static::createClient();
        $product = $this->createProduct();
        $client->request(
            'PATCH', '/api/products/'.$product->getId(), [], [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'code' => 'P001',
                'name' => 'update Test Product',
                'description' => 'This is a test product.',
                'image' => 'http://example.com/image.jpg',
                'category' => 'Electronics',
                'price' => 199.99,
                'quantity' => 10,
                'internalReference' => 'INT-REF',
                'shellId' => 1,
                'inventoryStatus' => 'INSTOCK',
                'rating' => 4,
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testDeleteProduct(): void
    {
        $client = static::createClient();
        $product = $this->createProduct();
        $client->request('DELETE', '/api/products/'.$product->getId());

        $this->assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }


    private function createProduct(): Product
    {
        $em = self::getContainer()->get('doctrine')->getManager();

        $product = new Product();
        $product->setCode('P001');
        $product->setName('Test Product');
        $product->setDescription('This is a test product.');
        $product->setImage('http://example.com/image.jpg');
        $product->setCategory('Electronics');
        $product->setPrice(299.99);
        $product->setQuantity(10);
        $product->setInternalReference('INT-REF');
        $product->setShellId(1);
        $product->setInventoryStatus('INSTOCK');
        $product->setRating(4);

        $em->persist($product);
        $em->flush();

        return $product;
    }


}
