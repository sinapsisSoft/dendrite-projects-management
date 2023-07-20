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
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <?= $header ?>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <?= $sidebar ?>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">
              NUEVO USUARIO
              <button type="button" class="btn btn-primary btn-circle btn-lg" onclick="showModal(1)">
                <lord-icon src="<?= base_url() ?>/assets/json/system-outline-8-account.json" trigger="hover" colors="primary:#ffffff" style="width:25px;height:25px">
                </lord-icon>
              </button>
            </h4>
            <div class="ms-auto text-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="<?= base_url() ?>home">Inicio</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <a href="<?= base_url() ?>user">Usuarios</a>
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">
                  LISTA DE USUARIOS
                </h5>
                <div class="table-responsive">
                  <table id="table_obj" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Rol</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1 ?>
                      <?php foreach ($users as $obj) : ?>

                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $obj->User_name; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td><?= $obj->Role_name; ?></td>
                          <td><?= $obj->Created_at; ?></td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <button type="button" class="btn btn-outline-warning" onclick="getDataId(<?= $obj->User_id ?>, 1)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg></button>
                              <button type="button" class="btn btn-outline-success" onclick="getDataId(<?= $obj->User_id; ?>, 0)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                </svg></button>
                              <button type="button" class="btn btn-outline-danger" onclick="delete_(<?= $obj->User_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
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
                        <th>Estado</th>
                        <th>Rol</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Modal Content -->
        <!-- ============================================================== -->
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="createUpdateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="createUpdateModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content" style="width: 100%;">
              <div class="modal-header">
                <h5 class="modal-title" id="createUpdateModalLabel">NUEVO USUARIO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                  <input type="hidden" class="form-control" id="User_id" name="User_id" value="0">
                  <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                  <div class="col-12 col-md-6 mb-3">
                    <label for="User_name">Nombre</label>
                    <input type="text" class="form-control" id="User_name" name="User_name" placeholder="Nombre" required>
                  </div>
                  <div class="col-12 col-md-6 mb-3">
                    <label for="User_email">Correo electrónico</label>
                    <input type="email" class="form-control" id="User_email" name="User_email" placeholder="user@example.com" required>
                  </div>
                  <div id="userPassword-div" class="col-12 col-md-6 mb-3 user-password">
                    <label for="User_password">Contraseña</label>
                    <input type="password" class="form-control" id="User_password" name="User_password" placeholder="Contraseña" required>
                  </div>
                  <div id="userPassword-div" class="col-12 col-md-5 mb-3 user-password">
                    <label for="confirmPassword">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmar contraseña" required>
                  </div>
                  <div id="userPassword-div" class="col-1 mb-3 align-self-end user-password">
                    <button type="button" class="btn btn-outline-primary" id="showPassword" name="showPassword" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver/Ocultar" style="border: none;">
                    <i class="bi bi-eye" style="font-size: 1.6rem;"></i>
                    </button>
                  </div>
                  <div class="mb-3 col-4 d-none">
                    <label for="Comp_id">Empresa</label>
                    <select class="form-select form-select-sm" id="Comp_id" name="Comp_id" required>
                      <?php foreach ($companys as $company) : ?>
                        <option value="<?= $company['Comp_id']; ?>"> <?= $company['Comp_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-6 mb-3">
                    <label for="Role_id">Rol de usuario</label>
                    <select class="form-select form-select-sm" id="Role_id" name="Role_id" aria-label=".form-select-sm " required>
                      <option value="" selected>Seleccione...</option>
                      <?php foreach ($roles as $role) : ?>
                        <option value="<?= $role['Role_id']; ?>"> <?= $role['Role_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-6 mb-3">
                    <label for="Stat_id">Estado de usuario</label>
                    <select class="form-select form-select-sm form-disabled read" id="Stat_id" name="Stat_id" aria-label=".form-select-sm " required>
                      <?php foreach ($status as $statu) : ?>
                        <option value="<?= $statu->Stat_id; ?>"> <?= $statu->Stat_name; ?></option>
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

        <!-- ============================================================== -->
        <!-- End Modal Content -->
        <!-- ============================================================== -->

      </div>

      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <?= $footer ?>
      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- toasts -->
      <!-- ============================================================== -->
      <?= $toasts ?>
      <!-- ============================================================== -->
      <!-- End toasts -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->

  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- All Required js -->
  <!-- ============================================================== -->
  <?= $js ?>
  <!-- ============================================================== -->
  <!-- This page plugin js -->
  <!-- ============================================================== -->

  <!-- ============================================================== -->
  <script src="./controllers/user/user.controller.js"></script>
</body>

</html>