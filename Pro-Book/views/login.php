<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="/public/css/main.css" />
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
      </form>
    </div>
  </body>

  <script>
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
</html>
