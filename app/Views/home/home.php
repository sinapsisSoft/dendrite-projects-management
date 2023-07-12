<!DOCTYPE html>
<html dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
  <meta name="description" content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
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
                  <li class="breadcrumb-item"><a href="home">Home</a></li>
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
                <h6 class="mt-4">Vista en construcción</h6>
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
  <script src="./controllers/home/home.controller.js"></script>
</body>