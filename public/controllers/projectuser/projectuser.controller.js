showPreload();

$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Se presentó un error, vuelva a intentarlo','Solicitud creada exitosamente.', 'Solicitud actualizada exitosamente.','Solicitud eliminada exitosamente', 'La solicitud no pudo ser eliminada. Revise si éste está tiene productos asociados');
const ruteContent = "projectuser/";
// const nameModel = 'projectrequestdetail';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'ProjReq_id';
const URL_ROUTE = BASE_URL + ruteContent;
const myModalObjec = '#createUpdateModal';

const idForm = 'objForm';

var sTForm = null;
var url = "";
var formData = new Object();
var selectInsertOrUpdate = true;

function details(projectRequestId) {
  window.location = `${BASE_URL}projectuserdetail?projectRequestId=${projectRequestId}`
}

function create(formData) {  
  url = `${URL_ROUTE}${arRoutes[0]}`;
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
          timer: 2500
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
            arMessages[4],
            'error'
          );
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
  } else {
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    )
  }
  e.preventDefault();
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

function hideModal() {
  $(myModalObjec).modal("hide");
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

function getDataId(idData, type) {
  showPreload();
  selectInsertOrUpdate = false;
  formData[primaryId] = idData;
  url = `${URL_ROUTE}${arRoutes[4]}`;
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
        if(type == 0){
          sTForm.inputButtonDisable();
        }
        else if(type == 1){
          sTForm.inputButtonEnable();
        }
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