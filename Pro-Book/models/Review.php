<?php

class Review extends Model
{
  /**
   * Constructor.
   *
   */
  public function __construct()
  {
    parent::__construct('reviews');
  }

  /**
   * Create new review.
   *
   * @param array of data.
   * @return integer
   */
  public function create($data)
  {
    $orderId = $this->toSqlString($data['order_id']);
    $rating = $this->toSqlString($data['rating']);
    $comment = $this->toSqlString($data['comment']);

    $query = "INSERT INTO $this->table
              (order_id, rating, comment)
              VALUES ($orderId, $rating, $comment)";

    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      return 1;
    }

    return 0;
  }

  public function getReview($data)
  {
    $query = "SELECT orders.id, title, author, image_path FROM books INNER JOIN orders ON orders.book_id = books.id WHERE books.id = ".$data['book-id']." AND orders.id = ".$data['id'];
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      $stmt = $stmt->get_result();
      if ($stmt->num_rows > 0) {
        return $this->toArray($stmt)[0];
      }
    }

    return [];
  }


  /**
   * Get book's review from another users
   *
   * @param int of book id.
   * @return array of orders.
   */
   public function getByBookId($id)
   {
     $query = "SELECT comment, rating, users.username AS username, users.image_path
              FROM orders
              INNER JOIN books ON books.id = orders.book_id
              INNER JOIN reviews ON orders.id = reviews.order_id
              INNER JOIN users ON users.id = orders.user_id
              WHERE books.id = $id;";

     $stmt = $this->db->prepare($query);

     if ($stmt->execute()) {
       $stmt = $stmt->get_result();
       if ($stmt->num_rows > 0) {
         return $this->toArray($stmt);
       }
     }

     return [];
   }
}
