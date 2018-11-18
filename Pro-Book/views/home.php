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
		<div class="content p-24">
      <h1 class="secondary m-0">Search Book</h1>
      <form name="searchForm" action="/index.php/search" method="GET" onsubmit="event.preventDefault(); return validate();">
        <div class="d-flex">
          <input type="text" placeholder="Input search terms..." name="keyword" class="flex-fill mt-24 mb-16">
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">
            Search
          </button>
        </div>
      </form>
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
