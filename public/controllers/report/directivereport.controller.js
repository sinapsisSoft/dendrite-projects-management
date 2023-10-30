showPreload();

tableInfo = $("#table_obj").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

tableInfo2 = $("#table_obj1").DataTable({
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
  }
});

const arRoutes = AR_ROUTES_GENERAL;
const arMessages = new Array('Revise la información suministrada',  'Archivo generado exitosamente');
const ruteContent = "report/";
const nameModel = 'reports';
const dataModel = 'data';
const dataResponse = 'response';
const dataMessages = 'message';
const dataCsrf = 'csrf';
const chart1 = 'chart1';
const chart2 = 'chart2';
const chart3 = 'chart3';
let modules = [];
const backgroundcolors = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(54, 162, 235, 0.2)',
  'rgba(255, 206, 86, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(153, 102, 255, 0.2)',
  'rgba(255, 159, 64, 0.2)'];

const bordercolor = [
  'rgba(255, 99, 132, 1)',
  'rgba(54, 162, 235, 1)',
  'rgba(255, 206, 86, 1)',
  'rgba(75, 192, 192, 1)',
  'rgba(153, 102, 255, 1)',
  'rgba(255, 159, 64, 1)'
];

const URL_ROUTE = BASE_URL + ruteContent;

const TOASTS = new STtoasts();
const idForm = 'objForm';
const infoUrl = '';

var sTForm = null;
var url = "";
var assignmentAction = 0;
var formData = new Object();
var first = 0;

window.addEventListener("load", (event) => {
  let initialDate = firstDay();
  let finalDate = lastDay();
  document.getElementById("initialDate").value = formatDate(initialDate);
  document.getElementById("finalDate").value = formatDate(finalDate);
  drawChart1('chart1', 'bar', dataChart1);
  // drawChart2('chart2', 'polarArea', dataChart2);
  drawChart3('chart3', 'line', dataChart3);
  first++;
});

function reorderChart1(jsonData){
  let arrResult = [];
  for (const iterator of jsonData) {
    arrResult.push(iterator);
  }
  console.log(arrResult);
  return arrResult;  
}

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

function drawChart1(chartId, type, jsonData) {
  var myChart;
  if(first > 0){
    document.getElementById(chartId).remove();
    let canvas = document.createElement('canvas');
    canvas.setAttribute('id',chartId);
    canvas.setAttribute('width','100%');
    document.querySelector('#'+chartId+'Report').appendChild(canvas); 
  }
  var ctx = document.getElementById(chartId);
  myChart = new Chart(ctx, {
    type: type,
    data: {     
      datasets: [{
        label: 'Cumplimiento de proyectos ',        
        data: jsonData,        
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]      
    },
    options: {
      parsing: {
        xAxisKey: 'Project_name',
        yAxisKey: 'Project_estimation'
      },
      plugins: {
        title: {
          display: true,
          text: 'Porcentaje de cumplimiento de los proyectos'
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Proyecto'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Cumplimiento'
          }
        }
      }
    }
  });
}

function drawChart2(chartId, type, jsonData) {
  var myChart;
  if(first > 0){
    document.getElementById(chartId).remove();
    let canvas = document.createElement('canvas');
    canvas.setAttribute('id',chartId);
    canvas.setAttribute('width','100%');
    document.querySelector('#'+chartId+'Report').appendChild(canvas); 
  }
  let labels = [], data = [];
  if (jsonData.length > 0 || jsonData != 0) {
    for (const iterator of jsonData) {
      labels.push(iterator["Project_name"]);
      data.push(iterator["Project_percentage"])
    }
  }
  
  var ctx = document.getElementById(chartId);
  myChart = new Chart(ctx, {    
    type: type,
    data: {     
      labels: labels,
      datasets: [{
        label: 'Avance del proyecto',        
        data: data,        
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]      
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Porcentaje de avance de los proyectos'
        }
      }
    }    
  });
}

function drawChart3(chartId, type, jsonData) {
  
  var myChart;
  if(first > 0){
    document.getElementById(chartId).remove();
    let canvas = document.createElement('canvas');
    canvas.setAttribute('id',chartId);
    canvas.setAttribute('width','100%');
    document.querySelector('#'+chartId+'Report').appendChild(canvas); 
  }  
  var ctx = document.getElementById(chartId);
  myChart = new Chart(ctx, {    
    type: type,
    options: {
      plugins: {
        title: {
          text: 'Cantidad de solicitudes por gerente',
          display: true
        }
      },
      scales: {
        x: {
          type: 'time',
          time: {
            tooltipFormat: 'MMM-y'
          },
          title: {
            display: true,
            text: 'Fecha'
          }
        },
        y: {
          title: {
            display: true,
            text: 'Cantidad de solicitudes'
          }
        }
      },
    },
  });
  setTimeout(function (){
    addDataset(myChart, jsonData);
  }, 1000);  
}

