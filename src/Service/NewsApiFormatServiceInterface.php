<?php
namespace App\Service;

use App\Entity\News;

interface NewsApiFormatServiceInterface
{
    public function objectToArray(News $object): array;
}