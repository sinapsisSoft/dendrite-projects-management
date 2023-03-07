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
$("#table_obj").DataTable();

// ==============================================================
// This is Variable  
// ==============================================================

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created', 'A new user was created', 'Updated user ', 'The user was deleted');
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
    debugger;
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
                console.log(response[dataModel]);
                debugger;
                TOASTS.toastView("", "", arMessages[1], 0);
                hideModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTForm.inputButtonEnable();
            debugger;
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
                console.log(response[dataModel]);
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

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function delete users
*/
function delete_(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
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
                    console.log(response[dataModel]);
                    TOASTS.toastView("", "", arMessages[4], 0);
                    window.location.reload();

                } else {
                    console.log(arMessages[0]);
                }
                hidePreload();
            });
    }
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions is general for the operations of users
*/
function sendData(e, formObj) {
    let obj = formObj;
    sTForm = SingletonClassSTForm.getInstance();
    if (sTForm.validateConfirmationsPassword()) {
        if (sTForm.validateForm()) {
            showPreload();
            if (selectInsertOrUpdate) {
                create(sTForm.getDataForm());
            } else {
                update(sTForm.getDataForm());
            }
            sTForm.inputButtonDisable();
        }
    } else {
        TOASTS.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function get data id user
*/
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
                console.log(arMessages[0]);
            }
        });
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function to hide user modal 
*/
function addData() {
    selectInsertOrUpdate = true;
    showModal(1);
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