
<?php
  require_once('../Models/DetaliiModel.php');
  
  $general_params = array('id', 'id_pusculite', 'id_users', 'suma', 'tip', 'detalii', 'expected_date');
  
  function getSumAlocata($venit, $procentaj){
    return $venit * ($procentaj / 100);
  }
  function getSumFolosita($id, $detalii){
    $suma = 0;
    foreach($detalii as $dtl){
      if($dtl->id_pusculite == $id) {
        $suma += $dtl->suma; 
      }
    }
    return $suma;
  }
  
  class DetaliiSerializer {
    static function each($conn, $objects) {
      $response = array();
      foreach($objects as $obj) {
        array_push($response, array(
          'id' => $obj->id,
          'id_pusculite' => $obj->id_pusculite,
          'id_users' => $obj->id_users,
          'suma' => $obj->suma,
          'tip' => $obj->tip,
          'detalii' => $obj->detalii,
          'expected_date' =>date("d-m-y", strtotime($obj->expected_date)),
        ));
      }
      return $response;
    }
    static function eachCheltuieli($conn, $objects, $obj_pusculite) {
      $response = array();
      foreach($objects as $obj) {
        array_push($response, array(
          'id' => $obj->id,
          'nume_pusculite' => $obj_pusculite[$obj->id_pusculite]->denumire,
          'id_users' => $obj->id_users,
          'suma' => $obj->suma,
          'tip' => $obj->tip,
          'detalii' => $obj->detalii,
          'expected_date' => date("d-m-y", strtotime($obj->expected_date)),
        ));
      }
      return $response;
    }
    static function eachPusculite($conn, $objects, $sumaVenit, $detalii) {
      $response = array();
      foreach($objects as $obj) {
        $id = $obj->id;
        $suma_alocata = getSumAlocata($sumaVenit, $obj->procentaj);
        $suma_folosita = getSumFolosita($id, $detalii);
        // $suma_luna_anterioara = getSumPreviousMonth();
        array_push($response, array(
          'id' => $id,
          'pusculita_name' => $obj->id_pusculite,
          'id_users' => $obj->id_users,
          'suma_alocata' => $suma_alocata,
          'suma_folosita' => $obj->tip,
          'diferenta' => $obj->detalii,
          'suma_luna_anterioara' => date("d-m-y", strtotime($obj->expected_date)),
          'more_details' => "<div class='button-detalii' onclick='geMoreDetailds($obj->id)'>Details</div>",
        ));
      }
      return $response;
    }
    static function once($conn, $obj) {
      return array(
        'id' => $obj->id,
          'id_pusculite' => $obj->id_pusculite,
          'id_users' => $obj->id_users,
          'suma' => $obj->suma,
          'tip' => $obj->tip,
          'detalii' => $obj->detalii,
          'expected_date' => $obj->expected_date,
      );
    }
  }
  
?>
  