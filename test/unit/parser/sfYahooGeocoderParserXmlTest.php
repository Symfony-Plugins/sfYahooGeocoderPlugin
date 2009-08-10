<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once(dirname(__FILE__).'/../../../lib/exception/sfYahooGeocoderException.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponse.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseXml.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseCollection.class.php');
require_once(dirname(__FILE__).'/../../../lib/parser/sfYahooGeocoderParser.class.php');
require_once(dirname(__FILE__).'/../../../lib/parser/sfYahooGeocoderParserXml.class.php');

$t = new lime_test(6, new lime_output_color());

$singleResult = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseXml.xml');
$collectionResult = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseCollectionXml.xml');

$t->diag('->parse() a single result');

$parser = new sfYahooGeocoderParserXml();

try
{
  $collection = $parser->parse($singleResult);
  $t->pass('->parse() did not throw any exception');
}
catch (Exception $e)
{
  $t->fail('->parse() should not throw an exception for valid fixtures');
}

$t->isa_ok($collection, 'sfYahooGeocoderResponseCollection', '->parse() returns a "sfYahooGeocoderResponseCollection" object');
$t->is(count($collection), 1, '->parse() returns a collection with 1 element');

$t->diag('->parse() a collection of results');

$parser = new sfYahooGeocoderParserXml();

try
{
  $collection = $parser->parse($collectionResult);
  $t->pass('->parse() did not throw any exception');
}
catch (Exception $e)
{
  $t->fail('->parse() should not throw an exception for valid fixtures');
}

$t->isa_ok($collection, 'sfYahooGeocoderResponseCollection', '->parse() returns a "sfYahooGeocoderResponseCollection" object');
$t->is(count($collection), 4, '->parse() returns a collection with 4 elements');

