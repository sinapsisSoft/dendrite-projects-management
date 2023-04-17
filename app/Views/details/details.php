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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Información del Proyecto</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Información</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Gestión</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <form class="form-horizontal mt-3" id="objForm" action="" onsubmit="sendData(event,this.id)">
                            <div class="row">
                                <input type="hidden" class="form-control" id="Project_id" name="Project_id" value="<?= $data["project"]["Project_id"] ?>">
                                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" disabled id="Project_name" name="Project_name" value="<?= $data["project"]["Project_name"] ?>" required>
                                    <label for="Project_name">Nombre</label>
                                </div>
                                <div class="form-floating mb-3 col-4">
                                    <input type="text" class="form-control" disabled id="Project_purchaseOrder" name="Project_purchaseOrder" value="<?= $data["project"]["Project_purchaseOrder"] ?>" required>
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
                                    <input type="text" class="form-control" disabled id="Project_link" value="<?= $data["project"]["Project_link"] ?>" name="Project_link" required>
                                    <label for="Project_link">Link del proyeto</label>
                                </div>
                                <div class="form-floating mb-3 col-6">
                                    <input type="text" class="form-control" disabled id="Project_percentage" value="<?= $data["project"]["Project_percentage"] ?>" name="Project_percentage" required>
                                    <label for="Project_percentage">% realizado del proyecto</label>
                                </div>
                                <div class="form-floating mb-3 col-6">
                                    <input type="text" class="form-control" disabled id="Project_observation" value="<?= $data["project"]["Project_observation"] ?>" name="Project_observation" required>
                                    <label for="Project_observation">Observaciones</label>
                                </div>
                            </div>
                        </form>
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
                                            <th>Estado</th>
                                            <th>Semaforo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1 ?>
                                        <?php foreach ($data['products'] as $obj) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $obj->Prod_name; ?></td>
                                                <td><?= $obj->Project_productAmount; ?></td>
                                                <td><?= $obj->Stat_name; ?></td>
                                                <td>
                                                    <div class="circle" style="background-color:<?= $obj->color; ?>"></div>
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
                                            <th>Estado</th>
                                            <th>Semaforo</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Informacion</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Gestión</div>
                </div>


                <div class="modal fade" id="createUpdateModal" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createUpdateModalLabel">NUEVO PRODUCTO</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                                    <input type="hidden" class="form-control" id="Country_id" name="Country_id" value="0">
                                    <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                    <div class="form-floating mb-3 col-6">
                                        <select name="Prod_id" id="Prod_id" class="form-control">
                                            <option value="">
                                                Seleccionar...
                                            </option>
                                            <?php foreach ($products as $product) : ?>
                                                <option value="<?= $product['Prod_id']; ?>">
                                                    <?= $product['Prod_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="Prod_id">Producto</label>
                                    </div>
                                    <div class="form-floating mb-3 col-6">
                                        <input type="text" class="form-control" id="Country_name" name="Country_name" required>
                                        <label for="Country_name">Cantidad</label>
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
    <script src="../controllers/details/details.controller.js"></script>
</body>