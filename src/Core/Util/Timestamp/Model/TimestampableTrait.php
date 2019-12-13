<?php

namespace App\Core\Util\Timestamp\Model;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    /**
     * @var \DateTime|null $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" : "CURRENT_TIMESTAMP"}, nullable=false)
     */
    public $createdAt;

    /**
     * @var \DateTime|null $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    public $updatedAt;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt ?? new \DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt ?? new \DateTime();

        return $this;
    }
}
