<?php
function getIpInfo($ipAddress)
{
    $apiUrl = "http://ip-api.com/json/{$ipAddress}";

    $response = @file_get_contents($apiUrl);
    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);
    return $data;
}

function getLocationByIP($ipAddress)
{
    $apiUrl = "http://ip-api.com/json/{$ipAddress}";
    $response = @file_get_contents($apiUrl);
    if ($response === false) {
        return null;
    }

    $data = json_decode($response, true);
    return $data;
}

function mostrarImagenCliente($id)
{
    $directorioDestino = "app/uploads/";
    $nombreArchivoJpg = sprintf("0000%04d.jpg", $id);
    $nombreArchivoPng = sprintf("0000%04d.png", $id);
    $rutaImagenJpg = $directorioDestino . $nombreArchivoJpg;
    $rutaImagenPng = $directorioDestino . $nombreArchivoPng;

    if (file_exists($rutaImagenJpg)) {
        return $rutaImagenJpg;
    } elseif (file_exists($rutaImagenPng)) {
        return $rutaImagenPng;
    } else {
        return "https://robohash.org/$id";
    }
}

$ipAddress = $cli->ip_address;
$ipInfo = getIpInfo($ipAddress);
$location = getLocationByIP($ipAddress);

if ($location && $location['status'] === 'success') {
    $lat = $location['lat'];
    $lon = $location['lon'];
    $city = $location['city'];
    $country = $location['country'];
} else {
    echo "<p class='alert alert-danger '>Error al obtener la dirección IP.</p>";
}
?>

<hr>
<button onclick="location.href='./'" class="btn btn-success"> Volver </button>
<form class="mb-2" style="text-align: end;">
    <input type="hidden" name="id" value="<?= $cli->id ?>">
    <button type="submit" name="nav-detalles" value="Anterior" class="btn btn-outline-secondary">Anterior</button>
    <button style="background-color: blue; color:white;" onclick="window.print()"
        class="btn btn-primary">Imprimir</button>
    <button type="submit" name="nav-detalles" value="Siguiente" class="btn btn-outline-secondary">Siguiente</button>
</form>
<table class="table table-bordered table-hover">
    <tr>
        <td>id:</td>
        <td><input class="form-control" type="number" name="id" value="<?= htmlspecialchars($cli->id) ?>" readonly> </td>
        <td rowspan="7" class="bg-light text-dark" style="text-align:center ;">
            <img src="<?= mostrarImagenCliente($cli->id) ?>?t=<?= time(); ?>" alt="Imagen del Cliente"
                style="max-width: 30%; border: 3px solid black;" class="rounded-circle">

            <?php
            if ($ipInfo && $ipInfo['status'] === 'success') {
                $country = $ipInfo['country'];
                $countryCode = strtolower($ipInfo['countryCode']);
                $flagUrl = "https://flagpedia.net/data/flags/w1600/{$countryCode}.png";

                echo "<br>Información de la IP: {$ipAddress}<br>";
                echo "País: {$country} ({$countryCode})<br>";
                echo "Bandera: <br><br><img class='rounded-top rounded-bottom mb-2' src='{$flagUrl}' style='width: 150px;' alt='Bandera de {$country}'><br>";

            } else {
                echo "<p class='alert alert-danger mt-2 w-75 mx-auto text-center'>No se pudo obtener la dirección IP.</p>";

            }
            ?>
        </td>
    </tr>
    <tr>
        <td>first_name:</td>
        <td><input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($cli->first_name) ?>" readonly> </td>
    </tr>
    <tr>
        <td>last_name:</td>
        <td><input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($cli->last_name) ?>" readonly></td>
    </tr>
    <tr>
        <td>email:</td>
        <td><input type="email" class="form-control" name="email" value="<?= htmlspecialchars($cli->email) ?>" readonly></td>
    </tr>
    <tr>
        <td>gender</td>
        <td><input type="text" class="form-control" name="gender" value="<?= htmlspecialchars($cli->gender) ?>" readonly></td>
    </tr>
    <tr>
        <td>ip_address:</td>
        <td><input type="text" class="form-control" name="ip_address" value="<?= htmlspecialchars($cli->ip_address) ?>" readonly></td>
    </tr>
    <tr>
        <td>telefono:</td>
        <td><input type="tel" class="form-control" name="telefono" value="<?= htmlspecialchars($cli->telefono) ?>" readonly></td>
    </tr>
</table>
<div id="map" class="d-block mb-3" style="width: 100%; height: 500px;"></div>

<script src="https://cdn.jsdelivr.net/npm/ol@v7.3.0/dist/ol.js"></script>

<script>
    const lat = <?= $lat ?>;
    const lon = <?= $lon ?>;

    const map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM(),
            }),
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([lon, lat]),
            zoom: 10,
        }),
        controls: [],
    });

    const marker = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([lon, lat])),
    });

    const markerLayer = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [marker],
        }),
        style: new ol.style.Style({
            image: new ol.style.Circle({
                radius: 10,
                fill: new ol.style.Fill({ color: 'red' }),
                stroke: new ol.style.Stroke({ color: 'white', width: 4 }),
            }),
        }),
    });

    map.addLayer(markerLayer);
</script>