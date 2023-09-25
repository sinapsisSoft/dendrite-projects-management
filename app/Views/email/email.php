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
                    <a href="<?= base_url() ?>email" >Credenciales</a>
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
                  CREDENCIALES DE CORREO DE NOTIFICACIÓN
                </h5>
              </div>
              <div class="modal-header">
              </div>
              <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                <input type="hidden" class="form-control" id="Email_id" name="Email_id" value="<?= $emails == null ? '' : $emails['Email_id'] ?>">
                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                <div class="mb-3 col-8">
                  <label for="Email_user">Correo *</label>
                  <input type="email" class="form-control" id="Email_user" name="Email_user" required value="<?= $emails == null ? '' : $emails['Email_user'] ?>">
                </div>
                <div class="mb-3 col-4">
                  <label for="Email_pass">Contraseña *</label>
                  <input type="text" class="form-control" id="Email_pass" name="Email_pass" required value="<?= $emails == null ? '' : $emails['Email_pass'] ?>">
                </div>
                <div class="mb-3 col-8">
                  <label for="Email_host">Host *</label>
                  <input type="text" class="form-control" id="Email_host" name="Email_host" required value="<?= $emails == null ? '' : $emails['Email_host'] ?>">
                </div>
                <div class="mb-3 col-4">
                  <label for="Email_puerto">Puerto *</label>
                  <input type="text" class="form-control" id="Email_puerto" name="Email_puerto" required value="<?= $emails == null ? '' : $emails['Email_puerto'] ?>">
                </div>
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
  <script src="./controllers/email/email.controller.js"></script>
  <script>
    //var route = document.getElementById("route");
    //route.href = `${BASE_URL}email`;
  </script>
</body>