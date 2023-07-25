// $("#table_obj_Manager").DataTable();

const UserModal = '#userModal';
const idUserForm = 'objUserForm';

var sTFormUser = null
var formDataUser = new Object();
var selectInsertOrUpdateUser = true;
var userPassword = document.getElementById("User_password");
var confirmPassword = document.getElementById("confirmPassword");


function hideUserModal() {
  $(UserModal).modal("hide");
}

function showUserModal(type) {
  if (type == 1) {
    sTFormUser = SingletonClassSTFormUser.getInstance();
    sTFormUser.inputButtonEnable();
    sTFormUser.FormEnableEdit();
    passwordInputHide(0);
    selectInsertOrUpdateUser = false;
  }
  else {
    passwordInputHide(1);
    disableFormProject();
    selectInsertOrUpdateUser = true;
  }
  sTFormUser.clearDataForm();
  $(UserModal).modal("show");
}

var SingletonClassSTFormUser = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idUserForm);
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

function activeUser(idData){
  showPreload();
  formDataUser[primaryIdManager] = idData;
  urlUser =  `${URL_ROUTEManager}findUser`;
  sTFormUser = SingletonClassSTFormUser.getInstance();
  fetch(urlUser, {
    method: "POST",
    body: JSON.stringify(formDataUser),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        if(response[dataModel][0]["UserManager_id"] != undefined && response[dataModel][0]["UserManager_id"] > 0){
          showUserModal(1);
          sTFormUser.setDataForm(response[dataModel][0]);
          hidePreload();
        }
        else {
          showUserModal(0);
          sTFormUser.setDataForm(response[dataModel][0]);
          hidePreload();
        }        
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
      }
    });
}

function sendUserData(e, formObj) {  
  let obj = formObj;
  sTFormUser = SingletonClassSTFormUser.getInstance();
  if (sTFormUser.validateForm()) {
    showPreload();
    sTFormUser.inputButtonDisable();
    if (selectInsertOrUpdateUser) {
      if(sTFormUser.validateConfirmationsPassword()){
        createUser(sTFormUser.getDataForm());
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
      updateUser(sTFormUser.getDataForm());
    }
  } else {
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    );
    hidePreload();
  }
  e.preventDefault();
  hidePreload();
  sTFormUser.inputButtonEnable();
}

function createUser(formData) {
  urlUser =  `${URL_ROUTEManager}createUser`;
  fetch(urlUser, {
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
          title: arMessages[13],
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
        hidePreload();
      }
      sTFormUser.inputButtonEnable();
      hidePreload();
    });
}

function updateUser(formData) {
  url = `${URL_ROUTEManager}updateUser`;
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
          title: arMessages[14],
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
      sTFormUser.inputButtonEnable();
      hidePreload();
    });
}

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

document.getElementById("showPassword").addEventListener('click', showHiddePassword);

function disableFormProject(){
  let readInputs = document.getElementsByClassName('read');
  for(element of readInputs){
    element.setAttribute("disabled","true");
  }
}

function enableFormProject(inputId){
  inputId.removeAttribute("disabled");
}