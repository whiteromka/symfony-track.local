<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataTransformerInterface;


class TagTransformer implements DataTransformerInterface
{
    public function __construct(
        private readonly TagRepository $tagRepository
    )
    {
    }

    /**
     * @param PersistentCollection<Tag> $value
     */
    public function transform(mixed $value): string
    {
        $tagsArray = $value->toArray();
        $tagNames = array_map(fn(Tag $tag) => $tag->getName(), $tagsArray);
        return implode(', ', $tagNames);
    }

    public function reverseTransform(mixed $value = null): ?ArrayCollection
    {
        if (!$value) {
            return null;
        }

        $items = explode(',', $value);
        $items = array_map('trim', $items);
        $items = array_unique($items);
        $tags = new ArrayCollection();

        $existingTags = $this->tagRepository->findBy(['name' => $items]);
        $tagsByName = [];
        foreach ($existingTags as $tag) {
            $tagsByName[$tag->getName()] = $tag;
        }

        foreach ($items as $item) {
            if (isset($tagsByName[$item])) {
                $tags->add($tagsByName[$item]);
            } else {
                $tags->add((new Tag())->setName($item));
            }
        }

        return $tags;
    }
}