
const ruteContentTracking = "projecttracking/";
const nameModelTracking = 'projecttrackings';
const dataModelTracking = 'data';
const dataResponseTracking = 'response';
const dataMessagesTracking = 'message';
const dataCsrfTracking = 'csrf';

const primaryIdTracking = 'ProjectTrack_id';
const URL_ROUTETracking = BASE_URL + ruteContentTracking;

const TOASTSTracking = new STtoasts();
const TrackingModal = '#TrackingModal';
const idTrackingForm = 'objTrackingForm';

var sTFormTracking = null
var urlTracking = "";
var assignmentActionTracking = 0;
var formDataTracking = new Object();
var selectInsertOrUpdateTracking = true;

function createTracking(formData) {
    urlTracking = URL_ROUTETracking + arRoutes[0];
    fetch(urlTracking, {
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
                TOASTSTracking.toastView("", "", arMessages[1], 0);
                hidelTrackingModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormTracking.inputButtonEnable();
            hidePreload();
        });
}

function updateTracking(formData) {
    urlTracking = URL_ROUTETracking + arRoutes[2];
    fetch(urlTracking, {
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
                TOASTSTracking.toastView("", "", arMessages[3], 0);
                hidelTrackingModal();
                window.location.reload();
            } else {
                console.log(arMessages[0]);
            }
            sTFormTracking.inputButtonEnable();
            hidePreload();
        });
}

function deleteTracking(id) {
    let text = "Do you want to carry out this process?\n OK or Cancel.";
    if (confirm(text) == true) {
        showPreload();
        urlTracking = URL_ROUTETracking + arRoutes[3];
        formData[primaryIdTracking] = id;
        fetch(urlTracking, {
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

function sendTrackingData(e, formObj) {
    debugger;
    let obj = formObj;
    sTFormTracking = SingletonClassSTFormTracking.getInstance();
    if (sTFormTracking.validateForm()) {
        showPreload();
        if (selectInsertOrUpdateTracking) {
            createTracking(sTFormTracking.getDataForm());
        } else {
            updateTracking(sTFormTracking.getDataForm());
        }
        sTFormTracking.inputButtonDisable();
    } else {
        TOASTSTracking.toastView("", "", arMessages[0], 1);
    }
    e.preventDefault();
}

function detail(idData) {
    getDataId(idData);
    toogleDisabledFields();
}

function toogleTrackingDisabledFields() {
    const btnSubmit = document.getElementById('btn-submit');
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.classList.add('form-disabled'))
    const selects = document.querySelectorAll('select')
    selects.forEach(select => select.classList.add('form-disabled'))
    btnSubmit.disabled = true;
}

function getTrackingDataId(idData) {
    showPreload();
    selectInsertOrUpdateTracking = false;
    formDataTracking[primaryIdTracking] = idData;
    urlTracking = URL_ROUTETracking + arRoutes[4];
    sTFormTracking = SingletonClassSTFormTracking.getInstance();
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
                showTrackingModal(0);
                sTForm.setDataForm(response[dataModel]);
                hidePreload();
            } else {
                console.log(arMessages[0]);
            }
        });
}

function addTrackingData() {
    selectInsertOrUpdateTracking = true;
    showTrackingModal(1);
}

function hidelTrackingModal() {
    $(TrackingModal).modal("hide");
}

function showTrackingModal(type) {
    debugger;
    if (type == 1) {
        sTFormTracking = SingletonClassSTFormTracking.getInstance();
        sTFormTracking.inputButtonEnable();
    }
    sTFormTracking.clearDataForm();
    $(TrackingModal).modal("show");
}

var SingletonClassSTFormTracking = (function () {
    var objInstance;
    function createInstance() {
        var object = new STForm(idTrackingForm);
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