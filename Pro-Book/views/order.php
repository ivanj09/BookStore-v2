<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
    $book = $this->data['book'];
    $recommendedbooks = $this->data['recommendedbooks'];
    $username = $this->data['username'];
?>

<head>
  <meta charset="utf-8">
  <title>
    <?php echo $book->volumeInfo->title . ' - ' . implode(', ', $book->volumeInfo->authors); ?>
  </title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <link rel="stylesheet" href="/public/css/order.css" />
</head>

<body>
  <div class="order-notif">
    <div class="order-notif-container">
      <div class="order-notif-header">
        <div class="order-close-btn" onclick="this.parentNode.parentNode.parentNode.style.display='none';">
          &times;
        </div>
      </div>
      <div class="order-notif-body">
        <img class="p-8" src="/public/images/svg/order-success-icon.svg"/>
        <h1>Pemesanan berhasil!</h1>
        <p id="order-id" class="m-0"></p>
      </div>
    </div>
  </div>
  <div class="container w-60 pb-48">
    <?php include('__header.php') ?>
    <div class="menu d-flex">
      <a href="/index.php/home" class="flex-fill text-center bg-dark-primary active white py-16">Browse</a>
      <a href="/index.php/history" class="flex-fill text-center bg-dark-primary white py-16">History</a>
      <a href="/index.php/profile" class="flex-fill text-center bg-dark-primary white py-16">Profile</a>
    </div>
  </div>
  <div class="container w-60">
    <div id="book-image">
      <h3><?php echo $book->saleInfo->saleability; ?></h3>
      <img class="ml-16" src="<?php echo $book->volumeInfo->imageLinks->thumbnail ?>"/>
      <div class="rating p-4">
        <label>
          <?php
            for ($i = 0; $i < floor($book->volumeInfo->averageRating); $i++):
          ?>
              <img class="icon" src="/public/images/svg/rating-hover.svg" width="28px" height="28px"/>
          <?php
            endfor;
            for ($j = $i; $j < 5; $j++):
          ?>
              <img class="icon" src="/public/images/svg/rating.svg" width="28px" height="28px"/>
          <?php
            endfor;
          ?>
        </label>
        <p class="m-0 w-60" style="text-align: right">
          <?php echo round($book->volumeInfo->averageRating, 2, PHP_ROUND_HALF_DOWN); ?> / 5.0
        </p>
        <?php
          if ($book->saleInfo->saleability === "FOR_SALE"){
        ?>
            <h3 class="tertiary"><?php echo "Rp. " . $book->volumeInfo->price . ", -"; ?></h3>
        <?php
          }
        ?>
      </div>
    </div>
    <h1 class="secondary m-0 pl-16">
      <?php echo $book->volumeInfo->title; ?>
    </h1>
    <p class="m-4 pl-16">
      <?php echo implode(', ', $book->volumeInfo->authors); ?>
    </p>
    <div class="container w-60 m-0 pl-24 pt-24 pb-8">
      <p>
        <?php echo $book->volumeInfo->description; ?>
      </p>
    </div>
    <?php
      if ($book->saleInfo->saleability === "FOR_SALE"){
    ?>
        <div class="pl-16 ml-4 order-section">
          <h2 class="tertiary">Order</h2>
          <label class="mr-24">Jumlah: </label>
          <select id="qty">
            <?php
              for($i = 1; $i <= 99; $i++):
            ?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php
              endfor;
            ?>
          </select>
        </div>
        <div onclick="order()" class="btn-primary btn mb-48 mr-48 mt-16" style="float: right;">Order</div>
    <?php
      }
    ?>
  </div>
  <div class="container w-60 p-24 mt-24">
    <div class="pl-16 ml-4">
      <h2 class="tertiary">Reviews</h2>
      <!-- <?php
        // foreach ($reviews as $review):
      ?>
          <div class="review-section p-8">
            <div class="review">
              <img src="<?php echo $review['image_path'];?>" width="100px" height="100px"/>
              <label id="uname-review">@<?php echo $review['username'];?></label>
              <p id="comment">
                <?php echo $review['comment'];?>
              </p>
              <div class="rating" style="text-align: center">
                <img class="icon" src="/public/images/svg/rating-hover.svg" width="28px" height="28px"/>
              </div>
              <p id="rating-num">
                <?php echo $review['rating'];?>.0 / 5.0
              </p>
            </div>
          </div>
      <?php
        // endforeach;
      ?> -->
    </div>
    <div class="pl-16 ml-4">
      <h2 class="tertiary">Recommendation Books</h2>
      <div class="review-section p-8">
          <?php
            if ($recommendedbooks != null){
              foreach($recommendedbooks as $recommendedbook):
          ?>
            <div class="review pb-48">
              <img src="<?php echo $recommendedbook->volumeInfo->imageLinks->thumbnail;?>" width="100px" height="100px"/>
              <label id="uname">
                <?php echo $recommendedbook->volumeInfo->title . " - " . $recommendedbook->volumeInfo->authors[0];?>
              </label>
              <p id="comment">
                <?php echo $recommendedbook->volumeInfo->description;?>
              </p>
              <div class="rating" style="text-align: center">
                <img class="icon" src="/public/images/svg/rating-hover.svg" width="28px" height="28px"/>
              </div>
              <p id="rating-num">
                <?php echo $recommendedbook->volumeInfo->averageRating; ?> / 5.0
              </p>
            </div>
          <?php
              endforeach;
            } else {
              echo "Recommended books not found..";
            }
          ?>
      </div>
    </div>
  </div>
</body>
<script>
  function order() {
    const quantity = document.getElementById('qty').value;
    const bookId = <?php echo $data['book']['id']; ?>;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/index.php/apis/create-order`);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        console.log(xhr.responseText);
        const result = JSON.parse(xhr.responseText);
        var orderNotif = document.getElementsByClassName('order-notif')[0];
        var orderId = document.getElementById('order-id');
        orderNotif.style.display = 'block';
        orderId.innerHTML = 'Nomor transaksi: ' + result.order_id;
      } else {
        console.log('Request failed.  Returned status of ' + xhr.status);
      }
    };
    xhr.send(`book_id=${bookId}&quantity=${quantity}`);
  }
</script>

</html>
