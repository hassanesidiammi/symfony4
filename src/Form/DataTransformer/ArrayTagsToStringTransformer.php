<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ArrayTagsToStringTransformer implements DataTransformerInterface
{
    /**
     * @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Tag[] $tags
     */
    public function transform($tags): string
    {
        return implode(',', $tags);
    }

    /**
     * @param string $names
     *
     * @return Tag[]
     */
    public function reverseTransform($names): array
    {
        if (!$names) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', explode(',', $names))));
        $tags = $this->repository->findBy(['name' => $names]);

        $newNames = array_diff($names, $tags);
        foreach ($newNames as $name) {
            $tags[] = new Tag($name);
        }

        return $tags;
    }
}
