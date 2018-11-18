<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  $user = $this->data['user'];
  $username = $user['username'];
?>

<head>
  <meta charset="utf-8">
  <title>
    <?php echo $user['name'];?>
  </title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/profile.css" />
</head>

<body>
  <?php
    Session::start();
    if (Session::exist('message')):
  ?>
    <div class="info-dialog" style="position: absolute; left: 30%;">
      <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p><?php echo Session::get('message'); ?></p>
    </div>
  <?php
    Session::unset('message');
    endif;
  ?>
  <div class="container w-60 pl-32 pr-32">
    <?php include('__header.php') ?>
    <div class="menu d-flex">
			<a href="/index.php/home" class="flex-fill text-center bg-dark-primary white py-16">Browse</a>
			<a href="/index.php/history" class="flex-fill text-center bg-dark-primary white py-16">History</a>
			<a href="/index.php/profile" class="flex-fill text-center bg-dark-primary active white py-16">Profile</a>
		</div>
  </div>
  <div class="top-profile bg-display-pic container w-60 pt-32 pb-32">
    <a href="/index.php/profile/edit">
      <img class="pencil-icon pr-24"/>
    </a>
    <img class="display-pic" src="<?php echo $user['image_path']; ?>" width="128px" height="128px" />
    <h1><?php echo $user['name']; ?></h1>
  </div>
  <div class="container w-60 pb-48">
    <h1 class="secondary p-16">My Profile</h1>
    <div class="container w-40 pb-48">
      <div class="profile">
        <img class="mr-24" src="/public/images/svg/user-shape.svg" height="16px" width="16px" />
        <label class="label">Username</label>
        <label class="value">
          <?php echo $user['username'];?></label>
      </div>
    </div>
    <div class="container w-40 pb-48">
      <div class="profile">
        <img class="mr-24" src="/public/images/svg/envelope.svg" height="16px" width="16px" />
        <label class="label">Email</label>
        <label class="value">
          <?php echo $user['email'];?></label>
      </div>
    </div>
    <div class="container w-40 pb-48">
      <div class="profile">
        <img class="mr-24" src="/public/images/svg/home.svg" height="16px" width="16px" />
        <label class="label">Address</label>
        <label class="value">
          <?php echo $user['address'];?></label>
      </div>
    </div>
    <div class="container w-40">
      <div class="profile">
        <img class="mr-24" src="/public/images/svg/telephone-handle-silhouette.svg" height="16px" width="16px" />
        <label class="label">Phone Number</label>
        <label class="value">
          <?php echo $user['phone_number'];?></label>
      </div>
    </div>
  </div>
</body>

</html>
