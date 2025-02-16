<?php
session_start();
define('FPAG', 10);

require_once 'app/helpers/util.php';
require_once 'app/config/configDB.php';
require_once 'app/models/Cliente.php';
require_once 'app/models/AccesoDatosPDO.php';
require_once 'app/controllers/crudclientes.php';


if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['login_attempts'] <= 1) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $accesoDatos = AccesoDatos::getModelo();
        $rol = $accesoDatos->verificarRol($login, $password);

        if ($rol === 1) {

            $_SESSION['user_id'] = $login;
            $_SESSION['login_attempts'] = 0;
            header('Location: .');
            exit();
        } elseif ($rol === 0) {
            $_SESSION['user_id'] = $login;
            $_SESSION['login_attempts'] = 0;
            $tclientes = $accesoDatos->getClientes(0, FPAG);
            require_once "app/views/Acceso_0.php";
            exit();
        } else {

            $_SESSION['login_attempts']++;
            $error = "Login o contraseña incorrectos.";
        }
    } else {
        $error = "Demasiados intentos fallidos. Por favor, refresque la página.";
    }
} else {

    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['user_id'])) {
    require_once 'app/views/login.php';
    exit;
}

$midb = AccesoDatos::getModelo();
$totalfilas = $midb->numClientes();
if ($totalfilas % FPAG == 0) {
    $posfin = $totalfilas - FPAG;
} else {
    $posfin = $totalfilas - $totalfilas % FPAG;
}

if (!isset($_SESSION['posini'])) {
    $_SESSION['posini'] = 0;
}
$posAux = $_SESSION['posini'];

if (!isset($_SESSION['ordenacion'])) {
    $_SESSION['ordenacion'] = " ";
}

$_SESSION['msg'] = " ";

ob_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['organizacion'])) {
        switch ($_GET['organizacion']) {
            case "ordenar-id_asc":
                $_SESSION['organizacion'] = " order by id ASC ";
                break;
            case "ordenar-id_desc":
                $_SESSION['organizacion'] = " order by id DESC ";
                break;

            case "ordenar-nombre_asc":
                $_SESSION['organizacion'] = " order by first_name ASC ";
                break;
            case "ordenar-nombre_desc":
                $_SESSION['organizacion'] = " order by first_name DESC ";
                break;

            case "ordenar-email_asc":
                $_SESSION['organizacion'] = " order by email ASC ";
                break;
            case "ordenar-email_desc":
                $_SESSION['organizacion'] = " order by email DESC ";
                break;

            case "ordenar-genero_asc":
                $_SESSION['organizacion'] = " order by gender ASC ";
                break;
            case "ordenar-genero_desc":
                $_SESSION['organizacion'] = " order by gender DESC ";
                break;

            case "ordenar-ip_asc":
                $_SESSION['organizacion'] = " order by ip_address ASC ";
                break;
            case "ordenar-ip_desc":
                $_SESSION['organizacion'] = " order by ip_address DESC ";
                break;
        }
    }

    if (isset($_GET['nav'])) {
        switch ($_GET['nav']) {
            case "Primero":
                $posAux = 0;
                break;
            case "Siguiente":
                $posAux += FPAG;
                if ($posAux > $posfin)
                    $posAux = $posfin;
                break;
            case "Anterior":
                $posAux -= FPAG;
                if ($posAux < 0)
                    $posAux = 0;
                break;
            case "Ultimo":
                $posAux = $posfin;
        }
        $_SESSION['posini'] = $posAux;
    }
    if (isset($_GET['nav-detalles'])) {
        switch ($_GET['nav-detalles']) {
            case "Anterior":
                crudDetallesAnterior($_GET['id']);
                break;
            case "Siguiente":
                crudDetallesSiguiente($_GET['id']);
                break;
        }
    }
    if (isset($_GET['nav-modificar'])) {
        switch ($_GET['nav-modificar']) {
            case "Anterior":
                crudModificarAnterior($_GET['id']);
                break;
            case "Siguiente":
                crudModificarSiguiente($_GET['id']);
                break;
        }
    }

    if (isset($_GET['orden'])) {
        switch ($_GET['orden']) {
            case "Nuevo":
                crudAlta();
                break;
            case "Borrar":
                crudBorrar($_GET['id']);
                break;
            case "Modificar":
                crudModificar($_GET['id']);
                break;
            case "Detalles":
                crudDetalles($_GET['id']);
                break;
            case "Terminar":
                session_destroy();
                crudTerminar();
                require_once 'app/views/login.php';
                exit();
                break;
        }
    }
} else {
    if (isset($_POST['orden'])) {
        switch ($_POST['orden']) {
            case "Nuevo":
                crudPostAlta();
                break;
            case "Modificar":
                crudPostModificar();
                break;
            case "Detalles":
                crudDetalles($_GET['id']);
                break;
            case "Terminar":
                crudTerminar();
                exit();
        }
    }
}


if (ob_get_length() == 0) {
    $db = AccesoDatos::getModelo();
    $posini = $_SESSION['posini'];
    $tclientes = $db->getClientes($posini, FPAG);
    require_once "app/views/list.php";

}
$contenido = ob_get_clean();
$msg = $_SESSION['msg'];

require_once "app/views/principal.php";
