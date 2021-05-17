<?php

namespace Modules\Core\DTO\Base;

use Carbon\Carbon;
use Modules\Core\Exception\InvalidArgumentException;
use Modules\Core\Exception\NotImplementedException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use ReflectionProperty;

class BaseDTO implements BaseDTOInterface
{
    protected string $selfType;

    protected bool $allParametersAreRequired = false;

    protected function getRelationsArrayMap(): array
    {
        return [];
    }

    public function __construct(array $parameters = [], $type = self::class)
    {
        $this->selfType = $type;
        $this->convertToDTO($parameters);
    }

    public function toModel()
    {
        $attributes = get_object_vars($this);
        $result = new ReflectionClass(static::class);
        $reflectionProperties = $result->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach ($reflectionProperties as $reflectionProperty) {
            unset($attributes[$reflectionProperty->getName()]);
        }
        return $attributes;
    }

    public function toDTO(array $parameters = [], bool $allParametersAreRequired = false): self
    {
        $this->allParametersAreRequired = $allParametersAreRequired;
        $this->convertToDTO($parameters);
        return $this;
    }

    public function toList(Collection $collection, $type)
    {
        $list = [];
        foreach ($collection as $item) {
            $originalData = $item->toArray();
            $list[] = $this->mapToDTO(new $type($originalData), $originalData);
        }
        return $list;
    }

    public function mapToDTO($dto, array $originalData): self
    {
        return $dto;
    }

    private function convertToDTO(array $arguments = [])
    {
        if (count($arguments) > 0) {
            $currentClass = $this;
            $this->getPropertiesBy(static::class, function ($name, $type, $nullable) use ($currentClass, $arguments) {
                try {
                    if ($type == Carbon::class) {
                        $this->convertValueToDatetime($name, $nullable, $arguments, $currentClass);
                    } else {
                        $fieldValue = null;
                        $relationArraysMap = $this->getRelationsArrayMap();

                        if (isset($relationArraysMap[$name]) && isset($arguments[$name])) {
                            $fieldValue = $this->getCustomRelationValue($relationArraysMap, $type, $name, $arguments);
                        } else if ($this->checkTypeIsADTO($type) && $arguments[$name] !== null) {
                            $fieldValue = new $type($arguments[$name]);
                        } else {
                            $fieldValue = $arguments[$name];
                        }

                        $currentClass->{$name} = $fieldValue;
                    }
                } catch (\Exception $exception) {
                    if ($currentClass->allParametersAreRequired && $name !== 'id') {
                        throw new InvalidArgumentException("You should specify {$name} field.");
                    }
                }
            });
        }
    }

    private function getCustomRelationValue(array $relationArraysMap, string $type, string $name, array $arguments)
    {
        $temp = null;

        // map relation collections
        if($type === 'array') {
            $temp = [];
            foreach ($arguments[$name] as $dtoData) {
                $temp[] = new $relationArraysMap[$name]($dtoData);
            }
        }

        // map relation object
        if($this->checkTypeIsADTO($type) ) {
            $temp = new $relationArraysMap[$name]($arguments[$name]);
        }

        return $temp;
    }

    private function checkTypeIsADTO(string $type): bool
    {
        return ((is_subclass_of($type, 'Modules\Core\DTO\Base\BaseDTO')) || $type === BaseDTO::class);
    }

    private function getPropertiesBy(string $class, $callback, $filter = ReflectionProperty::IS_PUBLIC)
    {
        $result = new ReflectionClass($class);
        $reflectionProperties = $result->getProperties($filter);
        foreach ($reflectionProperties as $reflectionProperty) {
            $propertyName = $reflectionProperty->getName();
            $type = $reflectionProperty->getType();
            $typeName = $type->getName();
            $nullable = $type->allowsNull();
            $callback($propertyName, $typeName, $nullable);
        }
    }

    /**
     * @param $name
     * @param $nullable
     * @param array $arguments
     * @param BaseDTO $currentClass
     */
    function convertValueToDatetime($name, $nullable, array $arguments, BaseDTO $currentClass): void
    {
        $value = $arguments[$name];
        if ($nullable && empty($value)) {
            $currentClass->{$name} = null;
        } else {
            $currentClass->{$name} = Carbon::parse($arguments[$name]);
        }
    }

    public function validator(array $parameters, array $rules)
    {
        $validator = Validator::make($parameters, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        } else {
            return [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $parameters, bool $updateMode)
    {
        throw new NotImplementedException("You should implement validate method in your DTO class.");
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequestParameters(array $requestParameters, array $routeParameters, int $auth_user_id): self
    {
        throw new NotImplementedException("You should implement handleRequestParameters method in your DTO class.");
    }
}
