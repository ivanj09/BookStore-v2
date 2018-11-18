<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
	$orders = $this->data['orders'];
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
	<?php
    Session::start();
    if (Session::exist('message')):
  ?>
    <div class="info-dialog">
      <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p><?php echo Session::get('message'); ?></p>
    </div>
  <?php
    Session::unset('message');
    endif;
  ?>
	<div class="container w-60">
		<header class="navbar d-flex justify-content-between align-items-center position-relative bg-primary py-8 px-16">
			<h1 class="m-0"><span class="secondary-light">Pro</span><span class="white">-Book</span></h1>
			<form action="/index.php/logout" method="POST" class="d-flex flex-row">
				<p class="white m-0"><u>Hi, <?php echo $username; ?></u></p>
				<div class="anti-overlap ml-16"></div>
				<button class="position-absolute bg-secondary logout">
					<img src="/public/images/svg/power-button-off.svg" alt="Logout" height="20px">
				</button>
			</form>
		</header>
		<div class="menu d-flex">
			<a href="/index.php/home" class="flex-fill text-center bg-dark-primary white py-16">Browse</a>
			<a href="/index.php/history" class="flex-fill text-center bg-dark-primary white active py-16">History</a>
			<a href="/index.php/profile" class="flex-fill text-center bg-dark-primary white py-16">Profile</a>
		</div>
		<div class="content p-24">
			<div class="mb-24">
				<h1 class="secondary m-0">History</h1>
			</div>
			<?php
				foreach($orders as $item) {
			?>
			<div class="d-flex flex-row">
				<div class="image-overlap d-flex justify-content-center mr-24">
					<img src="<?php echo $item['image_path']; ?>" alt="<?php echo $item['title']; ?>">
				</div>
				<div class="d-flex justify-content-between w-100">
					<div class="d-flex flex-column">
						<h2 class="secondary m-0"><?php echo $item['title']; ?></h2>
						<p class="m-0 nowrap font-weight-light">Jumlah : <?php echo $item['quantity']; ?></p>
						<p class="m-0 nowrap font-weight-light"><?php echo $item['reviewed'] == 0 ? 'Belum direview' : 'Anda sudah memberikan review' ?></p>
					</div>
					<div class="d-flex flex-column text-right">
						<p class="m-0 nowrap font-weight-bold"><b><?php echo date("d F Y", strtotime($item['ordered_by']));; ?></b></p>
						<p class="m-0 nowrap font-weight-bold"><b>Nomor Order : #<?php echo $item['no_order']; ?></b></p>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-end mb-32">
				<?php
					if($item['reviewed'] == 0) {
				?>
				<a href="/index.php/review?id=<?php echo $item['no_order']; ?>&book-id=<?php echo $item['book_id']; ?>" class="btn btn-primary">Review</a>
				<?php
					}
				?>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</body>

</html>
