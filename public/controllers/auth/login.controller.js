
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
// Functions 
// ==============================================================
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:17/05/2022
*Description:This functionsend data Login 
*/
var sTForm=null;
function sendDataLogin(e, formObj) {

    var obj;
    if (typeof formObj === 'object') {
        obj = formObj.id;

    } else {
        obj = formObj;

    }
    sTForm = new STForm(obj);
    getDataLogin(sTForm.getDataForm());
    sTForm.clearDataForm(obj);
    sTForm.inputDisable();
    e.preventDefault();
}
/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:17/05/2022
*Description:This functionsend data Login 
*/
function recoveryPassword(e, formObj) {

    var obj;
    if (typeof formObj === 'object') {
        obj = formObj.id;

    } else {
        obj = formObj;

    }
    const sTForm = new STForm(obj);
    sTForm.clearDataForm(obj);
    e.preventDefault();
}

/*
  *Ahutor:DIEGO CASALLAS
  *Busines: SINAPSIS TECHNOLOGIES
  *Date:31/01/2023
  *Description:This function view input password
  */
function viewInputPassword(inputId, iconId) {
    var x = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    var iconActivie='mdi-eye';
    var iconInActivie='mdi-eye-off';
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
    console.log(formData);
    var url = BASE_URL+"login/login";
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
   
       console.log(response['data']);
       sTForm.inputEnable();
        
      });
  }

