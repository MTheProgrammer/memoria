<?php

declare(strict_types=1);

namespace Example;

interface ExampleRepositoryInterface
{
    /**
     * @param int $id
     * @param string|null $additionalParam
     * @return RepositoryResult
     */
    public function execute(int $id, ?string $additionalParam = null): RepositoryResult;

    /**
     * @param int[] $ids
     * @return RepositoryResult[]
     */
    public function executeList(array $ids): array;
}