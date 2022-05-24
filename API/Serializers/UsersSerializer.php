
<?php
  require_once('../Models/UsersModel.php');
  
  $general_params = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  class UsersSerializer {
    static function each($conn, $objects) {
      $response = array();
      foreach($objects as $obj) {
        array_push($response, array(
          'id' => $obj->id,
          'username' => $obj->username,
          'fullname' => $obj->fullname,
          'password' => $obj->password,
          'isAdmin' => $obj->isAdmin,
          'created_at' => $obj->created_at,
          'date_salary' => $obj->date_salary,
        ));
      }
      return $response;
    }
    static function once($conn, $obj) {
      return array(
        'id' => $obj->id,
          'username' => $obj->username,
          'fullname' => $obj->fullname,
          'password' => $obj->password,
          'isAdmin' => $obj->isAdmin,
          'created_at' => $obj->created_at,
          'date_salary' => $obj->date_salary,
      );
    }
  }
  
?>
  