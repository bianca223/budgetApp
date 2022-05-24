
<?php
  require_once('ControllerLib/ControllerWatch.php');
  require_once('../Models/PusculiteModel.php');
  require_once('../Serializers/PusculiteSerializer.php');
  
  $accepted_params_post = array('id', 'denumire','procentaj','status', 'id_user');
  
  
  $required_params_post = array('denumire', 'procentaj');
  
  
  $accepted_params_update = array('id', 'denumire', 'status', 'id_user');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  $search_params = array('id', 'denumire', 'procentaj', 'status', 'id_user');
  
  
  class PusculiteController {
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
        $allRecords = generalLike($conn, 'Pusculite', $params, $searchParams);
        $countRecords = generalLikeCount($conn, 'Pusculite', $params, $searchParams);
      }
      else  {
        $allRecords = generalGet($conn, 'Pusculite', $params, $searchParams);
        $countRecords = generalGetCount($conn, 'Pusculite', $params, $searchParams);
      }
      $total_percentage = 0;
      foreach($allRecords as $all){
        $total_percentage += $all->procentaj;
      }
      $maxPages = intval($countRecords / $per_page) + ($countRecords % $per_page != 0);
      $response = array(
        "records" => PusculiteSerializer::each($conn, $allRecords),
        "total_procentaj" => $total_percentage,
        "count" => $countRecords,
        "totalPages" => $maxPages
      );
      mysqli_close($conn);
      return $response;
    }
    public static function getForUpdate($params){
      $conn = mysqli_connect();
      mysqli_select_db($conn, "budget_app");
      $obj = Pusculite::get($conn, array(
        'id' => $params['id']
      ));
      $reponse = PusculiteSerializer::getForUp($conn, $obj);
      mysqli_close($conn);
      return $reponse;
    }
    public static function post($params) {
      
      $conn = mysqli_connect();
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $params['id_user'] = $_SESSION['usr_id'];
      $params['status'] = 'activ';
      $pusculite_all = Pusculite::where($conn, array(
        "id_user" => $params['id_user']
      ))->fetch();
      $total_percentage = 0;
      foreach($pusculite_all as $pall){
        $total_percentage +=  $pall->procentaj;
      }
      if($total_percentage + $params['procentaj'] > 100){
        $dif = ( $total_percentage + $params['procentaj']) - 100;
        $conn->rollback();
        return array(
          "Error" => "Procentajul este prea mare! Diferenta este cu $dif mai mare!"
        );
      }
      $obj = Pusculite::insert($conn, $params);
      if(!$obj) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut inregistra recordul Pusculite!"
        );
      }
      $conn->commit();
      $reponse = PusculiteSerializer::once($conn, $obj);
      mysqli_close($conn);
      return $reponse;
    }
    public static function update($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Pusculite::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Pusculite cu id $id!"
        );
      }
      unset($params['id']);
      if(!$obj->update($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut face update la recordul Pusculite!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return PusculiteSerializer::once($conn, $obj);
    }
    public static function delete($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Pusculite::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Pusculite cu id $id!"
        );
      }
      if(!$obj->delete($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut sterge recordul Pusculite!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return PusculiteSerializer::once($conn, $obj);
    }
  }
  if(!isset($_SESSION)) {
    session_start();
  }
  if(!isset($_SESSION['usr_username'])){
    exit(401);
  }
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = array();
    foreach($search_params as $key) {
      $value = getCurrentUrlValue($key);
      if($value) {
        $params[$key] = $value;
      }
      
    }
    $params['id_user'] = $_SESSION['usr_id'];
    if(getCurrentUrlValue('update') && getCurrentUrlValue('update') == true){
      echo json_encode(PusculiteController::getForUpdate($params));
      return ;
    }
    echo json_encode(PusculiteController::get($params));
    return ;
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = $_POST;
    if(getCurrentUrlValue('patch') && getCurrentUrlValue('patch') == true) {
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
      $response = PusculiteController::update($params);
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
    $response = PusculiteController::post($params);
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
    $response = PusculiteController::delete($params);
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
  