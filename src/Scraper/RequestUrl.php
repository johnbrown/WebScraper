<?php
namespace Scraper;

/**
 * Class RequestUrl
 *
 * @package Scraper
 */
class RequestUrl
{
    /**
     * @var string type of request ie http/https
     */
    protected $requestType = 'http';

    /**
     * @var string url for use in the request
     */
    protected $baseUrl;

    /**
     * @var array request parameters
     */
    protected $params;

    /**
     * @param string $domain
     * @param string $path
     * @param array  $params
     * @param string $requestType
     */
    public function __construct($domain, $path, array $params = array(), $requestType = 'http')
    {
        $this->baseUrl     = $domain . $path;
        $this->params      = $params;
        $this->requestType = $requestType;
    }

    /**
     * getUrl
     *
     * gets the complete url
     *
     * @param array $params
     * @return string
     */
    public function getUrl(array $params = array())
    {
        $params = array_merge($this->params, $params);
        return sprintf("%s://%s?%s", $this->requestType, $this->baseUrl, $this->buildQuery($params));
    }

    /**
     * buildQuery
     *
     * converts the array params to query params
     *
     * @param array $params
     * @return string
     */
    protected function buildQuery(array $params = array())
    {
        return http_build_query($params);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * @param $requestType
     */
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }
}