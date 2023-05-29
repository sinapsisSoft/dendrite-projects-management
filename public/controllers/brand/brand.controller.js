// $("#table_obj_Brand").DataTable();

const ruteContentBrand = "brand/";
const nameModelBrand = 'brands';
const dataModelBrand = 'data';
const dataResponseBrand = 'response';
const dataMessagesBrand = 'message';
const dataCsrfBrand = 'csrf';

const primaryIdBrand = 'Brand_id';
const URL_ROUTEBrand = BASE_URL + ruteContentBrand;

const TOASTSBrand = new STtoasts();
const BrandModal = '#BrandModal';
const idBrandForm = 'objBrandForm';

var sTFormBrand = null
var urlBrand = "";
var assignmentActionBrand = 0;
var formDataBrand = new Object();
var selectInsertOrUpdateBrand = true;

function createBrand(formData) {
    urlBrand = URL_ROUTEBrand + arRoutes[0];
    formData['Client_id'] = document.getElementById('Client_id').value;
    fetch(urlBrand, {
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
                TOASTSBrand.toastView("", "", arMessages[1], 0);
                hidelBrandModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormBrand.inputButtonEnable();
            hidePreload();
        });
}

function updateBrand(formData) {
    urlBrand = URL_ROUTEBrand + arRoutes[2];
    formData['Client_id'] = document.getElementById('Client_id').value;
    fetch(urlBrand, {
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
                TOASTSBrand.toastView("", "", arMessages[3], 0);
                hidelBrandModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormBrand.inputButtonEnable();
            hidePreload();
        });
}

function deleteBrand(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
        showPreload();
        urlBrand = URL_ROUTEBrand + arRoutes[3];
        formData[primaryIdBrand] = id;
        fetch(urlBrand, {
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

function sendBrandData(e, formObj) {
    debugger;
    let obj = formObj;
    sTFormBrand = SingletonClassSTFormBrand.getInstance();
    if (sTFormBrand.validateForm()) {
        showPreload();
        if (selectInsertOrUpdateBrand) {
            createBrand(sTFormBrand.getDataForm());
        } else {
            updateBrand(sTFormBrand.getDataForm());
        }
        sTFormBrand.inputButtonDisable();
    } else {
        TOASTSBrand.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}

function detailBrand(idData) {
    getBrandDataId(idData);
    toogleBrandDisabledFields();
}

function toogleBrandDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
}

function getBrandDataId(idData) {
    showPreload();
    selectInsertOrUpdateBrand = false;
    formDataBrand[primaryIdBrand] = idData;
    urlBrand = URL_ROUTEBrand + arRoutes[4];
    sTFormBrand = SingletonClassSTFormBrand.getInstance();
    fetch(urlBrand, {
        method: "POST",
        body: JSON.stringify(formDataBrand),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {
                showBrandModal(0);
                sTFormBrand.setDataForm(response[dataModel]);
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

function addBrandData() {
    selectInsertOrUpdateBrand = true;
    showBrandModal(1);
}

function hidelBrandModal() {
    $(BrandModal).modal("hide");
}

function showBrandModal(type) {
    debugger;
    if (type == 1) {
        sTFormBrand = SingletonClassSTFormBrand.getInstance();
        sTFormBrand.inputButtonEnable();
    }
    sTFormBrand.clearDataForm();
    $(BrandModal).modal("show");
}



var SingletonClassSTFormBrand = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idBrandForm);
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