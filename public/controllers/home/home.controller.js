showPreload();

const myModalObjec = 'welcomeModal';
const welcomeVideo = 'welcome-video';

let videoObj = document.getElementById(welcomeVideo);
let modalObj = document.getElementById(myModalObjec);

function hideModal() {
  $(myModalObjec).modal("hide");
}

function showModal() {  
  var myModal = new bootstrap.Modal(document.getElementById(myModalObjec), {
    backdrop: 'static'
  });  
  myModal.show();  
  hidePreload();
}
function showPreload() {
  $(".preloader").fadeIn();
}

function hidePreload() {
  $(".preloader").fadeOut();
}

document.onload = showModal();

modalObj.addEventListener('hidden.bs.modal', function (event) {
  videoObj.pause();
});