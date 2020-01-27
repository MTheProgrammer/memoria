<?php

declare(strict_types=1);

namespace Example;

class ExampleRepository implements ExampleRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function execute(int $id, string $additionalParam = null): RepositoryResult
    {
        return new RepositoryResult($id, $additionalParam);
    }

    /**
     * @inheritDoc
     */
    public function executeList(array $ids): array
    {
        return [];
    }
}