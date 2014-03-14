<?php
namespace Scraper\Dom;

use DOMXPath;
use DOMDocument;
use Scraper\Scraper;
use Scraper\ScraperInterface;

/**
 * Class DomScraper
 *
 * @package Scraper\Dom
 */
class DomScraper extends Scraper implements ScraperInterface
{
    /**
     * @var DOMXPath
     */
    protected $crawler;

    /**
     * scrape
     *
     * scrapes the page for the required data
     *
     * @return mixed|void
     */
    public function scrape()
    {
        $data = array();
        $crawler = $this->getCrawler();
        foreach($this->keys as $name=>$path) {
            $result = $crawler->query($path);
            if ($result->length > 0 ) {
                $data[$name] = $this->parsePath($result);
            }
        }

        $data['Model'] = $this->calculateModel($data);
        return $data;
    }

    /**
     * parsePath
     *
     * uses Dom to parse the path
     *
     * @param $data
     * @return mixed
     */
    protected function parsePath($data)
    {
        $result = null;
        $current      = $data->item(0);
        $hasAttribute = false;
        if ($current->attributes->length > 0) {
            $attributes = $current->attributes;
            if ($attributes->length > 0) {
                $hasAttribute = true;
                $attributes = $attributes->getNamedItem('content');
            }
        }

        if ($hasAttribute && $attributes != null) {
            $result = $attributes->textContent;
        } else {
            $result = $current->textContent;
        }
        return $result;
    }

    /**
     * getCrawler
     *
     * gets a Dom XPath object
     *
     * @return DOMXPath
     */
    public function getCrawler()
    {
        if ($this->crawler == null) {
            $url = $this->request->getUrl();
            $html = file_get_contents($url);

            $domDocument = new DOMDocument();

            libxml_use_internal_errors(true);
            $domDocument->loadHTML($html);

            $this->crawler = new DOMXPath($domDocument);
        }

        return $this->crawler;
    }
}