<?php

    require "tarea.php";

    session_start();
    if (!isset($_SESSION['cedula'])){
        header("Location : ingreso.php");
        exit;
    }

    $listaTareas = listarTareas($_SESSION['cedula']);
    $pendientes = $listaTareas['pendientes'];
    $completadas = $listaTareas['completadas'];
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="estilos.css"></head>
<body>
    <h1>Gestor de tareas</h1>
    <?php if ($error): ?><p style="color:red;"><?= $error ?></p><?php endif; ?>
    <form method="POST" action="tareas.php">
        <label>Tarea:</label>
        <input type="text" name="tarea" required><br>
        <input type="submit" value="Guardar">
        <label>Tareas pendientes:</label>
        <ul>
            <?php foreach($pendientes as $p): ?>
                <?php $desempaquetado = explode(',', $p)?>
                <li>
                    <?= htmlspecialchars("$desempaquetado[0] | $desempaquetado[1] | ") ?>
                    <a href="tareas.php"?accion=completar&id=<?= $desempaquetado[0] ?>>Completar</a>
                    <a href="tareas.php"?accion=eliminar&id=<?= $desempaquetado[0] ?>>Eliminar</a>
                </li>
            <?php endforeach?>
        </ul>
        <label>Tarea completadas:</label>
        <ul>
            <?php foreach($completadas as $c): ?>
                <?php $desempaquetado = explode(',', $c)?>
                <li>
                    <?= htmlspecialchars("$desempaquetado[0] | $desempaquetado[1] | ") ?>
                    <a href="tareas.php"?accion=eliminar&id=<?= $desempaquetado[0] ?>>Eliminar</a>
                </li>
            <?php endforeach?>
        </ul>
    </form>
</body>
</html>