<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ImageExtractor
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function extractImages(array $urls): array
    {
        $start = microtime(true);
        $responses = [];
        $promises = [];

        foreach ($urls as $url) {
            $promises[$url] = $this->client->request('GET', $url);
        }

        foreach ($promises as $url => $promise) {
            try {
                $responses[$url] = $promise->getContent();
            } catch (\Exception $e) {
            }
        }

        $images = [];
        foreach ($responses as $url => $content) {
            try {
                $images[] = $this->extractImageFromContent($content, $url); 
            } catch (\Exception $e) {
            }
        }

        $elapsed = microtime(true) - $start;
        // dump('ImageExtractor elapsed time: ' . $elapsed . ' seconds');

        return $images; 
    }

    private function extractImageFromContent(string $content, string $url): string
    {
        libxml_use_internal_errors(true);
        $doc = new \DomDocument();
        @$doc->loadHTML($content);
        libxml_clear_errors();
        $xpath = new \DomXpath($doc);

        if (strstr($url, "commitstrip.com")) {
            $query = '//img[contains(@class,"size-full")]/@src';
        } else {
            $query = '//img/@src';
        }

        $xq = $xpath->query($query);
        if ($xq->length > 0) {
            return $xq[0]->value;
        }

        throw new \Exception('No image found');
    }
}
