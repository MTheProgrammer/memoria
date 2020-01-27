<?php

declare(strict_types=1);

namespace Example;

class RepositoryResult
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $additionalParam;

    /**
     * @param int $id
     * @param string $additionalParam
     */
    public function __construct(int $id, string $additionalParam)
    {
        $this->id = $id;
        $this->additionalParam = $additionalParam;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAdditionalParam(): string
    {
        return $this->additionalParam;
    }
}