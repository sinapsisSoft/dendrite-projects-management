showPreload();

$("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

// const arRoutes = AR_ROUTES_GENERAL;
// const arMessages = new Array('Revise la información suministrada', 'Producto agregado exitosamente', 'Seguimiento agregado exitosamente', 'Actividad agregada exitosamente', 'Producto actualizado exitosamente', 'Seguimiento actualizado exitosamente', 'Actividad actualizada exitosamente', 'Producto eliminado del proyecto exitosamente', 'Seguimiento eliminado del proyecto exitosamente', 'Actividad eliminada del proyecto exitosamente', 'El producto no pudo ser eliminado. Revise si éste tiene asociadas actividades', 'El seguimiento no pudo ser eliminado', 'La actividad no pudo ser eliminada. Revise si ésta tiene asociadas subactividades', 'Se ha copiado el link', 'No pudo ser copiado el link');
const ruteContent = "project/";
// const nameModel = 'projects';
// const dataModel = 'data';
// const dataResponse = 'response';
// const dataMessages = 'message';
// const dataCsrf = 'csrf';

const primaryId = 'ProjReq_id';
const URL_ROUTE = BASE_URL + ruteContent;

// const TOASTS = new STtoasts();
// const myModalObjec = '#createUpdateModal';
// const idForm = 'objForm';

// var sTForm = null;
// var url = "";
// var assignmentAction = 0;
// var formData = new Object();
var selectInsertOrUpdate = true;

// function hideModal() {
//   $(myModalObjec).modal("hide");
// }

// function sendData(e, formObj) {
//   let obj = formObj;
//   sTForm = SingletonClassSTForm.getInstance();
//   if (sTForm.validateForm()) {
//     showPreload();
//     if (selectInsertOrUpdate) {
//       create(sTForm.getDataForm());
//     } else {
//       update(sTForm.getDataForm());
//     }
//     sTForm.inputButtonDisable();
//   } else {
//     Swal.fire(
//       '¡No pudimos hacer esto!',
//       arMessages[0],
//       'error'
//     );
//   }
//   e.preventDefault();
// }

// function update(formData) {
//   url = `${BASE_URL}/projectproduct/${arRoutes[2]}`;
//   fetch(url, {
//     method: "POST",
//     body: JSON.stringify(formData),
//     headers: {
//       "Content-Type": "application/json",
//       "X-Requested-With": "XMLHttpRequest"
//     }
//   })
//     .then(response => response.json())
//     .catch(error => console.error('Error:', error))
//     .then(response => {
//       if (response[dataResponse] == 200) {
//         Swal.fire({
//           position: 'top-end',
//           icon: 'success',
//           title: arMessages[4],
//           showConfirmButton: false,
//           timer: 1500
//         });
//         hideModal();
//         setTimeout(function(){
//           window.location.reload();
//         }, 2000);   
//       } else {
//         Swal.fire(
//           '¡No pudimos hacer esto!',
//           arMessages[0],
//           'error'
//         );
//       }
//       sTForm.inputButtonEnable();
//       hidePreload();
//     });
// }

// function create(formData) {
//   url = `${BASE_URL}/projectproduct/${arRoutes[0]}`;
//   fetch(url, {
//     method: "POST",
//     body: JSON.stringify(formData),
//     headers: {
//       "Content-Type": "application/json",
//       "X-Requested-With": "XMLHttpRequest"
//     }
//   })
//     .then(response => response.json())
//     .catch(error => console.error('Error:', error))
//     .then(response => {
//       if (response[dataResponse] == 200) {
//         Swal.fire({
//           position: 'top-end',
//           icon: 'success',
//           title: arMessages[1],
//           showConfirmButton: false,
//           timer: 1500
//         });
//         hideModal();
//         setTimeout(function(){
//           window.location.reload();
//         }, 2000);   
//       } else {
//         Swal.fire(
//           '¡No pudimos hacer esto!',
//           arMessages[0],
//           'error'
//         );
//       }
//       sTForm.inputButtonEnable();
//       hidePreload();
//     });
// }

// function update(formData) {
//   url = `${BASE_URL}/projectproduct/${arRoutes[2]}`;
//   fetch(url, {
//     method: "POST",
//     body: JSON.stringify(formData),
//     headers: {
//       "Content-Type": "application/json",
//       "X-Requested-With": "XMLHttpRequest"
//     }
//   })
//     .then(response => response.json())
//     .catch(error => console.error('Error:', error))
//     .then(response => {
//       if (response[dataResponse] == 200) {
//         Swal.fire({
//           position: 'top-end',
//           icon: 'success',
//           title: arMessages[4],
//           showConfirmButton: false,
//           timer: 1500
//         });
//         hideModal();
//         setTimeout(function(){
//           window.location.reload();
//         }, 2000);   
//       } else {
//         Swal.fire(
//           '¡No pudimos hacer esto!',
//           arMessages[0],
//           'error'
//         );
//       }
//       sTForm.inputButtonEnable();
//       hidePreload();
//     });
// }

// function getDataId(idData) {
//   showPreload();
//   selectInsertOrUpdate = false;
//   formData[primaryId] = idData;
//   url = `${BASE_URL}/projectproduct/${arRoutes[4]}`;
//   sTForm = SingletonClassSTForm.getInstance();
//   fetch(url, {
//     method: "POST",
//     body: JSON.stringify(formData),
//     headers: {
//       "Content-Type": "application/json",
//       "X-Requested-With": "XMLHttpRequest"
//     }
//   })
//     .then(response => response.json())
//     .catch(error => console.error('Error:', error))
//     .then(response => {
//       if (response[dataResponse] == 200) {
//         showModal(0);
//         sTForm.setDataForm(response[dataModel]);
//         hidePreload();
//       } else {
//         Swal.fire(
//           '¡No pudimos hacer esto!',
//           arMessages[0],
//           'error'
//         );
//       }
//     });
// }

// function delete_(id) {
//   Swal.fire({
//     title: '¿Está seguro?',
//     text: "¡Esta acción no se puede revertir!",
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#7460ee',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Si, eliminar!'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       showPreload();
//     url = `${BASE_URL}/projectproduct/${arRoutes[3]}`;
//     formData[primaryId] = id;
//     fetch(url, {
//       method: "POST",
//       body: JSON.stringify(formData),
//       headers: {
//         "Content-Type": "application/json",
//         "X-Requested-With": "XMLHttpRequest"
//       }
//     })
//       .then(response => response.json())
//       .catch(error => console.error('Error:', error))
//       .then(response => {
//         if (response[dataResponse] == 200) {
//           Swal.fire({
//             position: 'top-end',
//             icon: 'success',
//             title: arMessages[7],
//             showConfirmButton: false,
//             timer: 1500
//           });
//           setTimeout(function(){
//             window.location.reload();
//           }, 2000);   
//         } else {
//           Swal.fire(
//             '¡No pudimos hacer esto!',
//             arMessages[10],
//             'error'
//           );
//         }
//         hidePreload();
//       });
      
//     }
//   })
// }
// function showModal(type) {
//   if (type == 1) {
//     sTForm = SingletonClassSTForm.getInstance();
//     sTForm.inputButtonEnable();
//     disableFormProject();
//     selectInsertOrUpdate = true;
//   }
//   sTForm.clearDataForm();
//   $(myModalObjec).modal("show");
// }



function showPreload() {
  $(".preloader").fadeIn();
}

function hidePreload() {
  $(".preloader").fadeOut();
}

// var SingletonClassSTForm = (function () {
//   var objInstance;
//   function createInstance() {
//     var object = new STForm(idForm);
//     return object;
//   }
//   return {
//     getInstance: function () {
//       if (!objInstance) {
//         objInstance = createInstance();
//       }
//       return objInstance;
//     }
//   }
// })();

// function disableFormProject() {
//   let readInputs = document.getElementsByClassName('read');
//   for (element of readInputs) {
//     element.setAttribute("disabled", "true");
//   }
// }