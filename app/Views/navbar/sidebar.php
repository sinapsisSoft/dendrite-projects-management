<?php
$model = model('App\Models\User\UserModel');
$url = substr($_SERVER['REQUEST_URI'], 1, strlen($_SERVER['REQUEST_URI']));
if ($userModel = $model->sp_select_user_modules(session()->UserId)) {
  // return redirect()->route('login');
}

?>
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
        <?php foreach ($userModel as $obj): ?>
          <?php if ($obj->Mod_route != "" && $obj->Mod_parent == NULL): ?>
            <li class="sidebar-item">
              <?php if ($url == $obj->Mod_route): ?>
                <a class="sidebar-link waves-effect waves-dark active" href="<?= $obj->Mod_route ?>" aria-expanded="false">
                <?php else: ?>
                  <a class="sidebar-link waves-effect waves-dark" href="<?= $obj->Mod_route ?>" aria-expanded="false">
                  <?php endif; ?>
                  <lord-icon src="<?= $obj->Mod_icon ?>" trigger="hover" colors="primary:#121331"
                    style="width:25px;height:25px">
                  </lord-icon>
                  <span class="hide-menu">&emsp;
                    <?= $obj->Mod_name ?>
                  </span></a>
            </li>
          <?php elseif ($obj->Mod_route == ""): ?>
            <li class="sidebar-item">
              <?php if ($url == $obj->Mod_route): ?>
                <a class="sidebar-link waves-effect waves-dark active" href="javascript:void(0)" aria-expanded="false">
                <?php else: ?>
                  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                  <?php endif; ?>
                  <lord-icon src="<?= $obj->Mod_icon ?>" trigger="hover" colors="primary:#121331"
                    style="width:25px;height:25px">
                  </lord-icon>
                  <span class="hide-menu">&emsp;
                    <?= $obj->Mod_name ?>
                  </span>
                </a>
                <ul aria-expanded="false" class="collapse first-level color">
                  <?php foreach ($userModel as $objSub): ?>
                    <?php if ($objSub->Mod_route != "" && $objSub->Mod_parent == $obj->Mod_id): ?>
                      <li class="sidebar-item">
                        <a href="<?= $objSub->Mod_route ?>" class="sidebar-link project"><i
                            class="mdi mdi-chevron-right"></i><span class="hide-menu"><?= $objSub->Mod_name ?></span></a>
                      </li>
                    <?php endif ?>
                  <?php endforeach; ?>
                </ul>
            </li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>