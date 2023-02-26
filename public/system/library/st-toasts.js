/*
*Ahutor:DIEGO CASALLAS
*Busines: SINAPSIS TECHNOLOGIES
*Date:25/02/2022
*Description:Form validation libraries
*Vesion:1.0
*/
class STtoasts {
    //Class variables
    //Constructor method
    constructor() {

        this.arrayType=new Array('successToasts','warningToasts','infoToasts','dangerToasts');
        this.objectToast=document.querySelectorAll('.toast');
        this.toastElList = [].slice.call(this.objectToast);

        this.typeToast=document.getElementById('liveToast');
      
        this.title=document.getElementById('title-toast');
        this.subTitle=document.getElementById('subTitle-toast');
        this.text=document.getElementById('body-toast');
        this.toastList=null;
      
    }

    /*
    *Ahutor:DIEGO CASALLAS
    *Busines: SINAPSIS TECHNOLOGIES
    *Date:25/02/2022
    *Description:Create toast
    */

    toastView(title,subTitle,text,type) {
    
    
        this.toastList = this.toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl);
        });  
        for(var i=0;i<this.arrayType.length;i++){
            this.typeToast.classList.remove(this.arrayType[i]);
        }
        if(type>this.arrayType.length){
            type=0;
        }
        if(title==""){
            title=document.title;
        }
        this.title.innerHTML=title;
        this.subTitle.innerHTML=subTitle;
        this.text.innerHTML=text;
     
        this.typeToast.classList.add(this.arrayType[type]);
        this.toastList.forEach(toast => toast.show());
        
    }
}