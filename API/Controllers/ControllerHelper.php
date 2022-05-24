<?php
  
  function connection_user($obj){
    $_SESSION['usr_id'] = $obj->id;
    $_SESSION['usr_username'] = $obj->username;
    $_SESSION['usr_fullname'] = $obj->fullname;
    $_SESSION['is_Admin'] = $obj->isAdmin;
    return 1;
  }
?>