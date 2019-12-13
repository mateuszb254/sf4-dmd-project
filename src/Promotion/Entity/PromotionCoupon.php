<?php

namespace App\Promotion\Entity;

use App\User\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="promotion_coupon")
 * @ORM\Entity(repositoryClass="App\Promotion\Repository\PromotionCouponRepository")
 */
class PromotionCoupon
{
    public const PER_PAGE = 25;

    /**
     * @var int|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer" , nullable=false)
     */
    private $id;

    /**
     * @var string|null $code
     *
     * @ORM\Column(name="code", type="string", length=8, nullable=false)
     */
    private $code;

    /**
     * @var Promotion|null
     *
     * @ORM\ManyToOne(targetEntity="App\Promotion\Entity\Promotion", inversedBy="coupons")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $promotion;

    /**
     * @var \DateTime|null $generatedAt
     *
     * @ORM\Column(type="datetime", name="generated_at", nullable=false)
     */
    private $generatedAt;

    /**
     * @var UserInterface|null $GeneratedBy
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(name="generated_by", nullable=false)
     */
    private $generatedBy;

    /**
     * @var UserInterface|null $usedBy
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(name="used_by", nullable=true)
     */
    private $usedBy;

    /**
     * @var \DateTime|null $usedAt
     *
     * @ORM\Column(name="used_at", type="datetime", nullable=true)
     */
    private $usedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return self
     */
    public function setCode(?string $code): PromotionCoupon
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Promotion|null
     */
    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    /**
     * @param Promotion|null $promotion
     * @return self
     */
    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getGeneratedAt(): ?\DateTime
    {
        return $this->generatedAt;
    }

    /**
     * @param \DateTime|null $generatedAt
     *
     * @return self
     */
    public function setGeneratedAt(?\DateTime $generatedAt): self
    {
        $this->generatedAt = $generatedAt;

        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getGeneratedBy(): ?UserInterface
    {
        return $this->generatedBy;
    }

    /**
     * @param UserInterface|null $GeneratedBy
     * @return self
     */
    public function setGeneratedBy(?UserInterface $GeneratedBy): PromotionCoupon
    {
        $this->generatedBy = $GeneratedBy;

        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getUsedBy(): ?UserInterface
    {
        return $this->usedBy;
    }

    /**
     * @param UserInterface|null $usedBy
     * @return self
     */
    public function setUsedBy(?UserInterface $usedBy): PromotionCoupon
    {
        $this->usedBy = $usedBy;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUsedAt(): ?\DateTime
    {
        return $this->usedAt;
    }

    /**
     * @param \DateTime|null $usedAt
     * @return self
     */
    public function setUsedAt(?\DateTime $usedAt): PromotionCoupon
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }
}
