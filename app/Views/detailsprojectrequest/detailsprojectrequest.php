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
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($data['projectrequestproducts'] as $obj) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->Prod_name; ?></td>
                          <td><?= $obj->ProjReq_product_amount; ?></td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->ProjReq_product_id ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                              </button>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <h4 class="col-4 page-title ">
              <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="VOLVER">
            </h4>
            <div class="col-8 text-end">
              <div class="row justify-content-end">
              <h6 class="page-title">
                APROBAR
                <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)">
                  <lord-icon src="<?= base_url() ?>/assets/json/system-outline-31-check.json" trigger="hover" colors="primary:#ffffff" style="width: 30px;px;height:30px">
                  </lord-icon>
                </button>
              </h6>
              <h6 class="page-title">
                RECHAZAR
                <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)">
                  <lord-icon src="<?= base_url() ?>/assets/json/system-outline-29-cross.json" trigger="hover" colors="primary:#ffffff" style="width:30px;height:30px">
                  </lord-icon>
                </button>
              </h6>
              </div>

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