<style>
  .color {
    background: #ffff !important;
  }

  .sidebar-nav ul .sidebar-item .sidebar-link {
    color: #1F0229;
  }

  .sidebar-nav ul .sidebar-item .sidebar-link i {

    color: #1F0229;
  }

  .sidebar-nav .has-arrow:after {
    border-color: #1F0229;
  }
</style>

<aside class="left-sidebar color" data-sidebarbg="skin5">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="pt-4 color">
        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link home" href="/" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-41-home.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Inicio</span></a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link project" href="/project" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-44-folder.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Gestión de proyectos</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-64-shopping-bag.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Productos / Servicios </span></a>
          <ul aria-expanded="false" class="collapse first-level color">
            <li class="sidebar-item">
              <a href="/product" class="sidebar-link product"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Productos </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/productbrand" class="sidebar-link productbrand"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Marca </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/producttype" class="sidebar-link producttype"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Tipo </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/filing" class="sidebar-link filing"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Presentación </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/unit" class="sidebar-link unit"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Unidad </span></a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item">
          <a href="/client" class="sidebar-link client">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-2-accessibility.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Gestión de Clientes </span></a>
        </li>
        <li class="sidebar-item">
          <a href="/reports" class="sidebar-link reports">
          <lord-icon src="<?= base_url() ?>/assets/json/system-outline-43-pie-chart-diagram.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Reportes </span></a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-8-account.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Gestión de Usuarios </span></a>
          <ul aria-expanded="false" class="collapse first-level color">
            <li class="sidebar-item">
              <a href="/user" class="sidebar-link user"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Usuario </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/module" class="sidebar-link module"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Módulos </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/role" class="sidebar-link role"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Roles </span></a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
            <lord-icon src="<?= base_url() ?>/assets/json/system-outline-63-settings-cog.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px">
            </lord-icon>
            <span class="hide-menu">&emsp;Configuración </span></a>
          <ul aria-expanded="false" class="collapse first-level color">
            <li class="sidebar-item">
              <a href="/doctype" class="sidebar-link doctype"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Tipo de documento </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/email" class="sidebar-link email"><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Credenciales de correo</span></a>
            </li>
            <li class="sidebar-item">
              <a href="/mail" class="sidebar-link mail "><i class="mdi mdi-chevron-right"></i><span class="hide-menu">Correo de correspondencia</span></a>
            </li>
            <li class="sidebar-item">
              <a href="/priorities" class="sidebar-link priorities"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Prioridades</span></a>
            </li>
            <li class="sidebar-item">
              <a href="/country" class="sidebar-link country"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> País </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/city" class="sidebar-link city"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Ciudad </span></a>
            </li>
            <li class="sidebar-item">
              <a href="/userstatus" class="sidebar-link userstatus"><i class="mdi mdi-chevron-right"></i><span class="hide-menu"> Estado </span></a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>

<script>
  window.onload = function() {
    let links = document.querySelectorAll("aside a");
    let position = 0;
    links.forEach(function(element) {
      let className = element.classList;
      ifelement.classList.contains("active") ? position = className.length - 2 : position = className.length - 1;
      element.href != "javascript:void(0)" ? element.href = BASE_URL + className[position] : element.href = "javascript:void(0)";
    })
  }
</script>