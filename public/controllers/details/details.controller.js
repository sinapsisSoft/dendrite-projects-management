const myModalObjec = '#createUpdateModal';
var sTForm = null;
const idForm = 'objForm';

function hideModal() {
    $(myModalObjec).modal("hide");
}

function showModal(type) {
    if (type == 1) {
        sTForm = SingletonClassSTForm.getInstance();
        sTForm.inputButtonEnable();
    }
    sTForm.clearDataForm();
    $(myModalObjec).modal("show");
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