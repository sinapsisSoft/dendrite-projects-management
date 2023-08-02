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

  <!-- <link href="/public/assets/css/global.css" rel="stylesheet" type="text/css"> -->


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
          <h4 class="page-title">
              NUEVA SOLICITUD
            </h4>
            <lord-icon src="<?= base_url() ?>assets/json/wired-flat-49-plus-circle.json" trigger="hover" colors="primary:#ffffff" style="width:60px; height:60px; cursor: pointer;" onclick="showModal(1)">
            </lord-icon>
            <div class="ms-auto text-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>home">Inicio</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Gestión de proyectos
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>projectrequest">Solicitudes</a>
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
                  LISTA DE SOLICITUDES DE PROYECTOS
                </h5>
                <div class="table-responsive  card-pp">
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Marca</th>
                        <th>Fecha de creación</th>
                        <th>Estado</th>
                        <th></th>
                        <th>Código Proyecto</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($projectrequest as $obj) : ?>
                        <?php switch ($obj->Stat_id) : 
                          case 6:
                            $color = '#FFD93D';
                            break;
                          case 7:                            
                            $color = '#16FF00';
                            break;
                          case 8:
                            $color = '#FF0303';
                            break;
                          endswitch;?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->Brand_name; ?></td>
                          <td><?= $obj->created_at; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td>
                            <div class="circle" style="background-color:<?= $color; ?>"></div>
                          </td>
                          <td><?= $obj->Project_code == NULL ? 'NO APLICA' : $obj->Project_code ?></td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <button type="button" class="btn btn-outline-success" onclick="details(<?= $obj->ProjReq_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                </svg></button>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Marca</th>
                        <th>Fecha de creación</th>
                        <th>Estado</th>
                        <th></th>
                        <th>Código Proyecto</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" data-bs-backdrop="static" id="createUpdateModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content" style="width: 100%;">
              <div class="modal-header">
                <h5 class="modal-title" id="createUpdateModalLabel">NUEVA SOLICITUD DE PROYECTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                    <input type="hidden" class="form-control" id="Project_id" name="ProjReq_id" value="0">
                    <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                    <div class="col-12 col-md-8 mb-3">
                      <label for="ProjReq_name" class="bmd-label-floating">Nombre del Proyecto</label>
                      <input type="text" class="form-control" id="ProjReq_name" name="ProjReq_name" required>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                      <label for="Brand_id">Marca</label>
                      <select name="Brand_id" id="Brand_id" class="form-control form-disabled form-select read" disabled required>
                        <option value="">
                          Seleccione...
                        </option>
                        <?php foreach ($brands as $brand) : ?>
                          <option value="<?= $brand->Brand_id ?>">
                            <?= $brand->Brand_name ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>                       
                    <div class="col-12 col-md-12 mb-3">
                      <label for="Project_observation">Observaciones</label>
                      <input type="text" class="form-control" id="Project_observation" name="Project_observation">
                    </div>
                  </form>
                  <div class="card-pp">
                <h4 class="page-title text-end">  
                Agregar Producto                
                  <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)"><i class="mdi mdi-plus"></i></button>
                </h4>
                <div class="table-responsive table-pp">
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                        <th colspan="2">Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($data['products'] as $obj) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->Prod_name; ?></td>
                          <td><?= $obj->Project_productAmount; ?></td>
                          <td><?= $obj->Project_product_percentage == "" ? 0 : $obj->Project_product_percentage; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td>
                            <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->Project_product_id ?>)" <?= $obj->Project_product_percentage != 100 ? "" : "disabled" ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                              </button>
                              <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->Project_product_id ?>)" <?= $obj->Project_product_percentage != 100 ? "" : "disabled" ?>>
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
                        <th>Porcentaje</th>
                        <th colspan="2">Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" id="btn-submit" form="objForm" class="btn btn-primary mx-auto w-50">Guardar</button>
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
    <script src="./controllers/projectuser/projectuser.controller.js"></script>
</body>