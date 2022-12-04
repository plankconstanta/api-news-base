<?php
namespace App\Service;

use App\Entity\News;

interface INewsApiFormatService
{
    public function objectToArray(News $object): array;
}