searchApp.controller('searchController', function($scope, $http){
  $scope.formData = {};
  $scope.search = function(){
    document.getElementById("search_result").style.display = "none";
    console.log($scope.formData.search_bar);

    if ($scope.formData.search_bar == ""){
      alert("Fill the search bar!");
    } else {
      document.getElementById("loading_text").innerHTML = "Retrieving data from Book WebService..";
      $http({
        method : "POST",
        url : "/index.php/books",
        data : {
          keyword: $scope.formData.search_bar
        },
        headers : {'Content-Type': 'application/x-www-form-urlencoded' }
      }).then(function(response){
        document.getElementById("loading_text").innerHTML = "";
        console.log(response.data);
        $scope.book_list = response.data;

        document.getElementById("search_result").style.display = "block";

        if (response.data === "Error, result null!"){
          document.getElementById("search_result_page").style.display = "none";
          document.getElementById("count").innerHTML = "0";
        } else {
          document.getElementById("search_result_page").style.display = "block";
          document.getElementById("count").innerHTML = $scope.book_list.length.toString();
        }
      }, function(response){
        console.log(response.statusText);
      })
    }
  }

  $scope.checkAverageRating = function(jsonObj) {
		if(jsonObj.averageRating > 0) {
			return jsonObj.averageRating + " / 5.0";
		}
		else {
			return "No rating available..";
		}
	}
})
