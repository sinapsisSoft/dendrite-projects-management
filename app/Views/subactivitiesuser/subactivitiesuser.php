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
          <div class="tab-content" id="myTabContent">

            <!-- TABLA DE SUB ACTIVIDADES -->
            <div class="card-pp">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Proyecto</th>
                        <th>Actividad</th>
                        <th>Subactividad</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th></th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($subactivities as $obj) : ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->Client_name; ?></td>
                          <td><?= $obj->Project_name; ?></td>
                          <td><?= $obj->Activi_name; ?></td>
                          <td><?= $obj->SubAct_name; ?></td>
                          <td class="priorities-text" style="color: <?= $obj->Priorities_color ?>"><?= $obj->Priorities_name; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td>
                            <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
                          </td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <?php if (PERMITS[2] == "3") : ?>
                                <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->SubAct_id ?>)" <?= $obj->SubAct_percentage == 100 ? "disabled" : "" ?>>
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                  </svg>
                                </button>
                              <?php endif; ?>
                              <button type="button" class="btn btn-outline-success" onclick="showEmailModal(1, <?= $obj->SubAct_id ?>)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-plus-fill" viewBox="0 0 16 16">
                                  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z" />
                                  <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z" />
                                </svg>
                              </button>
                              <?php if (PERMITS[2] == "3") : ?>
                                <button type="button" class="btn btn-outline-primary" onclick="getDataIdFinish(<?= $obj->SubAct_id ?>)">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                                    <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                                    <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                  </svg>
                                </button>
                              <?php endif; ?>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Proyecto</th>
                        <th>Actividad</th>
                        <th>Subactividad</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th></th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>

            <div class="modal fade" id="createUpdateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="width: 100%;">
                  <div class="modal-body ">
                    <form class="form-horizontal mt-3" id="objForm" action="" onsubmit="sendData(event,this.id)">
                      <div class="row">
                        <input type="hidden" class="form-control" id="SubAct_id" name="SubAct_id" value="NULL">
                        <input type="hidden" class="form-control" id="Activi_id" name="Activi_id" value="NULL">
                        <div class="col-12 col-md-12 mb-3">
                          <label for="SubAct_name">Nombre de Subactividad</label>
                          <input type="text" class="form-control form-disabled" id="SubAct_name" name="SubAct_name" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="SubAct_estimatedEndDate">Fecha Estimada de Entrega</label>
                          <input type="date" class="form-control form-disabled" id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate">
                        </div>
                        <div class="col-12 col-md-4 mb-3 ">
                          <label for="SubAct_duration">Duración<small>(Horas)</small> *</label>
                          <input type="text" class="form-control" id="SubAct_duration" name="SubAct_duration" min="0" value="" required>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                          <label for="SubAct_percentage">% actividad realizada *</label>
                          <input type="text" class="form-control read" id="SubAct_percentage" name="SubAct_percentage" value="0" required>
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
                          <label for="SubAct_name">Asunto *</label>
                          <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="SubAct_name">Link *</label>
                          <input type="text" class="form-control" id="link" name="link" required>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="User_id">Colaboradores *</label>
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
                          <label for="SubAct_name">Descripción *</label>
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
                        <div class="mb-3 col-6">
                          <label for="SubAct_name">Nombre de la tarea</label>
                          <input type="text" class="form-control form-disabled" id="SubAct_name" name="SubAct_name" value="" required>
                        </div>
                        <div class="mb-3 col-6">
                          <label for="SubAct_estimatedEndDate">Fecha estimada de entrega</label>
                          <input type="date" class="form-control form-disabled" id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate" value="" required>
                        </div>
                        <div class="mb-3 col-6">
                          <label for="SubAct_duration">Duración<small>(Horas)</small> *</label>
                          <input type="text" class="form-control" id="SubAct_duration" name="SubAct_duration" min="0" value="" required>
                        </div>
                        <div class="mb-3 col-6">
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
            <input type="button" onclick="history.back()" class="btn btn-primary" name="volver atrás" value="VOLVER">
          </h4>
        </div>
      </div>
    </div>
    <?= $footer ?>
  </div>
  </div>
  <?= $js ?>
  <script src="./controllers/subactivitiesuser/subactivitiesuser.controller.js"></script>
</body>