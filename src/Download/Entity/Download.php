<?php

namespace App\Download\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="download")
 * @ORM\Entity(repositoryClass="App\Download\Repository\DownloadRepository")
 */
class Download
{
    /**
     * @var int|null $id
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer" , nullable=false)
     */
    private $id;

    /**
     * @var string|null $title
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=10)
     *
     * @ORM\Column(name="title", type="string", length=10, nullable=false)
     */
    private $title;

    /**
     * @var string|null $uri
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(name="uri", type="string", length=255, nullable=false)
     */
    private $uri;

    /**
     * @var string|null $image
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @var int|null $position
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    private $position;

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     *
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     *
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return self
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
