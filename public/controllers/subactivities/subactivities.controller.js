
const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered subactivity data', 'A new subactivity was created', 'A subactivity was created', 'Updated subactivity ', 'The subactivity was deleted');
const ruteContent = "subactivities/";
const nameModel = 'subactivities';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'SubAct_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';
const idEmailForm = 'objEmailForm';
const idFinForm = 'objEmailForm';


var sTForm = null;
var sTFormEmail = null
var sTFormFin = null
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

let collaborators = [];
let finishTask = null;

function toogleCollaborator(email) {
    const isExists = !!collaborators.find(collaborator => collaborator === email);
    if (isExists) collaborators = collaborators.filter(collaborator => collaborator !== email)
    else collaborators.push(email);
}

function finish() {
    showPreload();
    url = URL_ROUTE + 'finish';
    const id = finishTask.SubAct_id;
    const object = { id };
    fetch(url, {
        method: "POST",
        body: JSON.stringify(object),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    }).then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {
                TOASTS.toastView("", "", "Correo enviado con exito", 0);
                $(finModal).modal("hide");
            } else {
                console.log(arMessages[0]);
            }
            hidePreload();
        });
}

function sendNotification() {
    showPreload();
    url = URL_ROUTE + 'notification';
    const form = SingletonClassSTFormEmail.getInstance();
    const formData = form.getDataForm();
    formData['collaborators'] = collaborators.join(',');
    fetch(url, {
        method: "POST",
        body: JSON.stringify(formData),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    }).then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {
                console.log(response[dataModel]);
                TOASTS.toastView("", "", "Notificacion enviada con éxito", 0);
                $(emailModal).modal("hide");
            } else {
                console.log(arMessages[0]);
            }
            form.inputButtonEnable();
            hidePreload();
        });
}

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
            hidePreload();
        });
}

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

function delete_(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
        showPreload();
        url = URL_ROUTE + arRoutes[3];
        formData[primaryId] = id;
        formData['activityId'] = document.getElementById('Activi_id').value;
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
        TOASTS.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}

function detail(idData) {
    getDataId(idData);
    toogleDisabledFields();
}

function toogleDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
}

function getDataIdFinish(idData) {
    showPreload();
    selectInsertOrUpdate = false;
    formData[primaryId] = idData;
    url = URL_ROUTE + arRoutes[4];
    sTForm = SingletonClassSTFormFin.getInstance();
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
                showFinModal(0);
                finishTask = response[dataModel];
                document.getElementById('finish_id').value = finishTask.SubAct_id;
                document.getElementById('finish_name').value = finishTask.SubAct_name;
                document.getElementById('finish_estimatedEndDate').value = finishTask.SubAct_estimatedEndDate;
                document.getElementById('finish_description').value = finishTask.SubAct_description;
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

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

function addData() {
    selectInsertOrUpdate = true;
    showModal(1);
}

function hideModal() {
    $(myModalObjec).modal("hide");
}

function showModal(type) {
    if (type == 1) {
        sTForm = SingletonClassSTForm.getInstance();
        sTForm.inputButtonEnable();
        document.getElementById('Stat_id').setAttribute('disabled', true)
    } else {
        document.getElementById('Stat_id').setAttribute('disabled', false);
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

function showEmailModal(type, idData) {
    if (type == 1) {
        sTFormEmail = SingletonClassSTFormEmail.getInstance();
        sTFormEmail.inputButtonEnable();
        document.getElementById('not_subId').value = idData;
    }    
    sTFormEmail.clearDataForm();
    $(emailModal).modal("show");
}

var SingletonClassSTFormEmail = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idEmailForm);
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

function showFinModal(type) {
    $(finModal).modal("show");
}

var SingletonClassSTFormFin = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idFinForm);
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

function changePercent() {
    document.getElementById('SubAct_percentage').addEventListener('change', function (e) {
        const value = +e.target.value;
        const options = document.getElementById('Stat_id');
        if (value === 0) {
            for (let i = 0; i < options.length; i++) {
                const text = options[i].innerText.trim();
                if (text === 'Sin asignar') {
                    options[i].selected = "true";
                }
            }
        } else if (value > 0 && value < 100) {
            for (let i = 0; i < options.length; i++) {
                const text = options[i].innerText.trim();
                if (text === 'Pendiente') {
                    options[i].selected = "true";
                }
            }
        } else {
            for (let i = 0; i < options.length; i++) {
                const text = options[i].innerText.trim();
                if (text === 'Realizado') {
                    options[i].selected = "true";
                }
            }
        }
    });
}



document.addEventListener('DOMContentLoaded', () => {
    changePercent();
})