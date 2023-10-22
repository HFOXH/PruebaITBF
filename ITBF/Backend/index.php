<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$host = "localhost";
$port = "5432";
$dbname = "PruebaPHP";
$user = "postgres"; 
$password = "admin"; 

$conexionBD = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Verifica la conexión
if (!$conexionBD) {
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    exit;
}

// Consulta datos y recibe una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])) {
    $id = intval($_GET["consultar"]); 
    $sqlHoteles = pg_query($conexionBD, "SELECT * FROM tipos_habitacion WHERE hotel_id = $id");
    $hoteles = pg_fetch_all($sqlHoteles);
    if ($hoteles) {
        echo json_encode($hoteles);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

// Borrar pero se le debe enviar una clave (para borrado)
if (isset($_GET["borrar"])) {
    $id = intval($_GET["borrar"]); 
    $sqlHoteles = pg_query($conexionBD, "DELETE FROM hoteles WHERE id = $id");
    if ($sqlHoteles) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

if (isset($_GET["borrarHabitacion"])) {
    $id = intval($_GET["borrarHabitacion"]); 
    $sqlHoteles = pg_query($conexionBD, "DELETE FROM tipos_habitacion WHERE id = $id");
    if ($sqlHoteles) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

// Insertar un nuevo registro y recibe en el método POST los datos de nombre y correo
if (isset($_GET["insertar-habitacion"])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombre = pg_escape_string($conexionBD, $data->nombre);
    $cantidad = intval($data->cantidad); 
    $acomodacion = pg_escape_string($conexionBD, $data->acomodacion);
    $hotel_id = intval($data->hotel_id); 

    if (!empty($nombre) && !empty($cantidad) && !empty($acomodacion) && !empty($hotel_id)
        && ($nombre === 'Estandar' || $nombre === 'Junior' || $nombre === 'Suite')
        && ($acomodacion === 'Sencilla' || $acomodacion === 'Doble' || $acomodacion === 'Triple')) {
        
        $sqlTiposHabitacion = pg_query($conexionBD, "INSERT INTO tipos_habitacion (nombre, cantidad, acomodacion, hotel_id) VALUES ('$nombre', $cantidad, '$acomodacion', $hotel_id)");

        if ($sqlTiposHabitacion) {
            echo json_encode(["success" => 1]);
        } else {
            echo json_encode(["success" => 0]);
        }
    }
    exit();
}

if (isset($_GET["insertar-habitacion"])) {
    $data = json_decode(file_get_contents("php://input"));
    $nombre = pg_escape_string($conexionBD, $data->nombre);
    $direccion = pg_escape_string($conexionBD, $data->direccion);
    $ciudad = pg_escape_string($conexionBD, $data->ciudad);
    $nit = pg_escape_string($conexionBD, $data->nit);
    if (!empty($nombre) && !empty($direccion) && !empty($ciudad) && !empty($nit)) {
        $sqlHoteles = pg_query($conexionBD, "INSERT INTO hoteles(nombre, direccion, ciudad, nit) VALUES('$nombre','$direccion','$ciudad','$nit')");
        if ($sqlHoteles) {
            echo json_encode(["success" => 1]);
        } else {
            echo json_encode(["success" => 0]);
        }
    }
    exit();
}


// Actualizar datos pero recibe datos de nombre, correo y una clave para realizar la actualización
if (isset($_GET["actualizar"])) {
    $data = json_decode(file_get_contents("php://input"));
    $id = intval(isset($data->id) ? $data->id : $_GET["actualizar"]); 
    $nombre = pg_escape_string($conexionBD, $data->nombre); 
    $correo = pg_escape_string($conexionBD, $data->correo); 
    $sqlHoteles = pg_query($conexionBD, "UPDATE hoteles SET nombre='$nombre', correo='$correo' WHERE id=$id");
    if ($sqlHoteles) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}

// Consulta todos los registros de la tabla hoteles
$sqlHoteles = pg_query($conexionBD, "SELECT * FROM hoteles");
$hoteles = pg_fetch_all($sqlHoteles);
if ($hoteles) {
    echo json_encode($hoteles);
} else {
    echo json_encode([["success" => 0]]);
}

?>