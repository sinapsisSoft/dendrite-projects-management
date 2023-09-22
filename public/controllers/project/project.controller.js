showPreload();

$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada', 'Proyecto creado exitosamente', 'Proyecto actualizado exitosamente', 'Proyecto eliminado exitosamente', 'El proyecto no pudo ser eliminado. Revise si éste ya contiene seguimientos u actividades asociadas');
const ruteContent = "project/";
const nameModel = 'projects';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'Project_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';
const infoUrl = 'https://ior.ad/9jjF';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function getManagerByClient() {
  document.getElementById('Client_id')
    .addEventListener('change', function () {
      const data = new FormData();
      const value = document.getElementById('Client_id').value;
      const url = `${BASE_URL}manager/findByClient`;
      data['clientId'] = value;
      disableFormProject();
      fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest"
        }
      })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
          if (response[dataResponse] == 200) {
            const managers = response[dataModel];
            const managerSelect = document.getElementById('Manager_id');
            enableFormProject(managerSelect);            
            managerSelect.innerHTML = "";
            managerSelect.innerHTML += "<option value=''>Seleccione...</option>";
            managers.map(item => {
              managerSelect.innerHTML += `<option value="${item.Manager_id}">${item.Manager_name}</option>`;
            });
            getCityByClient();
          } else {
            Swal.fire(
              '¡No pudimos hacer esto!',
              arMessages[0],
              'error'
            )
          }
          hidePreload();
        });
    })
}

function getCityByClient(){
  const data = new FormData();
  const clientId = document.getElementById('Client_id').value;
  data['clientId'] = clientId;
  const url = `${BASE_URL}client/findCountry`;
  fetch(url, {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        let countryClient = response[dataModel];
        const country = document.getElementById('Country_id');
        country.innerHTML = "";
        countryClient.map(item => {
          country.innerHTML += `<option value="${item.Country_id}" selected>${item.Country_name}</option>`;
        });
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        )
      }
      hidePreload();
    });
  
}

function getBrandByManager() {
  document.getElementById('Manager_id')
    .addEventListener('change', function () {
      const data = new FormData();
      const value = document.getElementById('Manager_id').value;
      const url = `${BASE_URL}brand/findByManager`;
      data['managerId'] = value;
      fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest"
        }
      })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
          if (response[dataResponse] == 200) {
            const brands = response[dataModel];
            const brandSelect = document.getElementById('Brand_id');
            enableFormProject(brandSelect);
            brandSelect.innerHTML = "";
            brandSelect.innerHTML += "<option value=''>Seleccione...</option>";
            brands.map(item => {
              brandSelect.innerHTML += `<option value="${item.Brand_id}">${item.Brand_name}</option>`;
            });
          } else {
            Swal.fire(
              '¡No pudimos hacer esto!',
              arMessages[0],
              'error'
            )
          }
          hidePreload();
        })
    });
}

function details(projectId) {
  window.location = `${BASE_URL}details?projectId=${projectId}`
}

function create(formData) {
  url = URL_ROUTE + arRoutes[0];
  fetch(url, {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[1],
          showConfirmButton: false,
          timer: 1500
        });
        hideModal();
        setTimeout(function(){
          window.location.reload();
        }, 2000);   
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        )
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function update(formData) {
  url = URL_ROUTE + arRoutes[2];
  fetch(url, {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[2],
          showConfirmButton: false,
          timer: 1500
        })
        hideModal();
        setTimeout(function(){
          window.location.reload();
        }, 2000);   
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        )
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function delete_(id) {
  Swal.fire({
    title: '¿Está seguro?',
    text: "¡Esta acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#7460ee',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {
      showPreload();
    url = URL_ROUTE + arRoutes[3];
    formData[primaryId] = id;
    fetch(url, {
      method: "POST",
      body: JSON.stringify(formData),
      headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    })
      .then(response => response.json())
      .catch(error => console.error('Error:', error))
      .then(response => {
        if (response[dataResponse] == 200) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: arMessages[3],
            showConfirmButton: false,
            timer: 1500
          });
          setTimeout(function(){
            window.location.reload();
          }, 2000);   
        } else {
          Swal.fire(
            '¡No pudimos hacer esto!',
            arMessages[0],
            'error'
          )
        }
        hidePreload();
      });
    }
  })
}

function sendData(e, formObj) {  
  let obj = formObj;
  sTForm = SingletonClassSTForm.getInstance();
  if (sTForm.validateForm()) {
    showPreload();
    if (selectInsertOrUpdate) {
      create(sTForm.getDataForm());
    } else {
      update(sTForm.getDataForm());
    }
    sTForm.inputButtonDisable();
  } else {
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    )
  }
  e.preventDefault();
}

function detail(idData) {
  getDataId(idData);
}

function getDataId(idData) {
  showPreload();
  selectInsertOrUpdate = false;
  formData[primaryId] = idData;
  url = URL_ROUTE + arRoutes[4];
  sTForm = SingletonClassSTForm.getInstance();
  fetch(url, {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        showModal(0);
        sTForm.setDataForm(response[dataModel]);
        hidePreload();
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        )
      }
    });
}

function addData() {
  selectInsertOrUpdate = true;
  showModal(1);
}

function hideModal() {
  $(myModalObjec).modal("hide");
}

function showModal(type) {
  if (type == 1) {
    selectInsertOrUpdate = true;
    sTForm = SingletonClassSTForm.getInstance();
    sTForm.inputButtonEnable();
    disableFormProject();
  } else {
    document.getElementById('Stat_id').setAttribute('disabled', false)
  }
  sTForm.clearDataForm();
  $(myModalObjec).modal("show");
}

function showPreload() {
  $(".preloader").fadeIn();
}

function hidePreload() {
  $(".preloader").fadeOut();
}

var SingletonClassSTForm = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idForm);
    return object;
  }
  return {
    getInstance: function () {
      if (!objInstance) {
        objInstance = createInstance();
      }
      return objInstance;
    }
  }
})();

document.addEventListener('DOMContentLoaded', function () {
  getManagerByClient();
  getBrandByManager();
})

function disableFormProject(){
  let readInputs = document.getElementsByClassName('read');
  for(element of readInputs){
    element.setAttribute("disabled","true");
  }
}

function enableFormProject(inputId){
  inputId.removeAttribute("disabled");
}

document.getElementById('btn-info').href = infoUrl;