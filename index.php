<?php
require_once("vendor/autoload.php");

$title       = 'Goutte Based Solution';
$description = <<<'DESCRIPTION'
<h1>Goutte Based Solution</h1>
<p>In this example, I am using the external library <a href='https://github.com/fabpot/goutte'>Goutte</a> to do the scraping.</p>

<p><a href="dom.php">Example without external libraries</a></p>
DESCRIPTION;
$products = array( 'A7170751', 'A4786838' );
$results = array();

foreach ($products as $itemId) {
    $scraper = new \Scraper\Goutte\GoutteScraper('accessories.us.dell.com', '/sna/productdetail.aspx', array( 'sku' => $itemId ));
    $results[ $itemId ] = $scraper->scrape();
}

include_once('output.phtml');
