<?php

namespace App\Article\Entity;

use App\Core\Util\Timestamp\Model\TimestampableTrait;
use App\User\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="App\Article\Repository\ArticleRepository")
 */
class Article
{
    use TimestampableTrait;

    public const STATUS_PUBLISHED = 1;
    public const STATUS_DRAFT = 0;

    /** @var int */
    public const PER_PAGE = 3;

    /** @var int */
    public const PER_PAGE_ADMIN = 25;

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
     */
    private $title;

    /**
     * @var string|null $title
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=65532)
     *
     * @ORM\Column(name="contents", type="text", length=65532, nullable=false)
     */
    private $contents;

    /**
     * @var UserInterface|null $author
     *
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     * @ORM\JoinColumn(name="author", nullable=false)
     */
    private $author;

    /**
     * @var int $status
     *
     * @see self::STATUS_*
     *
     * @ORM\Column(name="status",)
     */
    private $status = self::STATUS_DRAFT;

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
     * @return string|null
     */
    public function getContents(): ?string
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     *
     * @return self
     */
    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    /**
     * @param UserInterface $author
     *
     * @return self
     */
    public function setAuthor(UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
