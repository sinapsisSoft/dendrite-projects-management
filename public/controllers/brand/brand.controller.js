// $("#table_obj_Brand").DataTable();

const ruteContentBrand = "brand/";
const nameModelBrand = 'brands';
const dataModelBrand = 'data';
const dataResponseBrand = 'response';
const dataMessagesBrand = 'message';
const dataCsrfBrand = 'csrf';

const primaryIdBrand = 'Brand_id';
const URL_ROUTEBrand = BASE_URL + ruteContentBrand;

const TOASTSBrand = new STtoasts();
const BrandModal = '#BrandModal';
const idBrandForm = 'objBrandForm';

var sTFormBrand = null
var urlBrand = "";
var assignmentActionBrand = 0;
var formDataBrand = new Object();
var selectInsertOrUpdateBrand = true;

function createBrand(formData) {
  urlBrand = URL_ROUTEBrand + arRoutes[0];
  formData['Client_id'] = document.getElementById('Client_id').value;
  fetch(urlBrand, {
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
          title: arMessages[5],
          showConfirmButton: false,
          timer: 1500
        });
        hidelBrandModal();
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
      sTFormBrand.inputButtonEnable();
      hidePreload();
    });
}

function updateBrand(formData) {
  urlBrand = URL_ROUTEBrand + arRoutes[2];
  formData['Client_id'] = document.getElementById('Client_id').value;
  fetch(urlBrand, {
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
        hidelBrandModal();
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
      sTFormBrand.inputButtonEnable();
      hidePreload();
    });
}

function deleteBrand(id) {
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
      urlBrand = URL_ROUTEBrand + arRoutes[3];
      formData[primaryIdBrand] = id;
      fetch(urlBrand, {
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
              title: arMessages[7],
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(function(){
              window.location.reload();
            }, 2000); 

          } else {
            Swal.fire(
              '¡No pudimos hacer esto!',
              arMessages[8],
              'error'
            );
          }
          hidePreload();
        });
    }
  })
}

function sendBrandData(e, formObj) {
  let obj = formObj;
  sTFormBrand = SingletonClassSTFormBrand.getInstance();
  if (sTFormBrand.validateForm()) {
    showPreload();
    if (selectInsertOrUpdateBrand) {
      createBrand(sTFormBrand.getDataForm());
    } else {
      updateBrand(sTFormBrand.getDataForm());
    }
    sTFormBrand.inputButtonDisable();
  } else {
    Swal.fire(
      '¡No pudimos hacer esto!',
      arMessages[0],
      'error'
    );
  }
  e.preventDefault();
}

function getBrandDataId(idData, type) {
  showPreload();
  selectInsertOrUpdateBrand = false;
  formDataBrand[primaryIdBrand] = idData;
  urlBrand = URL_ROUTEBrand + arRoutes[4];
  sTFormBrand = SingletonClassSTFormBrand.getInstance();
  fetch(urlBrand, {
    method: "POST",
    body: JSON.stringify(formDataBrand),
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  })
    .then(response => response.json())
    .catch(error => console.error('Error:', error))
    .then(response => {
      if (response[dataResponse] == 200) {
        showBrandModal(0);
        sTFormBrand.setDataForm(response[dataModel]);
        if(type == 0){
          sTFormBrand.inputButtonDisable();
        }
        else if(type == 1){
          sTFormBrand.inputButtonEnable();
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

function addBrandData() {
  selectInsertOrUpdateBrand = true;
  showBrandModal(1);
}

function hidelBrandModal() {
  $(BrandModal).modal("hide");
}

function showBrandModal(type) {
  if (type == 1) {
    sTFormBrand = SingletonClassSTFormBrand.getInstance();
    sTFormBrand.inputButtonEnable();
    selectInsertOrUpdate = true;
    sTFormBrand.FormEnableEdit();
  }
  sTFormBrand.clearDataForm();
  $(BrandModal).modal("show");
}



var SingletonClassSTFormBrand = (function () {
  var objInstance;
  function createInstance() {
    var object = new STForm(idBrandForm);
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