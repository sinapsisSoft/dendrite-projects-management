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
                        <h4 class="page-title">
                            <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)"><i class="mdi mdi-account-plus"></i></button>
                        </h4>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                  LISTA DE PROYECTOS
                                </h5>
                                <div class="table-responsive">
                                    <table id="table_obj" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                                <th>#</th>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Fecha de creación</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1 ?>
                                            <?php foreach ($projects as $obj) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $obj['Project_code']; ?></td>
                                                    <td><?= $obj['Project_name']; ?></td>
                                                    <td><?= $obj['created_at']; ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                            <button type="button" class="btn btn-warning" onclick="getDataId(<?= $obj['Project_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                </svg></button>
                                                            <button type="button" class="btn btn-success" onclick="details(<?= $obj['Project_id'] ?>)" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                                </svg></button>
                                                            <button type="button" class="btn btn-danger" onclick="delete_(<?= $obj['Project_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
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
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Fecha de creación</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="createUpdateModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createUpdateModalLabel">DATOS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal mt-3" id="objForm" action="" onsubmit="sendData(event,this.id)">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="Project_id" name="Project_id" value="0">
                                    <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="Project_name" name="Project_name" required>
                                        <label for="Project_name">Nombre</label>
                                    </div>
                                    <div class="form-floating mb-3 col-4">
                                        <input type="text" class="form-control" id="Project_purchaseOrder" name="Project_purchaseOrder" required>
                                        <label for="Project_purchaseOrder">Orden de compra</label>
                                    </div>
                                    <!-- <div class="form-floating mb-3">
                                        <input type="date" class="form-control form-disabled" id="Project_ddtStartDate" name="Project_ddtStartDate" required>
                                        <label for="Project_ddtStartDate">Fecha Inicio DDT</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control form-disabled" id="Project_ddtEndDate" name="Project_ddtEndDate" required>
                                        <label for="Project_ddtEndDate">Fecha Máxima DDT</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control form-disabled" id="Project_startDate" name="Project_startDate" required>
                                        <label for="Project_startDate">Fecha Inicio Proyecto</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control form-disabled" id="Project_estimatedEndDate" name="Project_estimatedEndDate" required>
                                        <label for="Project_estimatedEndDate">Fecha Entrega Estimada de Proyecto</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control form-disabled" id="Project_activitiStartDate" name="Project_activitiStartDate" required>
                                        <label for="Project_activitiStartDate">Fecha de inicio de las actividades del proyecto</label>
                                    </div> -->
                                    <div class="form-floating mb-3 col-8">
                                        <input type="text" class="form-control" id="Project_link" name="Project_link" required>
                                        <label for="Project_link">Link del proyeto</label>
                                    </div>
                                    <div class="form-floating mb-3 col-6">
                                        <input type="text" class="form-control" id="Project_percentage" name="Project_percentage" required>
                                        <label for="Project_percentage">% realizado del proyecto</label>
                                    </div>
                                    <div class="form-floating mb-3 col-6">
                                        <input type="text" class="form-control" id="Project_observation" name="Project_observation" required>
                                        <label for="Project_observation">Observaciones</label>
                                    </div>
                                    <div class="form-floating mb-3 col-8">
                                        <select name="Client_id" id="Client_id" class="form-control">
                                            <?php foreach($clients as $client) : ?>
                                                <option value="<?= $client['Client_id'] ?>">
                                                    <?= $client['Client_name'] ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="Client_id">Clientes</label>
                                    </div>
                                    <div class="form-floating mb-3 col-4">
                                        <select name="Country_id" id="Country_id" class="form-control">
                                            <?php foreach($countries as $country) : ?>
                                                <option value="<?= $country['Country_id'] ?>">
                                                    <?= $country['Country_name'] ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="Country_id">Pais</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select name="User_id" id="User_id" class="form-control">
                                            <?php foreach($users as $user) : ?>
                                                <option value="<?= $user->User_id; ?>">
                                                <?= $user->User_email; ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="User_id">Usuarios</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select name="Stat_id" id="Stat_id" class="form-control">
                                            <?php foreach($userstatuses as $userstatus) : ?>
                                                <option value="<?= $userstatus->Stat_id; ?>">
                                                <?= $userstatus->Stat_name; ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
                                        <label for="Stat_id">Estado</label>
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
            </div>
            <?= $footer ?>
            <?= $toasts ?>
        </div>
    </div>
    <?= $js ?>
    <script src="../controllers/project/project.controller.js"></script>
</body>