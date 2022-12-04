<?php
namespace App\Controller;
use App\Repository\NewsRepository;
use App\Repository\TagNewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    const COUNT_NEWS_PER_PAGE = 5;

    private $newsRepository;
    private $tagNewsRepository;

    public function __construct(NewsRepository $newsRepository, TagNewsRepository $tagNewsRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->tagNewsRepository = $tagNewsRepository;
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
                return null;
            }

        }
        return $dateFrom;
    }

    /**
     * @Route("/api/news", name="api_news")
     */
    public function index(Request $request)
    {
        $page  = (int)($request->get('page') ? $request->get('page') : 1);
        $page  = $page > 0 ? $page : 1;
        $tagIds = $this->getTagIdsFromRequest($request);
        $dateFrom = $this->getDateFromRequest($request);

        $news = $this->newsRepository->findByParams(self::COUNT_NEWS_PER_PAGE, $page, $dateFrom, $tagIds);

        $data = [
            'items' =>  [$news],
            'page'  =>  $page,
            'limit' =>  self::COUNT_NEWS_PER_PAGE,
            'total' =>  count($news)
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedServices(): array
    {
        return [];
    }
}