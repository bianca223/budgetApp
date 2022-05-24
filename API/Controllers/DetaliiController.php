
<?php
  require_once('ControllerLib/ControllerWatch.php');
  require_once('../Models/DetaliiModel.php');
  require_once('../Models/PusculiteModel.php');
  require_once('../Serializers/DetaliiSerializer.php');
  
  $accepted_params_post = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  $required_params_post = array('suma', 'tip', 'detalii', 'expected_date');
  
  
  $accepted_params_update = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  $search_params = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  class DetaliiController {
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
        $allRecords = generalLike($conn, 'Detalii', $params, $searchParams);
        $countRecords = generalLikeCount($conn, 'Detalii', $params, $searchParams);
      }
      else  {
        $allRecords = generalGet($conn, 'Detalii', $params, $searchParams);
        $countRecords = generalGetCount($conn, 'Detalii', $params, $searchParams);
      }
      $maxPages = intval($countRecords / $per_page) + ($countRecords % $per_page != 0);
      mysqli_close($conn);
      return array(
        "records" => DetaliiSerializer::each($conn, $allRecords),
        "count" => $countRecords,
        "totalPages" => $maxPages
      );
    }
    public static function getStatus($params) {

      $conn = mysqli_connect();
    
        mysqli_select_db($conn, "budget_app");
        $conn->autocommit(FALSE);
        $luna = intval(date("n"));
        $allRecords = Detalii::all($conn)->whereRaw("YEAR(expected_date) = ? AND MONTH(expected_date) = ? AND id_users = ?", [intval(date("Y")), $luna, $params['id_users']])->fetch();
        if(!$allRecords) {
          $conn->rollback();
          return array(
            "Error" => "Nu s-a putut gasi niciun record pe aceasta luna!"
          );
        }
        $records_venit = array();
        $records_cheltuieli = array();
        $sumaVenit = 0;
        $sumaCheltuieli = 0;
        foreach($allRecords as $all){       
          if($all->tip == "v"){
            array_push($records_venit, $all);
            $sumaVenit += $all->suma;
          } else {
            array_push($records_cheltuieli, $all);
            $sumaCheltuieli += $all->suma;
          }
        }
        $obj_pusculite = imap(Pusculite::where($conn, array(
          "id_user" => $params['id_users']
        ))->fetch(), "id");
        $diferenta = $sumaCheltuieli - $sumaVenit;
        if($diferenta > 0 ){
          $status = "Luna asta te-ai intins cu $diferenta";
        } else if($diferenta < 0){
          $aux = abs($diferenta);
          $status = "Luna asta inca mai poti face shopping pentru $aux";
        } else {
          $status = "Luna asta esti mega norocos! Esti la fix!";
        }
        $return = array(
          "records_venit" => DetaliiSerializer::each($conn, $records_venit),
          "records_cheltuieli" => DetaliiSerializer::eachCheltuieli($conn, $records_cheltuieli, $obj_pusculite),
          "records_pusculite" => DetaliiSerializer::eachPusculite($conn, $obj_pusculite, $sumaVenit, $allRecords),
          "luna" => $luna,
          "status" => $status
        );
        $conn->commit();
        mysqli_close($conn);
        return $return;
      }
    public static function post($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $params["id_users"] = $_SESSION['usr_id'];
      $obj = Detalii::insert($conn, $params);
      if(!$obj) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut inregistra recordul Detalii!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return DetaliiSerializer::once($conn, $obj);
    }
    public static function update($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Detalii::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Detalii cu id $id!"
        );
      }
      unset($params['id']);
      if(!$obj->update($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut face update la recordul Detalii!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return DetaliiSerializer::once($conn, $obj);
    }
    public static function delete($params) {
      
    $conn = mysqli_connect();
  
      mysqli_select_db($conn, "budget_app");
      $conn->autocommit(FALSE);
      $obj = Detalii::get($conn, array(
        'id' => $params['id']
      ));
      if(!$obj) {
        $conn->rollback();
        $id = $params['id'];
        return array(
          "Error" => "Nu s-a putut gasi recordul obiectului Detalii cu id $id!"
        );
      }
      if(!$obj->delete($conn, $params)) {
        $conn->rollback();
        return array(
          "Error" => "Nu s-a putut sterge recordul Detalii!"
        );
      }
      $conn->commit();
      mysqli_close($conn);
      return DetaliiSerializer::once($conn, $obj);
    }
  }
  // function getAllWithPusculite($obj_pusculite, $sumaVenit, $detalii){
  //   // echo json_encode($obj_pusculite);
  //   // exit();
  //   foreach($detalii as $dtl){
  //     if()
  //   }
  //   return array(
  //     "denumire" => $obj_pusculite->denumire,
  //     "procentaj" => $obj_pusculite->procentaj,
  //     "suma_alocata" => 
  //   )
  // }
  if(!isset($_SESSION)) {
    session_start();
  }
  if(!isset($_SESSION['usr_username'])){
    exit(401);
  }
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = array();
    if(getCurrentUrlValue('getStatus') && getCurrentUrlValue('getStatus') == true){
      $params['id_users'] = $_SESSION['usr_id'];
      echo json_encode(DetaliiController::getStatus($params));
      return ;  
    }
    foreach($search_params as $key) {
      $value = getCurrentUrlValue($key);
      if($value) {
        $params[$key] = $value;
      }
    }
    $params['id_users'] = $_SESSION['usr_id'];
    echo json_encode(DetaliiController::get($params));
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
      $response = DetaliiController::update($params);
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
    $response = DetaliiController::post($params);
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
    $response = DetaliiController::delete($params);
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
  