// $("#table_obj_Manager").DataTable();

const ruteContentManager = "manager/";
const nameModelManager = 'managers';
const dataModelManager = 'data';
const dataResponseManager = 'response';
const dataMessagesManager = 'message';
const dataCsrfManager = 'csrf';

const primaryIdManager = 'Manager_id';
const URL_ROUTEManager = BASE_URL + ruteContentManager;

const TOASTSManager = new STtoasts();
const ManagerModal = '#ManagerModal';
const idManagerForm = 'objManagerForm';

var sTFormManager = null
var urlManager = "";
var assignmentActionManager = 0;
var formDataManager = new Object();
var selectInsertOrUpdateManager = true;

let brands = [];


function createManager(formData) {
  urlManager = URL_ROUTEManager + arRoutes[0];
  formData['Client_id'] = document.getElementById('Client_id').value;
  formData['Brands'] = brands;
  fetch(urlManager, {
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
        hidelManagerModal();
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
      sTFormManager.inputButtonEnable();
      hidePreload();
    });
}

function toggleBrand(brandId) {
  const isExists = !!brands.find(brand => brand == brandId);
  if (!isExists) {
    brands.push(brandId);
  }
}

function updateManager(formData) {
  urlManager = URL_ROUTEManager + arRoutes[2];
  formData['Client_id'] = document.getElementById('Client_id').value;
  formData['Brands'] = brands;
  fetch(urlManager, {
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
          title: arMessages[10],
          showConfirmButton: false,
          timer: 1500
        });
        hidelManagerModal();
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
      sTFormManager.inputButtonEnable();
      hidePreload();
    });
}

function deleteManager(id) {
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
      urlManager = URL_ROUTEManager + arRoutes[3];
      formData[primaryIdManager] = id;
      fetch(urlManager, {
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
              title: arMessages[11],
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

function sendManagerData(e, formObj) {
  let obj = formObj;
  sTFormManager = SingletonClassSTFormManager.getInstance();
  if (sTFormManager.validateForm()) {
    showPreload();
    if (selectInsertOrUpdateManager) {
      createManager(sTFormManager.getDataForm());
    } else {
      updateManager(sTFormManager.getDataForm());
    }
    sTFormManager.inputButtonDisable();
  } else {
    TOASTSManager.toastView("", "", arMessages[0], 1);
  }
  e.preventDefault();
}

function getManagerDataId(idData, type) {
  showPreload();
  selectInsertOrUpdateManager = false;
  formDataManager[primaryIdManager] = idData;
  urlManager = URL_ROUTEManager + arRoutes[4];
  sTFormManager = SingletonClassSTFormManager.getInstance();
  fetch(urlManager, {
    method: "POST",
    body: JSON.stringify(formDataManager),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        showManagerModal(0);         
        const result = response[dataModel];
        setManagerBrands(result.brands, result.manager['Manager_id']);
        sTFormManager.setDataForm(result.manager);
        if (type == 0) {
          sTFormManager.inputButtonDisable();
        }
        else if (type == 1) {
          sTFormManager.inputButtonEnable();
        }       
        hidePreload();
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
        hidePreload();
      }
    });
}

function setManagerBrands(brands, managerId) {
  // removeElementsFromList();
  const ul = document.getElementById("managerBrands");
  const managerBrands = brands.filter(brand => brand["Manager_id"] === null || brand["Manager_id"] == managerId)
  let li = "", checked = "";
  managerBrands.forEach(managerBrand => {
    if(managerBrand["Manager_id"] == managerId){
      checked = 'checked';
      toggleBrand(parseInt(managerBrand["Brand_id"]));
    }
    else {
      checked = '';
    }
    li += `<li class="col-4">
            <div class="form-check">              
                <input class="form-check-input" ${checked} type="checkbox" onchange="toggleBrand(${managerBrand["Brand_id"]})">
                <label class="form-check-label text-break">${managerBrand["Brand_name"]}</label>
            </div>
        </li>`;    
  });
  li.length > 0 ? ul.innerHTML = li : ul.innerHTML = '<li></li>';
}

function removeElementsFromList() {
  // Obtén una referencia al elemento 'ul'
  var ulElement = document.getElementById('managerBrands');

  // Obtén una colección de elementos 'li' dentro del 'ul'
  var liElements = ulElement.getElementsByTagName('li');

  // Convierte la colección en un array para facilitar la iteración
  var liArray = Array.from(liElements);

  // Elimina los elementos 'li' uno por uno
  liArray.forEach(function (li) {
      ulElement.removeChild(li);
  });
}

function addManagerData() {
  selectInsertOrUpdateManager = true;
  showManagerModal(1);
}

function hidelManagerModal() {
  $(ManagerModal).modal("hide");
}

function showManagerModal(type) {
  if (type == 1) {
    sTFormManager = SingletonClassSTFormManager.getInstance();
    sTFormManager.inputButtonEnable();
    selectInsertOrUpdateManager = true;
    sTFormManager.FormEnableEdit();
    removeElementsFromList();
  }
  sTFormManager.clearDataForm();
  $(ManagerModal).modal("show");
}

var SingletonClassSTFormManager = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idManagerForm);
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