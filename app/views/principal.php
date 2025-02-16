<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CRUD CLIENTES</title>
    <link href="web/css/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="text/javascript" src="web/js/funciones.js"></script>
</head>
<style>
    .custom-file-input::file-selector-button {
        border-radius: 10px;
        border: none;
        background-color: rgb(48, 122, 196);
        box-shadow: 0 0 15px rgba(20, 0, 240, 0.5);
        color: white;
        padding: 4px;
    }
</style>

<body>
    <div id="container" class="d-flex text-center flex-column m-auto mt-5 mb-5" style="width: 90%;">
        <div id="header">
            <h1>MIS CLIENTES CRUD versión 1.0</h1>
        </div>
        <div class="d-flex justify-content-start p-2">
            <a href="?orden=Terminar" class="btn btn-danger">Cerrar sesión</a>
        </div>
        <?php if (!empty($msg) && isset($_GET['orden'])): ?>
            <div id="aviso">
                <?php if ($_GET['orden'] == 'Borrar'): ?>
                    <p class="alert alert-danger"><?= $msg ?></p>
                <?php elseif ($_GET['orden'] == 'Nuevo'): ?>
                    <?= $msg ?>
                <?php elseif ($_GET['orden'] == 'Modificar'): ?>
                    <?= $msg ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div id="content">
            <?= $contenido ?>
        </div>
    </div>
</body>

</html>