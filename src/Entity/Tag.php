<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MicroPost", mappedBy="tags")
     */
    private $microPosts;

    public function __construct($name=null)
    {
        $this->microPosts = new ArrayCollection();
        if ($name) {
            $this->setName($name);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|MicroPost[]
     */
    public function getMicroPosts(): Collection
    {
        return $this->microPosts;
    }

    public function addMicroPost(MicroPost $microPost): self
    {
        if (!$this->microPosts->contains($microPost)) {
            $this->microPosts[] = $microPost;
            $microPost->addTag($this);
        }

        return $this;
    }

    public function removeMicroPost(MicroPost $microPost): self
    {
        if ($this->microPosts->contains($microPost)) {
            $this->microPosts->removeElement($microPost);
            $microPost->removeTag($this);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return (string) $this;
    }
}
