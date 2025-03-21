<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Это обязательно!')]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    // Многие Blog-и имеют одну категорию. Обратная: одна категория включает много блогов
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'blogs')] // inversedBy: 'blogs' указывает на обратную связь, у меня ее нет
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category|null $category = null;

    // Многие Blog-и имеют один BlogStatus.
    #[ORM\ManyToOne(targetEntity: BlogStatus::class, inversedBy: 'blogs')]
    #[ORM\JoinColumn(name: 'blog_status_id', referencedColumnName: 'id')]
    private BlogStatus $blogStatus;

    # Многие блоги связаны с многими тегами
    #[ORM\JoinTable(name: 'tag_to_blog')]
    #[ORM\JoinColumn(name: 'blog_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Tag::class, cascade: ['persist'])]
    private ArrayCollection|PersistentCollection $tags;

    public function addTag(Tag $tag): void
    {
        $this->tags[] = $tag;
    }

    public function getTags(): ArrayCollection|PersistentCollection
    {
        return $this->tags;
    }

    public function setTags(ArrayCollection|PersistentCollection $tags): static
    {
        $this->tags = $tags;

        return $this;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getBlogStatus(): ?BlogStatus
    {
        return $this->blogStatus;
    }

    public function setBlogStatus(?BlogStatus $blogStatus): static
    {
        $this->blogStatus = $blogStatus;
        return $this;
    }
}
