<?php
namespace App\Service;

use App\Repository\TagNewsRepository;

class TagHelper
{
    private TagNewsRepository $tagNewsRepository;

    public function __construct(TagNewsRepository $tagNewsRepository)
    {
        $this->tagNewsRepository = $tagNewsRepository;
    }

    public function getTagIdByName(string $name): int
    {
        $data = $this->tagNewsRepository->findAll(
            ['hash'=>crc32($name)]
        );

        foreach($data as $tag) {
            if ($tag->getName() === $name) {
                return $tag->getId();
            }
        }

        return null;
    }
}