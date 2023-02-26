/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/01/2023
*Description:General login management functions
*/
// ==============================================================
// Start View
// ==============================================================
$(".preloader").fadeOut();
// ==============================================================
// Login and Recover Password
// ==============================================================
/****************************************
*       Basic Table                   *
****************************************/
$("#zero_config").DataTable();


// ==============================================================
// This is Variable  
// ==============================================================

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created', 'A new user was created', '', 'The user was deleted');
const ruteContent = "user/";
const nameModel='users';
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
const myModalObjec = document.getElementById('createUpdateModal');
const objForm = document.getElementById('objForm');
// ==============================================================
// This is Variable  
// ==============================================================
var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();

// ==============================================================
// Functions 
// ==============================================================
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/05/2022
*Description:This functions is general for the operations of users
*/
function sendDataUser(e, formObj) {
    let obj = formObj;
    sTForm = new STForm(obj);
    if (sTForm.validateConfirmationsPassword()) {
        if (sTForm.validateForm()) {
            create(sTForm.getDataForm());
            sTForm.clearDataForm(obj);
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
*Date:31/01/2023
*Description:This function create users
*/
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
                console.log(response[dataModel]);
                TOASTS.toastView("", "", arMessages[1], 0);
                hideModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTForm.inputButtonEnable();
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
            });
    }
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function get data id user
*/
function getDataId(id) {
    formData[primaryId] = id;
    url = URL_ROUTE + arRoutes[4];
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
                objSTFrom = new STForm(objForm.id);
                objSTFrom.setDataForm(response[dataModel], objForm.id);
                console.log(response[dataModel]);
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

function hideModal() {
    let modal = bootstrap.Modal.getInstance(myModalObjec);
    modal.hide();
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2023
*Description:This function to show user modal 
*/
function showModal() {
    let modal = bootstrap.Modal.getInstance(myModalObjec);
    modal.show();
}

