function imap(records, by) {
  let response = {};
  for(let i = 0; i < records.length; i++) {
    if(!(by in records)) {
      response[records[i][by]] = [];
    }
    response[records[i][by]].push(records[i]);
  }
  return response;
}

function createElementFromHTML(htmlString) {
  var div = document.createElement('div');
  div.innerHTML = htmlString.trim();
  return div.firstChild; 
}

function addOptionToSelect(id, optionName) {
  const current = document.getElementById(id);
  if(current) {
    current.appendChild(createElementFromHTML(
      `<option value='${optionName}'>${optionName}</option>`
    ));
    return 1;
  }
  return 0;
}

function getParamBy(url, field) {
  var url_string = url;
  var url = new URL(url_string);
  return url.searchParams.get(field);
}

function redirectToPage(path) {
  window.location.href = path;
}

function setForm(id, dataObject) {
  const element = document.getElementById(id)
  if(element) {
    setChilds(element, dataObject)
  }
}

function setChilds(obj, data) {
  if(obj.tagName == "INPUT") {
    if(data[obj.name]) {
      obj.value = data[obj.name];
    }
    return ;
  }
  for(let i = 0; i < obj.childNodes.length; i++) {
    setChilds(obj.childNodes[i], data)
  }
}

function getForm(id) {
  const form = document.getElementById(id);
  if(!form) {
    return null;
  }
	const formData = new FormData(form);
  const dataToSend = {};
  for(let x of formData.entries()) {
    if(x[1].length) {
      dataToSend[x[0]] = x[1];
    }
  }
  return dataToSend;
}

function rand() {
  seed = (seed * 1103515245 + 12345) % (1<<30);
  return Math.floor(seed / 65536) % 32768;
}

function addFieldsToTable(currentFields) {
  let currentColumn = document.getElementById("filter")
  if(currentColumn) {
    currentColumn = currentColumn.value;
  }
  let innerFields = "";
  const element = document.getElementById("valueID");
  let specialString = "";
  if(element) {
    specialString = element.value;
  }
  currentFields.forEach(cell => {
    let cellString = cell[0].toString();
    if(currentColumn && cell[1] === currentColumn && specialString.length) {
      let cll = JSON.parse(JSON.stringify(cellString));
      let specialStringCopy = JSON.parse(JSON.stringify(specialString));
      let index = cll.toLowerCase().indexOf(specialStringCopy.toLowerCase());
      if(index !== -1) {
        cellString = cellString.slice(0, index) + `<span style="background-color:blue; color: white; font-size: 16px;">${cellString.slice(index, index + specialString.length)}</span>` + cellString.slice(index + specialString.length, cellString.length)
      }
    }
    innerFields += `<td>${cellString}</td>`
  });
  return innerFields;
}

function aquireSpinner(id) {
  const element = document.getElementById(id)
  if(element) {
    element.innerHTML = ''
    element.appendChild(createElementFromHTML(`
      <div class='spinner-bot'>
        <div class="loader"></div>
        <div>Se calculeaza</div>
      </div>
    `))
    return 1;
  }
  return 0;
}

function throwErrorBox(id, message) {
  const element = document.getElementById(id)
  if(element) {
    element.innerHTML = ''
    element.appendChild(createElementFromHTML(`
      <div class='error-parent'>
        <div class='error-box'>
          <div class='error-box-title'>
            Eroare
          </div>
          <div class='error-box-message'>
            ${message}
          </div>
        </div>
      </div>
    `))
    return 1;
  }
  return 0;
}

function releaseSpinner(id) {
  const element = document.getElementById(id);
  if(element) {
    element.innerHTML = '';
    return 1;
  }
  return 0;
}

function getKeysAsTableNames(records, acceptedParams) {
  let response = [];
  for (const [key, _] of Object.entries(records)) {
    if(acceptedParams[key] !== undefined) {
      response.push(acceptedParams[key]);
    }
  }
  return addNamesToTable(response);
}

function getValuesAsTableValues(records, acceptedParams) {
  let responseFields = [];
  for (const [key, value] of Object.entries(records)) {
    if(acceptedParams[key] !== undefined) {
      if(value) {
        responseFields.push([value, key]);
      }
      else {
        responseFields.push(["", key]);
      }
    }
  }
  return addFieldsToTable(responseFields);
}


