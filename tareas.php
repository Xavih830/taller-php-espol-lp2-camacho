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
    <div class="header">
        <h1>Gestor de tareas</h1>
        <a href="logout.php">Cerrar sesion</a>
    </div>
    <form method="POST" action="tareas.php">
        <label>Tarea:</label>
        <input type="text" name="tarea" required><br>
        <input type="submit" value="Guardar">
        <label>Tareas pendientes:</label>
        <ul>
            <?php if($listaTareas): ?>
                <?php if(count($pendientes)): ?>
                    <?php foreach($pendientes as $p): ?>
                        <?php $desempaquetado = explode(',', $p)?>
                        <li>
                            <?= htmlspecialchars("$desempaquetado[0] | $desempaquetado[1] | ") ?>
                            <a href="tareas.php?accion=completar&id=<?= $desempaquetado[0] ?>">Completar</a> | 
                            <a href="tareas.php?accion=eliminar&id=<?= $desempaquetado[0] ?>">Eliminar</a>
                        </li>
                    <?php endforeach?>
                <?php else: ?>
                    <p>Aqui se mostraran tus tareas pendientes cuando agregues una.</p>
                <?php endif?>
            <?php else: ?>
                <p>Aqui se mostraran tus tareas pendientes cuando agregues una.</p>
            <?php endif?>
        </ul>
        <label>Tarea completadas:</label>
        <ul>
            <?php if($listaTareas): ?>
                <?php if(count($completadas)): ?>
                    <?php foreach($completadas as $c): ?>
                        <?php $desempaquetado = explode(',', $c)?>
                        <li>
                            <?= htmlspecialchars("$desempaquetado[0] | $desempaquetado[1] | ") ?>
                            <a href="tareas.php?accion=eliminar&id=<?= $desempaquetado[0] ?>">Eliminar</a>
                        </li>
                    <?php endforeach?>
                <?php else: ?>
                    <p>Aqui se mostraran tus tareas completadas cuando termines una.</p>
                <?php endif?>
            <?php else: ?>
                <p>Aqui se mostraran tus tareas completadas cuando termines una.</p>
            <?php endif?>
        </ul>
    </form>
</body>
</html>