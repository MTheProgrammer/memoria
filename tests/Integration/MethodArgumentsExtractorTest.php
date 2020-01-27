<?php

declare(strict_types=1);

namespace Tests\Integration;

use Example\ExampleRepositoryInterface;
use App\Generator\MethodArgumentsExtractor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MethodArgumentsExtractorTest extends KernelTestCase
{
    public function testExtract()
    {
        self::bootKernel();
        $container = self::$container;
        $extractor = $container->get(MethodArgumentsExtractor::class);

        $expected = 'int $id, ?string $additionalParam = null';
        $result = $extractor->extract(ExampleRepositoryInterface::class, 'execute');
        $this->assertEquals($expected, $result);
    }
}