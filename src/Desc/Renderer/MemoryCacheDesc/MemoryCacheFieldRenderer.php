<?php

declare(strict_types=1);

namespace App\Desc\Renderer\MemoryCacheDesc;

use App\Generator\Generator;

class MemoryCacheFieldRenderer
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
     * @param array $fieldNames
     *
     * @return string
     */
    public function render(array $fieldNames): string
    {
        return array_reduce($fieldNames, function (string $result, string $fieldName) {
            return $result . $this->generator->execute('MemoryCacheField', ['fieldName' => $fieldName]) . PHP_EOL;
        }, '');
    }
}
