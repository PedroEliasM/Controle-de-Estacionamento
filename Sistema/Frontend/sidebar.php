<!-- Main Sidebar Container -->

<
<style>
    .main-sidebar {
        left: inherit;
    }
    .sidebar-dark-primary {
        background-color: #343a40;
    }
    .elevation-4 {
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22) !important;
    }
    .elevation-3 {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23) !important;
    }

</style>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="../img/logo.png" alt="ParkWay Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!--<div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php //echo fotoUsuario($_SESSION['idLogin']); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo nomeUsuario($_SESSION['idLogin']); ?></a>
        </div>
      </div>-->

      <!-- Sidebar Menu -->      
      <?php echo montaMenu($_SESSION['menu-n1'],$_SESSION['menu-n2']);?>      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>