<?php

function crudBorrar($id)
{
    $db = AccesoDatos::getModelo();
    $resu = $db->borrarCliente($id);
    if ($resu) {
        $_SESSION['msg'] = " El usuario " . $id . " ha sido eliminado.";
    } else {
        $_SESSION['msg'] = " Error al eliminar el usuario " . $id . ".";
    }
}

function crudTerminar()
{
    AccesoDatos::closeModelo();
    session_destroy();
}

function crudAlta()
{
    $cli = new Cliente();
    $orden = "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    include_once "app/views/detalles.php";
}

function crudDetallesAnterior($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    include_once "app/views/detalles.php";
}

function crudModificarSiguiente($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    include_once "app/views/formulario.php";
}

function crudModificarAnterior($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    include_once "app/views/formulario.php";
}

function crudModificar($id)
{
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden = "Modificar";
    include_once "app/views/formulario.php";
}

function crudPostAlta()
{
    limpiarArrayEntrada($_POST);
    $cli = new Cliente();
    $cli->first_name = $_POST['first_name'];
    $cli->last_name = $_POST['last_name'];
    $cli->email = $_POST['email'];
    $cli->gender = $_POST['gender'];
    $cli->ip_address = $_POST['ip_address'];
    $cli->telefono = $_POST['telefono'];

    if (!validar_IP($cli->ip_address)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: La dirección IP no es válida.</p>";
        return;
    }

    if (!validar_telefono($cli->telefono)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: El número de teléfono no es válido.</p>";
        return;
    }

    if (!validarEmail($cli->email)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: El email no tiene un formato válido.</p>";
        return;
    }

    $db = AccesoDatos::getModelo();
    if (!$db->EmailNoRepetido($cli->email, $cli->id)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: Este email ya está en uso</p>";
        return;
    }

    $db = AccesoDatos::getModelo();
    if ($db->addCliente($cli)) {
        $_SESSION['msg'] = "<p class='alert alert-success'>El usuario " . $cli->first_name . " se ha dado de alta.</p>";
        $nuevoClienteId = $db->getUltimoClienteId();
        if ($nuevoClienteId) {
            $cli->id = $nuevoClienteId;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
                if (subirImagen($cli->id)) {
                    $_SESSION['msg'] .= "";
                }
            }
        }
    } else {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error al dar de alta al usuario " . $cli->first_name . ".</p>";
    }
}

function crudPostModificar()
{
    limpiarArrayEntrada($_POST);
    $cli = new Cliente();

    $cli->id = $_POST['id'];
    $cli->first_name = $_POST['first_name'];
    $cli->last_name = $_POST['last_name'];
    $cli->email = $_POST['email'];
    $cli->gender = $_POST['gender'];
    $cli->ip_address = $_POST['ip_address'];
    $cli->telefono = $_POST['telefono'];

    if (!validar_IP($cli->ip_address)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: La dirección IP no es válida.</p>";
        return;
    }

    if (!validar_telefono($cli->telefono)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: El número de teléfono no es válido.</p>";
        return;
    }

    if (!validarEmail($cli->email)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: El email no tiene un formato válido.</p>";
        return;
    }
    $db = AccesoDatos::getModelo();
    if (!$db->EmailNoRepetido($cli->email, $cli->id)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error: Este email ya está en uso</p>";
        return;
    }

    $db = AccesoDatos::getModelo();

    if ($db->modCliente($cli)) {
        $_SESSION['msg'] = "<p class='alert alert-success'>El usuario ha sido modificado.</p>";
    } else {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error al modificar el usuario.</p>";
        
    }

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        if (subirImagen($cli->id)) {
            $_SESSION['msg'] .= "<p class='alert alert-success'>Imagen subida correctamente.</p>";
        }
    }
}

function subirImagen($id)
{
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error al subir la imagen.</p>";
        return false;
    }

    $imagen = $_FILES['imagen'];
    $directorioDestino = "app/uploads/";
    $tamanoMaximo = 500 * 1024;

    if ($imagen['size'] > $tamanoMaximo) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>La imagen es demasiado grande. Máximo 500 KB.</p>";
        return false;
    }

    $extensionesPermitidas = ['jpg', 'png'];
    $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $extensionesPermitidas)) {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Formato no permitido. Usa JPG o PNG.</p>";
        return false;
    }

    $nombreArchivo = sprintf("0000%04d.%s", $id, $extension);
    $rutaDestino = $directorioDestino . $nombreArchivo;

    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        return true;
    } else {
        $_SESSION['msg'] = "<p class='alert alert-danger'>Error al mover la imagen.</p>";
        return false;
    }
}

function validar_IP($ip)
{
    return filter_var($ip, FILTER_VALIDATE_IP) !== false;
}

function validar_telefono($phone)
{
    return preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone);
}

function validarEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
