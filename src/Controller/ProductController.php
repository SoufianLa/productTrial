<?php

namespace App\Controller;

use App\Component\IResponder;
use App\DTO\Contract\ErrorResponseDTO;
use App\DTO\Contract\ProductDTO;
use App\Entity\Product;
use App\Service\IProductService;
use App\Attribute\MapRequestDTO;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ProductController extends AbstractController
{
    public function __construct(readonly private IProductService $service, readonly private IResponder $responder)
    {

    }

    #[Route('/api/products', name: 'create_product', methods: ['POST'])]
    #[OA\RequestBody(content: new Model(type: ProductDTO::class))]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Created with success',
        content: new Model(type: Product::class)
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Wrong input',
        content: new Model(type: ErrorResponseDTO::class)
    )]
    #[OA\Tag('Product')]
    public function createProduct(#[MapRequestDTO] ProductDTO $dto): Response
    {
        $product = $this->service->addProduct($dto);

        return $this->responder->render($product, Response::HTTP_CREATED);
    }

    #[Route('/api/products', name: 'get_products', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successful response',
        content: new Model(type: Product::class)
    )]
    #[OA\Tag('Product')]
    public function getProducts(): Response
    {
        return $this->responder->render($this->service->getProducts());
    }

    #[Route('/api/products/{id}', name: 'get_product_details', methods: ['GET'])]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successful response',
        content: new Model(type: Product::class)
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
    )]
    #[OA\Tag('Product')]
    public function getProductDetails(?Product $product): Response
    {
        $statusCode = $product ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        return $this->responder->render($product, $statusCode);
    }

    #[Route('/api/products/{id}', name: 'update_product', methods: ['PATCH'])]
    #[OA\RequestBody(content: new Model(type: ProductDTO::class))]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Successful response',
        content: new Model(type: Product::class)
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
    )]
    #[OA\Response(
        response: Response::HTTP_UNPROCESSABLE_ENTITY,
        description: 'Wrong input',
        content: new Model(type: ErrorResponseDTO::class)
    )]
    #[OA\Tag('Product')]
    public function updateProduct(?Product $product, #[MapRequestDTO] ProductDTO $dto): Response
    {
        $product = $this->service->updateProduct($product, $dto);
        $statusCode = $product ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;

        return $this->responder->render($product, $statusCode);
    }

    #[Route('/api/products/{id}', name: 'delete_product', methods: ['DELETE'])]
    #[OA\Response(
        response: Response::HTTP_NO_CONTENT,
        description: 'success',
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Not found',
    )]
    #[OA\Tag('Product')]
    public function deleteProduct(?Product $product): Response
    {
        $this->service->removeProduct($product);
        $statusCode = $product ? Response::HTTP_NO_CONTENT : Response::HTTP_NOT_FOUND;

        return $this->responder->render([], $statusCode);
    }

}