<?php

require_once('./models/User.php');

class ValidateCardNumber
{
  /**
   * Run a single action controller.
   * Check card number whether it is exist or not.
   * 
   * @param array of request.
   * @return object json result.
   */
  public function run($request)
  {
    $user = new User();
    $exist = $user->getByCardNumber($request['card-number']);
    $result = [
      'status_code' => '200',
      'message' => 'Success',
      'result' => ($exist !== null ? 0 : 1),
    ];

    echo json_encode($result);
  }
}