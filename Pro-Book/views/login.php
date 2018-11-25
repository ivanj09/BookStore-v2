<html>
  <head>
    <title>Login</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="515763841802-0fa4ri4h0is7fd90376493b3lu6desao.apps.googleusercontent.com">
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
    <div class="bg-primary container w-40 mt-25 pt-8 pb-8" style="margin-top: 25vh;">
      <form name="loginForm" class="form-group bg-polkadot ml-4 mr-4" action="/index.php/login" method="POST" onsubmit="event.preventDefault(); return validate();">
        <h1>Login</h1>
        <div class="form-control m-16 pb-16">
          <label>Username</label>
          <input type="text" name="username" autofocus />
        </div>
        <div class="form-control m-16 pb-16">
          <label>Password</label>
          <input type="password" name="password" />
        </div>
        <div class="form-control ml-24 p-8" style="text-align: left;">
          <a href="/index.php/register">Don't have an account?</a><br />
        </div>
        <button type="submit" class="mb-16 button-secondary">Login</button>
        <div class="form-control pb-16" style="width: 22.5%; margin: auto;">
          <div class="g-signin2" data-onsuccess="onSignIn"></div>
        </div>
      </form>
    </div>
  </body>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

  <script>
    function signOut() {
      var auth2 = gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        console.log('User signed out.');
      });
    }
    function onSignIn(user){
      var profile = user.getBasicProfile();
      jQuery.ajax({
        type: "POST",
        url: '/index.php/loginbygoogle',
        data: {'username': profile.getId(), 'name': profile.getName(), 'image_path': profile.getImageUrl(), 'email': profile.getEmail()}
      })

      window.location.replace("/index.php/home");
    }
    function validate() {
      const validity = (
        validation.required([
          document.loginForm.username,
          document.loginForm.password,
        ])
      );

      if (validity.result) {
        document.loginForm.submit();
      } else {
        validation.display(validity.message);
      }
    }
  </script>
  <link rel="stylesheet" href="/public/css/main.css" />
  <script src="/public/js/validation.js"></script>
</html>
