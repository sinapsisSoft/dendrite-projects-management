/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/01/2023
*Description:General login management functions
*/
// ==============================================================
// Start View
// ==============================================================
showPreload();
// ==============================================================
// Login and Recover Password
// ==============================================================
/****************************************
*       Basic Table                   *
****************************************/
$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

// ==============================================================
// This is Variable  
// ==============================================================

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada', 'Usuario creado exitosamente', 'Usuario actualizado exitosamente', 'Usuario eliminado exitosamente', 'El usuario no pudo ser eliminado. Revise si éste está siendo usado en algún proyecto.');
const ruteContent = "user/";
const nameModel = 'users';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
// ==============================================================
// This is Variable  
// ==============================================================
const primaryId = 'User_id';
const URL_ROUTE = BASE_URL + ruteContent;
// ==============================================================
// This is Variable  
// ==============================================================
const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';

// ==============================================================
// This is Variable  
// ==============================================================
var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;
var userPassword = document.getElementById("User_password");
var confirmPassword = document.getElementById("confirmPassword");


// ==============================================================
// Functions 
// ==============================================================

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:31/01/2023
*Description:This function create users
*/
function create(formData) {
  url = URL_ROUTE + arRoutes[0];
  console.log(JSON.stringify(formData));
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
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:31/01/2023
*Description:This function update users
*/
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

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function delete users
*/
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
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions is general for the operations of users
*/
function sendData(e, formObj) {
  userPassword.type = 'password';
  confirmPassword.type = 'password';
  let obj = formObj;
  sTForm = SingletonClassSTForm.getInstance();
    if (sTForm.validateForm()) {
      showPreload();
      sTForm.inputButtonDisable();
      if (selectInsertOrUpdate) {
        if(sTForm.validateConfirmationsPassword()){
          create(sTForm.getDataForm());
        }      
        else {
          Swal.fire(
            '¡No pudimos hacer esto!',
            'Las contraseñas no coinciden',
            'error'
          );
          hidePreload();
        }
      } else {
        update(sTForm.getDataForm());
      }
    }else {
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    );
    hidePreload();
  }
  e.preventDefault();
  hidePreload();
  sTForm.inputButtonEnable();
}

function getDataId(idData, type) {
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

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function to hide user modal 
*/

function hideModal() {
  $(myModalObjec).modal("hide");
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function to show user modal 
*/
function showModal(type) {
  if (type == 1) {
    sTForm = SingletonClassSTForm.getInstance();
    sTForm.inputButtonEnable();
    selectInsertOrUpdate = true;
    passwordInputHide(1);
    sTForm.FormEnableEdit();
    disableFormProject();
  }
  else {
    passwordInputHide(0);
  }
  sTForm.clearDataForm();
  $(myModalObjec).modal("show");
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:27/02/2023
*Description:This function to show preload
*/
function showPreload() {
  $(".preloader").fadeIn();
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:27/02/2023
*Description:This function to hide preload
*/
function hidePreload() {
  $(".preloader").fadeOut();
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions singleton STForm class
*/
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

document.getElementById("showPassword").addEventListener('click', showHiddePassword);


function showHiddePassword(){
  let btnShow = document.getElementById("showPassword");
  if (userPassword.type === 'password'){
    userPassword.type = 'text';
    confirmPassword.type = 'text';
    btnShow.firstElementChild.classList.add('bi-eye-slash');
    btnShow.firstElementChild.classList.remove('bi-eye');
  }
  else {
    userPassword.type = 'password';
    confirmPassword.type = 'password';
    btnShow.firstElementChild.classList.remove('bi-eye-slash');
    btnShow.firstElementChild.classList.add('bi-eye');
  }
}

function passwordInputHide(type){  
  var inputHide = Array.from(document.getElementsByClassName('user-password'));
  
  if(type == 0){
    inputHide.forEach(element => {
      element.classList.add('d-none');
    });
    userPassword.removeAttribute("required");
    confirmPassword.removeAttribute("required");
  }
  else {
    inputHide.forEach(element => {
      element.classList.remove('d-none');
    });
    userPassword.setAttribute("required", "true");
    confirmPassword.setAttribute("required", "true");
  }  
}

function disableFormProject(){
  let readInputs = document.getElementsByClassName('read');
  for(element of readInputs){
    element.setAttribute("disabled","true");
  }
}