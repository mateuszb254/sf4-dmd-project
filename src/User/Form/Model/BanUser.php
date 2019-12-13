<?php


namespace App\User\Form\Model;


class BanUser
{
    /** @var int  */
    public const TEMPORARY_BAN_TYPE = 0;

    /** @var int  */
    public const PERM_BAN_TYPE = 1;

    /** @var string|null */
    protected $type;

    /** @var string|null */
    protected $reason;

    /** @var \DateTime|null */
    protected $banTime;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return self
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     * @return self
     */
    public function setReason(?string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBanTime(): ?\DateTime
    {
        return $this->banTime;
    }

    /**
     * @param \DateTime|null $banTime
     * @return self
     */
    public function setBanTime(?\DateTime $banTime): self
    {
        $this->banTime = $banTime;

        return $this;
    }
}
