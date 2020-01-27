<?php

declare(strict_types=1);

namespace Tests\Integration;

use Example\ExampleRepositoryInterface;
use App\Desc\MemoryCacheDescFactory;
use App\Generator\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GeneratorTest extends KernelTestCase
{
    public function testGenerate()
    {
        $kernel = self::bootKernel();
        $container = self::$container;

        /** @var Generator $generator */
        $generator = $container->get(Generator::class);
        /** @var MemoryCacheDescFactory $factoryDesc */
        $factoryDesc = $container->get(MemoryCacheDescFactory::class);
        $desc = $factoryDesc->create(ExampleRepositoryInterface::class);

        $expected = file_get_contents(implode(DIRECTORY_SEPARATOR, [__DIR__ , '..', '__files', 'ExampleRepositoryCache.php']));

        $this->assertEquals($expected, $generator->execute('MemoryCache.php', $desc));
    }
}