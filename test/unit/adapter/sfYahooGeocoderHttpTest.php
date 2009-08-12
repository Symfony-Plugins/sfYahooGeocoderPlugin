<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once(dirname(__FILE__).'/../../../lib/adapter/sfYahooAdapterHttp.class.php');
require_once(dirname(__FILE__).'/../../../lib/adapter/sfYahooAdapterHttpMock.class.php');
require_once(dirname(__FILE__).'/../../../lib/exception/sfYahooGeocoderException.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponse.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponsePhp.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseXml.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseCollection.class.php');

$t = new lime_test(24, new lime_output_color());

$xmlSingle = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseXml.xml');
$xmlRs     = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseCollectionXml.xml');
$phpSingle = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponsePhp.txt');
$phpRs     = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseCollectionPhp.txt');

$parameters = array(
  'output' => 'php', 
  'zip' => '75008',
  'city' => 'Paris',
  'state' => 'France'
);

$http = new sfYahooAdapterHttpMock();
$http->setParameters($parameters);

$t->diag('->getParameters()');
$t->isa_ok($http->getParameters(), 'array', '->getParameters() returns an array value');

$arr = $http->getParameters();

$t->is(array_key_exists('output', $arr), true, '->getParameters() has an "ouput" key');
$t->is(array_key_exists('zip', $arr), true, '->getParameters() has a "zip" key');
$t->is(array_key_exists('city', $arr), true, '->getParameters() has a "city" key');
$t->is(array_key_exists('state', $arr), true, '->getParameters() has a "state" key');
$t->is(count($arr), 4, '->getParameters() has a table with "4" elements');

$t->diag('->getParameter()');
$t->is($http->getParameter('foo'), NULL, '->getParameter() returns "NULL" for invalid parameter');
$t->is($http->getParameter('foo', 'bar'), 'bar', '->getParameter() returns "bar" as default value');
$t->is($http->getParameter('output'), 'php', '->getParameter() returns "php" for "output" parameter');

$t->diag('->getQueryString()');
$t->isa_ok($http->getQueryString(), 'string', '->getQueryString() returns a string value');
$t->is($http->getQueryString(), 'output=php&zip=75008&city=Paris&state=France', '->getQueryString() returns the query string');

$t->diag('->getUri()');
$t->isa_ok($http->getUri(), 'string', '->getUri() returns a string value');
$t->is($http->getUri(), 'http://local.yahooapis.com/MapsService/V1/geocode?output=php&zip=75008&city=Paris&state=France', '->getUri() returns the full URI');

$t->diag('->handle()');

$http = new sfYahooAdapterHttpMock('xml_single');
$t->isa_ok($http->handle(), 'string', '->handle() returns a string');
$t->is($http->handle(), $xmlSingle, '->handle() returns the single XML response');

$http = new sfYahooAdapterHttpMock('xml_rs');
$t->is($http->handle(), $xmlRs, '->handle() returns the collection XML response');

$http = new sfYahooAdapterHttpMock('php_single');
$t->is($http->handle(), $phpSingle, '->handle() returns the single PHP response');

$http = new sfYahooAdapterHttpMock('php_rs');
$t->is($http->handle(), $phpRs, '->handle() returns the collection PHP response');

try
{
  $http = new sfYahooAdapterHttpMock('error');
  $http->handle();

  $t->fail('->handle() should throw an exception');
}
catch (Exception $e)
{
  $t->pass('->handle() threw an exception');
}

$t->diag('->getContent()');

$http = new sfYahooAdapterHttpMock('xml_single');
$http->handle();
$t->isa_ok($http->getContent(), 'string', '->getContent() returns a string');
$t->is($http->getContent(), $xmlSingle, '->getContent() returns the single XML response');

$http = new sfYahooAdapterHttpMock('xml_rs');
$http->handle();
$t->is($http->getContent(), $xmlRs, '->getContent() returns the collection XML response');

$http = new sfYahooAdapterHttpMock('php_single');
$http->handle();
$t->is($http->getContent(), $phpSingle, '->getContent() returns the single PHP response');

$http = new sfYahooAdapterHttpMock('php_rs');
$http->handle();
$t->is($http->getContent(), $phpRs, '->getContent() returns the collection PHP response');