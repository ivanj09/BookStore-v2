<?php

require_once('./libs/nusoap/nusoap.php');

class SoapServiceController extends Controller
{
  public function __construct(){
    $client = new nusoap_client('http://localhost:4789/services/order?wsdl', 'wsdl');

    if ($client->getError()){
      echo 'error!';
    } else {
      // specific service call
      $result = $client->call('order', array("id" => "IwMfDgAAQBAJ", "quantity" => 100, "accountNumber" => 50001234));

      die($client->response);
    }
  }
}
