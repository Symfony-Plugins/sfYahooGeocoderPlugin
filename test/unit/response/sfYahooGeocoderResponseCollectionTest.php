<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');
require_once(dirname(__FILE__).'/../../../lib/exception/sfYahooGeocoderException.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponse.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponsePhp.class.php');
require_once(dirname(__FILE__).'/../../../lib/response/sfYahooGeocoderResponseCollection.class.php');

$objects = array();
$collection = new sfYahooGeocoderResponseCollection($objects);

$t = new lime_test(29, new lime_output_color());

$t->diag('->isEmpty()');

$t->isa_ok($collection->isEmpty(), 'boolean', '->isEmpty() returns a boolean value');
$t->is($collection->isEmpty(), true, '->isEmpty() returns "true"');

$objects[] = new sfYahooGeocoderResponsePhp();
$collection = new sfYahooGeocoderResponseCollection($objects);

$t->is($collection->isEmpty(), false, '->isEmpty() returns "false"');

$t->diag('->count()');

$t->isa_ok($collection->count(), 'integer', '->count() returns an integer value');
$t->is($collection->count(), 1, '->count() returns "1"');

$t->diag('->getObjects()');

$t->isa_ok($collection->getObjects(), 'array', '->getObjects() returns an array value');

$t->diag('->clear()');

$result = $collection->clear();

$t->isa_ok($result, 'boolean', '->clear() returns a boolean value');
$t->is($result, true, 'clear() returns true when collection is not empty');
$t->is($collection->isEmpty(), true, '->clear() has been successfully emptied');
$t->is($collection->clear(), false, '->clear() returns false if collection is already empty');

$t->diag('->getByIndex()');

$response1 = new sfYahooGeocoderResponsePhp();
$response1->setAddress('First');

$response2 = new sfYahooGeocoderResponsePhp();
$response2->setAddress('Second');

$collection = new sfYahooGeocoderResponseCollection(array($response1, $response2));

$t->is($collection->getByIndex(0) instanceOf sfYahooGeocoderResponse, true, '->getByIndex() returns a sfYahooGeocoderResponsePhp object');
$t->is($collection->getByIndex(1) instanceOf sfYahooGeocoderResponse, true, '->getByIndex() returns a sfYahooGeocoderResponsePhp object');
$t->is($collection->getByIndex(2), null, '->getByIndex() returns a NULL for invalid index');

$t->diag('->getFirst()');

$t->is($collection->getFirst() instanceOf sfYahooGeocoderResponse, true, '->getFirst() returns a sfYahooGeocoderResponsePhp object');
$t->is($collection->getFirst()->getAddress(), 'First', '->getFirst() returns the first element');

$t->diag('->getLast()');

$t->is($collection->getLast() instanceOf sfYahooGeocoderResponse, true, '->getLast() returns a sfYahooGeocoderResponsePhp object');
$t->is($collection->getLast()->getAddress(), 'Second', '->getLast() returns the last element');

$t->diag('->toArray()');

$toArray = array(
  array(
    'PrecisionLevel' => NULL,
    'Latitude' => NULL,
    'Longitude' => NULL,
    'Address' => 'First',
    'City' => NULL,
    'State' => NULL,
    'Zip' => NULL,
    'Country' => NULL,
   ),
  array(
    'PrecisionLevel' => NULL,
    'Latitude' => NULL,
    'Longitude' => NULL,
    'Address' => 'Second',
    'City' => NULL,
    'State' => NULL,
    'Zip' => NULL,
    'Country' => NULL,
   )
);

$t->isa_ok($collection->toArray(), 'array', '->toArray() returns an array value');
$t->is($collection->toArray(), $toArray, '->toArray() contains the two array representations');

$t->diag('__call()');

$infos = array(
  'PrecisionLevel' => 'address',
  'Latitude' => '23.456789',
  'Longitude' => '-2.45273',
  'Address' => 'Avenue des Champs Elysées',
  'City' => 'Paris',
  'State' => 'France',
  'Zip' => '75008',
  'Country' => 'FR'
 );

$phpResult  = new sfYahooGeocoderResponsePhp();
$phpResult->fromArray($infos);

$collection = new sfYahooGeocoderResponseCollection(array($phpResult));

try
{
  $t->is($collection->getPrecisionLevel(), 'address', '->__call() calls the getPrecisionLevel() method');
  $t->is($collection->getLatitude(), 23.456789, '->__call() calls the getLatitude() method');
  $t->is($collection->getLongitude(), -2.45273, '->__call() calls the getLongitude() method');
  $t->is($collection->getAddress(), 'Avenue des Champs Elysées', '->__call() calls the getAddress() method');
  $t->is($collection->getCity(), 'Paris', '->__call() calls the getCity() method');
  $t->is($collection->getState(), 'France', '->__call() calls the getState() method');
  $t->is($collection->getZip(), '75008', '->__call() calls the getZip() method');
  $t->is($collection->getCountry(), 'FR', '->__call() calls the getCountry() method');
}
catch (Exception $e)
{
  $t->fail('->__call() should not throw an exception for expected methods');
}

try
{
  $collection->getInvalidMethod();
  $t->fail('->__call() should throw an exception for invalid method');
}
catch (Exception $e)
{
  $t->pass('->__call() threw an exception for invalid method');
}

try
{
  $collection->setPrecisionLevel('city');
  $t->fail('->__call() should throw an exception for non accessor methods');
}
catch (Exception $e)
{
  $t->pass('->__call() threw an exception for non accessor methods');
}