<?php

namespace App\Game\Model;

class GameApiResponse implements GameApiResponseInterface
{
    /**
     * @var string $status
     */
    private $status;

    /**
     * @var array|null $data
     */
    private $data;

    public function __construct(string $status, ?array $data = null)
    {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
