<?php
  require_once("header.php");
?>
<html>
  <head>
    <script src="scripts/pageLoader/pusculite.js" defer></script>
    <link rel="stylesheet" href="./css/styles.css">
  </head>
  <body>
    <div class='container'>
      <div class="title-class">
        <h1 class='title'>Pusculite</h1>
      </div>
      <div class="content-class">
        <div class='add-button' onclick='newPusculita()'>Adaugare de pusculite</div>
        <div class='total_class' id='total_id'></div>
        <table id ='table_id' class="styled-table" >
      </div>
      <div class='model' id='model'></div>
    </div>
    <div class="message-dialog" id="message_id"></div> 
  </body>
</html>