showPreload();

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada');
const myModalObjec = 'welcomeModal';
const welcomeVideo = 'welcome-video';

const ruteContent = "home/";
const nameModel = 'homes';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
const idForm = 'objForm';
const dataReportName = 'reportName';

const URL_ROUTE = BASE_URL + ruteContent;
var sTForm = null;
var formData = new Object();
var first = 0;
var totalProject = 0;
let backgroundColor = ['rgba(255, 159, 64, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 99, 132, 0.2)','rgba(255, 206, 86, 0.2)','rgba(54, 162, 235, 0.2)','rgba(75, 192, 192, 0.2)','rgba(255, 87, 51, 0.2)','rgba(218, 247, 166, 0.2)','rgba(166, 247, 235, 0.2)','rgba(166, 177, 247, 0.2)'];
let borderColor = ['rgba(255, 159, 64, 1)','rgba(153, 102, 255, 1)','rgba(255, 99, 132, 1)','rgba(255, 206, 86, 1)','rgba(54, 162, 235, 1)','rgba(75, 192, 192, 1)','rgba(255, 87, 51, 1)','rgba(218, 247, 166, 1)','rgba(166, 247, 235, 1)','rgba(166, 177, 247, 1)'];

let videoObj = document.getElementById(welcomeVideo);
let modalObj = document.getElementById(myModalObjec);
let lblTotalProject = document.getElementById("total-project");

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

// document.onload = showModal(); DESCOMENTARIAR CUANDO SE TRERMINE DE TRABAJAR LAS GRÁFICAS

modalObj.addEventListener('hidden.bs.modal', function (event) {
  videoObj.pause();
});

function sendData(e) {
  sTForm = SingletonClassSTForm.getInstance();
  showPreload();
  getData(sTForm.getDataForm());
  e.preventDefault();
}

function getData(formData) {
  showPreload();
  url = URL_ROUTE + 'chart';
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
        reportName = response[dataReportName];
        reorderData(response[dataModel]);
        hidePreload();
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
      }
    });
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

function reorderData(jsonData) {
  totalProject = 0;
  if(Array.isArray(jsonData)){
    if(!!jsonData[0]["result"]){
      hideCanvas();
    }
    else {
      if(jsonData.length > 0){
        first++;
        let arrResult = [];
        let month = jsonData[0]['Project_month'];
        let dataString = `"x" : "${jsonData[0]['Project_month']}"`;
        for (const element of jsonData) {
          totalProject += parseInt(element.Client_total);
          if (month != element['Project_month']) {
            arrResult.push(JSON.parse(`{${dataString}}`));
            month = element['Project_month'];
            dataString = `"x" : "${element['Project_month']}"`;
          }
          let keyName = Object.prototype.hasOwnProperty.call(element, 'Client_name');
          dataString += `, "${keyName ? element['Client_name'] : element['Brand_name']}" : ${element['Client_total']}`;
        }
        arrResult.push(JSON.parse(`{${dataString}}`));
        drawChart1(arrResult);
      }      
    }      
  }  
  else if(jsonData == 0){
    drawChart1(jsonData);
  }
}

function drawChart1(jsonData) {
  if (first > 0) {
    document.getElementById('chart1').remove();
    let canvas = document.createElement('canvas');
    canvas.setAttribute('id', 'chart1');
    canvas.setAttribute('width', ' 100%');
    char = document.querySelector('#chart1Report');
    document.getElementById('chart1Report').appendChild(canvas);
  }
  var ctx = document.getElementById('chart1');
  var myChart;
  let labelsName = [];  

  for (let i = 0; i < jsonData.length; i++) {
    labelsName.push(jsonData[i].x);
  };

  myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labelsName,
      datasets: []
    },
    options: {
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      },
      plugins: {
      title: {
        display: true,
        text: reportName
      }
    },
    }
  });
  setTimeout(function (){
    addDataset(myChart, jsonData);
  }, 1000);  
}

function addDataset(myChart, jsonData) {
  var dataKeys = [];
  if (jsonData.length > 0) {
    for (const iterator of jsonData) {
      for (const key in iterator) {
        dataKeys.push(key);
      }
    }
    var labels = dataKeys.filter((item, index) => {
      return dataKeys.indexOf(item) === index;
    })
    for (let i = 1; i < labels.length; i++) {
      var newData = [];
      newData.push({
        label: labels[i],
        data: jsonData,
        parsing: {
          yAxisKey: labels[i]
        },
        borderWidth: 1,
        backgroundColor: [backgroundColor[i - 1]],
        borderColor: [borderColor[i - 1]]
      }
      );
      myChart.config.data.datasets.push(newData[0]);
      myChart.update();
    }
  }
  lblTotalProject.innerText = `TOTAL: ${totalProject}`;
}

window.addEventListener("load", (event) => {
  let initialDate = firstDay();
  let finalDate = lastDay();
  document.getElementById("initialDate").value = formatDate(initialDate);
  document.getElementById("finalDate").value = formatDate(finalDate);
  reorderData(dataJson);
});


function firstDay() {
  var date = new Date();
  return new Date(date.getFullYear(), date.getMonth(), 1);
}

function lastDay() {
  var date = new Date();
  return new Date(date.getFullYear(), date.getMonth() + 1, 0);
}

function formatDate(date) {
  let month = date.getMonth() + 1;
  let day = date.getDate();
  return `${date.getFullYear()}-${(month < 10 ? '0' : '').concat(month)}-${(day < 10 ? '0' : '').concat(day)}`;
}

function hideCanvas(){
  document.getElementById("reportView").innerHTML = "";
  document.getElementById("reportView").innerHTML = "No hay información para mostrar";
}