
const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created', 'A new user was created', 'Updated user ', 'The user was deleted');
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
    debugger;
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

function getDataId(idData) {
    debugger;
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

function showEmailModal(type) {
    debugger;
    if (type == 1) {
        sTFormEmail = SingletonClassSTFormEmail.getInstance();
        sTFormEmail.inputButtonEnable();
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
    debugger;
    if (type == 1) {
        sTFormFin = SingletonClassSTFormFin.getInstance();
        sTFormFin.inputButtonEnable();
    }
    sTFormFin.clearDataForm();
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