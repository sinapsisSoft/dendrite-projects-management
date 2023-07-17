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
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>project">Proyectos</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Detalle del proyecto
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Subactividades
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
            <div class="col-4">
              <h6>Datos de Actividad</h6>
            </div>
            <div class="progress col-6" style="height: 15px;">
              <div id="progressbar" class="progress-bar" role="progressbar" style="width: <?= !is_null($activity) ? $activity->Activi_percentage : '' ?>%; " aria-valuenow="<?= $activity->Activi_percentage ?>" aria-valuemin="0" aria-valuemax="100">
                <?= !is_null($activity) ? $activity->Activi_percentage : '' ?>%
              </div>
            </div>
          </div>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Información de la Actividad</button>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">

            <!-- GESTIÓN DE ACTIVIDADES -->

            <!-- DETALLE DE ACTIVIDADES -->
            <div class="form-horizontal mt-3">
              <div class="row">
                <div class="col-12 col-md-3 mb-3">
                  <label for="Project_code">Código de Actvidad</label>
                  <input type="text" class="form-control" disabled id="SubAct_code" name="SubAct_code" value="<?= $activity->Activi_code ?>" required>
                </div>
                <div class="col-12 col-md-6 mb-3">
                  <label for="">Nombre de Actividad</label>
                  <input type="text" class="form-control" disabled value="<?= $activity->Activi_name ?>" required>
                </div>
                <div class="col-12 col-md-3 mb-3">
                  <label for="Project_product_name">Producto</label>
                  <input type="text" class="form-control" disabled id="Project_product_name" name="Project_product_name" value="<?= $activity->Prod_name ?>" value="" required>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="">Fecha estimada de entrega</label>
                  <input type="date" class="form-control" disabled value="<?= $activity->Activi_startDate ?>">
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Activi_codeMiigo">Código Miigo</label>
                  <input type="text" class="form-control" disabled id="Activi_codeMiigo" value="<?= $activity->Activi_codeMiigo ?>" name="Activi_codeMiigo" required>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Activi_codeSpectra">Código Spectra</label>
                  <input type="text" class="form-control" disabled id="Activi_codeSpectra" value="<?= $activity->Activi_codeSpectra ?>" name="Activi_codeSpectra" required>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Activi_codeDelivery">Código Entregable</label>
                  <input type="text" class="form-control" disabled id="Activi_codeDelivery" value="<?= $activity->Activi_codeDelivery ?>" name="Activi_codeDelivery" required>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Stat_name">Estado</label>
                  <input type="text" class="form-control" disabled id="Stat_name" name="Stat_name" value="<?= $activity->Stat_name ?>" required>
                </div>
                <div class="col-12 col-md-4 mb-3">
                  <label for="Activi_endDate">Fecha de entrega Final</label>
                  <input type="date" class="form-control" disabled id="Activi_endDate" name="SubAct_estimatedEndDate" value="<?= $activity->Activi_endDate ?>">
                </div>
                <div class="col-10 col-md-11 mb-3">
                  <label for="Activi_link">Enlace</label>
                  <input type="text" class="form-control" id="Activi_link" name="Activi_link" value="<?= $activity->Activi_link ?>" disabled>
                </div>
                <div class="col-2 col-md-1 mb-3 align-self-end">
                  <button type="button" class="btn btn-outline-primary" id="copyToClipboard" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar" style="border: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                      <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"></path>
                      <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"></path>
                    </svg>
                  </button>
                </div>
                <div class="col-12 mb-3">
                  <label for="Activi_observation">Observaciones</label>
                  <input type="text" class="form-control" id="Activi_observation" name="Activi_observation" value="<?= $activity->Activi_observation ?>" disabled>
                </div>
              </div>
            </div>

            <!-- TABLA DE SUB ACTIVIDADES -->

            <div class="card-pp">
              <h4 class="page-title text-end">
                Nueva Subactividad
                <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)"><i class="mdi mdi-plus"></i></button>
              </h4>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Prioridad</th>
                        <th colspan="2">Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($subactivities as $obj) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->SubAct_name; ?></td>
                          <td class="priorities-text" style="color: <?= $obj->Priorities_color ?>"><?= $obj->Priorities_name; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td>
                            <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">                              
                              <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->SubAct_id ?>)" <?= $obj->SubAct_percentage == 100 ? "disabled" : "" ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                              </button>
                              <button type="button" class="btn btn-outline-success" onclick="showEmailModal(1, <?= $obj->SubAct_id ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-plus-fill" viewBox="0 0 16 16">
                                  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z" />
                                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                              </button>
                              <button type="button" class="btn btn-outline-primary" onclick="getDataIdFinish(<?= $obj->SubAct_id ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                                  <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                                  <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                </svg>
                              </button>
                              <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->SubAct_id ?>)" <?= $obj->SubAct_percentage == 100 ? "disabled" : "" ?>>
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg></button>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Prioridad</th>
                        <th colspan="2">Estado</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <!-- MODAL DE SUBACTIVIDADES-->

            <div class="modal fade" id="createUpdateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="width: 100%;">
                <div class="modal-header">
                      <h5 class="modal-title" id="createUpdateModalLabel">AGREGAR SUBACTIVIDAD</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                  <div class="modal-body ">
                    <form class="form-horizontal mt-3" id="objForm" action="" onsubmit="sendData(event,this.id)">
                      <div class="row">
                        <input type="hidden" class="form-control" id="Activi_id" name="Activi_id" value="<?= $activity->Activi_id; ?>">
                        <input type="hidden" class="form-control" id="SubAct_id" name="SubAct_id" value="NULL">
                        <div class="col-12 col-md-8 mb-3">
                          <label for="SubAct_name">Nombre de Subactividad</label>
                          <input type="text" class="form-control" id="SubAct_name" name="SubAct_name" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="User_id">Colaborador</label>
                          <select name="User_id" id="User_id" class="form-control form-select" required>
                            <option value="">
                              Seleccione...
                            </option>
                            <?php foreach ($collaborators as $user) : ?>
                              <option value="<?= $user->User_id ?>">
                                <?= $user->User_name  ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="SubAct_estimatedEndDate">Fecha Estimada de Entrega</label>
                          <input type="date" class="form-control" id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate">
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
                        <div class="col-12 col-md-4 mb-3">
                          <label for="SubAct_percentage">% actividad realizada</label>
                          <input type="text" class="form-control read" id="SubAct_percentage" name="SubAct_percentage" value="0" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="SubAct_endDate">Fecha de Entrega</label>
                          <input type="text" class="form-control form-disabled read" id="SubAct_endDate" name="SubAct_endDate">
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="Stat_id">Estado</label>
                          <select class="form-control form-select form-disabled read" id="Stat_id" name="Stat_id" required>
                            <?php foreach ($userstatuses as $userstatus) : ?>
                              <option value="<?= $userstatus['Stat_id']; ?>">
                                <?= $userstatus['Stat_name']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>           
                        <div class="col-12 mb-3">
                          <label for="SubAct_description">Descripción</label>
                          <input type="text" class="form-control" id="SubAct_description" name="SubAct_description">
                        </div>
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

            <!-- MODAL DE EMAIL -->

            <div class="modal fade" id="emailModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-md">
                <div class="modal-content" style="width: 100%;">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createUpdateModalLabel">ENVÍO DE NOTIFICACIÓN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body ">
                    <form class="form-horizontal mt-3" id="objEmailForm">
                      <input type="hidden" class="form-control" id="not_subId" name="SubAct_id" value="NULL">
                      <div class="row">
                        <div class="col-12 mb-3">
                          <label for="SubAct_name">Asunto</label>
                          <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="SubAct_name">Link</label>
                          <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="User_id">Colaboradores</label>
                          <ul class="row" style="list-style: none;">
                            <?php foreach ($users as $user) : ?>
                              <li class="mb-3 col-3">
                                <input type="checkbox" onchange="toogleCollaborator('<?= $user->User_email  ?>')">
                                <?= $user->User_name  ?>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="SubAct_name">Descripción</label>
                          <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" onclick="sendNotification()" id="btn-submit" class="btn btn-primary mx-auto w-50">Enviar</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- MODAL DE FINAL ACTIVIDAD -->

            <div class="modal fade" id="finModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="width: 100%;">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createUpdateModalLabel">MARCAR SUBACTIVIDAD COMO FINALIZADA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body ">
                    <form class="form-horizontal mt-3" id="objFinForm">
                      <div class="row">
                        <input type="hidden" class="form-control" id="SubAct_id" name="SubAct_id" value="0">
                        <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                        <div class="mb-3 col-4">
                          <label for="SubAct_name">Nombre de la tarea</label>
                          <input type="text" class="form-control form-disabled" id="SubAct_name" name="SubAct_name" value="" required>
                        </div>
                        <div class="mb-3 col-4">
                          <label for="SubAct_estimatedEndDate">Fecha estimada de entrega</label>
                          <input type="date" class="form-control form-disabled" id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate" value="">
                        </div>
                        <div class="mb-3 col-4">
                          <label for="Stat_id">Estado</label>
                          <select class="form-control form-select form-disabled" id="Stat_id" name="Stat_id" required>
                            <?php foreach ($userstatuses as $userstatus) : ?>
                              <option value="<?= $userstatus['Stat_id']; ?>">
                                <?= $userstatus['Stat_name']; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-3 col-12">
                          <label for="SubAct_description">Descripción</label>
                          <input type="text" class="form-control form-disabled" id="SubAct_description" name="SubAct_description" value="" required>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" onclick="finish('objFinForm')" form="objActivitiesForm" class="btn btn-primary mx-auto w-50">Finalizar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <h4 class="page-title text-end">
            <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="volver">
          </h4>
        </div>
      </div>
    </div>
    <?= $footer ?>
    <?= $toasts ?>
  </div>
  </div>
  <?= $js ?>
  <script src="./controllers/subactivities/subactivities.controller.js"></script>
</body>