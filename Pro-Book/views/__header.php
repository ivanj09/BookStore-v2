<link rel="stylesheet" href="/public/css/home.css" />
<link rel="stylesheet" href="/public/css/main.css" />

<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
<meta name="google-signin-client_id" content="515763841802-0fa4ri4h0is7fd90376493b3lu6desao.apps.googleusercontent.com">

<header class="navbar d-flex justify-content-between align-items-center position-relative bg-primary py-8 px-16">
  <h1 class="m-0"><span class="secondary-light">Pro</span><span class="white">-Book</span></h1>
  <form action="/index.php/logout" method="POST" class="d-flex flex-row">
    <p class="white m-0"><u>Hi, <?php echo $username; ?></u></p>
    <div class="anti-overlap ml-16"></div>
    <button class="position-absolute bg-secondary logout" onclick="signOut();">
      <img src="/public/images/svg/power-button-off.svg" alt="Logout" height="20px">
    </button>
  </form>
</header>

<script>
  function onLoad() {
    gapi.load('auth2', function() {
      gapi.auth2.init();
    });
  }

  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('signed out!');
    });
  }
</script>
