<?php

class Bootstrap
{
  private $url = null;
  private $path = null;
  private $routes = null;
  private $handler = null;
  private $controller = null;
  private $requestBody = null;
  private $apiPath = 'apis/';
  private $requestMethod = null;
  private $controllerPath = 'controllers/';

  /**
   * Contructor.
   * 
   * @param array list of routes.
   */
  public function __construct($routes)
  {
    $this->routes = $routes;
  }

  /**
   * Start bootstrap.
   * 
   */
  public function init($url = null, $api = false)
  {
    if (!$url) {
      $this->getURL();
    } else {
      $this->url = filter_var($url, FILTER_SANITIZE_URL);
    }

    if (!$api) {
      $this->path = $this->controllerPath;
    } else {
      $this->path = $this->apiPath;
    }
    
    $this->getRequestMethod();
    $this->getRequestBody();
    $this->resolve();
  }

  /**
   * Fetches url from $_GET.
   * 
   */
  public function getURL()
  {
    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $this->url = filter_var($url, FILTER_SANITIZE_URL);
  }

  /**
   * Fetches request method from $_SERVER.
   * 
   */
  public function getRequestMethod()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST'
      && array_key_exists('_method', $_POST)
      && $_POST['_method'] === 'PUT') {
      $this->requestMethod = 'PUT';
    } else {
      $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
  }

  /**
   * Fetches query string or request body from either $_GET or $_POST.
   * 
   */
  public function getRequestBody()
  {
    if ($this->requestMethod == 'GET') {
      $this->requestBody = [];
      
      foreach ($_GET as $key => $value) {
        $this->requestBody[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }

    if ($this->requestMethod == 'POST' || $this->requestMethod == 'PUT') {
      $this->requestBody = [];

      foreach ($_POST as $key => $value) {
        $this->requestBody[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
    }
  }

  /**
   * Get defined handler based on list of routes.
   * 
   */
  public function getHandler()
  {
    $matchRoute = array_filter($this->routes, function($value) {
                  return $value['method'] == $this->requestMethod && $value['path'] == $this->url;
                }, ARRAY_FILTER_USE_BOTH);
    if (count($matchRoute) > 0) {
      $this->handler = array_pop($matchRoute)['handler'];
    }
  }

  /**
   * Load handler class.
   * 
   */
  public function loadController()
  {
    $className = explode('@', $this->handler)[0];
    $file = $this->path . $className . '.php';
    if (file_exists($file)) {
      require $file;
      $this->controller = new $className;
    } else {
      die('501 - Not Implemented');
    }
  }

  /**
   * Call specified method in class handler.
   * 
   */
  public function callControllerMethod()
  {
    if ($this->path === $this->apiPath) {
      $className = explode('@', $this->handler)[0];
      $classMethod = 'run';
    } else {
      $className = explode('@', $this->handler)[0];
      $classMethod = explode('@', $this->handler)[1];
    }

    if (is_callable(array($className, $classMethod))) {
      $this->controller->$classMethod($this->requestBody);
    } else {
      die('501 - Not Implemented');
    }
  }

  /**
   * Resolve routing.
   * 
   */
  public function resolve()
  {
    $this->getHandler();
    if ($this->handler !== null) {
      $this->loadController();
      $this->callControllerMethod();
    } else {
      die('404 - Not Found');
    }    
  }
}