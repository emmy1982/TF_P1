<?php
session_start();

require_once 'controllers/db_connection.php';

$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

include 'views/layouts/header.php';

include 'views/layouts/navigation.php';

$admin_pages = ['usuarios-administracion', 'citas-administracion', 'noticias-administracion'];

if (in_array($page, $admin_pages)) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        echo '<div class="container"><div class="alert alert-danger">No tienes permiso para acceder a esta página.</div></div>';
        $page = 'home';
    }
}

switch ($page) {
    case 'home':
        include 'views/home.php';
        break;
    case 'login':
        include 'views/login.php';
        break;
    case 'registro':
        include 'views/registro.php';
        break;
    case 'noticias':
        include 'views/noticias.php';
        break;
    case 'appointments':
        include 'views/appointments.php';
        break;
    case 'profile':
        include 'views/profile.php';
        break;
    case 'usuarios-administracion':
        include 'views/admin/usuarios.php';
        break;
    case 'citas-administracion':
        include 'views/admin/citas.php';
        break;
    case 'noticias-administracion':
        include 'views/admin/noticias.php';
        break;
    case 'especialidad':
        include 'views/especialidad.php';
        break;
    case 'servicios':
        include 'views/servicios.php';
        break;
    case 'citaciones':
        include 'views/citaciones.php';
        break;
    default:
        include 'views/home.php';
}

include 'views/layouts/footer.php';
?>
