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
 * The sfYahooGeocoderResponsePhp unserialises the response php array and hydrates its properties defined 
 * in abstract sfYahooGeocoderResponse class.
 *
 * @package sfYahooGeocoderPlugin
 * @subpackage lib.response
 * @author Hugo Hamon <hugo.hamon@sensio.com>
 *
 * @see http://www.symfony-project.org/plugins/sfYahooGeocoderPlugin
 */
class sfYahooGeocoderResponsePhp extends sfYahooGeocoderResponse
{
  /**
   * Hydrates the object from an array
   *
   * @throws sfYahooGeocoderException
   */
  public function fromArray(array $result)
  {
    if (array_key_exists('precision', $result))
    {
      $this->setPrecisionLevel((string) $result['precision']);
    }

    foreach ($result as $key => $value)
    {
      $method = sprintf('set%s', $key);

      if (method_exists($this, $method) && is_callable(array($this, $method)))
      {
        call_user_func(array($this, $method), $value);
      }
    }
  }
}