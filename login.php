<?php
?>
<html>
  <head>
    <script src="scripts/utils.js" ></script>
    <script src="scripts/externals/utils.js" ></script>
    <script src="scripts/pageLoader/login.js" defer></script>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/modals.css">
  </head>
  <body>
    <div class="container">
      <div class="login">
        <h1 class='login-title'>Login</h1>
        <form action="javascript:" data-role="validator" id="log_in">
          <input type="text" name="username" class="login-input" placeholder="Username" required>
          <input type="password" name="password" class="login-input" placeholder="Password" required>
          <input type="submit" class="login-button" value="Login" onclick="getUsersData()">
          <p class="login-text">Don't have an account? <a class="login-a" href="sign_in.php">Sign up now</a>.</p>
        </form>
      </div>
      <div class="message-dialog" id="message_id"></div> 
    </div>
  </body>
</html>