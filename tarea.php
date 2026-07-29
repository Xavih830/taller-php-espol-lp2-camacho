<?php
    function guardarTarea($usuario, $texto){
        $archivo = "tareas_$usuario.csv";
        $maxId = 0;

        $lineas = file($archivo);
        if (file_exists($archivo) && (count($lineas) > 0)){
            foreach ($lineas as $linea){
                $variables = explode(',', $linea);
                $maxId = max($maxId, (int)$variables[0]);
            }
        }

        $id = $maxId + 1;
        $linea = "$id, $texto, pendiente";
        file_put_contents($archivo, $linea, FILE_APPEND);
    }

    function listarTareas($usuario){
        if (!file_exists("tareas_$usuario.csv")) return false;

        $pendientes = [];
        $completadas = [];

        $lineas = file("tareas_$usuario.csv");
        foreach ($lineas as $linea){
            $variables = explode(',', $linea);
            if ($variables[2] == 'pendiente'){
                $pendientes[] = $linea;
            } else {
                $completadas[] = $linea;
            }
        }

        $listaTareas = [
            'pendientes' => $pendientes,
            'completadas' => $completadas
        ];

        return $listaTareas;
    }

    function completarTarea($usuario, $id){
        if (!file_exists("tareas_$usuario.csv")) return false;

        $nuevasLineas = [];
        $lineas = file("tareas_$usuario.csv");
        foreach ($lineas as $linea){
            $variables = explode(',', $linea);
            if ($variables[0] == $id){
                $variables[2] = 'completada';
            }

            $nuevasLineas[] = implode(',', $variables);
        }

        file_put_contents("tareas_$usuario.csv", implode("\n", $nuevasLineas). "\n");
    }

    function eliminarTarea($usuario, $id){
        if (!file_exists("tareas_$usuario.csv")) return false;

        $lineas = file("tareas_$usuario.csv");
        foreach ($lineas as $i => $linea){
            $variables = explode(',', $linea);
            if ($variables[0] == $id){
                unset($lineas[$i]);
            }
        }

        file_put_contents("tareas_$usuario.csv", implode("\n", $lineas));
    }
?>