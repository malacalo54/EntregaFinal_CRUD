<form class="container-fluid d-flex flex-column" method="POST" enctype="multipart/form-data">
    <div class="d-flex flex-row justify-content-end">
        <input class="btn btn-primary mb-2 mx-2" style="width:8%" type="submit" name="orden" value="<?= $orden ?>">
        <input class="btn btn-success mb-2" style="width:8%" type="submit" name="orden" value="Volver">
    </div>
    <div class="form-floating mb-3">
        <input class="form-control" type="text" name="id" readonly value="<?= $cli->id ?>">
        <label class="floatingInput" for="id">Id:</label>
    </div>
    <div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="first_name" name="first_name" value="<?= $cli->first_name; ?>"
                placeholder="first_name">
            <label for="first_name">Nombre:</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="last_name" name="last_name" value="<?= $cli->last_name; ?>"
                placeholder="last_name">
            <label for="last_name">Apellido:</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="email" id="email" name="email" value="<?= $cli->email; ?>"
                placeholder="email">
            <label for="email">Email:</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="gender" name="gender" value="<?= $cli->gender; ?>"
                placeholder="gender">
            <label for="gender">Género:</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="ip_address" name="ip_address" value="<?= $cli->ip_address; ?>"
                placeholder="ip_address">
            <label for="ip_address">Dirección IP:</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" type="text" id="telefono" name="telefono" value="<?= $cli->telefono; ?>"
                placeholder="telefono">
            <label for="telefono">Teléfono:</label>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Subir Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
        </div>
    </div>
</form>