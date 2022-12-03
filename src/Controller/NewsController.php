<?php
namespace App\Controller;
use App\Repository\NewsRepository;
use App\Service\TagHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    const COUNT_NEWS_PER_PAGE = 5;

    private $newsRepository;
    private $tagHelper;

    public function __construct(NewsRepository $newsRepository, TagHelper $tagHelper)
    {
        $this->newsRepository = $newsRepository;
        $this->tagHelper = $tagHelper;
    }

    /**
     * @Route("/api/news", name="api_news")
     */
    public function index(Request $request)
    {
        //$news = $this->newsRepository->findAll();
        /*$page = $request->get('page');
        $tags = $request->get('tag');
        $year = $request->get('year');
        $month = $request->get('month');

        if ($year && $month) {
            $data = $year . ' ' . $month;
        }

        $offset = ($page - 1) * self::COUNT_NEWS_PER_PAGE;

        $tag_ids = [];
        foreach($tags as $tag) {
            if ($tag_id = $this->tagHelper->getTagIdByName($tag)) {
                $tag_ids[] = $tag_id;
            }
        }*/

        $data = [];

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