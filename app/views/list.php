<form class="text-center">
    <button type="submit" name="orden" value="Nuevo" class="btn btn-success"> Cliente Nuevo </button><br>
</form>
<br>
<table class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th>
                <form>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up" name="organizacion"
                        value="ordenar-id_asc"></button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down" name="organizacion"
                        value="ordenar-id_desc"></button>
                </form>
                ID
            </th>
            <th>
                <form><button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up" name="organizacion"
                        value="ordenar-nombre_asc"></button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down" name="organizacion"
                        value="ordenar-nombre_desc"></button>
                </form>
                First Name
            </th>
            <th>
                <form><button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up" name="organizacion"
                        value="ordenar-email_asc"></button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down" name="organizacion"
                        value="ordenar-email_desc"></button>
                </form> Email
            </th>
            <th>
                <form><button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up" name="organizacion"
                        value="ordenar-genero_asc"></button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down" name="organizacion"
                        value="ordenar-genero_desc"></button>
                </form> Gender
            </th>
            <th>
                <form><button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-up" name="organizacion"
                        value="ordenar-ip_asc"></button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm bi bi-arrow-down" name="organizacion"
                        value="ordenar-ip_desc"></button>
                </form>IP Address
            </th>
            <th>Teléfono</th>
            <th colspan="3"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tclientes as $cli): ?>
            <tr>
                <td><?= $cli->id ?> </td>
                <td><?= $cli->first_name ?> </td>
                <td><?= $cli->email ?> </td>
                <td><?= $cli->gender ?> </td>
                <td><?= $cli->ip_address ?> </td>
                <td><?= $cli->telefono ?> </td>
                <td><a href="#" onclick="confirmarBorrar('<?= $cli->first_name ?>','<?= $cli->id ?>');"
                        class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
                <td><a href="?orden=Modificar&id=<?= $cli->id ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                </td>
                <td><a href="?orden=Detalles&id=<?= $cli->id ?>" class="btn btn-warning"><i class="bi bi-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<form class="text-center">
    <button name="nav" value="Primero" class="btn btn-outline-secondary">
        << </button>
            <button name="nav" value="Anterior" class="btn btn-outline-secondary">
                < </button>
                    <button name="nav" value="Siguiente" class="btn btn-outline-secondary"> > </button>
                    <button name="nav" value="Ultimo" class="btn btn-outline-secondary"> >> </button>
</form>