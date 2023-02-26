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
var sTForm = null;
const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created');
const ruteContent = "user/";
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
var assignmentAction = 0;
const URL_ROUTE = BASE_URL + ruteContent;
var url = "";
const TOASTS = new STtoasts();
const myModalObjec = document.getElementById('userModal');
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
*Description:This function to hide user modal 
*/

function hideModal() {
    let modal = bootstrap.Modal.getInstance(myModalObjec);
    modal.hide();
}
function showModal() {
    let modal = bootstrap.Modal.getInstance(myModalObjec);
    modal.show();
}

