<?php

namespace App\Resolver;

use App\Attribute\MapRequestDTO;
use App\Exception\ApiException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MapRequestDtoResolver implements ValueResolverInterface
{
    private PropertyAccessorInterface $propertyAccessor;
    private ValidatorInterface $validator;

    public function __construct(PropertyAccessorInterface $propertyAccessor, ValidatorInterface $validator)
    {
        $this->propertyAccessor = $propertyAccessor;
        $this->validator = $validator;
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $group = null;
        $className = $argument->getType();
        $attribute = $argument->getAttributesOfType(MapRequestDTO::class)[0] ?? null;
        if ($attribute) {
            $data = array_merge($request->request->all()??[], $request->files->all()??[], $request->query->all()??[], json_decode($request->getContent(), 1)??[]);
            $dto = new $className($request);
            $reflect = new \ReflectionClass($dto);
            foreach ($reflect->getProperties() as $property) {
                $name = $property->getName();
                $value = $data[$name] ?? null;
                $this->propertyAccessor->setValue($dto, $name, $value);
            }
            if(!empty($attribute->getValidationGroup())){
                $group[] = $attribute->getValidationGroup();
            }
            $violation = $this->formatViolationMessage($this->validator->validate($dto, null, $group));
            if ($violation) {
                throw new ApiException( statusCode: Response::HTTP_UNPROCESSABLE_ENTITY, message: $violation);
            }
            yield $dto;
        }
        return [];

    }

    private function formatViolationMessage(ConstraintViolationListInterface $list): bool|string
    {
        if (count($list) > 0) {
            $violation = $list->get(0);

            return ucfirst($violation->getPropertyPath()).' : '.$violation->getMessage();
        }

        return false;
    }


}