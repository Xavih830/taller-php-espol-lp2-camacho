<?php

    require "tarea.php";

    session_start();
    if (!isset($_SESSION['cedula'])){
        header("Location : ingreso.php");
        exit;
    }

    $usuario = $_SESSION['cedula'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarea'])){
        guardarTarea($usuario, $_POST['tarea']);
        header("Location: tareas.php");
        exit;
    }

    if(isset($_GET['accion']) && isset($_GET['id'])){
        if($_GET['accion'] === 'completar'){
            completarTarea($usuario, $_GET['id']);
        } else if ($_GET['accion'] === 'eliminar'){
            eliminarTarea($usuario, $_GET['id']);
        }
        
        header("Location: tareas.php");
        exit;
    }

    $pendientes = [];
    $completadas = [];

    $listaTareas = listarTareas($usuario);

    if ($listaTareas){
        $pendientes = $listaTareas['pendientes'];
        $completadas = $listaTareas['completadas'];
    }

?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="estilos.css"></head>
<body>
<div class="contenedor contenedor--ancha">
    <div class="header">
        <h1>Gestor de tareas</h1>
        <a href="logout.php">Cerrar sesión</a>
    </div>

    <form method="POST" action="tareas.php" class="form-agregar">
        <div class="campo-tarea">
            <label>Nueva tarea:</label>
            <input type="text" name="tarea" required>
        </div>
        <input type="submit" value="Agregar">
    </form>

    <div class="tableros">
        <div class="tablero">
            <h2>Pendientes</h2>
            <ul>
                <?php if($listaTareas): ?>
                    <?php if(count($pendientes) > 0): ?>
                        <?php foreach($pendientes as $p): ?>
                            <?php $desempaquetado = explode(',', $p)?>
                            <li class="tarea-item">
                                <span class="tarea-texto"><?= htmlspecialchars($desempaquetado[1]) ?></span>
                                <span class="tarea-acciones">
                                    <a class="accion-completar" href="tareas.php?accion=completar&id=<?= $desempaquetado[0] ?>">Completar</a>
                                    <a class="accion-eliminar" href="tareas.php?accion=eliminar&id=<?= $desempaquetado[0] ?>">Eliminar</a>
                                </span>
                            </li>
                        <?php endforeach?>
                    <?php else: ?>
                        <p class="vacio">Aqui se mostraran tus tareas pendientes cuando agregues una.</p>
                    <?php endif?>
                <?php else: ?>
                    <p class="vacio">Aqui se mostraran tus tareas pendientes cuando agregues una.</p>
                <?php endif?>
            </ul>
        </div>

        <div class="tablero">
            <h2>Completadas</h2>
            <ul>
                <?php if($listaTareas): ?>
                    <?php if(count($completadas) > 0): ?>
                        <?php foreach($completadas as $c): ?>
                            <?php $desempaquetado = explode(',', $c)?>
                            <li class="tarea-item">
                                <span class="tarea-texto"><?= htmlspecialchars($desempaquetado[1]) ?></span>
                                <span class="tarea-acciones">
                                    <a class="accion-eliminar" href="tareas.php?accion=eliminar&id=<?= $desempaquetado[0] ?>">Eliminar</a>
                                </span>
                            </li>
                        <?php endforeach?>
                    <?php else: ?>
                        <p class="vacio">Aqui se mostraran tus tareas completadas cuando termines una.</p>
                    <?php endif?>
                <?php else: ?>
                    <p class="vacio">Aqui se mostraran tus tareas completadas cuando termines una.</p>
                <?php endif?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>