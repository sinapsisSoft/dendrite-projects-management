// $("#table_obj_Manager").DataTable();

const ruteContentManager = "manager/";
const nameModelManager = 'managers';
const dataModelManager = 'data';
const dataResponseManager = 'response';
const dataMessagesManager = 'message';
const dataCsrfManager = 'csrf';

const primaryIdManager = 'Manager_id';
const URL_ROUTEManager = BASE_URL + ruteContentManager;

const TOASTSManager = new STtoasts();
const ManagerModal = '#ManagerModal';
const idManagerForm = 'objManagerForm';

var sTFormManager = null
var urlManager = "";
var assignmentActionManager = 0;
var formDataManager = new Object();
var selectInsertOrUpdateManager = true;

let brands = [];


function createManager(formData) {
    urlManager = URL_ROUTEManager + arRoutes[0];
    formData['Client_id'] = document.getElementById('Client_id').value;
    formData['Brands'] = brands;
    fetch(urlManager, {
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
                TOASTSManager.toastView("", "", arMessages[1], 0);
                hidelManagerModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormManager.inputButtonEnable();
            hidePreload();
        });
}

function toggleBrand(brandId) {
    const isExists = !!brands.find(brand => brand === brandId);
    if (isExists) {
        brands = brands.filter(brand => brand !== brandId);
    }
    else {
        brands.push(brandId);
    }
}

function updateManager(formData) {
    urlManager = URL_ROUTEManager + arRoutes[2];
    formData['Client_id'] = document.getElementById('Client_id').value;
    formData['Brands'] = brands;
    fetch(urlManager, {
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
                TOASTSManager.toastView("", "", arMessages[3], 0);
                hidelManagerModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormManager.inputButtonEnable();
            hidePreload();
        });
}

function deleteManager(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
        showPreload();
        urlManager = URL_ROUTEManager + arRoutes[3];
        formData[primaryIdManager] = id;
        fetch(urlManager, {
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

function sendManagerData(e, formObj) {
    debugger;
    let obj = formObj;
    sTFormManager = SingletonClassSTFormManager.getInstance();
    if (sTFormManager.validateForm()) {
        showPreload();
        if (selectInsertOrUpdateManager) {
            createManager(sTFormManager.getDataForm());
        } else {
            updateManager(sTFormManager.getDataForm());
        }
        sTFormManager.inputButtonDisable();
    } else {
        TOASTSManager.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}

function detailManager(idData) {
    getManagerDataId(idData);
    toogleDisabledFields();
}

function toogleManagerDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
}

function getManagerDataId(idData) {
    showPreload();
    selectInsertOrUpdateManager = false;
    formDataManager[primaryIdManager] = idData;
    urlManager = URL_ROUTEManager + arRoutes[4];
    sTFormManager = SingletonClassSTFormManager.getInstance();
    fetch(urlManager, {
        method: "POST",
        body: JSON.stringify(formDataManager),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {
                showManagerModal(0);
                const result = response[dataModel];
                setManagerBrands(result.brands, result.manager['Manager_id']);
                sTFormManager.setDataForm(result.manager);
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

function setManagerBrands(brands, managerId) {
    removeElementsFromList();
    const ul = document.getElementById("managerBrands");
    const managerBrands = brands.filter(brand => brand["Manager_id"] === null || brand["Manager_id"] == managerId)
    managerBrands.forEach(managerBrand => {
        const li = `<li class="col-4">
            <div class="form-check">
                <input class="form-check-input" ${managerBrand["Manager_id"] == managerId ? 'checked' : ''} type="checkbox" onchange="toggleBrand(${managerBrand["Brand_id"]})">
                <label class="form-check-label">${managerBrand["Brand_name"]}</label>
            </div>
        </li>`;
        ul.innerHTML += li;
    })
}

function removeElementsFromList() {
    // Obtén una referencia al elemento 'ul'
    var ulElement = document.getElementById('managerBrands');

    // Obtén una colección de elementos 'li' dentro del 'ul'
    var liElements = ulElement.getElementsByTagName('li');

    // Convierte la colección en un array para facilitar la iteración
    var liArray = Array.from(liElements);

    // Elimina los elementos 'li' uno por uno
    liArray.forEach(function (li) {
        ulElement.removeChild(li);
    });

}

function addManagerData() {
    selectInsertOrUpdateManager = true;
    showManagerModal(1);
}

function hidelManagerModal() {
    $(ManagerModal).modal("hide");
}

function showManagerModal(type) {
    debugger;
    if (type == 1) {
        sTFormManager = SingletonClassSTFormManager.getInstance();
        sTFormManager.inputButtonEnable();
    }
    sTFormManager.clearDataForm();
    $(ManagerModal).modal("show");
}



var SingletonClassSTFormManager = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idManagerForm);
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