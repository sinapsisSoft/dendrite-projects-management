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
        .card {
            padding: 2%;
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    CREDENCIALES DE CORREO DE NOTIFICACIÓN
                                </h5>
                            </div>
                            <div class="modal-header">
                            </div>
                            <form class="form-horizontal mt-3 row" id="objForm" action="" onsubmit="sendData(event,this.id)">
                                <input type="hidden" class="form-control" id="Email_id" name="Email_id" value="<?= $emails == null ? '' : $emails['Email_id']?>">
                                <input type="hidden" class="form-control" id="updated_at" name="updated_at" value="NULL">
                                <div class="mb-3 col-8">
                                    <label for="Email_user">Correo</label>
                                    <input type="email" class="form-control" id="Email_user" name="Email_user" required value="<?= $emails == null ? '' : $emails['Email_user']?>">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="Email_pass">Contraseña</label>
                                    <input type="text" class="form-control" id="Email_pass" name="Email_pass" required value="<?= $emails == null ? '' : $emails['Email_pass']?>">
                                </div>
                                <div class="mb-3 col-8">
                                    <label for="Email_host">Host</label>
                                    <input type="text" class="form-control" id="Email_host" name="Email_host" required value="<?= $emails == null ? '' : $emails['Email_host']?>">
                                </div>
                                <div class="mb-3 col-4">
                                    <label for="Email_puerto">Puerto</label>
                                    <input type="text" class="form-control" id="Email_puerto" name="Email_puerto" required value="<?= $emails == null ? '' : $emails['Email_puerto']?>">
                                </div>
                            </form>
                            <div class="modal-footer">
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
    <script src="../controllers/email/email.controller.js"></script>
</body>