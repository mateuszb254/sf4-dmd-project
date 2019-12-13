<?php


namespace App\Support\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait ContentTrait
{
    /**
     * @var string|null $content
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=65532)
     *
     * @ORM\Column(name="content", type="text", length=65532, nullable=false)
     */
    private $content;

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
