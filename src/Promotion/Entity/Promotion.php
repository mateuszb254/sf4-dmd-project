<?php

namespace App\Promotion\Entity;

use App\User\Model\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Promotion\Repository\PromotionRepository")
 * @UniqueEntity(fields={"name"})
 */
class Promotion
{
    /**
     * This type of promotion has no limit how many coupons can be used by an user
     *
     * @var string
     */
    public const NORMAL_TYPE = 'PROMOTION_NORMAL_TYPE';

    /**
     * This type of promotion has limit one code per user per one promotion
     *
     * @var string
     */
    public const ONE_PER_USER_TYPE = 'PROMOTION_ONE_PER_USER_TYPE';

    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=15)
     *
     * @ORM\Column(name="name", length=15, type="string", nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expires", type="datetime", nullable=true)
     */
    protected $expires;

    /**
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     *
     * @ORM\Column(name="coins", type="integer", nullable=false)
     */
    protected $coins;

    /**
     * @ORM\OneToMany(targetEntity="App\Promotion\Entity\PromotionCoupon", mappedBy="promotion", cascade={"persist"}, orphanRemoval=true)
     */
    protected $coupons;

    public function __construct()
    {
        $this->coupons = new ArrayCollection();
    }

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExpires(): ?\DateTime
    {
        return $this->expires;
    }

    /**
     * @param \DateTime|null $expires
     * @return self
     */
    public function setExpires(?\DateTime $expires): self
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * @param int $coins
     * @return self
     */
    public function setCoins(int $coins): self
    {
        $this->coins = $coins;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCoupons(): Collection
    {
        return $this->coupons;
    }

    /**
     * @param PromotionCoupon $promotionCoupon
     * @return Promotion
     */
    public function addCoupon(PromotionCoupon $promotionCoupon, UserInterface $user): self
    {
        if (!$this->coupons->contains($promotionCoupon)) {
            $promotionCoupon->setPromotion($this);
            $promotionCoupon->setGeneratedBy($user);

            $this->coupons->add($promotionCoupon);
        }

        return $this;
    }

    /**
     * @param array $coupons
     * @return $this
     */
    public function addCoupons(array $coupons, UserInterface $user)
    {
        foreach ($coupons as $coupon) {
            $this->addCoupon($coupon, $user);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
