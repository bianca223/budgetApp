function fetchData(){
  let id = {
    "like" : true,
  };
  getQuery(`API/Controllers/PusculiteController.php`, id, submitSuccessRecieveData, submitFail);
}

function updatePusculitaGet(id){
  let newid = {
    "update" : true,
    "id" : id
  }
  getQuery(`API/Controllers/PusculiteController.php`, newid, submitSuccessUpdate, submitFail);
}

function updatePusculita(id){
  let dataToUpdate = getForm("update_pusculita");
  dataToUpdate["id"] = id;
  postQuery(`API/Controllers/PusculiteController.php?patch=true`, dataToUpdate, submitSuccess, submitFail);
}

function addPusculita(){
  let dataToUpdate = getForm("new_pusculita");
  postQuery(`API/Controllers/PusculiteController.php`, dataToUpdate, submitSuccess, submitFail);
}

function deletePusculita(id){
  deleteQuery("API/Controllers/PusculiteController.php", {
    id: id
  }, () => submitSuccess(), submitFail)
}

function newPusculita(){
  const body = document.getElementById("model");
  body.style.display = "block";
  add_param = `
    <div class="model-content">
      <form action="javascript:" data-role="validator" id="new_pusculita">
        <div><input type='text' name='denumire' class='modal-input' placeholder="Denumire"></div>
        <div><input type='text' name='procentaj' class='modal-input' placeholder="Procentaj"></div>
        <div class='model-button' onclick='addPusculita()'>Add</div>
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

function submitSuccessUpdate(response){
  const body = document.getElementById("model");
  body.style.display = "block";
  add_param = `
    <div class="model-content">
      <form action="javascript:" data-role="validator" id="update_pusculita">
        <div>Denumire: ${response["denumire"]}</div>
        <div>Procentaj: ${response["procentaj"]}</div>
        <div>Status: ${response["status"]}</div>
        <div class='model-button' onclick='updatePusculita(${response["id"]})'>Update</div>
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

function submitSuccessRecieveData(response) {
  document.getElementById("total_id").innerText = `Total Procentaj: ${response['total_procentaj']}`;
  const serializer = transformResponseToTableData(response["records"], {
    "id": "Nr de ordine",
    "denumire": "Denumire",
    "procentaj": "Procentaj",
    "status": "Status",
    "delete_button": "Delete",
    "update_button": "Update"
  })
  constructTable("table_id", serializer)
}

function submitSuccess() {
  openMessage("Success", `Actiune realizata cu succes!`, "reload", "index.php");
}

function submitFail(response) {
  openMessage("Fail", `Au aparut urmatoarele erori: ${response['Error']}`, "close", "noPage");
}
fetchData();