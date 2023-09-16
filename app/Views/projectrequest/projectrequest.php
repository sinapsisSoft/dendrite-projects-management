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
            <h4 class="page-title">
              SOLICITUDES DE PROYECTOS
            </h4>
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
                        <th>Cliente</th>
                        <th>Gerente</th>
                        <th>Proyecto</th>
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
                          <td><?= $obj->Client_name; ?></td>
                          <td><?= $obj->User_name; ?></td>
                          <td><?= $obj->ProjReq_name; ?></td>
                          <td><?= $obj->Brand_name; ?></td>
                          <td><?= $obj->created_at; ?></td>
                          <td><?= $obj->Stat_name; ?></td>
                          <td>
                            <div class="circle" style="background-color:<?= $color; ?>"></div>
                          </td>
                          <td><?= $obj->Project_code == NULL ? 'NO APLICA' : $obj->Project_code ?></td>
                          <td>
                          <?php if (PERMITS[1] == "2") : ?>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                              <button type="button" class="btn btn-outline-success" onclick="details(<?= $obj->ProjReq_id ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                </svg></button>
                            </div>
                          <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Gerente</th>
                        <th>Proyecto</th>
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
        <?= $footer ?>
        <?= $toasts ?>
      </div>
    </div>
    <?= $js ?>
    <script src="./controllers/projectrequest/projectrequest.controller.js"></script>
</body>