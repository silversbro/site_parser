<?php

namespace Silversbro\SiteParser\Services;

class ParseSiteService
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct(
        \GuzzleHttp\Client $client
    ) {
        $this->client = $client;
    }

    public function getHtmlAttribute(string $url, string $tag,)
    {
        $html = $this->sendRequest($url);

        return $this->parseHtmlTags($html, $tag);
    }

    public function sendRequest(string $url)
    {
        $response = $this->client->request(config('site_parser.request_method'), $url);

        return $response->getBody()->getContents();
    }

    public function parseHtmlTags(string $html, string $tag)
    {
        $dom = new \DOMDocument;

        $dom->loadHTML(strval($html));
        $parseArray = [];

        $i = 0;
        foreach($dom->getElementsByTagName($tag) as $tag) {
            foreach ($tag->attributes as $attr) {
                $parseArray[$i][][$attr->nodeName] = $attr->nodeValue;
            }

            $parseArray[$i][]['text'] = $tag->textContent;

            $i++;
        }

        return $parseArray;
    }

}