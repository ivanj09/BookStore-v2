<?php

class Session
{
  /**
   * Start session.
   *
   */
  public static function start()
  {
    session_id(999);
    @session_start();
  }

  /**
   * Set session by key-value.
   *
   * @param string session key.
   * @param string session value.
   */
  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  /**
   * Unset session by key.
   *
   * @param string session key.
   */
  public static function unset($key)
  {
    if (self::exist($key)) {
      unset($_SESSION[$key]);
    }
  }

  /**
   * Check whether session key is exist.
   *
   * @param string session key.
   * @return boolean true if exist, otherwise false.
   */
  public static function exist($key)
  {
    return (self::get($key) !== null);
  }

  /**
   * Get session by key.
   *
   * @param string session key.
   * @return string session value.
   * @return null if session does not exist.
   */
  public static function get($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }

    return null;
  }

  /**
   * Destroy session.
   *
   */
  public static function destroy()
  {
    @session_destroy();
  }
}
