// $("#table_obj_activities").DataTable();

const ruteContentActivities = "activities/";
const nameModelActivities = 'activities';
const dataModelActivities = 'data';
const dataResponseActivities = 'response';
const dataMessagesActivities = 'message';
const dataCsrfActivities = 'csrf';

const primaryIdActivities = 'Activi_id';
const URL_ROUTEActivities = BASE_URL + ruteContentActivities;

const activitiesModal = '#activitiesModal';
const idActivitiesForm = 'objActivitiesForm';

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
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[3],
          showConfirmButton: false,
          timer: 1500
        });
        hidelActivitiesModal();
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
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[6],
          showConfirmButton: false,
          timer: 1500
        });
        hidelActivitiesModal();
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
    confirmButtonColor: '#7460ee',
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
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: arMessages[9],
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function(){
              window.location.reload();
            }, 2000);  
          } else {
            Swal.fire(
              '¡No pudimos hacer esto!',
              arMessages[12],
              'error'
            );
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
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    );
  }
  e.preventDefault();
}

function detailActivities(idData) {
  getActivitiesDataId(idData);
  toogleDisabledFields();
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
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        )
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
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: arMessages[13],
        showConfirmButton: false,
        timer: 1500
      });
    }).catch(err => {
      Swal.fire(
        '¡No pudimos hacer esto!',
        arMessages[14],
        'error'
      )
    })
})