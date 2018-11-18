<?php

require_once('./web.php');
require_once('./autoload.php');
ini_set('display_errors','On');

$url = substr($_SERVER['PATH_INFO'], 1);
$bootstrap = new Bootstrap(Route::getList());

if (preg_match('/^apis\/+/', $url)) {
  $bootstrap->init($url, true);
} else {
  $bootstrap->init($url);
}
