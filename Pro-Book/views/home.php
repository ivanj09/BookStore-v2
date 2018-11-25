<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  $username = $this->data['username'];
?>
<head>
  <meta charset="utf-8">
  <title>
		Home
  </title>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
  <script src="/public/js/angular/searchApp.js"></script>
	<script src="/public/js/angular/searchController.js"></script>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/home.css" />
  <script src="/public/js/validation.js"></script>
</head>

<body>
	<div class="container w-60">
		<?php include '__header.php'; ?>
		<div class="menu d-flex">
			<a href="/index.php/home" class="flex-fill text-center bg-dark-primary white active py-16">Browse</a>
			<a href="/index.php/history" class="flex-fill text-center bg-dark-primary white py-16">History</a>
			<a href="/index.php/profile" class="flex-fill text-center bg-dark-primary white py-16">Profile</a>
		</div>
    <div id="search-page" ng-app="searchApp" ng-controller="searchController">
      <div class="content p-24">
        <h1 class="secondary m-0">Search Book</h1>
        <div class="d-flex">
          <input type="text" placeholder="Input search terms..." name="search_bar" class="flex-fill mt-24 mb-16" ng-model="formData.search_bar">
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary" ng-click="search()">
            Search
          </button>
        </div>
        <h3 id="loading_text"></h3>
  		</div>
      <div id="search_result" class="content p-24" style="display: none;">
  			<div class="d-flex justify-content-between align-items-end mb-24">
  				<h1 class="secondary m-0">Search Result</h1>
  				<p class="nowrap m-0">Found <u><span><b id="count"></b></span></u> result(s)</p>
  			</div>
        <div id="search_result_page">
          <div ng-repeat="book in book_list">
            <div class="d-flex flex-row">
              <div class="image-overlap d-flex justify-content-center mr-24">
                <img src="{{book.volumeInfo.imageLinks.thumbnail}}" alt="{{book.volumeInfo.title}}">
              </div>
              <div class="d-flex flex-column">
                <h2 class="secondary m-0">{{book.volumeInfo.title}}</h2>
                <p class="m-0"><b>{{book.volumeInfo.authors.join(", ")}} - {{checkAverageRating(book.volumeInfo)}}</b></p>
                <p class="m-0 font-weight-light">{{book.volumeInfo.description}}</p>
              </div>
            </div>
            <form action="/index.php/book" method="get">
              <div class="d-flex justify-content-end mb-32">
                <input type="hidden" name="id" value="{{book.id}}" />
                <input type="submit" class="btn btn-primary" value="Detail" />
              </div>
            </form>
          </div>
        </div>
  		</div>
    </div>
	</div>
	<script type="text/javascript">
    function validate() {
      let validity = (
        validation.required([
          document.searchForm.keyword,
        ])
      );

      if (validity.result) {
        document.searchForm.submit();
      } else {
        validation.display(validity.message);
      }
    }
	</script>
</body>

</html>
