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
    <div class="main-wrapper">
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
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="auth-box border-secondary">
                <div class="text-center pt-3 pb-3">
                    <span class="db"><img class="" width="200px" src="<?= base_url() ?>/assets/img/logos/logo_slogan.png" alt="logo" /></span>
                </div>
                <div id="">
                    <!-- Form -->

                    <form class="form-horizontal mt-3" id="loginform" action="<?= base_url(route_to('signin')) ?>" method="POST">
                        <div class="row pb-4">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white h-100" id="basic-addon1"><i class="mdi mdi-account fs-4"></i></span>
                                    </div>
                                    <input type="email" id="User_email" name="User_email" value="<?= old('User_email') ?>" class="form-control form-control-lg" placeholder="Digitar Usuario" aria-label="User_email" aria-describedby="basic-addon1" require />
                                    <div id="User_emailFeedback" class="invalid-feedback" style="display: block;">
                                        <?= session('errors.User_email') ?>
                                        <?= session('msg.body') ?>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="cursor: pointer;" class="input-group-text bg-warning text-white h-100" id="basic-addon2" onclick="viewInputPassword('User_password','iconPassword')"><i id="iconPassword" class="mdi mdi-eye fs-4"></i></span>
                                    </div>
                                    <input type="password" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$" title="La contraseña debe tener entre 8 y 16 caracteres. Al menos un dígito. Al menos una minúscula. Al menos una mayúscula y al menos un caracter no alfanumérico." id="User_password" name="User_password" class="form-control form-control-lg" placeholder="Digitar Contraseña" aria-label="User_password" aria-describedby="basic-addon1" require />
                                    <div id="User_passwordFeedback" class="invalid-feedback" style="display: block;">
                                        <?= session('errors.User_password') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-secondary">
                        <div class="col-12">
                                <button class="btn btn-primary float-end text-white w-100" type="submit">
                                    Ingresar
                                </button>
                            </div>
                            <div class="col-12 my-2">
                                <button class="btn btn-info w-100" id="to-recover" type="button">
                                    <i class="mdi mdi-lock fs-4 me-1"></i> ¿Olvidaste la contraseña?
                                </button>
                            </div>                            
                        </div>
                    </form>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">Ingrese su e-mail y se le enviarán las instrucciones para recuperar la contraseña.</span>
                    </div>
                    <div class="row mt-3">
                        <!-- Form -->

                        <form class="col-12" action="" id="formRecoveryPassword" onsubmit="recoveryPassword(event,this.id)">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white h-100" id="basic-addon1"><i class="mdi mdi-email fs-4"></i></span>
                                </div>
                                <input type="email" class="form-control form-control-lg" placeholder="E-mail del usuario" id="User_email" name="User_email" aria-label="User_email" aria-describedby="basic-addon1" required />
                                <div id="ResultFeedback" class="" style="display: block;">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3 pt-3 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-info text-white" href="#" id="to-login" name="action">Volver a Ingreso</a>
                                    <button class="btn btn-primary float-end" type="submit" name="action">
                                        Recuperar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <?= $js ?>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script src="./controllers/auth/login.controller.js"></script>

</body>

</html>