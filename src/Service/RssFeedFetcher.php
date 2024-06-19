<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\TransportException;

class RssFeedFetcher
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function fetchUrls(string $feedUrl): array
    {
        $start = microtime(true);
        $urls = [];
        try {
            $response = $this->client->request('GET', $feedUrl);
            $data = $response->getContent();
            $xml = new \SimpleXMLElement($data, LIBXML_NOCDATA);

            foreach ($xml->channel->item as $item) {
                $content = (string) $item->children('content', true);
                if (preg_match('/\.(jpg|jpeg|png|gif)/i', $content)) {
                    $urls[] = (string) $item->link;
                }
            }
        } catch (TransportException $e) {
        } catch (\Exception $e) {
        }
        $elapsed = microtime(true) - $start;
        dump('RssFeedFetcher elapsed time: ' . $elapsed . ' seconds');
        

        return $urls;
    }
}
