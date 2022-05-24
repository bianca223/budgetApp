
<?php
  require_once('ActiveRecords/ActiveRecords.php');
  require_once('Extensions/UsersExtension.php');
  
  $accepted_params_post = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  $required_params_post = array('username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  $accepted_params_update = array('id', 'username', 'fullname', 'password', 'isAdmin', 'created_at', 'date_salary');
  
  
  $required_params_update = array('id');
  
  
  $accepted_params_delete = array('id');
  
  
  $required_params_delete = array('id');
  
  
  class Users extends UsersExtension  {
    public $id;
    public $username;
    public $fullname;
    public $password;
    public $isAdmin;
    public $created_at;
    public $date_salary;
    static $valTypes = array(
      'id' => 'int','username' => 'varchar','fullname' => 'varchar','password' => 'varchar','isAdmin' => 'varchar','created_at' => 'datetime','date_salary' => 'timestamp'
    );
  
    public static function get($conn, $params) {
      $self = new Users;
      $response = getRecordByMulti($conn, $params, "budget_app", "users", new Users);
      if(!$response) {
        return NULL;
      } 
      
      if(array_key_exists("id", $response)) {
        $self->id = $response['id'];
      }
      if(array_key_exists("username", $response)) {
        $self->username = $response['username'];
      }
      if(array_key_exists("fullname", $response)) {
        $self->fullname = $response['fullname'];
      }
      if(array_key_exists("password", $response)) {
        $self->password = $response['password'];
      }
      if(array_key_exists("isAdmin", $response)) {
        $self->isAdmin = $response['isAdmin'];
      }
      if(array_key_exists("created_at", $response)) {
        $self->created_at = $response['created_at'];
      }
      if(array_key_exists("date_salary", $response)) {
        $self->date_salary = $response['date_salary'];
      }
      return $self;
    }  

    public static function all($conn) {
      $result = array();
      $response = allTrunked($conn, "budget_app", "users", new Users, self::$valTypes);
      return $response;
    }

    public static function where($conn, $params) {
      $result = array();
      $response = whereRecordByMultiTrunk($conn, $params, "budget_app", "users", new Users, self::$valTypes);
      return $response;
    }

    public function tranfer($records) {
      $result = array();
      for($i = 0; $i < count($records); $i++) {
        $self = new Users;
        
      if(array_key_exists("id", $records[$i])) {
        $self->id = $records[$i]['id'];
      }
      if(array_key_exists("username", $records[$i])) {
        $self->username = $records[$i]['username'];
      }
      if(array_key_exists("fullname", $records[$i])) {
        $self->fullname = $records[$i]['fullname'];
      }
      if(array_key_exists("password", $records[$i])) {
        $self->password = $records[$i]['password'];
      }
      if(array_key_exists("isAdmin", $records[$i])) {
        $self->isAdmin = $records[$i]['isAdmin'];
      }
      if(array_key_exists("created_at", $records[$i])) {
        $self->created_at = $records[$i]['created_at'];
      }
      if(array_key_exists("date_salary", $records[$i])) {
        $self->date_salary = $records[$i]['date_salary'];
      }
        array_push($result, $self);
      }
      return $result;
    }

    public static function insertMulti($conn, $records) {
      $response = multiInsert($conn, "budget_app", "users", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      return 1;
    }

    public static function updateByIdMulti($conn, $records) {
      $response = updateByIdMulti($conn, "budget_app", "users", $records, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $ids = array();
      foreach($records as $record) {
        array_push($ids, $record['id']);
      }
      return Users::where($conn, array(
        "id" => $ids
      ));
    } 

    public static function insert($conn, $params) {
      $response = insertGeneral($conn, "budget_app", "users", $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      
      return Users::get($conn, array(
        'id' => $response[1]
      ));
    }

    public static function objectCount($conn, $clause) {
      return getCount($conn, "budget_app", "users", $clause);
    }

    public function update($conn, $params) {
      $new = Users::get($conn, array(
        "id" => $this->id
      ));
      if(!$new) {
        return 0;
      }
      $response = updateById($conn, "budget_app", "users", "id", $new->id, $params, self::$valTypes);
      if(!$response[0]) {
        return 0;
      }
      $new = Users::get($conn, array(
        "id" => $this->id
      ))->to_array();
      
      if(array_key_exists("id", $new)) {
        $this->id = $new['id'];
      }
      if(array_key_exists("username", $new)) {
        $this->username = $new['username'];
      }
      if(array_key_exists("fullname", $new)) {
        $this->fullname = $new['fullname'];
      }
      if(array_key_exists("password", $new)) {
        $this->password = $new['password'];
      }
      if(array_key_exists("isAdmin", $new)) {
        $this->isAdmin = $new['isAdmin'];
      }
      if(array_key_exists("created_at", $new)) {
        $this->created_at = $new['created_at'];
      }
      if(array_key_exists("date_salary", $new)) {
        $this->date_salary = $new['date_salary'];
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
      $current = Users::get($conn, array(
        "id" => $this->id
      ));
      if(!$current) {
        return 0;
      }
      $current = $current->to_array();
      
      if(array_key_exists("id", $current)) {
        $this->id = $current['id'];
      }
      if(array_key_exists("username", $current)) {
        $this->username = $current['username'];
      }
      if(array_key_exists("fullname", $current)) {
        $this->fullname = $current['fullname'];
      }
      if(array_key_exists("password", $current)) {
        $this->password = $current['password'];
      }
      if(array_key_exists("isAdmin", $current)) {
        $this->isAdmin = $current['isAdmin'];
      }
      if(array_key_exists("created_at", $current)) {
        $this->created_at = $current['created_at'];
      }
      if(array_key_exists("date_salary", $current)) {
        $this->date_salary = $current['date_salary'];
      }
      $response = deleteRecordBy($conn, "budget_app", "users", "id", $current["id"]);
      return $response[0];
    } 

    public static function execute($conn, $params) {
    } 

    public static function map_to_object($conn, $params) {
      $self = new Users;
      
      if(array_key_exists("id", $params)) {
        $self->id = $params['id'];
      }
      if(array_key_exists("username", $params)) {
        $self->username = $params['username'];
      }
      if(array_key_exists("fullname", $params)) {
        $self->fullname = $params['fullname'];
      }
      if(array_key_exists("password", $params)) {
        $self->password = $params['password'];
      }
      if(array_key_exists("isAdmin", $params)) {
        $self->isAdmin = $params['isAdmin'];
      }
      if(array_key_exists("created_at", $params)) {
        $self->created_at = $params['created_at'];
      }
      if(array_key_exists("date_salary", $params)) {
        $self->date_salary = $params['date_salary'];
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
  