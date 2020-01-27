<?php

declare(strict_types=1);

namespace App\Desc\Renderer\MemoryCacheDesc;

use App\Desc\ClassMethodDesc;
use App\Generator\Generator;

class MemoryCacheMethodRenderer
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @param Generator $generator
     */
    public function __construct(
        Generator $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * @param ClassMethodDesc[] $methodDescList
     *
     * @return string
     */
    public function render(array $methodDescList): string
    {
        $methods = '';
        foreach ($methodDescList as $methodDesc) {
            $methods .= PHP_EOL;
            $methods .= $this->generator->execute('MemoryCacheMethod', $methodDesc);
        }

        return $methods;
    }
}
