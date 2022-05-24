<php 
?>
<html lang="en">
  <head>
    <script src="scripts/pageLoader/sign_in.js"></script>
    <script src="scripts/externals/utils.js"></script>
    <script src="scripts/utils.js"></script>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="./css/modals.css">
  </head>
  <body>
    <div class="container">
      <div class="login">
        <h1 class='login-title'>SignUp</h1>
        <form action="javascript:" data-role="validator" id="sign_in">
          <input type="text" name="username" class="login-input" placeholder="Username" required>
          <input type="text" name="fullname" class="login-input" placeholder="Nume Complet">
          <input type="password" name="password" class="login-input" placeholder="Password">
          <label class="login-text">Date of next salary:</label>
          <input type="date" name="date_salary" class="login-input">
          <input type="submit" class="login-button" onclick="getUsersData()">
          <p class="login-text" >Already have an account? <a class="login-a" href="login.php">Login here</a>.</p>
        </form>
      </div>
      <div class="message-dialog" id="message_id"></div> 
    </div>    
  </body>
</html>