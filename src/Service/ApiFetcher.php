<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ApiFetcher
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function fetchUrls(string $apiUrl): array
    {
        $start = microtime(true);
        $urls = [];
        try {
            $response = $this->client->request('GET', $apiUrl);
            $data = $response->getContent();
            $json = json_decode($data, true);

            if ($json === null) {
                throw new \Exception('Failed to decode JSON');
            }

            foreach ($json['articles'] as $article) {
                if (!empty($article['urlToImage'])) {
                    $urls[] = $article['url'];
                }
            }
        } catch (\Exception $e) {
        }
        $elapsed = microtime(true) - $start;
        // dump('ApiFetcher elapsed time: ' . $elapsed . ' seconds');

        return $urls;
    }
}
