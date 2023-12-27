<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo RUTA_URL; ?>home" class="brand-link">
        <img src="<?php echo RUTA_URL; ?>public/img/logo-<?php echo NOMBRE_LOGICO; ?>.png" width="50" height="50" class="brand-image elevation-0" style="opacity: .8; width: 44px; margin-top: 1px; margin-left: 5px;">
        <span class="brand-text font-weight-light" style="font-size: 16px;;"><?php echo NOMBRE_SISTEMA; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        
        <?php

        function generarMenu($menuItems)
        {
            echo '<ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact" data-widget="treeview" role="menu" data-accordion="false">';
            
            foreach ($menuItems as $menuItem) {
                echo '<li class="nav-item">';
                
                // Enlace principal
                echo '<a href="#" class="nav-link" style="font-size: 12px;">';
                echo '<i class="nav-icon '.$menuItem['icono'].'" style="font-size: 12px;"></i>';
                echo '<p>';
                echo $menuItem['nombre'];
                echo '<i class="right fa-solid fa-chevron-right" style="font-size: 10px; right: 12px;"></i>';
                echo '</p>';
                echo '</a>';
                
                // Submenú
                if (!empty($menuItem['child'])) {
                    generarSubMenu($menuItem['child'], 1);
                }
                
                echo '</li>';
            }
            
            echo '</ul>';
        }

        function generarSubMenu($subMenuItems, $submenu = 0 )
        {
            echo '<ul class="nav nav-treeview">';
            
            foreach ($subMenuItems as $subMenuItem) {
                echo '<li class="nav-item">';

                if ( !empty($subMenuItem['url']) )
                    $url = RUTA_URL . $subMenuItem['url'];

                echo '<a href="' . $url . '" class="nav-link" style="font-size: 12px;">';

                echo '<p>';
                echo $subMenuItem['nombre'];

                if ( empty($subMenuItem['url']) )
                    echo '<i class="right fa-solid fa-chevron-left" style="font-size: 10px; right: 22px;"></i>';

                echo '</p>';
                echo '</a>';

                // Verificar si hay más niveles
                if ( !empty($subMenuItem['child']) ) {
                    generarSubMenu($subMenuItem['child'], 1);
                }

                echo '</li>';
            }
            
            echo '</ul>';
        }

        // Llamar a la función para generar el menú
        generarMenu( $_SESSION['menu_perfil'] );

        ?>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>