<?php
session_start();
require "usuario.php";

$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];

if (validar($cedula)) {
    header("Location: ingreso.php");
    exit;
}

$datos = [
    'cedula'       => $cedula,
    'nombre'       => $nombre,
    'estado_civil' => $_POST['estado_civil'],
    'correo'       => $_POST['correo'],
    'clave_hash'   => password_hash($_POST['clave'], PASSWORD_DEFAULT)
];

guardar($datos);

$_SESSION['usuario'] = $nombre;
$_SESSION['cedula'] = $cedula;
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="estilos.css"></head>
<body>
    <div class="contenedor contenedor--angosta">
        <span class="eyebrow exito">Registro exitoso</span>
        <h1>Usuario registrado</h1>
        <p>Bienvenido, <?= htmlspecialchars($nombre) ?>.</p>
        <p><a href="index.php">Volver al menú</a></p>
    </div>
</body>
</html>