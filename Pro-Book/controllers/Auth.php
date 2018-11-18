<?php

require_once('./models/User.php');

class Auth extends Controller
{
  /**
  * Parse access_token cookie.
  *
  * @return array an associative array with key id and expire.
  */
  private function parseToken()
  {
    $value = explode("@", hex2bin(Cookie::get('access_token')));
    return [
      'id' => $value[0],
      'expire' => $value[1],
    ];
  }

  /**
   * Check user authentication.
   *
   * @return bool url login status.
   */
  public static function check()
  {
    if (Cookie::exist('access_token')) {
      $accessToken = self::parseToken();
      $user = new User();

      if ($user->find($accessToken['id']) && $accessToken['expire'] >= time()) {
        return true;
      }

      Cookie::unset('access_token');
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
   * Unset cookie and redirect to login page.
   *
   * @return view login.php
   */
  public function logout()
  {
    Cookie::unset("access_token");
    return $this->view('login.php');
  }

  /**
   * Login handler.
   *
   * @return Session current logged in user, if authorized.
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
        $expire = time() + 3600;
        $value = $user['id'] . "@" . $expire;
        $value = bin2hex($value);
        Cookie::set('access_token', $value);

        return $this->redirect('/index.php/home');
      }
    }

    return $this->redirect('/index.php/login', [
      'message' => 'Invalid username or password, try again!',
    ]);
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
