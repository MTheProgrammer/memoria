<?php

declare(strict_types=1);

namespace App\Command;

use App\Desc\MemoryCacheDescFactory;
use App\Generator\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCacheWrapper extends Command
{
    protected static $defaultName = 'app:create-cache-wrapper';
    /**
     * @var Generator
     */
    private $generator;
    /**
     * @var MemoryCacheDescFactory
     */
    private $memoryCacheDescFactory;

    /**
     * @param Generator $generator
     * @param MemoryCacheDescFactory $memoryCacheDescFactory
     * @param string|null $name
     */
    public function __construct(
        Generator $generator,
        MemoryCacheDescFactory $memoryCacheDescFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->generator = $generator;
        $this->memoryCacheDescFactory = $memoryCacheDescFactory;
    }

    protected function configure()
    {
        $this->setDescription('Creates a cache wrapper class.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->generator->execute();

        return 0;
    }
}