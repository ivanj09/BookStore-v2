<?php

require_once('./controllers/Auth.php');

class User extends Model
{
  /**
   * Constructor.
   *
   */
  public function __construct()
  {
    parent::__construct('users');
  }

  /**
   * Create new user.
   *
   * @param array of data.
   * @return integer
   */
  public function create($data)
  {
    $name = $this->toSqlString($data['name']);
    $username = $this->toSqlString($data['username']);
    $email = $this->toSqlString($data['email']);
    $address = $this->toSqlString($data['address']);
    $phoneNumber = $this->toSqlString($data['phone']);
    $imagePath = $this->toSqlString('/public/images/example_user.jpg');
    // Copy example image.
    $baseDir = $_SERVER['DOCUMENT_ROOT'];
    $targetDir = '/public/images/profiles/';
    $fileName = $targetDir . $data['username'] . '.jpg';
    $copied = copy($baseDir . '/public/images/example_user.jpg', $baseDir . $fileName);
    if ($copied) {
      $imagePath = $this->toSqlString($fileName);
    } else {
      $imagePath = null;
    }

    $password = $this->toSqlString(password_hash($data['password'], PASSWORD_DEFAULT));

    $query = "INSERT INTO $this->table
              (name, username, email, address, phone_number, image_path, password)
              VALUES ($name, $username, $email, $address, $phoneNumber, $imagePath, $password)";
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      return 1;
    }

    return 0;
  }

  /**
   * Update user's data.
   *
   * @param int Logged in user's id.
   * @param array Updated data for user's profile.
   * @return int of 1 when data is successfully edited, otherwise 0.
   */
  public function update($id, $data){
    $name = $this->toSqlString($data['name']);
    $address = $this->toSqlString($data['address']);
    $phoneNumber = $this->toSqlString($data['phone']);
    $imagePath = null;

    if (array_key_exists('image_path', $data)){
      $imagePath = $this->toSqlString($data['image_path']);
    } else {
      $imagePath = $this->toSqlString(Auth::user()['image_path']);
    }

    $query = "UPDATE $this->table
              SET name = $name, address = $address, phone_number = $phoneNumber, image_path = $imagePath
              WHERE id = $id";

    $stmt = $this->db->prepare($query);

    if ($stmt->execute()){
      return 1;
    }
    return 0;
  }

  /**
   * Get user by username
   *
   * @param string username.
   * @return object User
   */
  public function getByUsername($username)
  {
    $username = $this->toSqlString($username);

    $query = "SELECT * FROM $this->table WHERE username = $username";
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      $stmt = $stmt->get_result();
      if ($stmt->num_rows > 0) {
        return $this->toArray($stmt)[0];
      }
    }

    return null;
  }

  /**
   * Get user by email.
   *
   * @param string email.
   * @return object User
   */
  public function getByEmail($email)
  {
    $email = $this->toSqlString($email);

    $query = "SELECT * FROM $this->table WHERE email = $email";
    $stmt = $this->db->prepare($query);

    if ($stmt->execute()) {
      $stmt = $stmt->get_result();
      if ($stmt->num_rows > 0) {
        return $this->toArray($stmt)[0];
      }
    }

    return null;
  }
}
