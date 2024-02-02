<!DOCTYPE html>
<html dir="ltr">

<head>
  <?= $meta ?>
  <title>
    <?= $title ?>
  </title>
  <?= $css ?>
</head>

<body>
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <?= $header ?>
    <?= $sidebar ?>
    <div class="page-wrapper">
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
            <div class="ms-auto text-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>home">Inicio</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>report">Reporte General</a>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">
                  REPORTE GENERAL
                </h5>
                <ul class="nav nav-tabs nav-fill">
                  <li class="nav-item">
                    <a class="nav-link active" id="report1-tab" data-bs-toggle="tab" data-bs-target="#report1" role="tab" aria-controls="report1" aria-selected="true">Reporte General</a>
                  </li>
                </ul>
                <div class="tab-content" id="tabContent">
                  <div class="tab-pane fade show active" id="report1" role="tabpanel" aria-labelledby="report1-tab">
                    <div class="row">
                      <form class="form-horizontal mt-3 row justify-content-center" id="objForm">
                        <div class="col-12 my-4">
                          <h6 class="m-0 font-weight-bold text-primary">Seleccione el rango de fechas para generar el reporte</h6>
                        </div>
                        <div class="col-12 col-md-5">
                          <label for="initialDate">Fecha Inicial </label>
                          <input type="date" id="initialDate" value="" class="form-control bg-light border-0">
                        </div>
                        <div class="col-10 col-md-5">
                          <label for="finalDate">Fecha Final </label>
                          <input type="date" id="finalDate" value="" class="form-control bg-light border-0">
                        </div>
                        <div class="col-auto align-self-end">
                          <button type="submit" class="btn btn-primary" onclick="sendData(event);return false">
                            <i class="fas fa-search fa-sm"></i>
                            <div class="ripple-container"></div>
                          </button>
                        </div>
                      </form>
                    </div>
                    <div class="row reportChart align-items-center justify-content-center">
                      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="row">
                          <div id="chart1Report" class="col-12 my-3 shadow-sm">
                            <canvas id="chart1" style="width: 100%;"></canvas>
                          </div>
                          <div id="chart3Report" class="col-12 my-3 shadow-sm">
                            <canvas id="chart3" style="width: 100%;"></canvas>
                          </div>
                        </div>
                      </div>
                      <div id="chart2Report" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <canvas id="chart2" style="width: 100%;"></canvas>
                      </div>
                    </div>
                    <div class="row justify-content-end">
                      <button type="button" class="btn btn-light my-3 mx-4 col-auto" onclick="downloadExcel(); return false;">
                        <lord-icon src="<?= base_url() ?>/assets/json/system-outline-12-arrow-down.json" id="btn-excel" trigger="hover" colors="primary:#28b779" style="width:35px;height:35px">
                        </lord-icon>
                      </button>
                    </div>
                    <div class="card-pp">
                      <div class="table-responsive">
                        <table id="table_obj" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Código</th>
                              <th>Proyecto</th>                                                         
                              <th>Cliente</th>
                              <th>País</th>
                              <th>Orden de compra</th>   
                              <th>Factura</th>   
                              <th>Estado factura</th>   
                              <th>Fecha factura</th>   
                              <th>Gerente</th>
                              <th>Marca</th>
                              <th>Fecha inicio proyecto</th>
                              <th>Avance proyecto</th>
                              <th>Fecha estimada entrega proyecto</th>
                              <th>Fecha finalización proyecto</th>
                              <th>Tráfico</th>
                              <th>Actividad</th>
                              <th>Producto</th>
                              <th>Fecha estimada entrega actividad</th>
                              <th>Fecha finalización actividad</th>                              
                              <th>Subactividad</th>
                              <th>Colaborador</th>
                              <th>% Avance</th>
                              <th>Fecha estimada entrega subactividad</th>
                              <th>Fecha finalización subactividad</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($dataTable as $obj) : ?>
                              <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $obj->Project_code; ?></td>
                                <td><?= $obj->Project_name; ?></td>                                                              
                                <td><?= $obj->Client_name; ?></td>
                                <td><?= $obj->Country_name; ?></td>
                                <td><?= $obj->Project_purchaseOrder; ?></td>  
                                <td><?= $obj->Project_invoice == null ? '' : $obj->Project_invoice; ?></td>  
                                <td><?= $obj->Project_invoiceState == null ? '' : $obj->Project_invoiceState; ?></td>  
                                <td><?= $obj->Project_invoiceDate == null ? '' : $obj->Project_invoiceDate; ?></td>  
                                <td><?= $obj->Manager_name; ?></td>
                                <td><?= $obj->Brand_name; ?></td>
                                <td><?= $obj->Project_startDate; ?></td>                                
                                <td><?= $obj->Project_percentage; ?></td>                                
                                <td><?= $obj->Project_estimatedEndDate; ?></td>                                
                                <td><?= $obj->Project_activitiEndDate; ?></td>                                
                                <td><?= $obj->Project_traffic; ?></td>                                
                                <td><?= $obj->Activi_name; ?></td>
                                <td><?= $obj->Prod_name; ?></td>
                                <td><?= $obj->Activi_startDate; ?></td>
                                <td><?= $obj->Activi_endDate; ?></td>                                
                                <td><?= $obj->SubAct_name; ?></td>
                                <td><?= $obj->User_name; ?></td>
                                <td><?= $obj->SubAct_percentage; ?></td>
                                <td><?= $obj->SubAct_estimatedEndDate; ?></td>
                                <td><?= $obj->SubAct_endDate; ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>#</th>
                              <th>Código</th>
                              <th>Proyecto</th>                             
                              <th>Cliente</th>
                              <th>País</th>
                              <th>Orden de compra</th>   
                              <th>Factura</th>   
                              <th>Estado factura</th>   
                              <th>Fecha factura</th>   
                              <th>Gerente</th>
                              <th>Marca</th>
                              <th>Fecha inicio proyecto</th>
                              <th>Avance proyecto</th>
                              <th>Fecha estimada entrega proyecto</th>
                              <th>Fecha finalización proyecto</th>
                              <th>Tráfico</th>
                              <th>Actividad</th>
                              <th>Producto</th>
                              <th>Fecha estimada entrega actividad</th>
                              <th>Fecha finalización actividad</th>                              
                              <th>Subactividad</th>
                              <th>Colaborador</th>
                              <th>% Avance</th>
                              <th>Fecha estimada entrega subactividad</th>
                              <th>Fecha finalización subactividad</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?= $footer ?>
      <?= $toasts ?>
    </div>
  </div>
  <?= $js ?>
  <script src="./assets/js/char.min.js"></script>
  <script src="./assets/js/chartjs-adapter-date-fns.bundle.min.js"></script>
  <script src="./controllers/report/commercialreport.controller.js"></script>
  <script>
    var dataChart1 = [],
      dataChart2 = [];
    dataChart1 = <?= $chart1 ?>;
    dataChart2 = <?= $chart2 ?>;
    dataChart3 = <?= $chart3 ?>;
  </script>
</body>