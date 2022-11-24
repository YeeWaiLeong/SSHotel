<!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          
          <li class="nav-item d-none d-sm-inline-block">
            <a target="_blank" href="<?php echo base_url ?>" class="nav-link"><?php echo (!isMobileDevice()) ? $_settings->info('name'):$_settings->info('short_name'); ?> - Admin Panel</a>
          </li>
        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
          <li class="nav-item"> 
            <a class="nav-link"href="<?php echo base_url.'admin/?page=system_info' ?>" role="button">
            <i class="fas fa-cog"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"  href="javascript:void(0)" onclick="location.replace('<?php echo base_url.'/classes/Login.php?f=logout' ?>')" role="button">
            <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->