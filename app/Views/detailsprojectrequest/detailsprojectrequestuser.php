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
                    <label for="ProjReq_name">Nombre del proyecto</label>
                    <input type="text" class="form-control" disabled id="ProjReq_name" name="ProjReq_name" value="<?= $data["projectrequest"]->ProjReq_name ?>" required>
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
                    <label for="User_name">Gerente</label>
                    <input type="text" class="form-control" disabled id="User_name" name="User_name" value="<?= $data["projectrequest"]->User_name ?>" required>
                  </div>
                  <div class="col-12 col-md-4 mb-3">
                    <label for="Brand_name">Marca</label>
                    <input type="text" class="form-control" disabled id="Brand_name" name="Brand_name" value="<?= $data["projectrequest"]->Brand_name ?>" required>
                  </div>
                  <div class="col-12 mb-3">
                    <label for="ProjReq_observation">Observaciones</label>
                    <input type="text" class="form-control" size="15" maxlength="30" disabled id="ProjReq_observation" value="<?= $data["projectrequest"]->ProjReq_observation ?>" name="Project_observation" required>
                  </div>
                </div>
              </div>

              <!-- TABLA DE PROYECT_PRODUCT -->

              <div class="card-pp">
                <h4 class="page-title text-end">
                  Agregar Producto
                  <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)"><i class="mdi mdi-plus"></i></button>
                </h4>
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
          <div class="row text-end">
            <h4 class="col-12 page-title ">
              <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="VOLVER">
            </h4>
          </div>
        </div>
      </div>

      <div class="modal fade" id="createUpdateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
              <h5 class="modal-title" id="createUpdateModalLabel">AGREGAR PRODUCTO</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal mt-3 row" id="objForm" action="POST" onsubmit="sendData(event,this.id)">
                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                <input type="hidden" class="form-control" id="ProjReq_product_id" name="Project_product_id" value="NULL">
                <div class="col-12 col-md-6 mb-3">
                  <label for="Prod_id">Producto</label>
                  <select class="form-control form-select" name="Prod_id" id="Prod_id" required>
                    <option value="">
                      Seleccionar...
                    </option>
                    <?php foreach ($products as $product) : ?>
                      <option value="<?= $product['Prod_id']; ?>">
                        <?= $product['Prod_name']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-12 col-md-2 mb-3">
                  <label for="Project_productAmount">Cantidad</label>
                  <input type="text" class="form-control" id="Project_productAmount" name="Project_productAmount" required>
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
  <script src="./controllers/projectuser/projectuser.controller.js"></script>
</body>