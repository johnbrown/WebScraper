<?php
namespace Scraper\Goutte;

use Goutte\Client;
use Scraper\Scraper;
use Scraper\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GoutteScraper
 *
 * @package Scraper\Goutte
 */
class GoutteScraper extends Scraper implements ScraperInterface
{

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * scrape
     *
     * scrapes the page for the required data
     *
     * @return array
     */
    public function scrape()
    {
        $data = array();
        $crawler = $this->getCrawler();
        foreach($this->keys as $name=>$path) {
            $result = $crawler->filterXPath($path);
            if ($result->count() > 0 ) {
                if ($result->attr('content') != null) {
                    $data[$name] = $result->attr('content');
                } else {
                    $data[$name] = $result->text();
                }
            }
        }

        $data['Model'] = $this->calculateModel($data);
        return $data;
    }

    /**
     * getClient
     *
     * gets a Guzzle Client
     *
     * @return \Guzzle\Http\Client
     */
    public function getClient()
    {
        if ($this->client == null) {
            $this->client = new Client();
            $this->client->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:21.0) Gecko/20100101 Firefox/21.0');
        }
        return $this->client;
    }

    /**
     * getCrawler
     *
     * gets a Dom Crawler
     *
     * @return mixed
     */
    public function getCrawler()
    {
        if ($this->crawler == null) {
            $url = $this->request->getUrl();
            $this->crawler = $this->getClient()->request('GET', $url);
        }

        return $this->crawler;
    }




}