function eachRow(rows, rowsData, functionClass) {
  let response = "";
  let index = 0;
  if(functionClass === null) {
    functionClass = function(row) {
      return "";
    }
  }
  if(rowsData && !rowsData.length) {
    return "";
  }
  if(rows instanceof Array) {
    rows.forEach(element => {
      response += 
      `
        <tr ${functionClass(rowsData[index])}>
          ${element}
        </tr>
      `;
      index++;
    })  
  }
  else {
    response = 
    `
    <tr ${classToAdd(rows)} id=${randomID}>
      ${rows}
    </tr>
    `
  }
  return response
}

function serializeData(jsonData, serializer) {
  if(jsonData.constructor.name == "Array") {
    let response = []
    for(let i = 0; i < jsonData.length; i++) {
      let record = {};
      for(const [key, value] of Object.entries(serializer)) {
        if(key in jsonData[i]) {
          record[value] = jsonData[i][key];
        }
      }
      response.push(record);
    }
    return response;
  }
  let record = {};
  for(const [key, value] of Object.entries(serializer)) {
    if(key in jsonData[i]) {
      record[value] = jsonData[i][key];
    }
  }
  return record;
}

function serializeTable(input, acceptedParams) {
  if(input && !input.length) {
    return []
  }
  if(input.constructor === Object) {
    return [getKeysAsTableNames(input, acceptedParams), getValuesAsTableValues(input, acceptedParams)];
  }
  const multiRecords = (input, acceptedParams) => {
    let response = [];
    input.forEach(element => {
      response.push(getValuesAsTableValues(element, acceptedParams));
    });
    return response;
  }
  return [getKeysAsTableNames(input[0], acceptedParams), multiRecords(input, acceptedParams)];
}

function addNamesToTable(names) {
  let innerFields = "";
  names.forEach(name => {
    innerFields += `<th data-sortable="true" class="bg-delonghi">${name}</th>`;
  });
  return innerFields;
}

function makeid(length) {
  var result           = [];
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
    result.push(characters.charAt(Math.floor(Math.random() * 
    charactersLength)));
 }
 return result.join('');
}

function parseExcel(file, processFunction) {
  var reader = new FileReader();
  reader.onload = function(e) {
    var data = e.target.result;
    var workbook = XLSX.read(data, {
      type: 'binary'
    });

    workbook.SheetNames.forEach(function(sheetName) {
      var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
      var json_object = XL_row_object;
      processFunction(json_object);
    })
  };
  reader.onerror = function(ex) {
    Metro.dialog.create({
      title: "Succes",
      content: "<div> A aparut o eroare in procesarea documentului! </div>",
      actions: [
        {
          caption: "Ok",
          cls: "js-dialog-close alert",
          onclick: function(){
            window.location.reload();
          }
        }
      ]
    });
  };
  reader.readAsBinaryString(file);
};

function interpolateBetween(source, target, percent) {
  let R = (target[0] - source[0]) * percent + source[0];
  let G = (target[1] - source[1]) * percent + source[1];
  let B = (target[2] - source[2]) * percent + source[2];
  return `rgb(${R}, ${G}, ${B}, 0.5)`;
}

function extractData(jsonData, toExtract) {
  if(jsonData.constructor.name == "Array") {
    let response = []
    for(let i = 0; i < jsonData.length; i++) {
      let record = {};
      for(let j = 0; j < toExtract.length; j++) {
        if(toExtract[j] in jsonData[i]) {
          record[toExtract[j]] = jsonData[i][toExtract[j]];
        }
      }
      response.push(record);
    }
    return response;
  }
  let record = {};
  for(let j = 0; j < toExtract.length; j++) {
    if(toExtract[j] in jsonData) {
      record[toExtract[j]] = jsonData[toExtract[j]];
    }
  }
  return record;
}

function dictToParams(params) {
  let response = [];
  for(const [key, value] of Object.entries(params)) {
    response.push(`${key}=${value}`);
  }
  return response.length ? `?${response.join('&')}` : '';
}

function createCustomElement(body, param_add){
  if(body){
    body.innerHTML = "";
  }
  body.appendChild(createElementFromHTML(param_add));
}
function openMessage(title, message, action, page){
  body = document.getElementById("message_id");
  param = `
  <div class="modal-content">
    <div class="modal-title-${title}">${title}</div>
    <div class="modal-message">${message}</div>
    <div class="modal-button" onclick='buttonModal("${action}", "${page}")'>OK</div>
  </div>
  `;
  createCustomElement(body, param);
  body.style.display = "block";
}
function buttonModal(action, page) {  
  if(action == "reload"){
    window.location.reload();
  }
  if(action == "redirect"){
    redirectToPage(page);
  }
  body = document.getElementById("message_id");
  body.style.display = "none";
}