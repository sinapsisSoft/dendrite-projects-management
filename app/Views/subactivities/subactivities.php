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
    <style>
        .circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 0;
        }

        .tab-content {
            background-color: white;
            padding: 15px;
        }

        .table-pp {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            ;
        }

        .card-pp {
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: all 0.3s cubic-bezier(.25, .8, .25, 1);
        }

        .card-details {
            padding: 15px;
            background-color: white;
        }

        .percentaje {
            padding: 10px;

        }

        .progress-bar {
            padding-left: 0% !important;
        }

        .modal-content {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
            width: 130%;
        }

        .modal-header {
            background: none;
            color: #1F0229;
        }

        .modal-footer {
            display: block !important;
            text-align: end;
        }

        .modal-footer .btn-secondary {
            width: 100px !important;
        }

        .modal-footer .btn-primary {
            width: 100px !important;
        }

        .form-control {
            border-radius: 5px;
        }

        .mb-3 {
            color: gray;
            font-size: 13px;
        }

        input {
            text-transform: uppercase !important;
        }

        .priorities {
            text-transform: uppercase;
            font-weight: bold;
        }
        ul{
            list-style: none;
            display: contents;
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
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Library
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
                                <div class="mb-3 col-4">
                                    <label for="Project_code">Código de la Actvidad</label>
                                    <input type="text" class="form-control" disabled id="SubAct_code" name="SubAct_code" value="<?= $activity->Activi_code ?>" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="">Nombre de la Actividad</label>
                                    <input type="text" class="form-control" disabled value="<?= $activity->Activi_name ?>" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="">Fecha estimada de entrega</label>
                                    <input type="text" class="form-control" disabled value="<?= $activity->Activi_startDate ?>" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="">Fecha de entrega final</label>
                                    <input type="text" class="form-control" disabled value="<?= $activity->Activi_endDate ?>" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="Project_product_name">Producto</label>
                                    <input type="text" class="form-control" disabled id="Project_product_name" name="Project_product_name" value="<?= $activity->Prod_name ?>" value="" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="SubAct_estimatedEndDate">Fecha Estimada de Entrega</label>
                                    <input type="date" class="form-control" disabled id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate" value="" required>
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="Stat_name">Estado</label>
                                    <input type="text" class="form-control" disabled id="Stat_name" name="Stat_name" value="<?= $activity->Stat_name ?>" required>
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="SubAct_estimatedEndDate">Fecha Entrga Final</label>
                                    <input type="date" class="form-control" disabled id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate" value="" required>
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="Activi_codeMiigo">Código Miigo</label>
                                    <input type="text" class="form-control" disabled id="Activi_codeMiigo" value="<?= $activity->Activi_codeMiigo ?>" name="Activi_codeMiigo" required>
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="Activi_codeSpectra">Código Spectra</label>
                                    <input type="text" class="form-control" disabled id="Activi_codeSpectra" value="<?= $activity->Activi_codeSpectra ?>" name="Activi_codeSpectra" required>
                                </div>
                                <div class="mb-3 col-3">
                                    <label for="Activi_codeDelivery">Código Entregable</label>
                                    <input type="text" class="form-control" disabled id="Activi_codeDelivery" value="<?= $activity->Activi_codeDelivery ?>" name="Activi_codeDelivery" required>
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
                                                <th>Estado</th>
                                                <th>Semaforo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($subactivities as $obj) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $obj->SubAct_name; ?></td>
                                                    <td class="priorities" style="color: <?= $obj->Priorities_color ?>"><?= $obj->Priorities_name; ?></td>
                                                    <td><?= $obj->Stat_name; ?></td>
                                                    <td>
                                                        <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                            <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->SubAct_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                </svg></button>
                                                            <button type="button" class="btn btn-outline-success" onclick="showEmailModal(1)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-plus-fill" viewBox="0 0 16 16">
                                                                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 4.697v4.974A4.491 4.491 0 0 0 12.5 8a4.49 4.49 0 0 0-1.965.45l-.338-.207L16 4.697Z" />
                                                                    <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z" />
                                                                </svg></button>
                                                            <button type="button" class="btn btn-outline-primary" onclick="getDataIdFinish(<?= $obj->SubAct_id ?>)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                                                                    <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                                                                    <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                                                </svg>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->SubAct_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
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
                                                <th>Estado</th>
                                                <th>Semaforo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- MODAL DE SUBACTIVIDADES-->

                        <div class="modal fade" id="createUpdateModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">

                                    <div class="modal-body ">
                                        <form class="form-horizontal mt-3" id="objForm" action="" onsubmit="sendData(event,this.id)">
                                            <div class="row">
                                                <input type="hidden" class="form-control" id="Activi_id" name="Activi_id" value="<?= $activity->Activi_id; ?>">
                                                <input type="hidden" class="form-control" id="SubAct_id" name="SubAct_id" value="NULL">
                                                <div class="mb-3 col-4">
                                                    <label for="SubAct_name">Nombre de Tarea</label>
                                                    <input type="text" class="form-control" id="SubAct_name" name="SubAct_name" required>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="User_id">Colaboradores</label>
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
                                                <div class="mb-3 col-4">
                                                    <label for="SubAct_estimatedEndDate">Fecha Estimada de Entrga</label>
                                                    <input type="date" class="form-control" id="SubAct_estimatedEndDate" name="SubAct_estimatedEndDate" required>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="Stat_id">Estado</label>
                                                    <select class="form-control form-select" id="Stat_id" name="Stat_id" required>
                                                        <?php foreach ($userstatuses as $userstatus) : ?>
                                                            <option value="<?= $userstatus['Stat_id']; ?>">
                                                                <?= $userstatus['Stat_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="Priorities_id">Prioridades</label>
                                                    <select class="form-control form-select" id="Priorities_id" name="Priorities_id" required>
                                                        <option value="">Seleccione...</option>
                                                        <?php foreach ($priorities as $priorities) : ?>
                                                            <option value="<?= $priorities['Priorities_id']; ?>">
                                                                <?= $priorities['Priorities_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-2">
                                                    <label for="SubAct_percentage">% actividad realizada</label>
                                                    <input type="text" class="form-control" id="SubAct_percentage" name="SubAct_percentage" required>
                                                </div>
                                                <div class="mb-3 col-12">
                                                    <label for="SubAct_description">Descripción</label>
                                                    <input type="text" class="form-control" id="SubAct_description" name="SubAct_description" required>
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

                        <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createUpdateModalLabel">ENVIO DE NOTIFICACIÓN</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <form class="form-horizontal mt-3" id="objEmailForm">
                                            <div class="row">
                                                <div class="mb-3 col-8">
                                                    <label for="SubAct_name">Asunto</label>
                                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                                </div>
                                                <div class="mb-3 col-8">
                                                    <label for="SubAct_name">Link</label>
                                                    <input type="text" class="form-control" id="link" name="link" required>
                                                </div>
                                                <div class="mb-3 col-12">
                                                    <label for="User_id">Colaboradores</label>
                                                    <ul class="row">
                                                        <?php foreach ($users as $user) : ?>
                                                            <li class="mb-3 col-3">
                                                                <input type="checkbox" onchange="toogleCollaborator('<?= $user->User_email  ?>')">
                                                                <?= $user->User_name  ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <div class="mb-3 col-12 row-3">
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

                        <div class="modal fade" id="finModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createUpdateModalLabel">FINALIZACIÓN DE ACTIVIDAD</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <form class="form-horizontal mt-3" id="objFinForm">
                                            <div class="row">
                                                <input type="hidden" class="form-control" id="finish_id" name="SubAct_id" value="0">
                                                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                                <div class="mb-3 col-4">
                                                    <label for="finish_name">Nombre de la tarea</label>
                                                    <input type="text" class="form-control" disabled id="finish_name" name="SubAct_name" value="" required>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="finish_estimatedEndDate">Fecha estimada de entrega</label>
                                                    <input type="date" class="form-control" disabled id="finish_estimatedEndDate" name="SubAct_estimatedEndDate" value="" value="" required>
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="Stat_id">Estado</label>
                                                    <select class="form-control form-select" id="finish_stat_id" name="Stat_id" required disabled>
                                                        <?php foreach ($userstatuses as $userstatus) : ?>
                                                            <option value="<?= $userstatus['Stat_id']; ?>">
                                                                <?= $userstatus['Stat_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 col-12">
                                                    <label for="finish_description">Descripción</label>
                                                    <input type="text" class="form-control" disabled id="finish_description" name="SubAct_description" value="" required>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" onclick="finish()" form="objActivitiesForm" class="btn btn-primary mx-auto w-50">Guardar</button>
                                    </div>
                                </div>
                            </div>
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
    <script src="../controllers/subactivities/subactivities.controller.js"></script>
</body>