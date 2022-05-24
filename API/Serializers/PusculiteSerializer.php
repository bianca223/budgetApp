
<?php
  require_once('../Models/PusculiteModel.php');
  
  $general_params = array('id', 'status', 'id_user');
  
  
  class PusculiteSerializer {
    static function each($conn, $objects) {
      $response = array();
      foreach($objects as $obj) {
        array_push($response, array(
          'id' => $obj->id,
          'denumire' => $obj->denumire,
          'procentaj' => $obj->procentaj,
          'status' => $obj->status,
          'id_user' => $obj->id_user,
          'update_button' => "<div class='button-update' onclick='updatePusculitaGet($obj->id)'>U</div>",
          'delete_button' => "<div class='button-delete' onclick='deletePusculita($obj->id)'> × </div>",
        ));
      }
      return $response;
    }
    static function once($conn, $obj) {
      return array(
        'id' => $obj->id,
        'denumire' => $obj->denumire,
        'procentaj' => $obj->procentaj,
        'status' => $obj->status,
        'id_user' => $obj->id_user,
      );
    }
    static function getForUp($conn, $obj){
      return array(
        'id' => $obj->id,
        'denumire' => "<input type='text' name='denumire' placeholder=$obj->denumire class='modal-input'>",
        'procentaj' => "<input type='text' name='procentaj' placeholder=$obj->procentaj class='modal-input'>",
        'status' => "<input type='text' name='status' placeholder=$obj->status class='modal-input'>",
      );
    }
  }
  
?>
  