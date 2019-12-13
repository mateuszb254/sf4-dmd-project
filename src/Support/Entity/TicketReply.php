<?php

namespace App\Support\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ticket_reply")
 * @ORM\Entity()
 */
class TicketReply
{
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
     * @var string|null $content
     *
     * @ORM\Column(name="content", type="text", length=64512)
     */
    private $content;

    /**
     * @var Ticket $ticket
     *
     * @ORM\ManyToOne(targetEntity="App\Support\Entity\Ticket", inversedBy="replies")
     * @ORM\JoinColumn(name="ticket_id", onDelete="cascade", nullable=false)
     */
    private $ticket;

    /**
     * @var User $author
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(name="author_id", nullable=false)
     */
    private $author;

    /**
     * @return Ticket
     */
    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    /**
     * @param Ticket $ticket
     *
     * @return self
     */
    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
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
}
