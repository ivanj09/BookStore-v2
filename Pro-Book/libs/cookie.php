<?php

class Cookie
{
  /**
   * Set cookie.
   * 
   * @param string key of cookie.
   * @param string value of cookie.
   * @param int expiration time using UNIX time, default = 1 hour.
   */
  public static function set($key, $value, $expire = null)
  {
    if ($expire === null) {
      $expire = time() + 3600;
    }
    setcookie($key, $value, $expire);
  }

  /**
   * Unset cookie.
   * 
   * @param string key of cookie.
   * @return boolean
   */
  public static function unset($key)
  {
    if (self::get($key)) {
      unset($_COOKIE[$key]);
      setcookie($key, '', time() - 3600);
    }
  }

  /**
   * Check whether cookie key is exist.
   * 
   * @param string cookie key.
   * @return boolean true if exist, otherwise false.
   */
  public static function exist($key)
  {
    return (self::get($key) !== null);
  }

  /**
   * Get cookie by key.
   * 
   * @param string cookie key.
   * @return string cookie value.
   * @return null if cookie does not exist.
   */
  public static function get($key)
  {
    if (isset($_COOKIE[$key])) {
      return $_COOKIE[$key];
    }
    
    return null;
  }
}