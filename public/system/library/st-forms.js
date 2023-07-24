/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:16/05/2022
*Description:Form validation libraries
*Vesion:1.0
*/
class STForm {
    //Class variables
    //Constructor method
    constructor(formObj) {

        this.objectForm = document.getElementById(this.validateFormObject(formObj));
        this.objectInput = null;
        this.elementsForm = this.objectForm.length;
        this.elementJson = {};
        this.inputValue = null;
        this.arrayTypeInput = new Array("checkbox", "color", "date", "datetime-local", "email", "file", "hidden", "image", "month", "number", "password", "radio", "range", "reset", "search", "tel", "text", "time", "textarea", "url", "week");
        this.vaslidateInput = true;
        this.textSubmit = "submit";
        this.textButton = "button";
        this.textSelect = "select-one";
        this.textRadio = "radio";
        this.textImg = "image";
        this.objJson = null;
        this.dataLengthJson = 0;
        this.objElementInput = null;
        this.postData = new FormData();
        this.classNameDisableInput = "form-disabled";
        this.classListInput = "";
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Get form data
    */

    getDataForm() {
        for (let i = 0; i < this.elementsForm; i++) {
            if (!((this.objectForm[i].type == this.textSubmit) || (this.objectForm[i].type == this.textButton))) {
                if (this.objectForm[i].getAttribute("src") != null) {
                    this.elementJson[this.objectForm[i].id] = this.objElementInput.src;
                } else {
                    if (this.objectForm[i].type == this.arrayTypeInput[0]) {
                        if (this.objectForm[i].checked) {
                            this.elementJson[this.objectForm[i].id] = true;
                        }
                        else {
                            this.elementJson[this.objectForm[i].id] = false;
                        }
                    } else if (this.objectForm[i].type == this.textSelect) {
                        this.elementJson[this.objectForm[i].id] = this.objectForm[i].value;
                    } else if (this.objectForm[i].type == this.textRadio) {
                        if (this.objectForm[i].checked) {
                            this.elementJson[this.objectForm[i].name] = this.objectForm[i].value;
                        }
                    }
                    else if (this.objectForm[i].required) {
                        this.elementJson[this.objectForm[i].id] = this.objectForm[i].value;
                    } else {
                        this.elementJson[this.objectForm[i].id] = this.objectForm[i].value;
                    }
                }
            }

        }
        return this.elementJson;
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Get form data
    */
    getFormData() {
        for (let i = 0; i < this.elementsForm; i++) {
            if (!((this.objectForm[i].type == this.textSubmit) || (this.objectForm[i].type == this.textButton))) {
                if (this.objectForm[i].type == this.arrayTypeInput[0]) {
                    if (this.objectForm[i].checked) {
                        this.elementJson[this.objectForm[i].id] = true;
                    }
                    else {
                        this.elementJson[this.objectForm[i].id] = false;
                    }
                } else if (this.objectForm[i].type == this.textSelect) {
                    this.postData.append(this.objectForm[i].name, this.objectForm[i].value);
                } else if (this.objectForm[i].type == this.textRadio) {
                    if (this.objectForm[i].checked) {
                        this.postData.append(this.objectForm[i].name, this.objectForm[i].value);
                    }
                }
                else if (this.objectForm[i].type == this.arrayTypeInput[5]) {
                    this.postData.append(this.objectForm[i].name, this.objectForm[i].files[0]);
                }
                else if (this.objectForm[i].required) {
                    this.postData.append(this.objectForm[i].name, this.objectForm[i].value);
                } else {
                    this.postData.append(this.objectForm[i].name, this.objectForm[i].value);
                }
            }
        }
        return this.postData;
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Form data validations requered, empty or with spaces
    */
    validateInput(input) {
        this.vaslidateInput = true;
        this.inputValue = input.value.trim();
        if (input.required) {
            switch (input.type) {
                case this.arrayTypeInput[0]:
                    break;
                case this.arrayTypeInput[1]:
                    break;
                case this.arrayTypeInput[2]:
                    break;
                case this.arrayTypeInput[3]:
                    break;
                case this.arrayTypeInput[4]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
                case this.arrayTypeInput[5]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
                case this.arrayTypeInput[6]:
                    break;
                case this.arrayTypeInput[7]:
                    break;
                case this.arrayTypeInput[8]:
                    break;
                case this.arrayTypeInput[9]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
                case this.arrayTypeInput[10]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
                case this.arrayTypeInput[16]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
                case this.arrayTypeInput[18]:
                    if (this.inputValue.trim() == "" || this.inputValue.length == 0) {
                        this.vaslidateInput = false;
                        input.focus();
                        break;
                    }
                    break;
            }
        }
        return this.vaslidateInput;
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Add data in the form, these methods validate the identification of the Html input with the json key to insert data in each Html element with the value that the Json has
    */
    setDataForm(dataJson) {
        this.objJson = Object.keys(dataJson);
        this.dataLengthJson = this.objJson.length;
        for (let i = 0; i < this.dataLengthJson; i++) {
            this.objElementInput = null;
            this.objElementInput = this.objectForm.querySelector(`#${this.objJson[i]}`);             
            if (i <= this.dataLengthJson) {
                if ((this.objElementInput) != undefined) {
              
                   if (this.objElementInput.type == this.arrayTypeInput[0]) {
                        this.objElementInputchecked = dataJson[this.objJson[i]];
                    } else if (this.objElementInput.type == this.textRadio) {

                        for (let j = 0; j < this.objElementInput.length; j++) {
                            if (this.objElementInput.value == dataJson[this.objJson[i]]) {
                                this.objElementInput.checked = true;
                            } else {
                                this.objElementInput.checked = false;
                            }
                        }
                    }
                    else {
                       
                        this.objElementInput.value = dataJson[this.objJson[i]];
                    }
                    
                    if (this.objElementInput.classList.contains(this.classNameDisableInput)) {
                        this.objElementInput.disabled = true;
                    } else {
                        this.objElementInput.disabled = false;
                    }

                }

            }

        }

    }


    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:31/08/2022
    *Description:Add data in the form, these methods validate the identification of the Html input with the json key to insert data in each Html element with the value that the Json has
    */
    setDataFormDisabled(dataJson, idForm) {
        this.objectForm = document.getElementById(idForm);
        this.objJson = Object.keys(dataJson);
        this.dataLengthJson = this.objJson.length;
        for (let i = 0; i < this.dataLengthJson; i++) {
            this.objElementInput = null;
            this.objElementInput = document.getElementById(this.objJson[i]);
            if (i <= this.dataLengthJson) {
                if (this.objElementInput.getAttribute("src") != null) {
                    this.objElementInput.src = ROUTE_FILE_VIEW_UPLOADS + dataJson[this.objJson[i]];
                    this.objElementInput.value = dataJson[this.objJson[i]];
                } else {
                    if (this.objectForm[i] === undefined) {
                        this.objElementInput = document.getElementById(this.objJson[i]);
                        this.objElementInput.value = dataJson[this.objJson[i]];
                        this.objElementInput.disabled = true;
                    } else if (this.objectForm[i].type == this.arrayTypeInput[0]) {
                        this.objElementInput = document.getElementById(this.objJson[i]);
                        this.objElementInput.checked = dataJson[this.objJson[i]];
                    } else if (this.objectForm[i].type == this.textRadio) {
                        this.objElementInput = document.getElementsByName(this.objJson[i]);
                        for (let j = 0; j < this.objElementInput.length; j++) {
                            if (this.objElementInput[j].value == dataJson[this.objJson[i]]) {
                                this.objElementInput[j].checked = true;
                            } else {
                                this.objElementInput[j].checked = false;
                            }
                        }
                    }
                    else {
                        this.objElementInput = document.getElementById(this.objJson[i])
                        this.objElementInput.value = dataJson[this.objJson[i]];
                        this.objElementInput.disabled = true;
                    }
                }
            }
        }
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:31/08/2022
    *Description:These methods add data to the form, validating the data that should remain disabled
    */
    FormEnableEdit() {
        this.dataLength = this.objectForm.length;
        for (let i = 0; i < this.dataLength; i++) {
            let classInput = this.objectForm[i].classList;
            if (this.objectForm[i].classList.item(i) === 'form-disabled') {
                this.objectForm[i].disabled = true;
            } else {
                this.objectForm[i].disabled = false;
            }
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Form input disable
    */
    inputDisable() {
        for (let i = 0; i < this.elementsForm; i++) {
            if (!((this.objectForm[i].type == this.textSubmit) || (this.objectForm[i].type == this.textButton))) {
                this.objectForm[i].disabled = true;
            }
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:Form input disable
    */
    inputEnable() {
        for (let i = 0; i < this.elementsForm; i++) {
            if (!((this.objectForm[i].type == this.textSubmit) || (this.objectForm[i].type == this.textButton))) {
                this.objectForm[i].disabled = false;
            }
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:01/02/2023
    *Description:Form input and button disable
    */
    inputButtonDisable() {
        for (let i = 0; i < this.elementsForm; i++) {
            this.objectForm[i].disabled = true;
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:01/02/2023
    *Description:Form input and button enable
    */
    inputButtonEnable() {
        for (let i = 0; i < this.elementsForm; i++) {
            this.objectForm[i].disabled = false;
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:This method clear the form
    */
    clearDataForm() {

        this.objectForm.value = "";
        this.objectForm.reset();

    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:This method clear the form
    */
    validateForm() {
        for (let i = 0; i < this.elementsForm; i++) {
            if (!this.validateInput(this.objectForm[i])) {
                return false;
            }
        }
        return true;
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:25/05/2022
    *Description:This method validate two input password 
    */
    validateConfirmationsPassword() {

        let obj = this.objectForm.querySelectorAll("input[type='password']");
        if(obj.length > 0){
            if (obj[0].value == obj[1].value) {
                this.vaslidateInput = true;
            } else {
                obj[1].focus;
                this.vaslidateInput = false;
            }
            return this.vaslidateInput;
        }
    }
    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:17/05/2022
    *Description:This method validate form object or id 
    */
    validateFormObject(formObj) {

        let obj;
        if (typeof formObj === 'object') {

            obj = formObj.id;

        } else {

            obj = formObj;

        }
        return obj;
    }
}
