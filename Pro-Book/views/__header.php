<link rel="stylesheet" href="/public/css/home.css" />
<link rel="stylesheet" href="/public/css/main.css" />

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
