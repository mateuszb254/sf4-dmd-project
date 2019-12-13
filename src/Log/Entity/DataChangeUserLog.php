<?php

namespace App\Log\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
class DataChangeUserLog extends UserLog
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="old_data", type="string", nullable=false)
     */
    protected $oldData;

    /**
     * @var string|null
     *
     * @ORM\Column(name="new_data", type="string", nullable=false)
     */
    protected $newData;

    /**
     * @return string|null
     */
    public function getOldData(): ?string
    {
        return $this->oldData;
    }

    /**
     * @param string $oldData
     * @return self
     */
    public function setOldData(string $oldData): self
    {
        $this->oldData = $oldData;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewData(): ?string
    {
        return $this->newData;
    }

    /**
     * @param string $newData
     * @return self
     */
    public function setNewData(string $newData): self
    {
        $this->newData = $newData;

        return $this;
    }
}
