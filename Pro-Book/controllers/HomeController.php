<?php

require_once('./models/Book.php');
require_once('./controllers/Auth.php');

class HomeController extends Controller
{
	/**
	 * Constructs HomeController.
	 *
	 */
  public function __construct()
  {
		if (!Auth::check()){
			return $this->redirect('/index.php/login');
		}
	}

	public function index()
	{
    if (Session::exist('isloginbygoogle')){
      $isSignedIn = Session::get('isloginbygoogle');
      if ($isSignedIn){
        return $this->view('home.php', [
          'username' => Session::get('google')['username']
        ]);
      } else {
        return $this->redirect('/index.php/login', [
          'message' => 'Problem encountered'
        ]);
      }
    }

		return $this->view('home.php', [
		  'username' => Auth::user()['username']
		]);
	}

	public function search($request)
	{
    $book = new Book();
    $book = $book->getByName($request['keyword']);

    if (Session::exist('isloginbygoogle')){
      $isSignedIn = Session::get('isloginbygoogle');
      if ($isSignedIn){
        return $this->view('search.php', [
          'book' => $book,
          'username' => Session::get('google')['username']
        ]);
      } else {
        return $this->redirect('/index.php/login', [
          'message' => 'Problem encountered'
        ]);
      }
    }

		return $this->view('search.php', [
			'book' => $book,
			'username' => Auth::user()['username']
		]);
	}
}
