
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <h2 class="text-center">Lista de Clientes</h2>
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>
                    <form method="get">
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up"
                            name="organizacion" value="ordenar-id_asc"></button>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down"
                            name="organizacion" value="ordenar-id_desc"></button>
                    </form>
                    ID
                </th>
                <th>
                    <form method="get">
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up"
                            name="organizacion" value="ordenar-nombre_asc"></button>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down"
                            name="organizacion" value="ordenar-nombre_desc"></button>
                    </form>
                    First Name
                </th>
                <th>
                    <form>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up"
                            name="organizacion" value="ordenar-email_asc"></button>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down"
                            name="organizacion" value="ordenar-email_desc"></button>
                    </form> Email
                </th>
                <th>
                    <form>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up"
                            name="organizacion" value="ordenar-genero_asc"></button>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down"
                            name="organizacion" value="ordenar-genero_desc"></button>
                    </form> Gender
                </th>
                <th>
                    <form>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up"
                            name="organizacion" value="ordenar-ip_asc"></button>
                        <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down"
                            name="organizacion" value="ordenar-ip_desc"></button>
                    </form>IP Address
                </th>
                <th>Teléfono</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tclientes as $cli): ?>
                <tr>
                    <td><?= htmlspecialchars($cli->id) ?> </td>
                    <td><?= htmlspecialchars($cli->first_name) ?> </td>
                    <td><?= htmlspecialchars($cli->email) ?> </td>
                    <td><?= htmlspecialchars($cli->gender) ?> </td>
                    <td><?= htmlspecialchars($cli->ip_address) ?> </td>
                    <td><?= htmlspecialchars($cli->telefono) ?> </td>
                    <td><a href="?orden=Detalles&id=<?= htmlspecialchars($cli->id) ?>" class="btn btn-warning"><i
                                class="bi bi-eye"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <form class="text-center" action="index.php" method="get">
        <button name="nav" value="Primero" class="btn btn-outline-secondary">
            << </button>
                <button name="nav" value="Anterior" class="btn btn-outline-secondary">
                    < </button>
                        <button name="nav" value="Siguiente" class="btn btn-outline-secondary">></button>
                        <button name="nav" value="Ultimo" class="btn btn-outline-secondary">>></button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>