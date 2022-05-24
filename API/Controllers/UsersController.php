
<?php
  require_once('ControllerLib/ControllerWatch.php');
  require_once('ControllerHelper.php');
  require_once('../Models/UsersModel.php');
  require_once('../Models/DetaliiModel.php');
  require_once('../Serializers/UsersSerializer.php');
  
  $accepted_params_post = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  $required_params_post = array('username', 'fullname', 'password', 'date_salary');
  
  
  $accepted_params_update = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  $search_params = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  class UsersController {
    public static function get($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $page = 1;
      $per_page = 20;
      $orderBy = 'id';
      $orderType = 'ASC';
      $n_page = getCurrentUrlValue('page');
      $n_per_page = getCurrentUrlValue('per_page');
      if($n_page && is_numeric($page)) {
        $page = $n_page;
      }
      if($n_per_page && is_numeric($per_page)) {
        $per_page = $n_per_page;
      }
      $countRecords = 0;
      $isLike = getCurrentUrlValue('like');
      $newOrderBy = getCurrentUrlValue('orderBy');
      $newOrderType = getCurrentUrlValue('orderType');
      if($newOrderBy) {
        $orderBy = $newOrderBy;
      }
      if($newOrderType) {
        $orderType = $newOrderType;
      }
      $allRecords = array();
      $searchParams = array(
        "page" => $page,
        "per_page" => $per_page,
        "orderBy" => $orderBy,
        "orderType" => $orderType
      );
      if($isLike && ($isLike === "true" || $isLike === true)) {
        if(count($params) !== 1) {
          return array(
            "Error" => "Daca 'like' este activ, nu pot fi mai mult de 1 parametru!"
          );
        }
        $allRecords = generalLike($conn, 'Users', $params, $searchParams);
        $countRecords = generalLikeCount($conn, 'Users', $params, $searchParams);
      }
      else  {
        $allRecords = generalGet($conn, 'Users', $params, $searchParams);
        $countRecords = generalGetCount($conn, 'Users', $params, $searchParams);
      }
      $maxPages = intval($countRecords / $per_page) + ($countRecords % $per_page != 0);
      mysqli_close($conn);
      return array(
        "records" => UsersSerializer::each($conn, $allRecords),
        "count" => $countRecords,
        "totalPages" => $maxPages
      );
    }
    public static function getByID($params){
      $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $obj = Users::get($conn, array(
        "id" => $_SESSION['usr_id']
      ));
      if(!$obj){
        $conn->rollback();
        $id = $_SESSION['usr_id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Users cu id $id!"
        );
      }
      $details = Detalii::get($conn, array(
        "id_users" => $obj->id
      ));
      return array(
        "records" => array(
          "luna" => $luna,
          "status" => $status,
        ),
        "tables" => $pusculite
      );
      // aici am ramas, contruieste un alt tabel numit cashflow unde sa ai tot ce intra si tot ce iese
    }
    public static function post($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);

      $obj = Users::insert($conn, $params);
      if(!$obj) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut inregistra recordul Users!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return UsersSerializer::once($conn, $obj);
    }
    public static function update($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Users::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Users cu id $id!"
        );
      }
      unset($params['id']);
      if(!$obj->update($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut face update la recordul Users!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return UsersSerializer::once($conn, $obj);
    }
    public static function login($params){
      $conn = mysqli_connect();
      mysqli_select_db($conn, "budget_app");
      $obj = Users::get($conn, array(
        'username' => $params['username']
      ));
      if(!$obj) {
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Users cu id $id!"
        );
      }
      if($obj->password !== $params['password']) {
        return array(
          "Error" => "Parola gresita! Incearca din nou!"
        );
      }
      if(!isset($_SESSION)){
        session_start();
        connection_user($obj);
      }
      return UsersSerializer::once($conn, $obj);
    }
    public static function delete($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Users::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Users cu id $id!"
        );
      }
      if(!$obj->delete($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut sterge recordul Users!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return UsersSerializer::once($conn, $obj);
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(!isset($_SESSION)) {
      session_start();
    }
    if(!isset($_SESSION['usr_id'])){
      exit(401);
    }
    $params = array();
    foreach($search_params as $key) {
      $value = getCurrentUrlValue($key);
      if($value) {
        $params[$key] = $value;
      }
    }
    if(getCurrentUrlValue('user') && getCurrentUrlValue('user') == true) {
      $response = UsersController::getByID($params);
      if(array_key_exists("Error", $response)) {
        http_response_code(400);
        echo json_encode($response);
        return ;
      }
      echo json_encode($response);
      return ;
    }
    echo json_encode(UsersController::get($params));
    return ;
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = $_POST;
    if(getCurrentUrlValue('patch') && getCurrentUrlValue('patch') == true) {
      if(!isset($_SESSION)) {
        session_start();
      }
      if(!isset($_SESSION['usr_id'])){
        exit(401);
      }
      $errs = checkAcceptedParams($accepted_params_update, $_POST);
      if(strlen($errs)) {
        http_response_code(400);
        echo json_encode(array(
          "Error" => $errs
        ));
        return ;
      }
      $errs = checkRequiredParams($required_params_update, $_POST);
      if(strlen($errs)) {
        http_response_code(400);
        echo json_encode(array(
          "Error" => $errs
        ));
        return ;
      }
      $response = UsersController::update($params);
      if(array_key_exists("Error", $response)) {
        http_response_code(400);
        echo json_encode($response);
        return ;
      }
      echo json_encode($response);
      return ;
    }
    if(getCurrentUrlValue('logare') && getCurrentUrlValue('logare') == true) {
      $response = UsersController::login($params);
      if(array_key_exists("Error", $response)) {
        http_response_code(400);
        echo json_encode($response);
        return ;
      }
      echo json_encode($response);
      return ;
    }
    $errs = checkAcceptedParams($accepted_params_post, $_POST);
    if(strlen($errs)) {
      http_response_code(400);
      echo json_encode(array(
        "Error" => $errs
      ));
      return ;
    }
    $errs = checkRequiredParams($required_params_post, $_POST);
    if(strlen($errs)) {
      http_response_code(400);
      echo json_encode(array(
        "Error" => $errs
      ));
      return ;
    }
    if(!isset($_SESSION)) {
      session_start();
    }
    if(!isset($_SESSION['usr_id'])){
      exit(401);
    }
    $response = UsersController::post($params);
    if(array_key_exists("Error", $response)) {
      http_response_code(400);
      echo json_encode($response);
      return ;
    }
    echo json_encode($response);
    return ;
  }
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $params = $_GET;
    $errs = checkAcceptedParams($accepted_params_delete, $params);
    if(strlen($errs)) {
      http_response_code(400);
      echo json_encode(array(
        "Error" => $errs
      ));
      return ;
    }
    $errs = checkRequiredParams($required_params_delete, $params);
    if(strlen($errs)) {
      http_response_code(400);
      echo json_encode(array(
        "Error" => $errs
      ));
      return ;
    }
    $response = UsersController::delete($params);
    if(array_key_exists("Error", $response)) {
      http_response_code(400);
      echo json_encode($response);
      return ;
    }
    echo json_encode($response);
    return ;
  }
  http_response_code(401);
  echo json_encode($error_code);
  
?>
  