<?php

namespace App\Entity;

use App\Repository\NewsCommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsCommentsRepository::class)]
class NewsComments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'newscomments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?News $news_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment_text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewsId(): ?News
    {
        return $this->news_id;
    }

    public function setNewsId(?News $news_id): static
    {
        $this->news_id = $news_id;

        return $this;
    }

    public function getCommentText(): ?string
    {
        return $this->comment_text;
    }

    public function setCommentText(string $comment_text): static
    {
        $this->comment_text = $comment_text;

        return $this;
    }
}
