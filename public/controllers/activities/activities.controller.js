// $("#table_obj_activities").DataTable();

const ruteContentActivities = "activities/";
const nameModelActivities = 'activities';
const dataModelActivities = 'data';
const dataResponseActivities = 'response';
const dataMessagesActivities = 'message';
const dataCsrfActivities = 'csrf';

const primaryIdActivities = 'Activi_id';
const URL_ROUTEActivities = BASE_URL + ruteContentActivities;

const TOASTSActivities = new STtoasts();
const activitiesModal = '#activitiesModal';
const idActivitiesForm = 'objActivitiesForm'; //Nombre del formulario

var sTFormActivities = null
var urlActivities = "";
var assignmentActionActivities = 0;
var formDataActivities = new Object();
var selectInsertOrUpdateActivities = true;

function details(subactivitiesId) {
  window.location = `${BASE_URL}subactivities?activitiesId=${subactivitiesId}`
}

function createActivities(formData) {
  urlActivities = URL_ROUTEActivities + arRoutes[0];
  fetch(urlActivities, {
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
        TOASTSActivities.toastView("", "", arMessages[7], 0);
        hidelActivitiesModal();
        window.location.reload();
      } else {
        console.log(arMessages[0]);
      }
      sTFormActivities.inputButtonEnable();
      hidePreload();
    });
}

function updateActivities(formData) {
  urlActivities = URL_ROUTEActivities + arRoutes[2];
  fetch(urlActivities, {
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
        TOASTSActivities.toastView("", "", arMessages[3], 0);
        hidelActivitiesModal();
        window.location.reload();
      } else {
        console.log(arMessages[0]);
      }
      sTFormActivities.inputButtonEnable();
      hidePreload();
    });
}

function deleteActivities(id) {
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
      urlActivities = URL_ROUTEActivities + arRoutes[3];
      formData[primaryIdActivities] = id;
      fetch(urlActivities, {
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
              'La actividad ha sido eliminada del proyecto.',
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

function sendActivitiesData(e, formObj) {
  let obj = formObj;
  sTFormActivities = SingletonClassSTFormActivities.getInstance();
  if (sTFormActivities.validateForm()) {
    showPreload();
    if (selectInsertOrUpdateActivities) {
      createActivities(sTFormActivities.getDataForm());
    } else {
      updateActivities(sTFormActivities.getDataForm());
    }
    sTFormActivities.inputButtonDisable();
  } else {
    TOASTSActivities.toastView("", "", arMessages[0], 1);
  }
  e.preventDefault();
}

function detailActivities(idData) {
  getActivitiesDataId(idData);
  toogleDisabledFields();
}

function toogleActivitiesDisabledFields() {
  const btnSubmit = document.getElementById('btn-submit');
  const inputs = document.querySelectorAll('input');
  inputs.forEach(input => input.classList.add('form-disabled'))
  const selects = document.querySelectorAll('select')
  selects.forEach(select => select.classList.add('form-disabled'))
  btnSubmit.disabled = true;
}

function getActivitiesDataId(idData) {
  showPreload();
  selectInsertOrUpdateActivities = false;
  formDataActivities[primaryIdActivities] = idData;
  urlActivities = URL_ROUTEActivities + arRoutes[4];
  sTFormActivities = SingletonClassSTFormActivities.getInstance();
  fetch(urlActivities, {
    method: "POST",
    body: JSON.stringify(formDataActivities),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        showActivitiesModal(0);
        sTFormActivities.setDataForm(response[dataModel]);
        hidePreload();
      } else {
        console.log(arMessages[0]);
      }
    });
}

function addActivitiesData() {
  selectInsertOrUpdateActivities = true;
  showActivitiesModal(1);
}

function hidelActivitiesModal() {
  $(activitiesModal).modal("hide");
}

function showActivitiesModal(type) {
  if (type == 1) {
    sTFormActivities = SingletonClassSTFormActivities.getInstance();
    sTFormActivities.inputButtonEnable();
    disableFormProject()
  }
  sTFormActivities.clearDataForm();
  $(activitiesModal).modal("show");
}



var SingletonClassSTFormActivities = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idActivitiesForm);
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

function disableFormProject() {
  let readInputs = document.getElementsByClassName('read');
  for (element of readInputs) {
    element.setAttribute("disabled", "true");
  }
}

document.getElementById("copyToClipboard").addEventListener('click', function () {
  let valueToCopy = document.getElementById("Activi_link").value;
  navigator.clipboard.writeText(valueToCopy)
    .then(() => {
      TOASTSActivities.toastView("", "", arMessages[5], 0);
    }).catch(err => {
      TOASTSActivities.toastView("", "", arMessages[6], 0);
    })
})