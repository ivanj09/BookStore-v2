<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  $user = $this->data['user'];
  $username = $user['username'];
?>

<head>
  <meta charset="utf-8">
  <title>
    <?php echo "Edit Profile - " . $user['name'];?>
  </title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/profile.css" />
  <script src="/public/js/validation.js"></script>
</head>

<body>
  <?php
    Session::start();
    if (Session::exist('message')){
  ?>
    <div class="alert-box">
      <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p><?php echo Session::get('message'); ?></p>
    </div>
  <?php
    }
    Session::unset('message');
  ?>
  <div class="container w-60 pl-32 pr-32">
    <?php include('__header.php') ?>
    <div class="menu d-flex">
			<a href="/index.php/home" class="flex-fill text-center bg-dark-primary white py-16">Browse</a>
			<a href="/index.php/history" class="flex-fill text-center bg-dark-primary white py-16">History</a>
			<a href="/index.php/profile" class="flex-fill text-center bg-dark-primary active white py-16">Profile</a>
		</div>
  </div>
  <div class="container w-60">
    <h1 class="secondary pt-16">Edit Profile</h1>
    <form name="editProfile" class="form-group p-32" action="/index.php/profile/edit" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); return validate();">
      <input type="hidden" name="_method" value="PUT">
      <div class="form-control ml-48 pb-24" style="clear: both; content: ''; display: table">
        <img src="<?php echo $user['image_path']; ?>"/>
        <label class="update-profile-label pb-8" style="width: 50%; margin: 0;">Update Profile Picture</label>
        <br>
        <input id="upload-path" type="text">
        <button onclick="upload()">Browse...</button>
        <input id="uploader" type="file" name="image" accept="image/*" style="display: none">
      </div>
      <div class="form-control m-16 pb-24">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $user['name'];?>" autofocus>
      </div>
      <div class="form-control m-16">
        <label>Address</label>
        <textarea class="mb-24" name="address" rows="5"><?php echo $user['address'];?></textarea>
      </div>
      <div class="form-control m-16 pb-24">
        <label>Phone Number</label>
        <input class="mb-48" name="phone" value="<?php echo $user['phone_number'];?>">
      </div>
      <div class="form-control m-16">
        <button type="button" class="button-secondary" style="float: left;" onclick="location.href='/index.php/profile';">Back</button>
        <button type="submit" class="button-primary mb-48" style="float: right;">Save</button>
      </div>
    </form>
  </div>
</body>
<script>
  function validate() {
    let validity = (
      validation.required([
        document.editProfile.name,
        document.editProfile.address,
        document.editProfile.phone,
      ])
    );

    if (validity.result) {
      validity = (
        validation.phone([
          document.editProfile.phone,
        ])
      );
    }

    if (validity.result) {
      document.editProfile.submit();
    } else {
      validation.display(validity.message);
    }
  }

  function upload() {
    event.preventDefault();
    document.getElementById('uploader').click();
    document.getElementById('uploader').addEventListener("input", function () {
      document.getElementById('upload-path').value = this.value.split(/(\\|\/)/g).pop();
    });
  }
</script>
</html>
