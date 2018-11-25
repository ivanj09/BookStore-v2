<?php

require_once('./models/User.php');
require_once('./libs/client.php');

class Auth extends Controller
{
  /**
  * Parse session access_token.
  *
  * @return array an associative array with key id and expire.
  */
  private function parseToken()
  {
    $value = explode("@", hex2bin(Session::get('access_token')));
    return [
      'id' => $value[0],
      'ip' => $value[1],
      'agent' => $value[2]
    ];
  }

  /**
   * Check user authentication.
   *
   * @return bool url login status.
   */
  public static function check()
  {
    Session::start();

    if (Session::exist('expire_time')) {
      $now = time();

      if ($now <= Session::get('expire_time')){
        $accessToken = self::parseToken();
        $google = 'google';

        if (strpos($accessToken['id'], $google) !== false){
          if ($accessToken['agent'] === Client::getUserAgent() && $accessToken['ip'] === Client::getIpAddress()){
            return true;
          } else {
            return false;
          }
        } else {
          $user = new User();

          if ($user->find($accessToken['id']) && $accessToken['agent'] === Client::getUserAgent() && $accessToken['ip'] === Client::getIpAddress()) {
            return true;
          } else {
            return false;
          }
        }
      }

      Session::unset('access_token');
      Session::unset('expire_time');
      Session::unset('google');
      Session::unset('isloginbygoogle');

      return false;
    }

    return false;
  }

  /**
   * Redirect to register page.
   *
   * @return view register.php
   */
  public function register()
  {
    if (Auth::check()){
      return $this->redirect('/index.php/home');
    }

    return $this->view('register.php');
  }

  /**
   * Register handler.
   *
   * @return Session current logged in user, if authorized.
   * @return view register.php, if unauthorized.
   */
  public function handleRegister($request)
  {
    $user = new User();
    if ($user->create($request)) {
      return $this->redirect('/index.php/register', [
        'message' => 'Data added successfully',
      ]);
    };

    return $this->redirect('/index.php/register', [
      'message' => 'Problem encountered',
    ]);
  }

  /**
   * Redirect to login page.
   *
   * @return view login.php
   */
  public function login()
  {
    if (Auth::check()){
      return $this->redirect('/index.php/home');
    }

    return $this->view('login.php');
  }

  /**
   * Unset Session and redirect to login page.
   *
   * @return view login.php
   */
  public function logout()
  {
    Session::start();
    Session::unset('access_token');
    Session::unset('expire_time');
    Session::unset('google');
    Session::unset('isloginbygoogle');

    return $this->view('login.php');
  }

  /**
   * Login handler.
   *
   * @return view home.php, if authorized
   * @return view login.php, if unauthorized.
   */
  public function handleLogin($request)
  {
    $username = $request['username'];
    $password = $request['password'];
    $user = new User();
    $user = $user->getByUsername($username);

    if ($user !== null){
      if (password_verify($password, $user['password'])) {
        $expire = time() + 7200;
        $userAgent = Client::getUserAgent();
        $ipAddress = Client::getIpAddress();

        $value = $user['id'] . '@' . $ipAddress . '@' . $userAgent;
        $value = bin2hex($value);

        Session::start();
        Session::set('access_token', $value);
        Session::set('expire_time', $expire);

        return $this->redirect('/index.php/home');
      }
    }

    return $this->redirect('/index.php/login', [
      'message' => 'Invalid username or password, try again!',
    ]);
  }

  /**
   * Login handler.
   *
   * @return view home.php and guaranted authorized
   */
  public function handleLoginByGoogle($request)
  {
    $isSignedIn = true;
    $google = 'google';
    $expire = time() + 7200;
    $ipAddress = Client::getIpAddress();
    $userAgent = Client::getUserAgent();

    $request['address'] = 'No available';
    $request['phone_number'] = 'No available';

    $value = $google . $request['username'] . '@' . $ipAddress . '@' . $userAgent;
    $value = bin2hex($value);

    Session::start();
    Session::set('access_token', $value);
    Session::set('expire_time', $expire);
    Session::set('google', $request);
    Session::set('isloginbygoogle', $isSignedIn);

    return $this->redirect('/index.php/home');
  }

  /**
   * Get logged in user.
   *
   * @return array current logged in user.
   */
  public static function user()
  {
    if (self::check()) {
      $id = self::parseToken()['id'];
      $user = new User();
      $user = $user->find($id);

      return $user;
    }

    return null;
  }
}
