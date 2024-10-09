<?php
    include("model/lib/conexion.php");

    $nombre_temporal = $_FILES['archivo']['tmp_name'];
    $nombre = $_FILES['archivo']['name'];
    $cedula = $_POST["cedula_exp"];
            if(!file_exists('expedientes_img/'.$cedula)){
                mkdir('expedientes_img/'.$cedula, 0777, true);
            }
            move_uploaded_file($nombre_temporal, 'expedientes_img/'.$cedula.'/'.$nombre);
            // session_start();
            // $id_usu_log = $_SESSION["id_solicita"];
            $ruta = 'expedientes_img/'.$cedula.'/'.$nombre;
            // echo "hola";
            $conexion = new Conexion();
            $db = $conexion->conecta();
            // $db = $this->conn;
            $query1 = $db->execute("INSERT INTO expedientes_img (ruta_exp_img, fk_cedula, nombre) VALUES ('".$ruta."', $cedula, '".$nombre."')");
    ?>