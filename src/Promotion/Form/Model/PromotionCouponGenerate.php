<?php

namespace App\Promotion\Form\Model;

use App\Promotion\Entity\Promotion;
use Symfony\Component\Validator\Constraints as Assert;

class PromotionCouponGenerate
{
    /**
     * @var integer|null
     *
     * @Assert\NotBlank()
     * @Assert\Positive()
     * @Assert\LessThanOrEqual(50)
     */
    protected $amount;

    /**
     * @var Promotion|null
     */
    protected $promotion;

    /**
     * @var Promotion|null
     *
     * @Assert\Valid(groups={"Promotion"})
     */
    protected $newPromotion;

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return PromotionCouponGenerate
     */
    public function setAmount(?int $amount): PromotionCouponGenerate
    {
        $this->amount = $amount;

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
     * @return Promotion|null
     */
    public function getNewPromotion(): ?Promotion
    {
        return $this->newPromotion;
    }

    /**
     * @param Promotion|null $newPromotion
     * @return self
     */
    public function setNewPromotion(?Promotion $newPromotion): self
    {
        $this->newPromotion = $newPromotion;

        return $this;
    }
}
