// $("#table_obj_activities").DataTable();

const ruteContentActivities = "activities/";
const nameModelActivities = 'activities';
const dataModelActivities = 'data';
const dataResponseActivities = 'response';
const dataMessagesActivities = 'message';
const dataCsrfActivities = 'csrf';

const primaryIdActivities = 'Activi_id';
const URL_ROUTEActivities = BASE_URL + ruteContentActivities;

const TOASTSActivities = new STtoasts();
const activitiesModal = '#activitiesModal';
const idActivitiesForm = 'objActivitiesForm';

var sTFormActivities = null
var urlActivities = "";
var assignmentActionActivities = 0;
var formDataActivities = new Object();
var selectInsertOrUpdateActivities = true;

function details(subactivitiesId) {
    window.location = `${BASE_URL}subactivities?activitiesId=${subactivitiesId}`
}

function createActivities(formData) {
    urlActivities = URL_ROUTEActivities + arRoutes[0];
    debugger;
    fetch(urlActivities, {
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
                TOASTSActivities.toastView("", "", arMessages[1], 0);
                hidelActivitiesModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormActivities.inputButtonEnable();
            hidePreload();
        });
}

function updateActivities(formData) {
    urlActivities = URL_ROUTEActivities + arRoutes[2];
    fetch(urlActivities, {
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
                TOASTSActivities.toastView("", "", arMessages[3], 0);
                hidelActivitiesModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormActivities.inputButtonEnable();
            hidePreload();
        });
}

function deleteActivities(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
        showPreload();
        urlActivities = URL_ROUTEActivities + arRoutes[3];
        formData[primaryIdActivities] = id;
        fetch(urlActivities, {
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

function sendActivitiesData(e, formObj) {
    debugger;
    let obj = formObj;
    sTFormActivities = SingletonClassSTFormActivities.getInstance();
    if (sTFormActivities.validateForm()) {
        showPreload();
        if (selectInsertOrUpdateActivities) {
            createActivities(sTFormActivities.getDataForm());
        } else {
            updateActivities(sTFormActivities.getDataForm());
        }
        sTFormActivities.inputButtonDisable();
    } else {
        TOASTSActivities.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}

function detailActivities(idData) {
    getActivitiesDataId(idData);
    toogleDisabledFields();
}

function toogleActivitiesDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
}

function getActivitiesDataId(idData) {
    showPreload();
    selectInsertOrUpdateActivities = false;
    formDataActivities[primaryIdActivities] = idData;
    urlActivities = URL_ROUTEActivities + arRoutes[4];
    sTFormActivities = SingletonClassSTFormActivities.getInstance();
    fetch(urlActivities, {
        method: "POST",
        body: JSON.stringify(formDataActivities),
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        }
    })
        .then(response => response.json())
        .catch(error => console.error('Error:', error))
        .then(response => {
            if (response[dataResponse] == 200) {
                showActivitiesModal(0);
                sTFormActivities.setDataForm(response[dataModel]);
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

function addActivitiesData() {
    selectInsertOrUpdateActivities = true;
    showActivitiesModal(1);
}

function hidelActivitiesModal() {
    $(activitiesModal).modal("hide");
}

function showActivitiesModal(type) {
    debugger;
    if (type == 1) {
        sTFormActivities = SingletonClassSTFormActivities.getInstance();
        sTFormActivities.inputButtonEnable();
    }
    sTFormActivities.clearDataForm();
    $(activitiesModal).modal("show");
}



var SingletonClassSTFormActivities = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idActivitiesForm);
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