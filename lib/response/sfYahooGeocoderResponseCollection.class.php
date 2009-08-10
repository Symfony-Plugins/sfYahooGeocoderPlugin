<?php

/**
 * This file is part of the sfYahooGeocoderPlugin package.
 *
 * (c) 2009 Hugo Hamon <hugo.hamon@sensio.com> - sfYahooGeocoderPlugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
/**
 * The sfYahooGeocoderResponseCollection encapsulates all sfYahooGeocoderResponse objects.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.response
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderResponseCollection implements Countable, Iterator
{
  /**
   * Objects of the collection
   *
   * @var array
   */
  protected $objects = array();

  /**
   * Constructor
   *
   * @param array $objects An array of objects to store as a collection
   */
  public function __construct(array $objects)
  {
    $this->objects = $objects;
  }

  /**
   * Wraps method calls of sfYahooGeocoderResponse objects
   *
   * @param string $method   The method to call
   * @param array  $argument An array of arguments to pass to the object
   *
   * @return mixed
   *
   * @throws Exception
   */
  public function __call($method, $arguments)
  {
    
    $object = current($this->objects);

    if (!$object)
    {
      return;
    }

    if ('get' !== substr($method, 0, 3))
    {
      throw new Exception('Only get*() methods can be called from the collection');
    }

    if (method_exists($object, $method) && is_callable(array($object, $method)))
    {
      return call_user_func(array($object, $method), $arguments);
    }

    throw new Exception(sprintf('Unable to call "%s" method on "%s" object', $method, get_class($object)));
  }

  /**
   * Returns the number of objects in the collection
   *
   * @return int
   * @see Countable::count()
   */
  public function count()
  {
    return count($this->objects);
  }

  /**
   *
   *
   *
   */
  public function getByIndex($index)
  {
    return isset($this->objects[$index]) ? $this->objects[$index] : null;
  }

  /**
   * Returns wether or not the collection is empty
   *
   * @return boolean
   */
  public function isEmpty()
  {
    return (0 === $this->count());
  }

  /**
   * Returns the array reprensentation of the object
   *
   * @return array
   */
  public function toArray()
  {
    $toArray = array();
    foreach ($this->objects as $object)
    {
      $toArray[] = $object->toArray();
    }

    return $toArray;
  }

  /**
   * Returns the first object of the collection
   *
   * @return sfYahooGeocoderResponse
   */
  public function getFirst()
  {
    return $this->getByIndex(0);
  }

  /**
   * Returns the last object of the collection
   *
   * @return sfYahooGeocoderResponse
   */
  public function getLast()
  {
    return $this->getByIndex($this->count() - 1);
  }

  /**
   * Clears the collection
   *
   * @return boolean
   */
  public function clear()
  {
    if (!$this->isEmpty())
    {
      $this->objects = array();

      return true;
    }

    return false;
  }

  /**
   * Returns all objects of the collection
   *
   * @return array
   */
  public function getObjects()
  {
    return $this->objects;
  }

  /**
   * Returns the current object of the collection
   *
   * @return sfYahooGeocoderResponse
   * @see Iterator::current()
   */
  public function current()
  {
    return current($this->objects);
  }

  /**
   * Resets the pointer of the collection
   *
   * @return sfYahooGeocoderResponse
   * @see Iterator::rewind()
   */
  public function rewind()
  {
    return reset($this->objects);
  }

  /**
   * Returns the following object of the collection
   *
   * @return sfYahooGeocoderResponse
   * @see Iterator::next()
   */
  public function next()
  {
    return next($this->objects);
  }

  /**
   * Returns the current key of the collection
   *
   * @return int
   * @see Iterator::key()
   */
  public function key()
  {
    return key($this->objects);
  }

  /**
   * Returns wether or not the collection is valid
   *
   * @return boolean
   * @see Iterator::isValid()
   */
  public function valid()
  {
    return false !== $this->current();
  }
}