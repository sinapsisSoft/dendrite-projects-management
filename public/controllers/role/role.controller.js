showPreload();

$("#table_obj").DataTable();

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Validate the entered username and password data', 'A new user was created', 'A new user was created', 'Updated user ', 'The user was deleted');
const ruteContent = "role/";
const nameModel = 'roles';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
let modules = [];

const primaryId = 'Role_id';
const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const myModalObjec = '#createUpdateModal';
const idForm = 'objForm';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var selectInsertOrUpdate = true;

function toggleModule(moduleId, permitId) {
    const exists = 0
    const indexAcces = findAcces(moduleId)
    if (indexAcces >= exists) {
        const existsPermissionByAcces = findPermissionByAccessId(indexAcces, permitId);
        if (existsPermissionByAcces) deletePermission(indexAcces, permitId)
        else addPermission(indexAcces, permitId)
    } else {
        const module = { accesId: moduleId, permissions: [] }
        module.permissions.push(permitId)
        modules.push(module)
    }
}

const findAcces = (accessId) => modules.findIndex(acces => +acces.accesId === accessId)

const findPermissionByAccessId = (index, permissionId) =>
    !!modules[index]?.permissions.find(
        (permission) => +permission === permissionId
    )

const addPermission = (index, permission) => {
    modules[index].permissions.push(permission)
}

const deletePermission = (index, permission) => {
    const permissions = modules[index].permissions
    modules[index].permissions = permissions.filter(p => +p !== permission)
    const totalPermissions = modules[index].permissions.length;
    if (totalPermissions === 0) modules.splice(index, 1);
}

function convertModuleToObjectPhp() {
    return modules.map(module => `${module.accesId};${module.permissions.join(',')}`)
}

function create(formData) {
    url = URL_ROUTE + arRoutes[0];
    formData.modules = convertModuleToObjectPhp();
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
    formData.modules = convertModuleToObjectPhp();
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
    getDataId(idData, true);
    toogleDisabledFields();
}

function toogleDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
    const checkbox = document.querySelectorAll('input[type="checkbox"]');
    checkbox.forEach(checkbox => checkbox.setAttribute('disabled', true))
}

function getDataId(idData, disabledChecbox = false) {
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
                convertResponseToObject(response[dataModel].modules);
                const checkbox = document.querySelectorAll('input[type="checkbox"]');
                checkbox.forEach(item => {
                    const moduleId = item.getAttribute('module-id');
                    const permitId = item.getAttribute('value');
                    const isChecked = isExistsPermitByModuleId(moduleId, permitId);
                    if (isChecked) item.setAttribute('checked', true);
                })
                sTForm.setDataForm(response[dataModel].role);
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

function isExistsPermitByModuleId(moduleId, permitId) {
    const module = modules.find(module => module.accesId === moduleId);
    if (module) return module.permissions.includes(permitId);
    return false;
}

function convertResponseToObject(moduleResponse) {
    modules = moduleResponse.map(response => {
        return {
            accesId: response.mod_id,
            permissions: response.permits ? response.permits.split(',') : []
        }
    })
}

function addData() {

    selectInsertOrUpdate = true;
    showModal(1);
}

function hideModal() {
    $(myModalObjec).modal("hide");
    const checkbox = document.querySelectorAll('input[type="checkbox"]');
    checkbox.forEach(checkbox => checkbox.setAttribute('disabled', false))
}

function showModal(type) {
    if (type == 1) {
        const checkbox = document.querySelectorAll('input[type="checkbox"]');
        checkbox.forEach(item => item.removeAttribute('checked'))
        modules = []
        sTForm = SingletonClassSTForm.getInstance();
        sTForm.inputButtonEnable();
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
