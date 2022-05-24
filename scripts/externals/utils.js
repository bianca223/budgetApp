
function createElementFromHTML(htmlString) {
  var div = document.createElement('div');
  div.innerHTML = htmlString.trim();
  return div.firstChild; 
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
    if(data[obj.name] !== undefined) {
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
async function postQueryAsync(url, params) {
  const response = await fetch(url, {
    method: 'POST',
    mode: 'cors',
    cache: 'no-cache',
    credentials: 'same-origin',
    body: params
  });
  return response.json();
}
function dictToForm(dict) {
  let formData = new FormData();
  for(const [key, value] of Object.entries(dict)) {
    formData.append(key, value)
  }
  return formData;
}
function redirectResponseTo(response, callbackSucces, callbackFail) {
  if(response['Error']) {
    callbackFail(response)
    return ;
  }
  callbackSucces(response)
}
function postQuery(url, params, callbackSucces, callbackFail) {
  postQueryAsync(url, dictToForm(params)).then((response) => redirectResponseTo(response, callbackSucces, callbackFail))
}
function dictToParams(params) {
  let response = [];
  for(const [key, value] of Object.entries(params)) {
    response.push(`${key}=${value}`);
  }
  return response.length ? `?${response.join('&')}` : '';
}
async function getQueryAsync(url) {
  const response = await fetch(url, {
    method: 'GET',
    mode: 'cors',
    cache: 'no-cache',
    credentials: 'same-origin'
  });
  return response.json();
}
async function deleteQueryAsync(url) {
  const response = await fetch(url, {
    method: 'DELETE',
    mode: 'cors',
    cache: 'no-cache',
    credentials: 'same-origin'
  });
  return response.json();
}
function deleteQuery(url, params, callbackSucces, callbackFail) {
  deleteQueryAsync(`${url}${dictToParams(params)}`, dictToForm(params)).then((response) => redirectResponseTo(response, callbackSucces, callbackFail))
}
function getQuery(url, params, callbackSucces, callbackFail) {
  getQueryAsync(`${url}${dictToParams(params)}`, dictToForm(params)).then((response) => redirectResponseTo(response, callbackSucces, callbackFail))
}
// function openPopup(type, message, callback=null, actions=null) {
//   Metro.dialog.create({
//     title: type,
//     content: `<div> ${message} </div>`,
//     actions: actions == null ? ([
//       {
//         caption: "Ok",
//         cls: "js-dialog-close alert",
//         onclick: (!callback ? function(){
//           window.location.reload();
//         } : callback)
//       }
//     ]) : actions
//   });
// }

function getHead(headData) {
  let headResponse = '';
  for(let i = 0; i < headData.length; i++) {
    headResponse += `
      <th> ${headData[i]} </th>
    `;
  }
  return `
    <thead>
      <tr>
        ${headResponse}
      </tr>
    </thead>
  `
}

function getBody(headData) {
  let headResponse = '';
  for(let i = 0; i < headData.length; i++) {
    let currentRow = ``;
    for(let j = 0; j < headData[i].length; j++) {
      currentRow += `
        <td>${headData[i][j]}</td>
      `;
    }
    headResponse += `
      <tr>${currentRow}</tr>
    `
  }
  return `
    <tbody>
      ${headResponse}
    </tbody>
  `
}

function constructTable(id, data) {
  const tableDOM = document.getElementById(id);
  if(!tableDOM) {
    return ;
  }
  if(!('header' in data) || !('payload' in data)) {
    tableDOM.appendChild(createElementFromHTML(`
      <div class='remark warning text-bold'>Nu exista inregistrari care sa respecte filtrele</div>
    `))
    return ;
  }
  let tableData = `
    <table class = 'table table-border cell-border subcompact' data-role="table">
      ${getHead(data['header'])}
      ${getBody(data['payload'])}
    </table>
  `
  tableDOM.appendChild(createElementFromHTML(tableData))
}

function transformResponseToTableData(data, fieldHeaders = {}) {
  if(!data.length) {
    return [];
  }
  let headData = [], realHeadData = [];
  for(const [key, _] of Object.entries(data[0])) {
    if(key in fieldHeaders) {
      headData.push(fieldHeaders[key]);
      realHeadData.push(key)
    }
  }
  let bodyData = [];
  for(let i = 0; i < data.length; i++) {
    let currentRow = [];
    for(let j = 0; j < realHeadData.length; j++) {
      currentRow.push(data[i][realHeadData[j]]);
    }
    bodyData.push(currentRow)
  }
  return {
    "header": headData,
    "payload": bodyData
  };
}

