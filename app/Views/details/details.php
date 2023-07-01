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
                            <div class="progress-bar" role="progressbar" style="width: <?= $data['percent']->percent ?>%; " aria-valuenow="<?= $data['percent']->percent ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= $data['percent']->percent ?> %
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Información del Proyecto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Seguimiento del Proyecto</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Gestión de Actividades</button>
                        </li>
                    </ul>

                    <!-- GESTIÓN DE PROYECTOS -->


                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">

                            <!-- FORMULARIO DE PROYECTOS -->

                            <div class="form-horizontal mt-3">
                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label for="Project_code">Código del proyecto</label>
                                        <input type="text" class="form-control" disabled id="Project_code" name="Project_code" value="<?= $data['project']->Project_code ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Project_name">Nombre del proyecto</label>
                                        <input type="text" class="form-control" disabled id="Project_name" name="Project_name" value="<?= $data["project"]->Project_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Client_name">Cliente</label>
                                        <input type="text" class="form-control" disabled id="Client_name" name="Client_name" value="<?= $data["project"]->Client_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Manager_name">Gerente</label>
                                        <input type="text" class="form-control" disabled id="Manager_name" name="Manager_name" value="<?= $data["project"]->Manager_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Brand_name">Marca</label>
                                        <input type="text" class="form-control" disabled id="Brand_name" name="Brand_name" value="<?= $data["project"]->Brand_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Project_purchaseOrder">Orden de compra</label>
                                        <input type="text" class="form-control" disabled id="Project_purchaseOrder" name="Project_purchaseOrder" value="<?= $data["project"]->Project_purchaseOrder ?>" required>
                                    </div>

                                    <div class="mb-3 col-3">
                                        <label for="Project_ddtStartDate">Fecha Inicio DDT</label>
                                        <input type="date" class="form-control" disabled id="Project_ddtStartDate" name="Project_ddtStartDate" value="<?= $data["project"]->Project_ddtStartDate ?>">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Project_ddtEndDate">Fecha Máxima DDT</label>
                                        <input type="date" class="form-control" disabled id="Project_ddtEndDate" name="Project_ddtEndDate" value="<?= $data["project"]->Project_ddtEndDate ?>">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Country_name">País</label>
                                        <input type="text" class="form-control" disabled id="Country_name" name="Country_name" value="<?= $data["project"]->Country_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="User_name">Nombre del Comercial</label>
                                        <input type="text" class="form-control" disabled id="User_name" name="User_name" value="<?= $data["project"]->User_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Project_startDate">Fecha de Creación</label>
                                        <input type="date" class="form-control" disabled id="Project_startDate" name="Project_startDate" value="<?= $data["project"]->Project_startDate ?>">
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label for="Project_estimatedEndDate">Fecha Estimada de Entrga</label>
                                        <input type="date" class="form-control" disabled id="Project_estimatedEndDate" name="Project_estimatedEndDate" value="<?= $data["project"]->Project_estimatedEndDate ?>">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="Project_activitiStartDate">Fecha Finalización de las actividades</label>
                                        <input type="date" class="form-control" disabled id="Project_activitiEndDate" name="Project_activitiEndtDate" value="<?= $data["project"]->Project_activitiEndDate ?>">
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="Stat_name">Estado</label>
                                        <input type="text" class="form-control" disabled id="Stat_name" name="Stat_name" value="<?= $data["project"]->Stat_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <label for="Priorities_id">Prioridad</label>
                                        <input type="text" class="form-control" disabled id="Priorities_name" name="Priorities_name" value="<?= $data["project"]->Priorities_name ?>" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="Project_link">Link del proyeto</label>
                                        <input type="text" class="form-control" disabled id="Project_link" value="<?= $data["project"]->Project_link ?>" name="Project_link" required>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="Project_observation">Observaciones</label>
                                        <input type="text" class="form-control" size="15" maxlength="30" disabled id="Project_observation" value="<?= $data["project"]->Project_observation ?>" name="Project_observation" required>
                                    </div>
                                </div>
                            </div>

                            <!-- TABLA DE PROYECT_PRODUCT -->

                            <div class="card-pp">
                                <h4 class="page-title text-end">
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
                                                <th>Estado</th>
                                                <th>Semaforo</th>
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
                                                    <td><?= $obj->Project_product_percentage === "" ? 0 : $obj->Project_product_percentage; ?></td>
                                                    <td><?= $obj->Stat_name; ?></td>
                                                    <td>
                                                        <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                            <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->Project_product_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                </svg></button>
                                                            <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->Project_product_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                                </svg></button>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Porcentaje</th>
                                                <th>Estado</th>
                                                <th>Semaforo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- MODAL DE PROJECT_PRODUCT -->

                            <div class="modal fade" id="createUpdateModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createUpdateModalLabel">NUEVO PRODUCTO</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal mt-3 row" id="objForm" action="POST" onsubmit="sendData(event,this.id)">
                                                <input type="hidden" class="form-control" id="Project_id" name="Project_id" value="<?= $data["project"]->Project_id ?>">
                                                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                                <input type="hidden" class="form-control" id="Project_product_id" name="Project_product_id" value="NULL">
                                                <div class="mb-3 col-6">
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
                                                <div class="mb-3 col-6">
                                                    <label for="Project_productAmount">Cantidad</label>
                                                    <input type="text" class="form-control" id="Project_productAmount" name="Project_productAmount" required>
                                                </div>
                                                <div class="mb-3 col-6">
                                                    <label for="Stat_id">Estado</label>
                                                    <select class="form-control form-select" id="Stat_id" name="Stat_id" required>
                                                        <?php foreach ($userstatuses as $userstatus) : ?>
                                                            <option value="<?= $userstatus['Stat_id']; ?>">
                                                                <?= $userstatus['Stat_name']; ?>
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
                        </div>

                        <!-- GESTIÓN DE SEGUIMIENTO DE PROYECTO -->

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            <!-- TABLA DE SEGUIMIENTO DE PROYECTO -->

                            <div class="card-pp">
                                <h4 class="page-title">
                                    <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showTrackingModal(1)"><i class="mdi mdi-plus"></i></button>
                                    Agregar Seguimiento
                                </h4>
                                <div class="card-body">
                                    <div class="table-responsive table-pp">
                                        <table id="table_obj_tracking" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($projecttrackings as $obj) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $obj['ProjectTrack_name']; ?></td>
                                                        <td><?= $obj['ProjectTrack_description']; ?></td>
                                                        <td><?= $obj['ProjectTrack_date']; ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                                <button type="button" class="btn btn-outline-warning" onclick="getTrackingProjectId(<?= $obj['ProjectTrack_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                    </svg></button>
                                                                <button type="button" class="btn btn-outline-success" onclick="detailProjectTracking(<?= $obj['ProjectTrack_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                                    </svg></button>
                                                                <button type="button" class="btn btn-outline-danger" onclick="deleteTracking(<?= $obj['ProjectTrack_id'] ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
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
                                                    <th>Descripción</th>
                                                    <th>Fecha</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL DE SEGUIMIENTO DE PROYECTO -->

                            <div class="modal fade" id="TrackingModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createUpdateModalLabel">NUEVO SEGUIMIENTO</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal mt-3" id="objTrackingForm" action="" onsubmit="sendTrackingData(event,this.id)">
                                                <div class="row">
                                                    <input type="hidden" class="form-control" id="ProjectTrack_id" name="ProjectTrack_id" value="0">
                                                    <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                                    <div class="mb-3 col-3">
                                                        <label for="ProjectTrack_name">Nombre</label>
                                                        <input type="text" class="form-control" id="ProjectTrack_name" name="ProjectTrack_name" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="ProjectTrack_date">Fecha</label>
                                                        <input type="date" class="form-control" id="ProjectTrack_date" name="ProjectTrack_date">
                                                    </div>
                                                    <div class="mb-3 col-12">
                                                        <label for="ProjectTrack_description">Descripción</label>
                                                        <input type="text" class="form-control" id="ProjectTrack_description" name="ProjectTrack_description" required>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" id="btn-submit" form="objTrackingForm" class="btn btn-primary mx-auto w-50">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- GESTIÓN DE ACTIVIDADES -->

                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                            <!-- TABLA DE ACTIVIDADES-->

                            <div class="card-pp">
                                <h4 class="page-title">
                                    <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showActivitiesModal(1)"><i class="mdi mdi-plus"></i></button>
                                    Asignar Actividad
                                </h4>
                                <div class="card-body">
                                    <div class="table-responsive table-pp">
                                        <table id="table_obj_activities" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Código</th>
                                                    <th>Fecha de creación</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ?>
                                                <?php foreach ($activities as $obj) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $obj->Activi_name; ?></td>
                                                        <td><?= $obj->Activi_code; ?></td>
                                                        <td><?= $obj->created_at; ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                                                <button type="button" class="btn btn-outline-warning" onclick="getActivitiesDataId(<?= $obj->Activi_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                    </svg></button>
                                                                <button type="button" class="btn btn-outline-success" onclick="details(<?= $obj->Activi_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                                    </svg></button>
                                                                <button type="button" class="btn btn-outline-danger" onclick="deleteActivities(<?= $obj->Activi_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
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
                                                    <th>Código</th>
                                                    <th>Fecha de creación</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL DE ACTIVIDADES-->

                            <div class="modal fade" id="activitiesModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createUpdateModalLabel">NUEVA ACTIVIDAD</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body ">
                                            <form class="form-horizontal mt-3" id="objActivitiesForm" action="" onsubmit="sendActivitiesData(event,this.id)">
                                                <div class="row">
                                                    <input type="hidden" class="form-control" id="Activi_id" name="Activi_id" value="0">
                                                    <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_name">Nombre de Actividad</label>
                                                        <input type="text" class="form-control" id="Activi_name" name="Activi_name" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Project_product_id">Producto</label>
                                                        <select name="Project_product_id" id="Project_product_id" class="form-control" required>
                                                            <option value="">
                                                                Seleccione...
                                                            </option>
                                                            <?php foreach ($data['products'] as $obj) : ?>
                                                                <option value="<?= $obj->Project_product_id ?>">
                                                                    <?= $obj->Prod_name; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_startDate">Fecha estimada de entrega</label>
                                                        <input type="date" class="form-control" id="Activi_startDate" name="Activi_startDate">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_endDate">Fecha de entrega final</label>
                                                        <input type="date" class="form-control" id="Activi_endDate" name="Activi_endDate">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_link">Enlace</label>
                                                        <input type="text" class="form-control" id="Activi_link" name="Activi_link" required>
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_codeMiigo">Código Miigo</label>
                                                        <input type="text" class="form-control" id="Activi_codeMiigo" name="Activi_codeMiigo">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_codeSpectra">Código Spectra</label>
                                                        <input type="text" class="form-control" id="Activi_codeSpectra" name="Activi_codeSpectra">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Activi_codeDelivery">Código Entregable</label>
                                                        <input type="text" class="form-control" id="Activi_codeDelivery" name="Activi_codeDelivery">
                                                    </div>
                                                    <div class="mb-3 col-3">
                                                        <label for="Stat_id">Estado</label>
                                                        <select class="form-control form-select Stat_activity" id="Stat_id" name="Stat_id">
                                                            <?php foreach ($statuses as $status) : ?>
                                                                <option value="<?= $status->Stat_id; ?>">
                                                                    <?= $status->Stat_name; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3 col-12">
                                                        <label for="Activi_observation">Observaciones</label>
                                                        <input type="text" class="form-control" id="Activi_observation" name="Activi_observation" required>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary mx-auto w-50" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" id="btn-submit" form="objActivitiesForm" class="btn btn-primary mx-auto w-50">Guardar</button>
                                        </div>
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
            <?= $footer ?>
            <?= $toasts ?>
        </div>.
    </div>
    <?= $js ?>
    <script src="./controllers/details/details.controller.js"></script>
    <script src="./controllers/activities/activities.controller.js"></script>
    <script src="./controllers/projecttracking/projecttracking.controller.js"></script>
</body>