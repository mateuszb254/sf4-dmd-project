<?php

namespace App\Support\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="App\Support\Repository\TicketRepository")
 */
class Ticket
{
    /** @var int */
    public const STATUS_PENDING = 'PENDING';
    /** @var int */
    public const STATUS_ANSWERED = 'ANSWERED';
    /** @var int */
    public const STATUS_CLOSED = 'CLOSED';
    /** @var int  */
    public const PER_PAGE = 25;

    use ContentTrait;
    use TimestampableTrait;

    /**
     * @var integer|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null $title
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=50)
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     *
     */
    private $title;

    /**
     * @var TicketCategory|null $category
     *
     * @ORM\ManyToOne(targetEntity="App\Support\Entity\TicketCategory", inversedBy="tickets")
     * @ORM\JoinColumn(name="category_id", nullable=false, onDelete="CASCADE")
     */
    private $category;

    /**
     * @var Collection|TicketReply[] $replies
     *
     * @ORM\OneToMany(targetEntity="App\Support\Entity\TicketReply", mappedBy="ticket", cascade={"persist"})
     */
    private $replies;

    /**
     * @var User|null $author
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(name="author_id", nullable=false)
     */
    private $author;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", nullable=false, options={
     *     "default" : App\Support\Entity\Ticket::STATUS_PENDING
     *     }
     * )
     */
    private $status = self::STATUS_PENDING;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

    /**
     * @return integer|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return TicketCategory|null
     */
    public function getCategory(): ?TicketCategory
    {
        return $this->category;
    }

    /**
     * @param TicketCategory $category
     *
     * @return self
     */
    public function setCategory(TicketCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|TicketReply[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return self
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Ticket
     */
    public function setStatus(string $status): Ticket
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isAnswered(): bool
    {
        return $this->status === self::STATUS_ANSWERED;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }

    /**
     * @param TicketReply $ticketReply
     * @param string $status
     * @return Ticket
     */
    public function addReply(TicketReply $ticketReply, string $status = self::STATUS_PENDING): self
    {
        if (!$this->replies->contains($ticketReply)) {
            $ticketReply->setTicket($this);

            $this->replies->add($ticketReply);

            $this->setStatus($status);
        }

        return $this;
    }
}
