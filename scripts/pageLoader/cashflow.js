function fetchData(){
  let id = {
    "like" : true,
  };
  getQuery(`API/Controllers/DetaliiController.php`, id, submitSuccessRecieveData, submitFail);
}

function postSuccess(response){
  openMessage("Success", `Actiune realizata cu succes!`, "reload", "index.php");
}

function submitFail(response) {
  openMessage("Fail", `Au aparut urmatoarele erori: ${response['Error']}`, "close", "noPage");
}

function addCashflow(){
  let dataToUpdate = getForm("new_cahflow");
  postQuery(`API/Controllers/DetaliiController.php`, dataToUpdate, submitSuccess, submitFail);
}

function newCashflow(){
  const body = document.getElementById("model");
  body.style.display = "block";
  add_param = `
    <div class="model-content">
      <form action="javascript:" data-role="validator" id="new_cahflow">
        <div><input type='text' name='detalii' class='modal-input' placeholder="Denumire"></div>
        <div><input type='number' name='suma' class='modal-input' placeholder="Suma"></div>
        <div><select name='tip' class='modal-input' onchange="createID()"><option value="venit">Venit</option><option value="cheltuiala">Cheltuiala</option></select></div>
        <div id="id_pusculite"></div>
        <div><input type='date' name='expected_date' class='modal-input'></div>
        <div class='model-button' onclick='addCashflow()'>Add</div>
      </form>
    </div>
  `;
  createCustomElement(body, add_param);
  window.onclick = function(event) {
    if (event.target == body) {
      body.style.display = "none";
    }
  }
}
function createID(){
  createCustomElement(document.getElementById('id_pusculite'), `<input type='text' name='id_pusculite' class='modal-input' placeholder="id_pusculite"></input>`);
}
function submitSuccessRecieveData(response) {
  // document.getElementById("total_id").innerText = `Total Procentaj: ${response['total_procentaj']}`;
  const serializer = transformResponseToTableData(response["records"], {
    "id": "Nr de ordine",
    "id_pusculite" : "Numele pusculitei",
    "suma": "Suma",
    "tip": "Tip",
    "detalii": "Detalii",
    "expected_date": "Data",
  })
  constructTable("table_id", serializer)
}
function submitSuccess() {
  openMessage("Success", `Actiune realizata cu succes!`, "reload", "index.php");
}
fetchData();