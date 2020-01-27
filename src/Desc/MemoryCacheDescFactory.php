<?php

declare(strict_types=1);

namespace App\Desc;

use App\Desc\Renderer\MemoryCacheDesc\MemoryCacheFieldRenderer;
use App\Desc\Renderer\MemoryCacheDesc\MemoryCacheMethodRenderer;
use App\Generator\Generator;
use App\Generator\MethodArgumentsExtractor;
use App\Reflection\ReflectionClassContainer;

/**
 * Factory for MemoryCacheDesc
 */
class MemoryCacheDescFactory
{
    /**
     * @var MethodArgumentsExtractor
     */
    private $methodArgumentsExtractor;

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var ReflectionClassContainer
     */
    private $reflectionClassContainer;
    /**
     * @var MemoryCacheFieldRenderer
     */
    private $memoryCacheFieldRenderer;
    /**
     * @var MemoryCacheMethodRenderer
     */
    private $memoryCacheMethodRenderer;

    /**
     * @param MethodArgumentsExtractor $methodArgumentsExtractor
     * @param Generator $generator
     * @param ReflectionClassContainer $reflectionClassContainer
     * @param MemoryCacheFieldRenderer $memoryCacheFieldRenderer
     * @param MemoryCacheMethodRenderer $memoryCacheMethodRenderer
     */
    public function __construct(
        MethodArgumentsExtractor $methodArgumentsExtractor,
        Generator $generator,
        ReflectionClassContainer $reflectionClassContainer,
        MemoryCacheFieldRenderer $memoryCacheFieldRenderer,
        MemoryCacheMethodRenderer $memoryCacheMethodRenderer
    ) {
        $this->methodArgumentsExtractor = $methodArgumentsExtractor;
        $this->generator = $generator;
        $this->reflectionClassContainer = $reflectionClassContainer;
        $this->memoryCacheFieldRenderer = $memoryCacheFieldRenderer;
        $this->memoryCacheMethodRenderer = $memoryCacheMethodRenderer;
    }

    /**
     * @param string $interfaceName
     * @return MemoryCacheDesc
     * @throws \ReflectionException
     */
    public function create(string $interfaceName): MemoryCacheDesc
    {
        $desc = new MemoryCacheDesc();
        $reflection = $this->reflectionClassContainer->get($interfaceName);
        $desc->namespace = $reflection->getNamespaceName();
        $desc->className = $this->getCacheClassName($reflection->getShortName());
        $desc->interface = '\\' . $interfaceName;

        $fields = [];
        $methodDescList = [];
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $fieldName = $method->getName() . 'Results';
            $methodDesc = new ClassMethodDesc();
            $methodDesc->method = $method->getName();
            $methodDesc->methodArguments = $this->methodArgumentsExtractor->extract($desc->interface, $methodDesc->method);
            $methodDesc->methodResults = $fieldName;
            $methodDesc->methodReturnType = $this->getReturnType($method);

            $fields[] = $fieldName;
            $methodDescList[] = $methodDesc;
        }

        $desc->fields = $this->memoryCacheFieldRenderer->render($fields);
        $desc->methods = $this->memoryCacheMethodRenderer->render($methodDescList);

        return $desc;
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function getReturnType(\ReflectionMethod $method): string
    {
        if (!$method->hasReturnType()) {
            return '';
        }

        if ($method->getReturnType()->isBuiltin()) {
            return (string)$method->getReturnType();
        }

        return '\\' . (string)$method->getReturnType();
    }

    /**
     * @param string $interfaceName
     * @return string
     */
    private function getCacheClassName(string $interfaceName): string
    {
        $cacheClassName = str_replace('Interface', '', $interfaceName);

        return $cacheClassName . 'Cache';
    }
}