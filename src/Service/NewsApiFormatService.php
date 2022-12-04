<?php
namespace App\Service;

use App\Entity\News;
use App\Entity\TagNews;

class NewsApiFormatService implements INewsApiFormatService
{
    public function __construct()
    {}

    public function objectToArray(News $news): array
    {
        $data = [];
        $data['id'] = $news->getId();
        $data['text'] = $news->getText();
        $data['title'] = $news->getTitle();
        $data['published_at'] = $news->getPublishedAt()?->format('Y-m-d H:i');
        $data['photo_url'] = $this->getPhotoUrlByUuid($news->getPhotoUuid());
        $data['tags'] = [];
        foreach ($news->getTags() as $tag) {
            /** @var TagNews $tag */
            $data['tags'][] = ['id'=>$tag->getId(), 'name'=>$tag->getName()];
        }
        return $data;
    }

    protected function getPhotoUrlByUuid(string $uuid): string
    {
        return '/public/img/'.$uuid;
    }
}