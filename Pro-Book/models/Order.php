<?php

class Order extends Model
{
  /**
   * Constructor.
   *
   */
  public function __construct()
  {
    parent::__construct('orders');
  }

  /**
   * Create order.
   * 
   * @param array of data.
   * @return int inserted id.
   * @return null if failed.
   */
  public function create($data)
  {
    $userId = $this->toSqlString($data['user_id']);
    $bookId = $this->toSqlString($data['book_id']);
    $quantity = $this->toSqlString($data['quantity']);

    $query = "INSERT INTO $this->table
              (user_id, book_id, quantity)
              VALUES ($userId, $bookId, $quantity)";
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      return mysqli_insert_id($this->db);
    }

    return null;
  }

  /**
   * Get user's order history.
   * 
   * @param int of user id.
   * @return array of orders.
   */
  public function getByUser($id)        
  {
    $query = "SELECT orders.id as no_order, orders.quantity, orders.ordered_by, books.id as book_id, books.title, books.author, books.synopsis, books.image_path, IFNULL(reviews.id, 0) as reviewed FROM orders LEFT OUTER JOIN reviews ON orders.id = reviews.order_id INNER JOIN books ON orders.book_id = books.id WHERE user_id = $id";
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