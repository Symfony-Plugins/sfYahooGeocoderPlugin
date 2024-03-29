<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once(dirname(__FILE__).'/../../../lib/exception/sfYahooGeocoderException.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponse.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseXml.class.php');

try
{
  $response = new sfYahooGeocoderResponseXml();
  
  $t = new lime_test(24, new lime_output_color());
}
catch (Exception $e)
{
  $t = new lime_test(1, new lime_output_color());

  $t->fail('The sfYahooGeocoderResponseXml class requires the SimpleXml API to be loaded');
}

$xml = file_get_contents(dirname(__FILE__).'/../../fixtures/sfYahooGeocoderResponseXml.xml');
$xmlElement = new SimpleXMLElement($xml);

$response->hydrateFromSimpleXmlElement($xmlElement->Result);

$t->diag('->getLatitude()');

$t->isa_ok($response->getLatitude(), 'double', '->getLatitude() returns a double value');
$t->is($response->getLatitude(), 48.870480, '->getLatitude() returns "48.870480"');
$t->is($response['Latitude'], 48.870480, '->offsetGet() returns "48.870480"');

$t->diag('->getLongitude()');

$t->isa_ok($response->getLongitude(), 'double', '->getLongitude() returns a double value');
$t->is($response->getLongitude(), 2.305420, '->getLongitude() returns "2.305420"');
$t->is($response['Longitude'], 2.305420, '->offsetGet() returns "2.305420"');

$t->diag('->getCountry()');

$t->isa_ok($response->getCountry(), 'string', '->getCountry() returns a string value');
$t->is($response->getCountry(), 'FR', '->getCountry() returns "FR"');
$t->is($response['Country'], 'FR', '->offsetGet() returns "FR"');

$t->diag('->getState()');

$t->isa_ok($response->getState(), 'string', '->getState() returns a string value');
$t->is($response->getState(), 'France', '->getState() returns "France"');
$t->is($response['State'], 'France', '->offsetGet() returns "France"');

$t->diag('->getZip()');

$t->isa_ok($response->getZip(), 'string', '->getZip() returns a string value');
$t->is($response->getZip(), '75008', '->getZip() returns "75008"');
$t->is($response['Zip'], '75008', '->offsetGet() returns "75008"');

$t->diag('->getCity()');

$t->isa_ok($response->getCity(), 'string', '->getCity() returns a string value');
$t->is($response->getCity(), 'Paris', '->getCity() returns "Paris"');
$t->is($response['City'], 'Paris', '->offsetGet() returns "Paris"');

$t->diag('->getAddress()');

$t->isa_ok($response->getAddress(), 'string', '->getAddress() returns a string value');
$t->is($response->getAddress(), 'Avenue des Champs-Élysées', '->getAddress() returns "Avenue des Champs-Élysées"');
$t->is($response['Address'], 'Avenue des Champs-Élysées', '->offsetGet() returns "Avenue des Champs-Élysées"');

$t->diag('->getPrecisionLevel()');

$t->isa_ok($response->getPrecisionLevel(), 'string', '->getPrecisionLevel() returns a string value');
$t->is($response->getPrecisionLevel(), 'address', '->getPrecisionLevel() returns "address"');
$t->is($response['PrecisionLevel'], 'address', '->offsetGet() returns "address"');