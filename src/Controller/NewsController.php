<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use App\Repository\TagNewsRepository;
use App\Service\INewsApiFormatService;
use App\Service\NewsApiException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    const COUNT_NEWS_PER_PAGE = 5;

    private NewsRepository $newsRepository;
    private TagNewsRepository $tagNewsRepository;
    private INewsApiFormatService $newsApiStructService;

    public function __construct(
        NewsRepository $newsRepository,
        TagNewsRepository $tagNewsRepository,
        INewsApiFormatService $newsApiFormatService)
    {
        $this->newsRepository = $newsRepository;
        $this->tagNewsRepository = $tagNewsRepository;
        $this->newsApiFormatService = $newsApiFormatService;
    }

    /**
     * @Route("/api/news", name="api_news")
     */
    public function index(Request $request)
    {
        $page  = (int)($request->get('page') ? $request->get('page') : 1);
        $page  = $page > 0 ? $page : 1;

        try {
            $tagIds = $this->getTagIdsFromRequest($request);
            $dateFrom = $this->getDateFromRequest($request);
        } catch (NewsApiException $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new JsonResponse('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        try {
            $paginator = $this->newsRepository->findPaginatedByParams(self::COUNT_NEWS_PER_PAGE, $page, $dateFrom, $tagIds);

            $items = [];
            foreach ($paginator as $news) {
                /* @var News $news */
                $items[] = $this->newsApiFormatService->objectToArray($news);
            }
        } catch (\Exception $e) {
            return new JsonResponse('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $data = [
            'items' =>  [$items],
            'page'  =>  $page,
            'limit' =>  self::COUNT_NEWS_PER_PAGE,
            'total' =>  count($paginator)
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    private function getTagIdsFromRequest(Request $request): array
    {
        $tag = $request->get('tag');
        $tagIds = [];
        if ($tag) {
            $tag = is_array($tag) ? $tag : [$tag];
            foreach ($tag as $item) {
                if ($tagId = $this->tagNewsRepository->findByName($item)?->getId()) {
                    $tagIds[] = $tagId;
                }
            }
        }
        return $tagIds;
    }

    private function getDateFromRequest(Request $request): ?\DateTimeImmutable
    {
        $year  = $request->get('year');
        $month = $request->get('month');

        $dateFrom = null;
        if ($year && $month) {
            try {
                $dateFrom = new \DateTimeImmutable($year . '-' . $month . '-' . '01');
            } catch (\Exception $e) {
                throw new NewsApiException('Illegal date');
            }

        }
        return $dateFrom;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedServices(): array
    {
        return [];
    }
}