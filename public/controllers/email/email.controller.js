showPreload();

$("#table_obj").DataTable();

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada', 'Configuración guardada exitosamente', 'Configuración actualizada exitosamente');
const ruteContent = "email/";
const nameModel = 'emails';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'Email_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';
const infoUrl = 'https://ior.ad/9izE';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function create(formData) {
  url = URL_ROUTE + arRoutes[0];
  debugger;
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
        setTimeout(function () {
          window.location.reload();
        }, 2000);
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
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
        );
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function sendData(e, formObj) {
  let obj = formObj;
  sTForm = SingletonClassSTForm.getInstance();
  selectInsertOrUpdate = document.getElementById("Email_id").value === '';
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
    );
  }
  e.preventDefault();
}

function detail(idData) {
  getDataId(idData);
  toogleDisabledFields();
}

function toogleDisabledFields() {
  const btnSubmit = document.getElementById('btn-submit');
  const inputs = document.querySelectorAll('input');
  inputs.forEach(input => input.classList.add('form-disabled'))
  const selects = document.querySelectorAll('select')
  selects.forEach(select => select.classList.add('form-disabled'))
  btnSubmit.disabled = true;
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
        );
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

document.getElementById('btn-info').href = infoUrl;