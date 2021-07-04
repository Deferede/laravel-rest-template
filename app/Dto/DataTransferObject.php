<?php

namespace App\Dto;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            if (array_key_exists($property, $parameters)) {
                $this->{$property} = $parameters[$property];
            }
        }
    }

    public function toArray(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            if (isset($this->{$property})) {
               $data[$property] =  $this->{$property};
            }
        }

        return $data;
    }

    public function toBase(): Collection
    {
        return collect($this->toArray());
    }
}