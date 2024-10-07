<?php

namespace App\DTO\Contract;

use Symfony\Component\Serializer\Annotation\Groups;

abstract class BaseDTO
{
    public function mapToEntity(string|object $entityClass, array $groups=[]): object
    {
        $dtoReflection = new \ReflectionClass($this);
        $dtoProperties = $dtoReflection->getProperties();
        $entity = is_object($entityClass) ? $entityClass : new $entityClass();
        foreach ($dtoProperties as $dtoProperty)
        {
            // Filter by group if groups are provided
            if (!empty($groups) && !$this->propertyBelongsToGroups($dtoProperty, $groups)) {
                continue;
            }

            $propertyName = $dtoProperty->getName();
            $propertyValue = $dtoProperty->getValue($this);
            $setterMethod = 'set' . ucfirst($propertyName);

            if (method_exists($entity, $setterMethod)) {
                $entity->$setterMethod($propertyValue);
            }
        }

        return $entity;
    }

    protected function propertyBelongsToGroups(\ReflectionProperty $property, array $groups): bool
    {
        $attributes = $property->getAttributes(Groups::class);
        foreach ($attributes as $attribute) {
            $attributeInstance = $attribute->newInstance();
            $propertyGroups = $attributeInstance->getGroups() ?? [];

            // Check if the property has at least one of the specified groups
            if (array_intersect($propertyGroups, $groups)) {
                return true;
            }
        }

        return false;
    }

}