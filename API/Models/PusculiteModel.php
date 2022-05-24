
<?php
  require_once('ActiveRecords/ActiveRecords.php');
  require_once('Extensions/PusculiteExtension.php');
  
  $accepted_params_post = array('id', 'denumire', 'procentaj', 'status', 'id_user');
  
  
  $required_params_post = array('denumire', 'procentaj', 'status', 'id_user');
  
  
  $accepted_params_update = array('id', 'denumire', 'procentaj', 'status', 'id_user');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  class Pusculite extends PusculiteExtension  {
    public $id;
    public $denumire;
    public $procentaj;
    public $status;
    public $id_user;
    static $valTypes = array(
      'id' => 'int','denumire' => 'varchar','procentaj' => 'int','status' => 'varchar','id_user' => 'int'
    );
  
    public static function get($conn, $params) {
      $self = new Pusculite;
      $response = getRecordByMulti($conn, $params, "budget_app", "pusculite", new Pusculite);
      if(!$response) {
        return NULL;
      } 
      
      if(array_key_exists("id", $response)) {
        $self->id = $response['id'];
      }
      if(array_key_exists("denumire", $response)) {
        $self->denumire = $response['denumire'];
      }
      if(array_key_exists("procentaj", $response)) {
        $self->procentaj = $response['procentaj'];
      }
      if(array_key_exists("status", $response)) {
        $self->status = $response['status'];
      }
      if(array_key_exists("id_user", $response)) {
        $self->id_user = $response['id_user'];
      }
      return $self;
    }  

    public static function all($conn) {
      $result = array();
      $response = allTrunked($conn, "budget_app", "pusculite", new Pusculite, self::$valTypes);
      return $response;
    }

    public static function where($conn, $params) {
      $result = array();
      $response = whereRecordByMultiTrunk($conn, $params, "budget_app", "pusculite", new Pusculite, self::$valTypes);
      return $response;
    }

    public function tranfer($records) {
      $result = array();
      for($i = 0; $i < count($records); $i++) {
        $self = new Pusculite;
        
      if(array_key_exists("id", $records[$i])) {
        $self->id = $records[$i]['id'];
      }
      if(array_key_exists("denumire", $records[$i])) {
        $self->denumire = $records[$i]['denumire'];
      }
      if(array_key_exists("procentaj", $records[$i])) {
        $self->procentaj = $records[$i]['procentaj'];
      }
      if(array_key_exists("status", $records[$i])) {
        $self->status = $records[$i]['status'];
      }
      if(array_key_exists("id_user", $records[$i])) {
        $self->id_user = $records[$i]['id_user'];
      }
        array_push($result, $self);
      }
      return $result;
    }

    public static function insertMulti($conn, $records) {
      $response = multiInsert($conn, "budget_app", "pusculite", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      return 1;
    }

    public static function updateByIdMulti($conn, $records) {
      $response = updateByIdMulti($conn, "budget_app", "pusculite", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $ids = array();
      foreach($records as $record) {
        array_push($ids, $record['id']);
      }
      return Pusculite::where($conn, array(
        "id" => $ids
      ));
    } 

    public static function insert($conn, $params) {
      $response = insertGeneral($conn, "budget_app", "pusculite", $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      
      return Pusculite::get($conn, array(
        'id' => $response[1]
      ));
    }

    public static function objectCount($conn, $clause) {
      return getCount($conn, "budget_app", "pusculite", $clause);
    }

    public function update($conn, $params) {
      $new = Pusculite::get($conn, array(
        "id" => $this->id
      ));
      if(!$new) {
        return 0;
      }
      $response = updateById($conn, "budget_app", "pusculite", "id", $new->id, $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $new = Pusculite::get($conn, array(
        "id" => $this->id
      ))->to_array();
      
      if(array_key_exists("id", $new)) {
        $this->id = $new['id'];
      }
      if(array_key_exists("denumire", $new)) {
        $this->denumire = $new['denumire'];
      }
      if(array_key_exists("procentaj", $new)) {
        $this->procentaj = $new['procentaj'];
      }
      if(array_key_exists("status", $new)) {
        $this->status = $new['status'];
      }
      if(array_key_exists("id_user", $new)) {
        $this->id_user = $new['id_user'];
      }
      return 1;
    } 

    public static function pluck($conn, $param, $array) {
      $response = array();
      for($index = 0; $index < count($array); $index++) {
        $current_object = $array[$index]->to_array();
        if(array_key_exists($param, $current_object)) {
          array_push($response, $current_object[$param]);
        }
      }
      return $response;
    } 

    public function delete($conn) {
      $current = Pusculite::get($conn, array(
        "id" => $this->id
      ));
      if(!$current) {
        return 0;
      }
      $current = $current->to_array();
      
      if(array_key_exists("id", $current)) {
        $this->id = $current['id'];
      }
      if(array_key_exists("denumire", $current)) {
        $this->denumire = $current['denumire'];
      }
      if(array_key_exists("procentaj", $current)) {
        $this->procentaj = $current['procentaj'];
      }
      if(array_key_exists("status", $current)) {
        $this->status = $current['status'];
      }
      if(array_key_exists("id_user", $current)) {
        $this->id_user = $current['id_user'];
      }
      $response = deleteRecordBy($conn, "budget_app", "pusculite", "id", $current["id"]);
      return $response[0];
    } 

    public static function execute($conn, $params) {
    } 

    public static function map_to_object($conn, $params) {
      $self = new Pusculite;
      
      if(array_key_exists("id", $params)) {
        $self->id = $params['id'];
      }
      if(array_key_exists("denumire", $params)) {
        $self->denumire = $params['denumire'];
      }
      if(array_key_exists("procentaj", $params)) {
        $self->procentaj = $params['procentaj'];
      }
      if(array_key_exists("status", $params)) {
        $self->status = $params['status'];
      }
      if(array_key_exists("id_user", $params)) {
        $self->id_user = $params['id_user'];
      }
      return $self;
    }

    public function save($conn) {

    }

    public function to_array() {
      return get_object_vars($this);
    } 
  }
  
?>
  