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
<?=var_dump($result->User_id); ?>
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
            <div class="auth-box border-top border-secondary">
                <div class="text-center pt-3 pb-3">
                    <span class="db"><img class="" width="200px"
                            src="<?= base_url() ?>/assets/img/logos/logo_slogan.png" alt="logo" /></span>
                </div>
                <div id="">
                    <!-- Form -->

                    <form class="form-horizontal mt-3" id="loginform" action="<?= base_url(route_to('signin')) ?>"
                        method="POST">
                        <div class="row pb-4">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white h-100"style="cursor: pointer;" id="basic-addon1"><i
                                                class="mdi mdi-eye fs-4" id="iconPasswordRepeat" onclick="viewInputPassword('Repeat_User_password','iconPasswordRepeat')"></i></span>
                                    </div>
                                    <input type="password" id="Repeat_User_password" name="Repeat_User_password"
                                        value="<?= old('Repeat_User_password') ?>" class="form-control form-control-lg"
                                        placeholder="Digitar Contraseña" aria-label="Repeat_User_password"
                                        aria-describedby="basic-addon1" required />
                                    <div id="User_emailFeedback" class="invalid-feedback" style="display: block;">
                                        <?= session('errors.Repeat_User_password') ?>
                                        <?= session('msg.body') ?>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="cursor: pointer;"
                                            class="input-group-text bg-warning text-white h-100" id="basic-addon2"
                                            onclick="viewInputPassword('User_password','iconPassword')"><i
                                                id="iconPassword" class="mdi mdi-eye fs-4"></i></span>
                                    </div>
                                    <input type="password" id="User_password" name="User_password"
                                        class="form-control form-control-lg" placeholder="Repetir Contraseña"
                                        aria-label="User_password" aria-describedby="basic-addon1" required />
                                    <div id="User_passwordFeedback" class="invalid-feedback" style="display: block;">
                                        <?= session('errors.User_password') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="pt-3">

                                        <button class="btn btn-success float-end text-white w-100" type="submit">
                                            <i class="mdi mdi-lock fs-4 me-1"></i> Changes password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="../controllers/auth/login.controller.js"></script>

</body>

</html>