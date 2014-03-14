<?php

namespace Scraper;

/**
 * Class Scraper
 *
 * @package Scraper
 */
abstract class Scraper
{
    /**
     * @var mixed
     */
    protected $crawler;

    /**
     * @var array basic request params for scraping
     */
    protected $requestParams = array(
        'c' => 'us',
        'l' => 'en',
        's' => 'dhs',
        'cs' => 19,
    );

    /**
     * @var array regular expressions to remove from model name
     */
    protected $modelExcludeRegex = array(
        '/ with /',
        '/[1-9]+\-[1-9]+mm [a-zA-Z]* Lens/',
        '/Camera/',
        '/[1-9]+\.[1-9]+ MP/',
        '/Digital [-]*/',
        '/ SLR /',
    );

    /**
     * @var array array of xpaths to find the data
     */
    protected $keys = array(
        'Product Name'  => '//span[@itemprop=\'name\']',
        'Manufacturer'  => '//meta[@itemprop=\'manufacturer\']',
        'Price'         => '//meta[@itemprop=\'price\']',
        'priceCurrency' => '//meta[@itemprop=\'priceCurrency\']',
    );

    /**
     * @var RequestUrl
     */
    protected $request;

    /**
     * @param $domain
     * @param $path
     * @param array $params
     */
    public function __construct($domain, $path, array $params = array())
    {
        $this->request = new RequestUrl($domain, $path, array_merge($this->requestParams, $params));
    }


    /**
     * calculate model
     *
     * uses the available information to calculate the model name
     *
     * @param array $data
     * @return mixed
     */
    public function calculateModel(array $data = array())
    {
        if (!isset($data['Manufacturer']) || !isset($data['Product Name'])) {
            return '';
        }

        $model = str_replace($data['Manufacturer'],'', $data['Product Name']);

        foreach ($this->modelExcludeRegex as $regex) {
            $model = preg_replace($regex, '', $model);
        }

        return $model;
    }

    /**
     * setRequestUrl
     *
     * @param RequestUrl $request
     */
    public function setRequest(RequestUrl $request)
    {
        // reset the crawler to null
        $this->crawler = null;
        $this->request = $request;
    }

    /**
     * @return \Scraper\RequestUrl
     */
    public function getRequest()
    {
        return $this->request;
    }
}