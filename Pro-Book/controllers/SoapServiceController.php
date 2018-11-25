<?php

require_once('./libs/nusoap/nusoap.php');
require_once('./controllers/Auth.php');

class SoapServiceController extends Controller
{
  private $clientSearch;
  private $clientRecommend;

  public function __construct()
  {
    $this->clientSearch = new nusoap_client('http://localhost:4789/services/search?wsdl', 'wsdl');
    $this->clientRecommend = new nusoap_client('http://localhost:4789/services/recommendation?wsdl', 'wsdl');

    if ($this->clientSearch->getError() || $this->clientRecommend->getError()){
      echo 'error!';
    }
  }

  public function searchBooks($request)
  {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $keyword = $request->keyword;

    if ($keyword == null){
      echo "Keyword not specified";
    } else {
      $result = $this->clientSearch->call('searchBooksByKeyword', array('title'=>$keyword));

      if ($result == null){
        echo "Error, result null!";
      } else {
        echo $result;
      }
    }
  }

  public function getBookDetails($request)
  {
    $id = $request['id'];
    if ($id == null){
      echo "Book id is not specified";
    } else {
      $result = $this->clientSearch->call('getBookDetails', array('id' => $id));
      $categories = json_decode($result)->volumeInfo->categories;

      $recommendedbooks = $this->clientRecommend->call('getRecommendedBooks', array('categories' => $categories[0]));

      if ($result == null){
        echo "Error, result null!";
      } else {
        $result = json_decode($result);
        $recommendedbooks = json_decode($recommendedbooks);

        return $this->view('order.php', [
          'book' => $result,
          'recommendedbooks' => $recommendedbooks,
          'username' => Auth::user()['username']
        ]);
      }
    }
  }
}
