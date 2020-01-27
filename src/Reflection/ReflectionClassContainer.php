<?php

declare(strict_types=1);

namespace App\Reflection;

use ReflectionClass;
use ReflectionException;

/**
 * Class ReflectionClassContainer serves as cache for the reflection metadata about classes
 */
class ReflectionClassContainer
{
    /**
     * @var ReflectionClass[]
     */
    private $reflectionClasses = [];

    /**
     * @param string $className
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function get(string $className): ReflectionClass
    {
        if (!isset($this->reflectionClasses[$className])) {
            $this->reflectionClasses[$className] = new ReflectionClass($className);
        }

        return $this->reflectionClasses[$className];
    }
}