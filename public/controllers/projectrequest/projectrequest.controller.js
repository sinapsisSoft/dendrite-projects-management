showPreload();

$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Se presentó un error, vuelva a intentarlo','Se ha creado el proyecto a partir de la solicitud exitosamente.', 'El proyecto se ha rechazado exitosamente.');
const ruteContent = "projectrequestdetail/";
const nameModel = 'projectrequestdetail';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'ProjReq_id';
const URL_ROUTE = BASE_URL + ruteContent;
const myModalObjec = '#createModal';

const idForm = 'objForm';
const infoUrl = 'https://ior.ad/9sGN';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function details(projectRequestId) {
  window.location = `${BASE_URL}projectrequestdetail?projectRequestId=${projectRequestId}`
}

function getGetParameter(){
  let url = window.location.href;
  url = url.split("?");
  projectId = url[1].split("=");
  return projectId[1];
}

function create(formData) {  
  formData['ProjReq_id'] = getGetParameter();
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
          title: `${arMessages[1]} Código del proyecto: ${response[dataModel]}`,
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

function delete_() {
  Swal.fire({
    title: '¿Está seguro?',
    text: "¡Esta acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#7460ee',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, rechazar!'
  }).then((result) => {
    if (result.isConfirmed) {
      showPreload();
    url = URL_ROUTE + arRoutes[3];
    formData[primaryId] = getGetParameter();
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
  })
}

function sendData(e, formObj) {  
  let obj = formObj;
  sTForm = SingletonClassSTForm.getInstance();
  if (sTForm.validateForm()) {
    showPreload();
    create(sTForm.getDataForm());
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

function showModal(type) {
  if (type == 1) {
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

document.getElementById('btn-info').href = infoUrl;