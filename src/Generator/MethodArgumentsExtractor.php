<?php

declare(strict_types=1);

namespace App\Generator;

use App\Reflection\ReflectionClassContainer;

class MethodArgumentsExtractor
{
    /**
     * @var ReflectionClassContainer
     */
    private $reflectionClassContainer;

    public function __construct(
        ReflectionClassContainer $reflectionClassContainer
    ) {
        $this->reflectionClassContainer = $reflectionClassContainer;
    }

    /**
     * Extract method arguments as concatenated string.
     *
     * @param string $className
     * @param string $methodName
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function extract(string $className, string $methodName): string
    {
        $reflection = $this->reflectionClassContainer->get($className);
        $method = $this->findPublicMethod($reflection, $methodName);
        if ($method === null) {
            throw new \ReflectionException("Public method '{$method}' was not found in class '{$className}'");
        }

        $arguments = array_map(function (\ReflectionParameter $parameter) {
            $groupType = implode('', [
                $parameter->allowsNull() ? '?' : '',
                $parameter->getType(),
            ]);
            $groupName = implode(' ', [
                "\${$parameter->getName()}",
                $parameter->isDefaultValueAvailable() ? "= {$this->getDefaultValue($parameter)}" : '',
            ]);

            return implode(' ', [
                trim($groupType),
                trim($groupName),
            ]);
        }, $method->getParameters());

        return implode(', ', $arguments);
    }

    /**
     * @param \ReflectionParameter $parameter
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    private function getDefaultValue(\ReflectionParameter $parameter): string
    {
        if ($parameter->getDefaultValue() === null) {
            return 'null';
        }

        return $parameter->getDefaultValue();
    }

    /**
     * Find if given public method exists in the class.
     *
     * @param \ReflectionClass $reflection
     * @param string $methodName
     *
     * @return \ReflectionMethod|null
     */
    private function findPublicMethod(\ReflectionClass $reflection, string $methodName): ?\ReflectionMethod
    {
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($method->getName() === $methodName) {
                return $method;
            }
        }

        return null;
    }
}
