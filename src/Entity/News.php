<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $published_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_uuid = null;

    #[ORM\ManyToMany(targetEntity: TagNews::class, inversedBy: 'news')]
    private Collection $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(?\DateTimeImmutable $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getPhotoUuid(): ?string
    {
        return $this->photo_uuid;
    }

    public function setPhotoUuid(?string $photo_uuid): self
    {
        $this->photo_uuid = $photo_uuid;

        return $this;
    }

    /**
     * @return Collection<int, TagNews>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(TagNews $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(TagNews $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
