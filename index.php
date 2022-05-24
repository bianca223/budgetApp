<?php
  require_once("header.php");
?>
<html>
  <head>
    <script src="scripts/pageLoader/index.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body>
    <div class='container'>
      <div class="title-class">
        <h1 class='title'>Budget</h1>
      </div>
      <div class="content-class">
        <div class="text_mediu" id="status_month"></div>
        <div class="content-child">
          <div class="content-child-header">
            <div class="text_special" id="venit_id"></div>
            <div class="text_special" id="cheltuieli_id"></div>
          </div>
          <div class="content-child-right">
            <table id ='table_id_venit' class="styled-table" >
            <table id ='table_id_cheltuieli' class="styled-table" > 
          </div>
          <div class="table_for_pusculite">
            <table id ='table_id_pusculite' class="styled-table" > 
          </div>
        </div>
      </div>
      <div class='model' id='model'></div>
    </div>
    <div class="message-dialog" id="message_id"></div> 
  </body>
</html>