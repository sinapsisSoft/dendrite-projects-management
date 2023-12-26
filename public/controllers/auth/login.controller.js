/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:17/01/2023
*Description:General login management functions
*/
// ==============================================================
// Start View
// ==============================================================
$(".preloader").fadeOut();
$("#recoverform").hide();
// ==============================================================
// Login and Recover Password
// ==============================================================
$("#to-recover").on("click", function () {
    $("#loginform").slideUp();
    $("#recoverform").fadeIn();
});

$("#to-login").click(function () {
    $("#recoverform").fadeOut();
    $("#loginform").slideDown();
});

// ==============================================================
// This is Variable  
// ==============================================================

var sTForm = null;
var arRoutes = new Array('login', 'checkUserEmail');
var arMessages = new Array('Revise la información de usuario y contraseña');
var ruteContent = "login/";
var dataModel = 'data';
var dataResponse = 'response';
var dataMessages = 'message';
var assignmentAction = 0;
const URL_ROUTE = BASE_URL + ruteContent;
var url = "";

// ==============================================================
// Functions 
// ==============================================================
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:17/05/2022
*Description:This function send data Login 
*/

function sendDataLogin(e, formObj) {
    let obj = formObj;
    sTForm = new STForm(obj);
    getDataLogin(sTForm.getDataForm());
    sTForm.clearDataForm(obj);
    sTForm.inputButtonDisable();
    e.preventDefault();
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:17/05/2022
*Description:This function recovery Password
*/
function recoveryPassword(e, formObj) {
    let obj = formObj;
    sTForm = new STForm(obj);
    validateEmailUser(sTForm.getDataForm());
    sTForm.clearDataForm(obj);
    sTForm.inputButtonDisable();
    e.preventDefault();
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:31/01/2023
*Description:This function view input password
*/
function viewInputPassword(inputId, iconId) {
    let x = document.getElementById(inputId);
    let icon = document.getElementById(iconId);
    let iconActivie = 'mdi-eye';
    let iconInActivie = 'mdi-eye-off';
    if (x.type === "password") {
        x.type = "text";
        icon.classList.remove(iconActivie);
        icon.classList.add(iconInActivie);
    } else {
        x.type = "password";
        icon.classList.add(iconActivie);
        icon.classList.remove(iconInActivie);
    }
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:31/01/2023
*Description:This function send data  login validate
*/
function getDataLogin(formData) {
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
            } else {
                console.log(arMessages[0]);
            }
            sTForm.inputButtonEnable();
        });
}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:31/01/2023
*Description:This function send data login validate
*/
function validateEmailUser(formData) {
    url = URL_ROUTE + arRoutes[1];
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
                var objResult = document.getElementById('ResultFeedback');
                if (response[dataModel] == null) {
                    objResult.innerHTML = "Error : Usuario no registrado";
                    objResult.classList.remove('valid-feedback');
                    objResult.classList.add('invalid-feedback');
                } else {
                    objResult.innerHTML = "Ok : Correo envíado";
                    objResult.classList.add('valid-feedback');
                    objResult.classList.remove('invalid-feedback');
                    console.log(response[dataModel]);
                }
            } else {
                console.log(arMessages[0]);
            }
            sTForm.inputButtonEnable();
        });
}

