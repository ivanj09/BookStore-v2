<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
    $order = $this->data['order'];
    $username = $this->data['username'];
  ?>

<head>
  <meta charset="utf-8">
  <title>
    <?php echo 'Review - ' . $order['title'];?>
  </title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/review.css" />
  <script src="/public/js/validation.js"></script>
</head>

<body>
  <?php
    Session::start();
    if (Session::exist('message')):
  ?>
    <div class="alert-box">
      <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p><?php echo Session::get('message'); ?></p>
    </div>
  <?php
    Session::unset('message');
    endif;
  ?>
  <div class="container w-60">
    <?php include('__header.php') ?>
    <div class="menu d-flex">
      <a href="/index.php/home" class="flex-fill text-center bg-dark-primary white py-16">Browse</a>
      <a href="/index.php/history" class="flex-fill text-center bg-dark-primary active white py-16">History</a>
      <a href="/index.php/profile" class="flex-fill text-center bg-dark-primary white py-16">Profile</a>
    </div>
    <h1 class="secondary pl-16 pr-16 pt-16">
      <?php echo $order['title']?>
    </h1>
    <p class="pl-16 m-4">
      <?php echo $order['author']?>
    </p>
    <form name="addReview" class="form-group p-32" action="/index.php/review" method="POST" onsubmit="return validate();" style="text-align: left;">
      <div id="book-img-wrapper" class="form-control pl-32 m-16 pb-16">
        <img src="<?php echo $order['image_path']; ?>" />
      </div>
      <div class="form-control m-16 pb-16">
        <h2 class="tertiary">Add Rating</h2>
        <div class="rating">
          <label>
            <input type="radio" name="rating" value="5" onchange="setStar();"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
          </label>
          <label>
            <input type="radio" name="rating" value="4" onchange="setStar();"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
          </label>
          <label>
            <input type="radio" name="rating" value="3" onchange="setStar();"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
          </label>
          <label>
            <input type="radio" name="rating" value="2" onchange="setStar();"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
          </label>
          <label>
            <input type="radio" name="rating" value="1" onchange="setStar();"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
            <img class="icon" src="/public/images/svg/rating.svg" width="36px" height="36px"/>
          </label>
        </div>
      </div>
      <div class="form-control m-16 pb-24">
        <h2 class="tertiary">Add Comment</h2>
        <textarea class="mb-24" name="comment" rows="7" style="width: 100%"></textarea>
      </div>
      <div class="form-control m-16 pt-24">
        <button type="button" class="button-secondary" style="float: left;" onclick="location.href='/index.php/history';">BACK</button>
        <button type="submit" class="button-primary mb-48" style="float: right;">SUBMIT</button>
      </div>
      <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>"/>
    </form>
  </div>
</body>

<script>
  function setStar(){
    var input = document.getElementsByTagName('input');
    var i = -1;

    if (input[0].checked == true){
      i = 0;
    } else if (input[1].checked == true){
      i = 1;
    } else if (input[2].checked == true){
      i = 2;
    } else if (input[3].checked == true){
      i = 3;
    } else if (input[4].checked == true){
      i = 4;
    }

    for (var j = 4; j > i; j--){
      var label = document.getElementsByTagName('label');
      var images = label[j].getElementsByTagName('img');

      for (var k = 0; k < images.length; k++){
        images[k].src = "/public/images/svg/rating-hover.svg";
      }
    }

    for (; i > 0; i--){
      var label = document.getElementsByTagName('label');
      var images = label[i].getElementsByTagName('img');

      for (var k = 0; k < images.length; k++){
        images[k].src = "/public/images/svg/rating.svg";
      }
    }
  }

  function validate(){
    if (validation.required([document.addReview.comment])['result'] &&
        document.addReview.rating.value !== ''){
        return true;
    }

    var message = '';
    if (!validation.required([document.addReview.comment])['result']){
      message = validation.required([
        document.addReview.comment,
      ])['message'] + ', ';
    }

    if (document.addReview.rating.value === ''){
      message += 'rating is required';
    }

    var alertBox = document.getElementsByClassName('alert-box')[0];

    if (alertBox != null){
      document.body.removeChild(document.body.firstChild);
    }

    let div = document.createElement('div');
    div.className = "alert-box";
    div.innerHTML = '<span class="close-btn" onclick="this.parentElement.style.display=\'none\';">&times;</span><p>' +
                    message + '</p>';
    document.body.insertBefore(div, document.getElementsByClassName('container')[0]);

    return false;
  }
</script>

</html>
