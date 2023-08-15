<style>
  .color {
    background: #B8CECA !important;
  }
</style>

<header class="topbar" data-navbarbg="skin5">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header color" data-logobg="skin5">
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <a class="navbar-brand" href="home">
        <!-- Logo icon -->
        <b class="logo-icon ps-2">
          <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
          <!-- Dark Logo icon -->
          <img src="<?= base_url() ?>/assets/img/logos/logo_small.png" alt="homepage" class="light-logo" width="30" />
        </b>
        <!--End Logo icon -->
        <!-- Logo text -->
        <b class="logo-text ms-2">
          <!-- dark Logo text -->
          <img src="<?= base_url() ?>/assets/img/logos/logo_slogan.png" alt="homepage" class="light-logo"
            width="130px" />
        </b>
       
      </a>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
          class="ti-menu ti-close"></i></a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-start me-auto">
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
            data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
        </li>

      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-end">
        <!-- ============================================================== -->
        <!-- Comment -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- End Messages -->
        <!-- ============================================================== -->
        <li class="nav-item">
          <a id="btn-info" href="#" target="_blank"
            class="nav-link text-muted waves-effect waves-dark pro-pic d-flex align-items-center">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-140-help-center.json" trigger="hover"
              colors="primary:#ffffff" style="width:30px;height:30px">
            </lord-icon>
          </a>
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic d-flex align-items-center"
            href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-8-account.json" trigger="hover"
              colors="primary:#ffffff" style="width:30px;height:30px">
            </lord-icon>
          </a>
          <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i
            class="fa fa-user-circle me-1 ms-1" aria-hidden="true"></i><?= session()->UserName ?></a>
            <a class="dropdown-item" href="<?= base_url(route_to('signout')) ?>"><i class="fa fa-power-off me-1 ms-1"></i>
              Cerrar sesión</a>
          </ul>
        </li>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
      </ul>
    </div>
  </nav>
</header>