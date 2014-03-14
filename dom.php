<?php
require_once("vendor/autoload.php");

$title = 'DOMDocument Based Solution';
$description = <<<'DESCRIPTION'
<h1>DOMDocument Based Solution</h1>
<p>In this example, I am using a DomDocument to scrape the page.</p>

<p><a href="index.php">Example with external libraries</a></p>
DESCRIPTION;
$products = array( 'A7170751', 'A4786838' );
$results = array();

foreach ($products as $itemId) {
    $scraper = new \Scraper\Dom\DomScraper('accessories.us.dell.com', '/sna/productdetail.aspx', array( 'sku' => $itemId ));
    $results[ $itemId ] = $scraper->scrape();
}

include_once('output.phtml');
