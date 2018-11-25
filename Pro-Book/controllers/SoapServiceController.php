<?php

require_once('./libs/nusoap/nusoap.php');

class SoapServiceController extends Controller
{
  private $client;

  public function __construct(){
    $this->client = new nusoap_client('http://localhost:4789/services/search?wsdl', 'wsdl');

    if ($this->client->getError()){
      echo 'error!';
    }
  }

  public function searchBooks($request){
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $keyword = $request->keyword;

    if ($keyword == null){
      echo "Keyword not specified";
    } else {
      $result = $this->client->call('searchBooksByKeyword', array('title'=>$keyword));

      if ($result == null){
        echo "Error, result null!";
      } else {
        echo $result;
      }
    }
  }
}
