
<?php
  require_once('ActiveRecords/ActiveRecords.php');
  require_once('Extensions/DetaliiExtension.php');
  
  $accepted_params_post = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  $required_params_post = array('id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  $accepted_params_update = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  class Detalii extends DetaliiExtension  {
    public $id;
    public $id_pusculite;
    public $id_users;
    public $suma;
    public $tip;
    public $detalii;
    public $expected_date;
    static $valTypes = array(
      'id' => 'int','id_pusculite' => 'int','id_users' => 'int','suma' => 'int','tip' => 'varchar','detalii' => 'varchar','expected_date' => 'timestamp'
    );
  
    public static function get($conn, $params) {
      $self = new Detalii;
      $response = getRecordByMulti($conn, $params, "budget_app", "detalii", new Detalii);
      if(!$response) {
        return NULL;
      } 
      
      if(array_key_exists("id", $response)) {
        $self->id = $response['id'];
      }
      if(array_key_exists("id_pusculite", $response)) {
        $self->id_pusculite = $response['id_pusculite'];
      }
      if(array_key_exists("id_users", $response)) {
        $self->id_users = $response['id_users'];
      }
      if(array_key_exists("suma", $response)) {
        $self->suma = $response['suma'];
      }
      if(array_key_exists("tip", $response)) {
        $self->tip = $response['tip'];
      }
      if(array_key_exists("detalii", $response)) {
        $self->detalii = $response['detalii'];
      }
      if(array_key_exists("expected_date", $response)) {
        $self->expected_date = $response['expected_date'];
      }
      return $self;
    }  

    public static function all($conn) {
      $result = array();
      $response = allTrunked($conn, "budget_app", "detalii", new Detalii, self::$valTypes);
      return $response;
    }

    public static function where($conn, $params) {
      $result = array();
      $response = whereRecordByMultiTrunk($conn, $params, "budget_app", "detalii", new Detalii, self::$valTypes);
      return $response;
    }

    public function tranfer($records) {
      $result = array();
      for($i = 0; $i < count($records); $i++) {
        $self = new Detalii;
        
      if(array_key_exists("id", $records[$i])) {
        $self->id = $records[$i]['id'];
      }
      if(array_key_exists("id_pusculite", $records[$i])) {
        $self->id_pusculite = $records[$i]['id_pusculite'];
      }
      if(array_key_exists("id_users", $records[$i])) {
        $self->id_users = $records[$i]['id_users'];
      }
      if(array_key_exists("suma", $records[$i])) {
        $self->suma = $records[$i]['suma'];
      }
      if(array_key_exists("tip", $records[$i])) {
        $self->tip = $records[$i]['tip'];
      }
      if(array_key_exists("detalii", $records[$i])) {
        $self->detalii = $records[$i]['detalii'];
      }
      if(array_key_exists("expected_date", $records[$i])) {
        $self->expected_date = $records[$i]['expected_date'];
      }
        array_push($result, $self);
      }
      return $result;
    }

    public static function insertMulti($conn, $records) {
      $response = multiInsert($conn, "budget_app", "detalii", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      return 1;
    }

    public static function updateByIdMulti($conn, $records) {
      $response = updateByIdMulti($conn, "budget_app", "detalii", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $ids = array();
      foreach($records as $record) {
        array_push($ids, $record['id']);
      }
      return Detalii::where($conn, array(
        "id" => $ids
      ));
    } 

    public static function insert($conn, $params) {
      $response = insertGeneral($conn, "budget_app", "detalii", $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      
      return Detalii::get($conn, array(
        'id' => $response[1]
      ));
    }

    public static function objectCount($conn, $clause) {
      return getCount($conn, "budget_app", "detalii", $clause);
    }

    public function update($conn, $params) {
      $new = Detalii::get($conn, array(
        "id" => $this->id
      ));
      if(!$new) {
        return 0;
      }
      $response = updateById($conn, "budget_app", "detalii", "id", $new->id, $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $new = Detalii::get($conn, array(
        "id" => $this->id
      ))->to_array();
      
      if(array_key_exists("id", $new)) {
        $this->id = $new['id'];
      }
      if(array_key_exists("id_pusculite", $new)) {
        $this->id_pusculite = $new['id_pusculite'];
      }
      if(array_key_exists("id_users", $new)) {
        $this->id_users = $new['id_users'];
      }
      if(array_key_exists("suma", $new)) {
        $this->suma = $new['suma'];
      }
      if(array_key_exists("tip", $new)) {
        $this->tip = $new['tip'];
      }
      if(array_key_exists("detalii", $new)) {
        $this->detalii = $new['detalii'];
      }
      if(array_key_exists("expected_date", $new)) {
        $this->expected_date = $new['expected_date'];
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
      $current = Detalii::get($conn, array(
        "id" => $this->id
      ));
      if(!$current) {
        return 0;
      }
      $current = $current->to_array();
      
      if(array_key_exists("id", $current)) {
        $this->id = $current['id'];
      }
      if(array_key_exists("id_pusculite", $current)) {
        $this->id_pusculite = $current['id_pusculite'];
      }
      if(array_key_exists("id_users", $current)) {
        $this->id_users = $current['id_users'];
      }
      if(array_key_exists("suma", $current)) {
        $this->suma = $current['suma'];
      }
      if(array_key_exists("tip", $current)) {
        $this->tip = $current['tip'];
      }
      if(array_key_exists("detalii", $current)) {
        $this->detalii = $current['detalii'];
      }
      if(array_key_exists("expected_date", $current)) {
        $this->expected_date = $current['expected_date'];
      }
      $response = deleteRecordBy($conn, "budget_app", "detalii", "id", $current["id"]);
      return $response[0];
    } 

    public static function execute($conn, $params) {
    } 

    public static function map_to_object($conn, $params) {
      $self = new Detalii;
      
      if(array_key_exists("id", $params)) {
        $self->id = $params['id'];
      }
      if(array_key_exists("id_pusculite", $params)) {
        $self->id_pusculite = $params['id_pusculite'];
      }
      if(array_key_exists("id_users", $params)) {
        $self->id_users = $params['id_users'];
      }
      if(array_key_exists("suma", $params)) {
        $self->suma = $params['suma'];
      }
      if(array_key_exists("tip", $params)) {
        $self->tip = $params['tip'];
      }
      if(array_key_exists("detalii", $params)) {
        $self->detalii = $params['detalii'];
      }
      if(array_key_exists("expected_date", $params)) {
        $self->expected_date = $params['expected_date'];
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
  