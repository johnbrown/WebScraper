<?php
namespace Scraper;

/**
 * Class ScraperInterface
 *
 * @package Scraper
 */
interface ScraperInterface
{

    /**
     * scrape
     *
     * Scrapse the webpage
     *
     * @return mixed
     */
    public function scrape();


    /**
     * calculate model
     *
     * uses the available information to calculate the model name
     *
     * @param array $data
     * @return mixed
     */
    public function calculateModel(array $data = array());


    /**
     * returns a crawler object for use in parsing the page
     *
     * @return mixed
     */
    public function getCrawler();
}