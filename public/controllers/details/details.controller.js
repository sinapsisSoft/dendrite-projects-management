showPreload();

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered product information', 'A new product added', 'A new tracking added', 'Product updated', 'The product was deleted', 'Copied', 'Could not be copied', 'A new activity added');
const ruteContent = "project/";
const nameModel = 'projects';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'Project_product_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function hideModal() {
  $(myModalObjec).modal("hide");
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
    TOASTS.toastView("", "", arMessages[0], 1);
  }
  e.preventDefault();
}

function update(formData) {
  url = `${BASE_URL}/projectproduct/${arRoutes[2]}`;
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
        TOASTS.toastView("", "", arMessages[3], 0);
        hideModal();
        window.location.reload();
      } else {
        console.log(arMessages[0]);
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function create(formData) {
  url = `${BASE_URL}/projectproduct/${arRoutes[0]}`;
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
        TOASTS.toastView("", "", arMessages[1], 0);
        hideModal();
        window.location.reload();
      } else {
        console.log(arMessages[0]);
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function update(formData) {
  url = `${BASE_URL}/projectproduct/${arRoutes[2]}`;
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
        TOASTS.toastView("", "", arMessages[3], 0);
        hideModal();
        window.location.reload();
      } else {
        console.log(arMessages[0]);
      }
      sTForm.inputButtonEnable();
      hidePreload();
    });
}

function getDataId(idData) {
  showPreload();
  selectInsertOrUpdate = false;
  formData[primaryId] = idData;
  url = `${BASE_URL}/projectproduct/${arRoutes[4]}`;
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
        console.log(arMessages[0]);
      }
    });
}

function delete_(id) {
  Swal.fire({
    title: '¿Está seguro?',
    text: "¡Esta acción no se puede revertir!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {
      showPreload();
    url = `${BASE_URL}/projectproduct/${arRoutes[3]}`;
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
          Swal.fire(
            'Eliminado!',
            'El producto ha sido eliminado del proyecto.',
            'success'
          )
          window.location.reload();

        } else {
          console.log(arMessages[0]);
        }
        hidePreload();
      });
      
    }
  })
}
function showModal(type) {
  if (type == 1) {
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