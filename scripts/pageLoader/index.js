function fetchData(){
  let id = {
    "getStatus" : true,
  };
  getQuery(`API/Controllers/DetaliiController.php`, id, submitSuccessRecieveData, submitFail);
}
function submitSuccessRecieveData(response) {
  const body = document.getElementById('status_month');
  const add_params = `
  <div>
    <div class="cod-title">Luna: ${response["luna"]}</div>
    <div class="input-groups">Status: ${response["status"]}</div>
  </div>
`;
  createCustomElement(body,add_params);
  const serializerVenit = transformResponseToTableData(response["records_venit"], {
    "id": "Nr de ordine",
    "detalii": "Detalii",
    "expected_date": "Data",
    "suma": "Suma"
  })
  constructTable("table_id_venit", serializerVenit)
  document.getElementById("venit_id").innerText = 'Venit';
  const serializerCheltuieli = transformResponseToTableData(response["records_cheltuieli"], {
    "id" : "Nr de ordine",
    "nume_pusculite" : "Pusculita",
    "detalii" : "Detalii",
    "expected_date" : "Data",
    "suma" : "Suma"
  })
  constructTable("table_id_cheltuieli", serializerCheltuieli)
  if(document.getElementById("table_id_cheltuieli")){
    document.getElementById("cheltuieli_id").innerText = 'Cheltuieli';
  }
  const serializerPusculite = transformResponseToTableData(response["records_pusculite"], {
    "id" : "Nr de ordine",
    "pusculita_name" : "Pusculita",
    "suma_alocata" : "Suma Alocata",
    "suma_folosita" : "Suma Folosita",
    "diferenta" : "Diferenta",
    "suma_luna_anterioara" : "Suma Anterioara Folosita"
  })
  let interval = setTimeout(constructTable("table_id_pusculite", serializerPusculite), 100000);
  clearTimeout(interval);
}
function submitFail(response) {
  openMessage("Fail", `Au aparut urmatoarele erori: ${response['Error']}`, "close", "noPage");
}
fetchData();