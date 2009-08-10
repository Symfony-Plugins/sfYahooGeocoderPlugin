<?php

require dirname(__FILE__).'/../../bootstrap/unit.php';
require_once(dirname(__FILE__).'/../../../lib/exception/sfYahooGeocoderException.class.php');
require dirname(__FILE__).'/../../../lib/geocoder/sfYahooGeocoder.class.php';
require dirname(__FILE__).'/../../../lib/adapter/sfYahooAdapterHttp.class.php';
require dirname(__FILE__).'/../../../lib/adapter/sfYahooAdapterHttpMock.class.php';
require dirname(__FILE__).'/../../../lib/parser/sfYahooGeocoderParser.class.php';
require dirname(__FILE__).'/../../../lib/parser/sfYahooGeocoderParserPhp.class.php';
require dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponse.class.php';
require dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponsePhp.class.php';
require dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseCollection.class.php';

$t = new lime_test(26, new lime_output_color());

$t->diag('->getApiKey');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->is($yahooGeocoder->getApiKey(), 'API_KEY', '->getApiKey() returns the API Key');

$t->diag('->getStreet()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setStreet('92 Boulevard Victor Hugo'), 'sfYahooGeocoder', '->setStreet() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getStreet(), '92 Boulevard Victor Hugo', '->getStreet() returns the street');

$t->diag('->getLocation()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setLocation('Paris, France'), 'sfYahooGeocoder', '->setLocation() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getLocation(), 'Paris, France', '->getLocation() returns the location');

$t->diag('->getCity()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setCity('Paris'), 'sfYahooGeocoder', '->setCity() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getCity(), 'Paris', '->getCity() returns the city');

$t->diag('->getState()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setState('France'), 'sfYahooGeocoder', '->setState() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getState(), 'France', '->getState() returns the state');

$t->diag('->getZipCode()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setZipCode('75015'), 'sfYahooGeocoder', '->setZipCode() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getZipCode(), '75015', '->getZipCode() returns the zip code');

$t->diag('->setZipCode()');
$yahooGeocoder = new sfYahooGeocoder('API_KEY');

try
{
  $yahooGeocoder->setZipCode('123456');
  $t->fail('->setZipCode() must throw an exception');
}
catch (Exception $e)
{
  $t->pass('->setZipCode() threw an exception for invalid zip code format');
}

try
{
  $yahooGeocoder->setZipCode('1234');
  $t->fail('->setZipCode() must throw an exception');
}
catch (Exception $e)
{
  $t->pass('->setZipCode() threw an exception for invalid zip code format');
}

try
{
  $yahooGeocoder->setZipCode('12345-12345');
  $t->fail('->setZipCode() must throw an exception');
}
catch (Exception $e)
{
  $t->pass('->setZipCode() threw an exception for invalid zip code format');
}

try
{
  $yahooGeocoder->setZipCode('12345');
  $t->pass('->setZipCode() passes with zip code "12345"');
}
catch (Exception $e)
{
  $t->fail('->setZipCode() should pass with zip code "12345"');
}

try
{
  $yahooGeocoder->setZipCode('12345-1234');
  $t->pass('->setZipCode() passes with zip code "12345-1234"');
}
catch (Exception $e)
{
  $t->fail('->setZipCode() should pass with zip code "12345-1234"');
}

$t->diag('->setOutput()');
$yahooGeocoder = new sfYahooGeocoder('API_KEY');

try
{
  $yahooGeocoder->setOutput('php');
  $t->pass('->setOutput() passes with output "php"');
}
catch (Exception $e)
{
  $t->fail('->setOutput() should pass with output "php"');
}

try
{
  $yahooGeocoder->setOutput('PHP');
  $t->pass('->setOutput() passes with output "PHP"');
}
catch (Exception $e)
{
  $t->fail('->setOutput() should pass with output "PHP"');
}

try
{
  $yahooGeocoder->setOutput('xml');
  $t->pass('->setOutput() passes with output "xml"');
}
catch (Exception $e)
{
  $t->fail('->setOutput() should pass with output "xml"');
}

try
{
  $yahooGeocoder->setOutput('json');
  $t->fail('->setOutput() must throw an exception with output "json"');
}
catch (Exception $e)
{
  $t->pass('->setOutput() threw an exception for invalid output "json"');
}

$t->diag('->getOutput()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$t->isa_ok($yahooGeocoder->setOutput('xml'), 'sfYahooGeocoder', '->setOutput() returns the sfYahooGeocoder instance');
$t->is($yahooGeocoder->getOutput(), 'xml', '->getOutput() returns the output');

$t->diag('->geocode()');

$yahooGeocoder = new sfYahooGeocoder('API_KEY');
$yahooGeocoder->setHttpAdapter(new sfYahooAdapterHttpMock());

$t->isa_ok($yahooGeocoder->geocode(), 'sfYahooGeocoderResponseCollection', '->geocode() returns the sfYahooGeocoderResponseCollection instance');
$t->is(count($yahooGeocoder->geocode()), 4, '->geocode() returns a collection with 4 elements');

$t->diag('->getRawResponse()');
$t->isa_ok($yahooGeocoder->getRawResponse(), 'string', '->getRawResponse() returns a string value');
$t->is($yahooGeocoder->getRawResponse(), file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseCollectionPhp.txt'), '->getRawResponse() returns the raw response content');