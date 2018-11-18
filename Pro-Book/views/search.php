<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
	$book = $this->data['book'];
	$username = $this->data['username'];
?>
<head>
  <meta charset="utf-8">
  <title>
		Home
  </title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/home.css" />
</head>

<body>
	<div class="container w-60">
		<?php include '__header.php'?>
		<div class="menu d-flex">
			<a href="/index.php/home" class="flex-fill text-center bg-dark-primary white active py-16">Browse</a>
			<a href="/index.php/history" class="flex-fill text-center bg-dark-primary white py-16">History</a>
			<a href="/index.php/profile" class="flex-fill text-center bg-dark-primary white py-16">Profile</a>
		</div>
		<div class="content p-24">
			<div class="d-flex justify-content-between align-items-end mb-24">
				<h1 class="secondary m-0">Search Result</h1>
				<p class="nowrap m-0">Found <u><b><?php echo count($book); ?></b></u> result(s)</p>
			</div>
			<?php
				foreach($book as $item) {
			?>
			<div class="d-flex flex-row">
				<div class="image-overlap d-flex justify-content-center mr-24">
					<img src="<?php echo $item['image_path']; ?>" alt="<?php echo $item['title']; ?>">
				</div>
				<div class="d-flex flex-column">
					<h2 class="secondary m-0"><?php echo $item['title']; ?></h2>
					<p class="m-0"><b><?php echo $item['author']; ?> - <?php echo round($item['avg_rating'], 2, PHP_ROUND_HALF_DOWN); ?>/5.0 (<?php echo $item['count_rating']; ?> votes)</b></p>
					<p class="m-0 font-weight-light"><?php echo $item['synopsis']; ?></p>
				</div>
			</div>
			<div class="d-flex justify-content-end mb-32">
				<a href="/index.php/order?book-id=<?php echo $item['id']; ?>" class="btn btn-primary">Detail</a>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</body>

</html>
