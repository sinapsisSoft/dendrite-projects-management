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
                  <li class="breadcrumb-item" aria-current="page">
                    Gestión de proyectos
                  </li>
                  <li class="breadcrumb-item" aria-current="page">
                    <a href="<?= base_url() ?>projectrequest">Solicitudes</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>projectrequestproduct">Detalle de la solicitud</a>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="card-details">
          <div class="row percentaje">
            <div class="col-12 col-md-4">
              <h6>Detalle de la solicitud</h6>
            </div>
          </div>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Información del Proyecto</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
              <div class="form-horizontal mt-3">
                <div class="row">
                  <div class="col-12 col-md-6 mb-3">
                    <label for="Project_name">Nombre del proyecto</label>
                    <input type="text" class="form-control" disabled id="Project_name" name="Project_name" value="<?= $data["projectrequest"]->ProjReq_name ?>" required>
                  </div>
                  <div class="col-12 col-md-6 mb-3">
                    <label for="Client_name">Cliente</label>
                    <input type="text" class="form-control" disabled id="Client_name" name="Client_name" value="<?= $data["projectrequest"]->Client_name ?>" required>
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label for="Country_name">País</label>
                    <input type="text" class="form-control" disabled id="Country_name" name="Country_name" value="<?= $data["projectrequest"]->Country_name ?>" required>
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label for="Manager_name">Gerente</label>
                    <input type="text" class="form-control" disabled id="User_name" name="User_name" value="<?= $data["projectrequest"]->User_name ?>" required>
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label for="Brand_name">Marca</label>
                    <input type="text" class="form-control" disabled id="Brand_name" name="Brand_name" value="<?= $data["projectrequest"]->Brand_name ?>" required>
                  </div>
                  <div class="col-12 mb-3">
                    <label for="Project_observation">Observaciones</label>
                    <input type="text" class="form-control" size="15" maxlength="30" disabled id="Project_observation" value="<?= $data["projectrequest"]->ProjReq_observation ?>" name="Project_observation" required>
                  </div>
                </div>
              </div>

              <!-- TABLA DE PROYECT_PRODUCT -->

              <div class="card-pp">
                <div class="table-responsive table-pp">
                  <table id="table_product" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($data['projectrequestproducts'] as $obj) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->Prod_name; ?></td>
                          <td><?= $obj->ProjReq_product_amount; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php if($data["projectrequest"]->Stat_id == 6): ?>
          <div class="row">
            <h4 class="col-4 page-title ">
              <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="VOLVER">
            </h4>            
            <div class="col-8 text-end">
              <div class="row justify-content-end">
                <h6 class="page-title">                  
                  APROBAR
                  <button type="button" class="btn btn-primary btn-circle btn-lg btn-approved" onclick="showModal(1)">
                    <lord-icon src="<?= base_url() ?>/assets/json/system-outline-31-check.json" trigger="hover" colors="primary:#ffffff" style="width: 30px;px;height:30px">
                    </lord-icon>
                  </button>
                </h6>
                <h6 class="page-title">
                  RECHAZAR
                  <button type="button" class="btn btn-primary btn-circle btn-lg btn-refused" onclick="delete_()">
                    <lord-icon src="<?= base_url() ?>/assets/json/system-outline-29-cross.json" trigger="hover" colors="primary:#ffffff" style="width:30px;height:30px">
                    </lord-icon>
                  </button>
                </h6>                
              </div>
            </div>            
          </div>          
          <?php else: ?> 
            <div class="row text-end">
            <h4 class="col-12 page-title ">
              <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="VOLVER">
            </h4>            
          </div> 
          <?php endif ?> 
        </div>
      </div>
      <div class="modal fade" id="createModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">CREAR PRODUCTO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal mt-3 row" id="objForm" action="POST" onsubmit="sendData(event,this.id)">
                <div class="col-12 col-md-4 mb-3">
                  <label for="Project_commercial">Nombre del comercial</label>
                  <select name="Project_commercial" id="Project_commercial" class="form-control form-select" required>
                    <option value="">
                      Seleccione...
                    </option>
                    <?php foreach ($commercial as $user) : ?>
                      <option value="<?= $user->User_id; ?>">
                        <?= $user->User_name; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12 col-md-3 mb-3">
                  <label for="User_id">Notificar a:</label>
                  <select name="User_id" id="User_id" class="form-control form-select" required>
                    <option value="">
                      Seleccione...
                    </option>
                    <?php foreach ($users as $user) : ?>
                      <option value="<?= $user->User_id; ?>">
                        <?= $user->User_name; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Priorities_id">Prioridad</label>
                  <select class="form-control form-select" id="Priorities_id" name="Priorities_id" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($priorities as $priorities) : ?>
                      <option value="<?= $priorities['Priorities_id']; ?>">
                        <?= $priorities['Priorities_name']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" id="btn-submit" form="objForm" class="btn btn-primary mx-auto w-50">Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <?= $footer ?>
      <?= $toasts ?>
    </div>.
  </div>
  <?= $js ?>
  <script src="./controllers/projectrequest/projectrequest.controller.js"></script>
</body>