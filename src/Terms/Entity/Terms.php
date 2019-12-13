<?php

namespace App\Terms\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="terms", indexes={
 *      @ORM\Index(name="idx_created_at", columns={"created_at"})
 * })
 * @ORM\Entity(repositoryClass="App\Terms\Repository\TermsRepository")
 */
class Terms
{
    use TimestampableTrait;
    /**
     * @var int $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string|null $content
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return self
     */
    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
