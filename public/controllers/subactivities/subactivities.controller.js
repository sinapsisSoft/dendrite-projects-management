
const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada', 'Subactividad creada exitosamente', 'Subactividad actualizada exitosamente', 'Subactividad eliminada exitosamente', 'La subactividad no pudo ser eliminada', 'Se ha copiado el link', 'No pudo ser copiado el link', 'Notificación enviada con éxito', 'E-mail enviado con éxito');
const ruteContent = "subactivities/";
const nameModel = 'subactivities';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'SubAct_id';
const URL_ROUTE = BASE_URL + ruteContent;

const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';
const idEmailForm = 'objEmailForm';
const idFinForm = 'objFinForm';


var sTForm = null;
var sTFormEmail = null
var sTFormFin = null
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

let collaborators = [];

function toogleCollaborator(email) {
  const isExists = !!collaborators.find(collaborator => collaborator === email);
  if (isExists) collaborators = collaborators.filter(collaborator => collaborator !== email)
  else collaborators.push(email);
}

function finish(formId) {
  showPreload();
  let form = document.getElementById(formId);
  url = URL_ROUTE + 'finish';
  const id = form.querySelector(`#${primaryId}`).value;
  let duration = form.querySelector(`#SubAct_duration`).value;
  const formData = {
    'SubAct_id' : id,
    'SubAct_duration' : duration
  };
  fetch(url, {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  }).then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[8],
          showConfirmButton: false,
          timer: 1500
        });
        $(finModal).modal("hide");
        window.location.reload();
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
      }
      hidePreload();
    }).catch(() => hidePreload());
}

function sendNotification() {
  showPreload();
  url = URL_ROUTE + 'notification';
  const form = SingletonClassSTFormEmail.getInstance();
  const formData = form.getDataForm();
  formData['collaborators'] = collaborators.join(',');
  fetch(url, {
    method: "POST",
    body: JSON.stringify(formData),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  }).then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: arMessages[7],
          showConfirmButton: false,
          timer: 1500
        });
        $(emailModal).modal("hide");
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
      }
      form.inputButtonEnable();
      hidePreload();
    });
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
      formData['activityId'] = document.getElementById('Activi_id').value;
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
            window.location.reload();
  
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
  // toogleDisabledFields();
}

// function toogleDisabledFields() {
//   const btnSubmit = document.getElementById('btn-submit');
//   const inputs = document.querySelectorAll('input');
//   inputs.forEach(input => input.classList.add('form-disabled'))
//   const selects = document.querySelectorAll('select')
//   selects.forEach(select => select.classList.add('form-disabled'))
//   btnSubmit.disabled = true;
// }

function getDataIdFinish(idData) {
  showPreload();
  selectInsertOrUpdate = false;
  formData[primaryId] = idData;
  url = URL_ROUTE + arRoutes[4];
  sTForm = SingletonClassSTFormFin.getInstance();
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
        showFinModal(0);
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
    sTForm = SingletonClassSTForm.getInstance();
    sTForm.inputButtonEnable();
    disableFormProject();
    selectInsertOrUpdate = true;
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

function showEmailModal(type, idData) {
  if (type == 1) {
    sTFormEmail = SingletonClassSTFormEmail.getInstance();
    sTFormEmail.inputButtonEnable();
    document.getElementById('not_subId').value = idData;
  }
  sTFormEmail.clearDataForm();
  $(emailModal).modal("show");
}

var SingletonClassSTFormEmail = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idEmailForm);
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

function showFinModal(type) {
  $(finModal).modal("show");
}

var SingletonClassSTFormFin = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idFinForm);
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

function changePercent() {
  document.getElementById('SubAct_percentage').addEventListener('change', function (e) {
    const value = +e.target.value;
    const options = document.getElementById('Stat_id');
    if (value === 0) {
      for (let i = 0; i < options.length; i++) {
        const text = options[i].innerText.trim();
        if (text === 'Sin asignar') {
          options[i].selected = "true";
        }
      }
    } else if (value > 0 && value < 100) {
      for (let i = 0; i < options.length; i++) {
        const text = options[i].innerText.trim();
        if (text === 'Pendiente') {
          options[i].selected = "true";
        }
      }
    } else {
      for (let i = 0; i < options.length; i++) {
        const text = options[i].innerText.trim();
        if (text === 'Realizado') {
          options[i].selected = "true";
        }
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  changePercent();
})

document.getElementById("copyToClipboard").addEventListener('click', function () {
  let valueToCopy = document.getElementById("Activi_link").value;
  navigator.clipboard.writeText(valueToCopy)
    .then(() => {
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: arMessages[5],
        showConfirmButton: false,
        timer: 1500
      });
    }).catch(err => {
      Swal.fire(
        '¡No pudimos hacer esto!',
        arMessages[6],
        'error'
      )
    })
})

function disableFormProject() {
  let readInputs = document.getElementsByClassName('read');
  for (element of readInputs) {
    element.setAttribute("disabled", "true");
  }
}