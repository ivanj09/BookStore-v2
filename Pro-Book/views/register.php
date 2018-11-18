<html>
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
<head>
  <title>Register</title>
  <link rel="stylesheet" href="/public/css/main.css" />
  <script src="/public/js/validation.js"></script>
</head>
<body>
  <div class="bg-primary container w-40 mt-25 pt-8 pb-8" style="margin-top: 12.5vh">
    <form name="registerForm" class="form-group bg-polkadot ml-4 mr-4" action="/index.php/register" method="POST" onsubmit="event.preventDefault(); return validate();">
      <h1>REGISTER</h1>
      <div class="form-control m-8 pb-24">
        <label>Name</label>
        <input name="name" class="form-control" type="text" placeholder="name" autofocus>
      </div>
      <div class="form-control m-8 pb-24">
        <label>Username</label>
        <input type="hidden" id="usernameValid">
        <input type="text" class="form-control" id="usernameField" name="username" placeholder="username">
        <img id="usernameValidity" hidden class="validity"/>
      </div>
      <div class="form-control m-8 pb-24">
        <label>Email</label>
        <input type="hidden" id="emailValid">
        <input type="text" class="form-control" id="emailField" name="email" placeholder="email">
        <img id="emailValidity" hidden class="validity"/>
      </div>
      <div class="form-control m-8 pb-24">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="password">
      </div>
      <div class="form-control m-8 pb-32">
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="confirmation" placeholder="confirmation">
      </div>
      <div class="form-control m-8 pb-24">
        <label>Address</label>
        <input type="text" class="form-control" name="address" type="text" placeholder="address">
      </div>
      <div class="form-control m-8 pb-32">
        <label>Phone Number</label>
        <input type="text" class="form-control" name="phone" type="text" placeholder="phone">
      </div>
      <div class="form-control ml-24 p-8" style="text-align: left;">
        <a href="/index.php/login">Already have an account?</a>
      </div>
      <button type="submit" class="mb-16 button-secondary">REGISTER</button>
    </form>
  </div>
  <script>
    function validate() {
      let validity = (
        validation.required([
          document.registerForm.name,
          document.registerForm.username,
          document.registerForm.email,
          document.registerForm.password,
          document.registerForm.confirmation,
          document.registerForm.address,
          document.registerForm.phone,
        ])
      );

      if (validity.result) {
        validity = (
          validation.maxLen([
            document.registerForm.username,
          ], 20)
        );
      }

      if (validity.result) {
        validity = (
          validation.email([
            document.registerForm.email,
          ])
        );
      }

      if (validity.result) {
        validity = (
          validation.phone([
            document.registerForm.phone,
          ])
        );
      }

      if (validity.result) {
        validity = (
          validation.password([
            document.registerForm.password,
            document.registerForm.confirmation,
          ])
        );
      }

      const usernameValid = document.getElementById('usernameValid').value == 1;
      const emailValid = document.getElementById('emailValid').value == 1;

      if (validity.result && usernameValid && emailValid) {
        document.registerForm.submit();
      } else if (validity.message !== 'OK') {
        validation.display(validity.message);
      } else if (!usernameValid) {
        validation.display('username is already used');
      } else {
        validation.display('email is already used');
      }
    }

    document.getElementById('usernameField').onblur = function () {
      const value = this.value;
      const xhr = new XMLHttpRequest();
      const expValid = validation.required([
        document.registerForm.username,
      ]).result;
      xhr.open('GET', `/index.php/apis/validate-username?username=${value}`);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const available = JSON.parse(xhr.responseText).result;
          var img = document.getElementById('usernameValidity');
          if (expValid && available) {
            document.getElementById('usernameValid').value = 1;
            img.hidden = false;
            img.src = '/public/images/svg/check-sign.svg';
          } else {
            document.getElementById('usernameValid').value = 0;
            img.hidden = false;
            img.src = '/public/images/svg/remove-symbol.svg';
          };
        } else {
          console.log('Request failed.  Returned status of ' + xhr.status);
        }
      };
      xhr.send();
    };

    document.getElementById('emailField').onblur = function () {
      const value = this.value;
      const xhr = new XMLHttpRequest();
      const expValid = validation.email([
        document.registerForm.email,
      ]).result;
      xhr.open('GET', `/index.php/apis/validate-email?email=${value}`);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const available = JSON.parse(xhr.responseText).result;
          var img = document.getElementById('emailValidity');
          if (expValid && available) {
            document.getElementById('emailValid').value = 1;
            img.hidden = false;
            img.src = '/public/images/svg/check-sign.svg';
          } else {
            document.getElementById('emailValid').value = 0;
            img.hidden = false;
            img.src = '/public/images/svg/remove-symbol.svg';
          };
        } else {
          console.log('Request failed.  Returned status of ' + xhr.status);
        }
      };
      xhr.send();
    };
  </script>
</body>
</html>
