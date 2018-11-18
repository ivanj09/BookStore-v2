<?php

class Model
{
  protected $db;
  protected $table;
  protected $primaryKey;

  /**
   * Constructor.
   * 
   * @param string table name.
   * @param string primary key name.
   */
  public function __construct($table, $primaryKey = 'id')
  {
    $this->table = $table;
    $this->primaryKey = $primaryKey;
    $this->db = new mysqli($_ENV['DB_SERVER'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
    if ($this->db->connect_error) {
      die('Connection failed, error: ' . $this->db->connect_error);
    }
  }

  /**
   * Get all tuples in a table.
   * 
   * @return array of tuples.
   */
  public function get()
  {
    $stmt = $this->db->prepare("SELECT * FROM $this->table");
    $stmt->execute();
    $stmt = $stmt->get_result();

    return $this->toArray($stmt);
  }

  /**
   * Get all tuples that satisfies the primary key.
   * 
   * @param integer of primary key.
   * @return array of tuples.
   */
  public function find($primaryKey)
  {
    $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE $this->primaryKey = $primaryKey");
    if ($stmt->execute()) {
      $stmt = $stmt->get_result();
      if ($stmt->num_rows > 0) {
        return $this->toArray($stmt)[0];
      }
    }

    return null;
  }

  /**
   * Convert results to array.
   * 
   * @param object msqli result.
   * @return array of result.
   */
  public function toArray($stmt)
  {
    $results = [];
    while ($row = $stmt->fetch_assoc()) {
      $results[] = $row;
    }

    return $results;
  }

  /**
   * Convert to SQL string.
   * 
   * @param string without quotation mark.
   * @return string with quotation mark.
   */
  public function toSqlString($str)
  {
    return '\'' . $str . '\'';
  }
}