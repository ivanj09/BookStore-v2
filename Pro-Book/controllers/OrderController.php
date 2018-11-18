<?php

require_once('./models/Book.php');
require_once('./models/User.php');
require_once('./models/Order.php');
require_once('./models/Review.php');
require_once('./controllers/Auth.php');

class OrderController extends Controller
{
  /**
   * Constructs UserController.
   *
   */
  public function __construct()
  {
    if (!Auth::check()){
      return $this->redirect('/index.php/login');
    }
  }

  /**
   * Redirect to index order page.
   *
   */
  public function index() {
    $order = new Order();
    $orders = $order->getByUser(Auth::user()['id']);

    return $this->view('history.php', [
      'orders' => $orders,
      'username' => Auth::user()['username'],
    ]);
  }

  /**
   * Redirect to order page.
   */
  public function create($request)
  {
    $book = new Book();
    $book = $book->getAvgRatingById($request['book-id'])[0];

    $reviews = new Review();
    $reviews = $reviews->getByBookId($request['book-id']);

    return $this->view('order.php', [
      'book' => $book,
      'reviews' => $reviews,
      'user' => Auth::user(),
    ]);
  }
}
