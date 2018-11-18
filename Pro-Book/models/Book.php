<?php

class Book extends Model
{
  /**
   * Constructor.
   *
   */
  public function __construct()
  {
    parent::__construct('books');
  }

  public function getByName($name)
  {
    $query = "SELECT books.*, IFNULL(AVG(reviews.rating), 0) AS avg_rating, COUNT(reviews.rating) AS count_rating FROM $this->table LEFT OUTER JOIN orders ON books.id = orders.book_id LEFT OUTER JOIN reviews ON orders.id = reviews.order_id WHERE title LIKE '%$name%' GROUP BY books.id";
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      $stmt = $stmt->get_result();
      if ($stmt->num_rows > 0) {
        return $this->toArray($stmt);
      }
    }

    return [];
  }


  public function getAvgRatingById($id)
  {
    $query = "SELECT books.*, AVG(reviews.rating) AS avg_rating, COUNT(reviews.rating) AS count_rating FROM $this->table INNER JOIN orders ON books.id = orders.book_id INNER JOIN reviews ON orders.id = reviews.order_id WHERE books.id = $id";
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
