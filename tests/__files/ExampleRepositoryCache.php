<?php

declare(strict_types=1);

namespace Example;

class ExampleRepositoryCache implements \Example\ExampleRepositoryInterface
{
    private $executeResults = [];

    private $executeListResults = [];

    /**
     * @var \Example\ExampleRepositoryInterface
     */
    private $parent;

    public function __construct(
        \Example\ExampleRepositoryInterface $parent
    ) {
        $this->parent = $parent;
    }

    public function execute(int $id, ?string $additionalParam = null): \Example\RepositoryResult
    {
        $args = func_get_args();
        $key = implode(':', $args);
        if (isset($this->executeResults[$key])) {
            return $this->executeResults[$key];
        }

        $result = $this->execute(...$args);
        $this->executeResults[$key] = $result;

        return $result;
    }

    public function executeList(array $ids): array
    {
        $args = func_get_args();
        $key = implode(':', $args);
        if (isset($this->executeListResults[$key])) {
            return $this->executeListResults[$key];
        }

        $result = $this->executeList(...$args);
        $this->executeListResults[$key] = $result;

        return $result;
    }

}