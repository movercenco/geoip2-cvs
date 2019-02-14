<?php

namespace App;

use GeoIp2\Database\Reader;

class ReaderFactory
{
  const DB_LOCATION = PR_ROOT . '/db/';

  public static function getCountryReader()
  {
    return new Reader(self::DB_LOCATION . 'GeoLite2-Country.mmdb');
  }

  public static function getCityReader()
  {
    return new Reader(self::DB_LOCATION . 'GeoLite2-City.mmdb');
  }
}
