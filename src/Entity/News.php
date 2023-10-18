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

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToMany(mappedBy: 'news_id', targetEntity: NewsComments::class)]
    private Collection $newsComments;

    public function __construct()
    {
        $this->newsComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Newscomments>
     */
    public function getNewsComments(): Collection
    {
        return $this->newsComments;
    }

    public function addNewsComment(NewsComments $newsComments): static
    {
        if (!$this->newsComments->contains($newsComments)) {
            $this->newsComments->add($newsComments);
            $newsComments->setNewsId($this);
        }

        return $this;
    }

    public function removeNewsComment(NewsComments $newsComments): static
    {
        if ($this->newsComments->removeElement($newsComments)) {
            // set the owning side to null (unless already changed)
            if ($newsComments->getNewsId() === $this) {
                $newsComments->setNewsId(null);
            }
        }

        return $this;
    }
}
