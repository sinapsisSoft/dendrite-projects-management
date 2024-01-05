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
var arRoutes = new Array('login', 'checkUserEmail', 'sendNotifications', 'editPassword');
var arMessages = new Array('Revise la información de usuario y contraseña','Contraseña actualizada con éxito');
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
    //console.log(url);
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
                    //console.log(response[dataModel]);
                    sendEmail(response[dataModel]);
                }
            } else {
                console.log(arMessages[0]);
            }
            sTForm.inputButtonEnable();
        });
}

function sendEmail(token) {
    url = URL_ROUTE + arRoutes[2];

    data = { token: token };
    fetch(url, {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {

                if (response[dataModel] == null) {


                } else {
                    console.log(response[dataModel]);
                }

            } else {
                console.log(arMessages[0]);
            }

        });


}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:29/12/2023
*Description:This function is to get data change password
*/
function getDataChangePassword(e,formObj) {

    let obj = formObj;
    sTForm = new STForm(obj);

    let inputFields = document.querySelectorAll("input");
    let inputValues = [];
    let menssage = "";
    for (let i = 0; i < inputFields.length; i++) {
        inputValues.push(inputFields[i].value);
    }
    if (inputValues[1] === inputValues[2]) {
        menssage = "";
        sendDataChangePassword(JSON.stringify({ User_id: inputValues[0], User_password: inputValues[1] }));
    } else {
        menssage = "Las contraseñas no coinciden";
    }
    document.getElementById('User_passwordFeedbackRepeat').innerHTML = menssage;
    document.getElementById('User_passwordFeedback').innerHTML = menssage;
    sTForm.clearDataForm(obj);
    sTForm.inputButtonDisable();
    e.preventDefault();

}

/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:29/12/2023
*Description:This function is to send data change password
*/
function sendDataChangePassword(data) {
    url = URL_ROUTE + arRoutes[3];
    fetch(url, {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            
            if (response[dataResponse] == 200) {
                if (response[dataModel] == null) {

                } else {
                    console.log(response[dataModel]);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: arMessages[1],
                        showConfirmButton: false,
                        timer: 1500
                      });
                      setTimeout(()=>{
                        window.location.assign(URL_ROUTE.substring(0,URL_ROUTE.length-1));
                      },2000);
                     
                }

            } else {
                console.log(arMessages[0]);
            }

        });
}

