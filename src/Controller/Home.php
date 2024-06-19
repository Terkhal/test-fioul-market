<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\RssFeedFetcher;
use App\Service\ApiFetcher;
use App\Service\ImageExtractor;

class Home extends AbstractController
{
    private $rssFeedFetcher;
    private $apiFetcher;
    private $imageExtractor;

    public function __construct(RssFeedFetcher $rssFeedFetcher, ApiFetcher $apiFetcher, ImageExtractor $imageExtractor)
    {
        $this->rssFeedFetcher = $rssFeedFetcher;
        $this->apiFetcher = $apiFetcher;
        $this->imageExtractor = $imageExtractor;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $rssUrls = $this->rssFeedFetcher->fetchUrls('http://www.commitstrip.com/en/feed/');
        $apiUrls = $this->apiFetcher->fetchUrls('https://newsapi.org/v2/top-headlines?country=us&apiKey=c782db1cd730403f88a544b75dc2d7a0');
        $allUrls = array_unique(array_merge($rssUrls, $apiUrls));

        $initialUrls = array_slice($allUrls, 0, 10);
        $images = $this->imageExtractor->extractImages($initialUrls);

        return $this->render('default/index.html.twig', [
            'images' => $images,
            'remainingUrls' => array_slice($allUrls, 10) 
        ]);
    }

    /**
     * @Route("/load-more-images", name="load_more_images")
     * @param Request $request
     * @return Response
     */
    public function loadMoreImages(Request $request)
    {
        $urls = $request->query->get('urls', []);
        $images = $this->imageExtractor->extractImages($urls);

        return $this->json(['images' => array_values($images)]);
    }

}
