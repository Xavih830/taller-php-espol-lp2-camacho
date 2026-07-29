<?php
    function guardarTarea($usuario, $texto){
        $archivo = "tareas_$usuario.csv";
        $maxId = 0;
        $lineas = [];

        if (file_exists($archivo)){
            $lineas = file($archivo);
        }

        if ((count($lineas) > 0)){
            foreach ($lineas as $linea){
                $variables = explode(',', $linea);
                $maxId = max($maxId, (int)$variables[0]);
            }
        }

        $id = $maxId + 1;
        $linea = "$id,$texto,pendiente\n";
        file_put_contents($archivo, $linea, FILE_APPEND);
    }

    function listarTareas($usuario){
        if (!file_exists("tareas_$usuario.csv")) return false;

        $pendientes = [];
        $completadas = [];

        $lineas = file("tareas_$usuario.csv");
        if (count($lineas) > 0){
            foreach ($lineas as $linea){
                $variables = explode(',', $linea);
                if (trim($variables[2]) == 'pendiente'){
                    $pendientes[] = $linea;
                } else {
                    $completadas[] = $linea;
                }
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
            $variables = explode(',', trim($linea));
            if ($variables[0] == $id){
                $variables[2] = 'completada';
            }

            $nuevasLineas[] = implode(',', $variables);
        }

        file_put_contents("tareas_$usuario.csv", empty($nuevasLineas) ? "" : implode("\n", $nuevasLineas) . "\n");
    }

    function eliminarTarea($usuario, $id){
        if (!file_exists("tareas_$usuario.csv")) return false;

        $lineas = file("tareas_$usuario.csv");
        $nuevasLineas = [];
        foreach ($lineas as $linea){
            $variables = explode(',', trim($linea));
            if ($variables[0] != $id){
                $nuevasLineas[] = implode(',', $variables);
            }
        }

        file_put_contents("tareas_$usuario.csv", empty($nuevasLineas) ? "" : implode("\n", $nuevasLineas) . "\n");
    }
?>