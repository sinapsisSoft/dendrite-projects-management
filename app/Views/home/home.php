<!DOCTYPE html>
<html dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Made in casa, Market Support" />
  <meta name="description" content="Made in Casa - Construyendo el futuro. Plataforma de gestión proyectos." />
  <meta name="robots" content="noindex,nofollow" />
  <title><?= $title ?></title>
  <?= $css ?>
  <!-- Custom CSS -->


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
                  INICIO
                </h5>
                <div id="reportView">
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
                  <div class="row reportChart my-4 justify-content-center">
                    <div class="col-auto">
                      <h4 id="total-project" class="m-0 font-weight-bold text-primary"></h4>
                    </div>
                  </div>
                  <div class="row reportChart my-4 justify-content-center">
                    <div id="chart1Report" class="col-sm-12 col-md-10">
                      <canvas id="chart1" style="width: 100%;"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal" id="welcomeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
              <h5 class="modal-title" id="welcomeModalLabel">BIENVENIDO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <video id="welcome-video" width="100%" height="auto" controls poster="<?= base_url() ?>assets/img/logos/logo_slogan.png" playsinline>
                <source src="<?= base_url() ?>assets/video/MarketSupport_video2023.mp4" type="video/mp4">
              </video>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
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
  <script src="./controllers/home/home.controller.js"></script>
  <script>
    var dataJson = [],
      reportName = "";
    dataJson = <?= $chart ?>;
    reportName = '<?= $reportName ?>';
  </script>
</body>