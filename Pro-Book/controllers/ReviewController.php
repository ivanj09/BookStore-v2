<?php

require_once('./controllers/Auth.php');
require_once('./models/Review.php');

class ReviewController extends Controller
{
  /**
   * Constructs ReviewController.
   *
   */
  public function __construct()
  {
    if (!Auth::check()){
      return $this->redirect('/index.php/login');
    }
  }

  /**
   * Review handler.
   * Show review page.
   * @param request User's order to review.
   * @return view review.php.
   */
  public function create($request)
  {
    $review = new Review();
    $review = $review->getReview($request);

    $username = Auth::user()['username'];

    return $this->view('review.php', [
      'order' => $review,
      'username' => $username
    ]);
  }

  /**
   * Store review handler.
   * @param request user's review from view review.php
   */
  public function store($request)
  {
    $review = new Review();

    if ($review->create($request)){
      return $this->redirect('/index.php/history',
        ['message' => "Your review was successfully added!"]
      );
    } else {
      return $this->redirect('/index.php/review',
        ['message' => "Failed to add review"]
      );
    }
  }
}
