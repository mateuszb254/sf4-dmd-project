<?php


namespace App\Support\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="ticket_category")
 * @ORM\Entity(repositoryClass="App\Support\Repository\TicketCategoryRepository")
 */
class TicketCategory
{
    public const UNANSWERED_TICKETS_AMOUNT_SAFE = 0;
    public const UNANSWERED_TICKETS_AMOUNT_WARNING = 10;
    public const UNANSWERED_TICKETS_AMOUNT_DANGER = 20;

    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null $name
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=25)
     *
     * @ORM\Column(name="name", type="string", length=25, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string|null $slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", length=50, type="string", unique=true)
     */
    private $slug;

    /**
     * @var string|null $priority
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority;

    /**
     * @var string|null $icon
     *
     * @ORM\Column(name="fa_icon_name", type="string", nullable=true)
     */
    private $faIconName;

    /**
     * @ORM\OneToMany(targetEntity="App\Support\Entity\Ticket", mappedBy="category")
     */
    private $tickets;

    /**
     * @return int|null
     */
    public function getId()
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
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     * @return self
     */
    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    /**
     * @param string|null $priority \
     *
     * @return $this
     */
    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFaIconName(): ?string
    {
        return $this->faIconName;
    }

    /**
     * @param string|null $faIconName
     * @return self
     */
    public function setFaIconName(?string $faIconName): self
    {
        $this->faIconName = $faIconName;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
