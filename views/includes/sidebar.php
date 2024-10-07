<!-- sidebar.php -->

<!-- Incluir los estilos desde header.php -->
<?php include('header.php'); ?>

<!-- Verificar si el usuario está autenticado -->
<?php
// Iniciar sesión solo si aún no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

// Obtener el nombre del usuario desde la sesión
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario Desconocido';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <!-- Logo del sistema -->
    <a href="#" class="brand-link">
        <img src="../../public/images/Arco.jpeg" alt="Sistema Gestión Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sistema Gestión</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Usuario actual -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../public/images/avatar30.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo htmlspecialchars($user_name); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="../admin/dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Panel Principal</p>
                    </a>
                </li>

                <!-- Gestión de Solicitudes -->
                <li class="nav-item">
                    <a href="../admin/solicitudes.php" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Todas las Solicitudes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitud_crear.php" class="nav-link">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Crear Solicitud</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitudes_aceptadas.php" class="nav-link">
                        <i class="fas fa-check-circle nav-icon"></i>
                        <p>Aceptadas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitudes_enproceso.php" class="nav-link">
                        <i class="fas fa-spinner nav-icon"></i>
                        <p>En Proceso</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitudes_pendientes.php" class="nav-link">
                        <i class="fas fa-hourglass-start nav-icon"></i>
                        <p>Pendientes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitudes_finalizadas.php" class="nav-link">
                        <i class="fas fa-check nav-icon"></i>
                        <p>Finalizadas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../admin/solicitudes_rechazadas.php" class="nav-link">
                        <i class="fas fa-times-circle nav-icon"></i>
                        <p>Rechazadas</p>
                    </a>
                </li>

                <!-- Gestión de Empleados -->
                <li class="nav-item">
                    <a href="../admin/empleados.php" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Empleados</p>
                    </a>
                </li>

                <!-- Gestión de Áreas -->
                <li class="nav-item">
                    <a href="../admin/areas.php" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Áreas</p>
                    </a>
                </li>

                <!-- Gestión de Usuarios -->
                <li class="nav-item">
                    <a href="../admin/usuarios.php" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Usuarios</p>
                    </a>
                </li>

                <!-- Reportes -->
                <li class="nav-item">
                    <a href="../admin/reportes_crear.php" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Reportes</p>
                    </a>
                </li>

                <!-- Configuración -->
                <li class="nav-item">
                    <a href="../admin/configuracion.php" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Configuración</p>
                    </a>
                </li>

                <!-- Cerrar sesión -->
                <li class="nav-item">
                    <a href="../../public/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
