<?php
  require_once("header.php");
?>
<html>
  <head>
    <script src="scripts/pageLoader/cashflow.js" defer></script>
    <link rel="stylesheet" href="./css/styles.css">
  </head>
  <body>
    <div class='container'>
      <div class="title-class">
        <h1 class='title'>Cashflow</h1>
      </div>
      <div class="content-class">
        <div class='add-button' onclick='newCashflow()'>Adaugare</div>
        <table id ='table_id' class="styled-table" >
      </div>
      <div class='model' id='model'></div>
    </div>
    <div class="message-dialog" id="message_id"></div> 
  </body>
</html>