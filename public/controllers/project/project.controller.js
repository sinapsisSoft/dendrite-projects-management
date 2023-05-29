showPreload();

$("#table_obj").DataTable();

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created', 'A new user was created', 'Updated user ', 'The user was deleted');
const ruteContent = "project/";
const nameModel = 'projects';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';

const primaryId = 'Project_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function getManagerByClient() {
    document.getElementById('Client_id')
        .addEventListener('change', function () {
            const data = new FormData();
            const value = document.getElementById('Client_id').value;
            const url = `${BASE_URL}manager/findByClient`;
            data['clientId'] = value;
            fetch(url, {
                method: 'POST',
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
                        const managers = response[dataModel];
                        const managerSelect = document.getElementById('Manager_id');
                        managerSelect.innerHTML = "";
                        managerSelect.innerHTML += "<option value=''>Seleccione...</option>";
                        managers.map(item => {
                            managerSelect.innerHTML += `<option value="${item.Manager_id}">${item.Manager_name}</option>`;
                        });
                    } else {
                        console.log(arMessages[0]);
                    }
                    hidePreload();
                });
        })
}

function getBrandByManager() {
    document.getElementById('Manager_id')
        .addEventListener('change', function () {
            const data = new FormData();
            const value = document.getElementById('Manager_id').value;
            const url = `${BASE_URL}brand/findByManager`;
            data['managerId'] = value;
            fetch(url, {
                method: 'POST',
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
                        const brands = response[dataModel];
                        const brandSelect = document.getElementById('Brand_id');
                        brandSelect.innerHTML = "";
                        brandSelect.innerHTML += "<option value=''>Seleccione...</option>";
                        brands.map(item => {
                            brandSelect.innerHTML += `<option value="${item.Brand_id}">${item.Brand_name}</option>`;
                        });
                    } else {
                        console.log(arMessages[0]);
                    }
                    hidePreload();
                })
        });
}

function details(projectId) {
    window.location = `${BASE_URL}details?projectId=${projectId}`
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
        document.getElementById('Stat_id').setAttribute('disabled', false)
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

document.addEventListener('DOMContentLoaded', function () {
    getManagerByClient();
    getBrandByManager();
})