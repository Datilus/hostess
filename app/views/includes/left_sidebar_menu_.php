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
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact" data-widget="treeview" role="menu" data-accordion="false">

                <?php

                foreach ($_SESSION['menu_perfil'] as $nivel1) {
                    // $menu_open = ( array_search($_SESSION["controlador"], array_column($nivel1["opcion"], 'metodo')) != "" ) ? "menu-open" : "" ;
                ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon <?php echo $nivel1["Icono"]; ?>" style="font-size: 16px;"></i>
                            <p>
                                <small><?php echo $nivel1["Text"]; ?></small>
                                <!-- <i class="right fas fa-angle-left"></i> -->
                                <i class="right fa-solid fa-chevron-right" style="font-size: 10px; right: 12px;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php
                            foreach ($nivel1["Opcion"] as $nivel2) {
                                switch ($nivel2["tipo"]) {
                                    case 'S':
                                        echo "<li class='nav-item'>
                                                <a href='#' class='nav-link'>
                                                    <i class='far fa-circle nav-icon' style='font-size: 8px;'></i>
                                                    <p>
                                                        <small>" . $nivel2["texto"] . "</small>
                                                        <i class='right fa-solid fa-chevron-left' style='font-size: 10px; right: 22px;'></i>
                                                    </p>
                                                </a>";

                                        echo "<ul class='nav nav-treeview'>";
                                        foreach ($nivel2["opcion"] as $nivel3) {
                                            echo "<li class='nav-item'>
                                                <a href='" . RUTA_URL . $nivel3["ruta_metodo"] . "' class='nav-link'>
                                                    <i class='far fa-dot-circle nav-icon' style='font-size: 8px;'></i>
                                                    <p style='font-size: 12px;'>" . $nivel3['texto'] . "</p>
                                                </a>
                                            </li>";
                                        }
                                        echo "</ul>
                                        </li>";

                                        break;
                                    case 'M':

                                        //$active = ($nivel2["metodo"] == $_SESSION["controlador"]) ? "active" : "";

                                        echo "<li class='nav-item'>
                                                <a href='" . RUTA_URL . $nivel2["ruta_metodo"] . "' class='nav-link' style='margin-bottom: 0px;'>
                                                    <i class='far fa-circle nav-icon' style='font-size: 8px;'></i>
                                                    <p style='font-size: 12px;'>" . $nivel2["texto"] . "</p>
                                                </a>
                                            </li>";

                                        break;
                                }
                            }
                            ?>
                        </ul>
                    </li>  

                <?php 
                }
                ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>