<!DOCTYPE html>
<html dir="ltr">

<head>
    <?= $meta ?>
    <title>
        <?= $title ?>
    </title>
    <?= $css ?>

  <style>
    .card {
      padding: 2%;
    }
  </style>
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
                  <li class="breadcrumb-item" aria-current="page">
                    Configuración
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>mail" >Correspondencia</a>
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
                  CORREO DE CORRESPONDENCIA
                </h5>
              </div>
              <div class="modal-header">
              </div>
              <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                <input type="hidden" class="form-control" id="Mail_id" name="Mail_id" value="<?= $mails == null ? '' : $mails['Mail_id'] ?>">
                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                <div class="mb-3 col-8">
                  <label for="Mail_user">Correo</label>
                  <input type="email" class="form-control" id="Mail_user" name="Mail_user" required value="<?= $mails == null ? '' : $mails['Mail_user'] ?>">
                </div>
              </form>
              </form>
              <?php if (PERMITS[2] == "3") : ?>
                <div class="modal-footer">
                  <button type="submit" id="btn-submit" form="objForm" class="btn btn-primary mx-auto w-50">Guardar</button>
                </div>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?= $footer ?>
      <?= $toasts ?>
    </div>
  </div>
  <?= $js ?>
  <script src="./controllers/mail/mail.controller.js"></script>
</body>