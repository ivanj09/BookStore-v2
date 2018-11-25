<?php

require_once('./models/Order.php');
require_once('./controllers/Auth.php');

class CreateOrder
{
  /**
   * Run a single action controller.
   * Create book order.
   *
   * @param array of request.
   * @return object json result.
   */
  public function run($request)
  {
    $order = new Order();

    Session::start();

    if (Session::exist('isloginbygoogle')){
      $userid = (int) Session::get('google')['username'];

    } else {
      $request['user_id'] = Auth::user()['id'];
    }

    $orderId = $order->create($request);
    $orderStatus = [
      'status_code' => ($orderId !== null? '200' : '500'),
      'message' => ($orderId !== null? 'Order made successfully' : 'Problem encountered'),
      'order_id' => ($orderId !== null? $orderId : null),
    ];

    echo json_encode($orderStatus);
  }
}