function addDataset(myChart, jsonData) {
  let labels = [];
  let dataset = [], newLabel = '';  
  for(let i = 0; i < jsonData.length; i++){
    labels.includes(jsonData[i]['Manager_name']) ? '' : labels.push(jsonData[i]['Manager_name']);
  }
  for (let i = 0; i < labels.length; i++) {
    let data = [];
    for (const iterator of jsonData) {      
      if (labels[i] == iterator['Manager_name']) {
        newLabel = iterator['Manager_name'];
        let newElement = {
          x: iterator['Project_date'],
          y: iterator['Project_count']
        }
        data.push(newElement);
      }      
    }
    let color = Math.floor(Math.random() * backgroundcolors.length);
    let newdataSet = {
      label: newLabel,
      backgroundColor: backgroundcolors[color],
      borderColor: bordercolor[color],
      fill: false,
      data: data
    }
    myChart.config.data.datasets.push(newdataSet);
    myChart.update();
  }
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

function sendData(e) {
  sTForm = SingletonClassSTForm.getInstance();
  showPreload();
  getData(sTForm.getDataForm());
  e.preventDefault();
}

function getData(formData) {
  showPreload();
  url = URL_ROUTE + 'createCharts';
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
        drawChart1('chart1', 'bar', response[chart1]);
        drawChart3('chart3', 'line', response[chart3]);
        createTable('table_obj', response['dataTable']);
        createTable2('table_obj1', response['dataTable2']);
        hidePreload();
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );
        hidePreload();
      }
    });
}


function createTable(tblid, jsonData){  
  tableInfo.destroy();
  let tableBody = document.querySelector(`#${tblid}`).children[1];
  let i = 1, newRow = '';  
  for (const iterator of jsonData) {
    newRow += `<tr>
      <td>${i}</td>
      <td>REQ_${iterator['ProjReq_id']}</td>
      <td>${iterator['Client_name']}</td>
      <td>${iterator['Manager_name']}</td>
      <td>${iterator['Brand_name']}</td>
      <td>${iterator['Prod_name'] == null ? '' : iterator['Prod_name']}</td>
      <td>${iterator['ProjReq_name']}</td>
      <td>${iterator['Project_code'] == null ? '' : iterator['Project_code']}</td>
      <td>${iterator['User_name'] == null ? '' : iterator['User_name']}</td>
      <td>${iterator['Stat_name']}</td>
      <td>${iterator['created_at']}</td>
      </tr>`;
    i++;
  }
  tableBody.innerHTML = newRow;
  tableInfo = $(`#${tblid}`).DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    }
  });
}

function createTable2(tblid, jsonData) {
  tableInfo2.destroy();
  let tableBody = document.querySelector(`#${tblid}`).children[1];
  let i = 1, newRow = '';  
  for (const iterator of jsonData) {
    newRow += `<tr>
      <td>${i}</td>
      <td>${iterator['Project_code']}</td>
      <td>${iterator['Project_name']}</td>
      <td>${iterator['Project_purchaseOrder']}</td>                                
      <td>${iterator['Client_name']}</td>
      <td>${iterator['Country_name']}</td>
      <td>${iterator['Manager_name']}</td>
      <td>${iterator['Brand_name']}</td>
      <td>${iterator['Project_startDate']}</td>                                
      <td>${iterator['Project_percentage']}</td>                                
      <td>${iterator['Project_estimatedEndDate']}</td>                                
      <td>${iterator['Project_activitiEndDate']}</td>  
      <td>${iterator['Project_commercialName']}</td>                                   
      <td>${iterator['Project_traffic']}</td>  
      <td>${iterator['Activi_name']}</td>
      <td>${iterator['Prod_name']}</td>
      <td>${iterator['Activi_startDate']}</td>
      <td>${iterator['Activi_endDate']}</td>                                
      <td>${iterator['SubAct_name']}</td>
      <td>${iterator['User_name']}</td>
      <td>${iterator['SubAct_percentage']}</td>
      <td>${iterator['SubAct_estimatedEndDate']}</td>
      <td>${iterator['SubAct_endDate']}</td>
      </tr>`;
    i++;
  }
  tableBody.innerHTML = newRow;
  tableInfo2 = $(`#${tblid}`).DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    }
  });
}

function downloadExcel(type){
  var reportRoute = ['administrativeExcel', 'administrativeExcel2'];
  sTForm = SingletonClassSTForm.getInstance();
  showPreload();
  generateExcel(sTForm.getDataForm(), reportRoute[type]);
}

function generateExcel(formData, route) {
  showPreload();
  url = URL_ROUTE + route;
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
        window.open(BASE_URL + response['document']);
        Swal.fire(
          'Descarga exitosa',
          arMessages[1],
          'success'
        );
      } else {
        Swal.fire(
          '¡No pudimos hacer esto!',
          arMessages[0],
          'error'
        );        
      }
      hidePreload();
    });
}



// document.getElementById('btn-info').href = infoUrl;