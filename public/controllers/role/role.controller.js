showPreload();

$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada',  'Rol creado exitosamente', 'Rol actualizado exitosamente', 'Rol eliminado exitosamente', 'El Rol no pudo ser eliminado. Revise si éste está siendo usado por algún usuario.');
const ruteContent = "role/";
const nameModel = 'roles';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
let modules = [];

const primaryId = 'Role_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';
const infoUrl = 'https://ior.ad/9kBH';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function toggleModule(moduleId, permitId) {
  const exists = 0
  const indexAcces = findAcces(moduleId)
  if (indexAcces >= exists) {
    const existsPermissionByAcces = findPermissionByAccessId(indexAcces, permitId);
    if (existsPermissionByAcces) deletePermission(indexAcces, permitId)
    else addPermission(indexAcces, permitId)
  } else {
    const module = { accesId: moduleId, permissions: [] }
    module.permissions.push(permitId)
    modules.push(module)
  }
}

const findAcces = (accessId) => modules.findIndex(acces => +acces.accesId === accessId)

const findPermissionByAccessId = (index, permissionId) =>
  !!modules[index]?.permissions.find(
    (permission) => +permission === permissionId
  )

const addPermission = (index, permission) => {
  modules[index].permissions.push(permission)
}

const deletePermission = (index, permission) => {
  const permissions = modules[index].permissions
  modules[index].permissions = permissions.filter(p => +p !== permission)
  const totalPermissions = modules[index].permissions.length;
  if (totalPermissions === 0) modules.splice(index, 1);
}

function convertModuleToObjectPhp() {
  return modules.map(module => `${module.accesId};${module.permissions.join(',')}`)
}

function create(formData) {
  url = URL_ROUTE + arRoutes[0];
  formData.modules = convertModuleToObjectPhp();
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
  formData.modules = convertModuleToObjectPhp();
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
        convertResponseToObject(response[dataModel].modules);
        const checkbox = document.querySelectorAll('input[type="checkbox"]');
        checkbox.forEach(item => {
          const moduleId = item.getAttribute('module-id');
          const permitId = item.getAttribute('value');
          const isChecked = isExistsPermitByModuleId(moduleId, permitId);
          isChecked ? item.setAttribute('checked', true) : item.removeAttribute('checked');
        })
        sTForm.setDataForm(response[dataModel].role);
        if(type == 0){
          sTForm.inputButtonDisable();
        }
        else if(type == 1){
          sTForm.inputButtonEnable();
          idData > 0 && idData < 8 ? document.getElementById("Role_name").setAttribute("disabled", true) : document.getElementById("Role_name").removeAttribute("disabled");
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

function isExistsPermitByModuleId(moduleId, permitId) {
  const module = modules.find(module => module.accesId === moduleId);
  if (module) return module.permissions.includes(permitId);
  return false;
}

function convertResponseToObject(moduleResponse) {
  modules = moduleResponse.map(response => {
    return {
      accesId: response.mod_id,
      permissions: response.permits ? response.permits.split(',') : []
    }
  })
}

function hideModal() {
  $(myModalObjec).modal("hide");
  const checkbox = document.querySelectorAll('input[type="checkbox"]');
  checkbox.forEach(checkbox => checkbox.setAttribute('disabled', false))
}

function showModal(type) {
  if (type == 1) {
    const checkbox = document.querySelectorAll('input[type="checkbox"]');
    checkbox.forEach(item => item.removeAttribute('checked'))
    modules = []
    sTForm = SingletonClassSTForm.getInstance();
    sTForm.inputButtonEnable();
    selectInsertOrUpdate = true;
    sTForm.FormEnableEdit();
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