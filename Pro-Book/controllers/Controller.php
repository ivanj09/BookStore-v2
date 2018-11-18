<?php

class Controller
{
  // Data passed to view.
  public $data = [];

  /**
   * Render view.
   * 
   * @param string view file name, e.g: register.php
   * @param array passing data to view.
   */
  public function view($view, $data = [])
  {
    $file = 'views/' . $view;
    if (file_exists($file)) {
      foreach ($data as $key => $value) {
        $this->data[$key] = $value;
      }
      require $file;
      return;
    }

    die('404 - Not Found');
  }

  /**
   * Redirect back.
   * 
   * @param array of messages in key-value format.
   */
  public function back($messages = null)
  {
    Session::start();
    if ($messages) {
      foreach ($messages as $key => $value) {
        Session::set($key, $value);
      }
    }
    
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  /**
   * Redirect page.
   * 
   * @param string path, e.g: /login.
   * @param array of messages in key-value format.
   */
  public function redirect($path, $messages = null)
  {
    Session::start();
    if ($messages) {
      foreach ($messages as $key => $value) {
        Session::set($key, $value);
      }
    }

    header("Location: $path");
  }
}