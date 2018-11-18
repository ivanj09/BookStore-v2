<?php

class Route {
  static $list;

  /**
   * Adds route for GET method.
   * 
   * @param string $path of the url, e.g: /login.
   * @param string $handler of the specified controller, e.g: Auth@login.
   */
  public static function get($path, $handler)
  {
    self::$list[] = [
      'method' => 'GET',
      'path' => $path,
      'handler' => $handler,
    ];
  }

  /**
   * Adds route for POST method.
   * 
   * @param string $path of the url, e.g: /login.
   * @param string $handler of the specified controller, e.g: Auth@login.
   */
  public static function post($path, $handler)
  {
    self::$list[] = [
      'method' => 'POST',
      'path' => $path,
      'handler' => $handler,
    ];
  }

  /**
   * Adds route for PUT method.
   * 
   * @param string $path of the url, e.g: /login.
   * @param string $handler of the specified controller, e.g: Auth@login.
   */
  public static function put($path, $handler)
  {
    self::$list[] = [
      'method' => 'PUT',
      'path' => $path,
      'handler' => $handler,
    ];
  }

  /**
   * Returns routes list.
   * 
   * @return array of routes list.
   */
  public static function getList()
  {
    return self::$list;
  }
}